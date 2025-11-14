<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\FaceDescriptor;
use App\Models\Attendance;
use App\Models\Setting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FaceRecognitionController extends Controller
{
    // Maximum file size for photos (5MB)
    private const MAX_PHOTO_SIZE = 5242880;
    
    // Rate limiting
    private const MAX_ATTEMPTS_PER_MINUTE = 10;

    /**
     * Register face untuk employee dengan validasi ketat
     */
    public function registerFace(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|exists:employees,id',
                'descriptor' => 'required|array|size:128', // Face descriptor harus 128 dimensi
                'descriptor.*' => 'required|numeric',
                'photo' => 'required|string|regex:/^data:image\/(png|jpeg|jpg);base64,/',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $employee = Employee::findOrFail($request->employee_id);

            // Check if employee is active
            if (!$employee->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Karyawan tidak aktif',
                ], 403);
            }

            // Validate and save photo
            $photoData = $request->photo;
            
            // Extract base64 data
            if (!preg_match('/^data:image\/(png|jpeg|jpg);base64,(.+)$/', $photoData, $matches)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format foto tidak valid',
                ], 422);
            }

            $imageData = base64_decode($matches[2]);
            
            // Check file size
            if (strlen($imageData) > self::MAX_PHOTO_SIZE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ukuran foto terlalu besar (maksimal 5MB)',
                ], 422);
            }

            // Validate image
            $imageInfo = getimagesizefromstring($imageData);
            if ($imageInfo === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'File bukan gambar yang valid',
                ], 422);
            }

            // Generate secure filename
            $photoName = 'faces/' . $employee->nip . '_' . uniqid() . '.png';
            Storage::disk('public')->put($photoName, $imageData);

            // Save descriptor
            FaceDescriptor::create([
                'employee_id' => $employee->id,
                'descriptor' => json_encode($request->descriptor),
                'photo_path' => $photoName,
            ]);

            // Update employee face_registered status
            $employee->update(['face_registered' => true]);

            Log::info('Face registered', [
                'employee_id' => $employee->id,
                'employee_name' => $employee->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Wajah berhasil didaftarkan',
            ]);

        } catch (\Exception $e) {
            Log::error('Face registration error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mendaftarkan wajah',
            ], 500);
        }
    }

    /**
     * Get all registered faces untuk matching
     */
    public function getRegisteredFaces()
    {
        try {
            $descriptors = FaceDescriptor::with(['employee' => function($query) {
                $query->where('is_active', true);
            }])
            ->whereHas('employee', function($query) {
                $query->where('is_active', true);
            })
            ->get()
            ->map(function ($desc) {
                return [
                    'employee_id' => $desc->employee_id,
                    'employee_name' => $desc->employee->name,
                    'employee_nip' => $desc->employee->nip,
                    'descriptor' => json_decode($desc->descriptor),
                ];
            });

            return response()->json($descriptors);

        } catch (\Exception $e) {
            Log::error('Get registered faces error', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data wajah',
            ], 500);
        }
    }

    /**
     * Check-in attendance dengan validasi
     */
    public function checkIn(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|exists:employees,id',
                'photo' => 'required|string|regex:/^data:image\/(png|jpeg|jpg);base64,/',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $employee = Employee::findOrFail($request->employee_id);
            
            // Check if employee is active
            if (!$employee->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Karyawan tidak aktif',
                ], 403);
            }

            $today = Carbon::today();

            // Check if already checked in
            $attendance = Attendance::where('employee_id', $employee->id)
                ->whereDate('date', $today)
                ->first();

            if ($attendance && $attendance->check_in) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan check-in hari ini pada ' . $attendance->check_in,
                ], 400);
            }

            // Validate and save photo
            if (!preg_match('/^data:image\/(png|jpeg|jpg);base64,(.+)$/', $request->photo, $matches)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format foto tidak valid',
                ], 422);
            }

            $imageData = base64_decode($matches[2]);
            
            if (strlen($imageData) > self::MAX_PHOTO_SIZE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ukuran foto terlalu besar',
                ], 422);
            }

            // Generate secure filename
            $photoName = 'attendance/' . $employee->nip . '_in_' . now()->format('YmdHis') . '_' . uniqid() . '.png';
            Storage::disk('public')->put($photoName, $imageData);

            // Determine status (late or on time)
            $workStartTime = Setting::get('work_start_time', '08:00:00');
            $lateTolerance = (int) Setting::get('late_tolerance_minutes', 15);
            $startTime = Carbon::parse($workStartTime)->addMinutes($lateTolerance);
            $now = Carbon::now();
            $status = $now->greaterThan($startTime) ? 'terlambat' : 'hadir';

            // Create or update attendance
            $attendance = Attendance::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'date' => $today,
                ],
                [
                    'check_in' => $now->format('H:i:s'),
                    'status' => $status,
                    'check_in_photo' => $photoName,
                ]
            );

            Log::info('Check-in recorded', [
                'employee_id' => $employee->id,
                'employee_name' => $employee->name,
                'status' => $status,
                'time' => $now->format('H:i:s'),
            ]);

            return response()->json([
                'success' => true,
                'message' => $status === 'hadir' ? 
                    'Check-in berhasil! Selamat bekerja.' : 
                    'Check-in berhasil, namun Anda terlambat.',
                'data' => [
                    'employee' => $employee->only(['id', 'name', 'nip', 'department']),
                    'attendance' => $attendance->only(['date', 'check_in', 'status']),
                    'status' => $status,
                    'time' => $now->format('H:i:s'),
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Check-in error', [
                'employee_id' => $request->employee_id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat check-in',
            ], 500);
        }
    }

    /**
     * Check-out attendance dengan validasi
     */
    public function checkOut(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|exists:employees,id',
                'photo' => 'required|string|regex:/^data:image\/(png|jpeg|jpg);base64,/',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $employee = Employee::findOrFail($request->employee_id);
            $today = Carbon::today();

            $attendance = Attendance::where('employee_id', $employee->id)
                ->whereDate('date', $today)
                ->first();

            if (!$attendance || !$attendance->check_in) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum melakukan check-in hari ini',
                ], 400);
            }

            if ($attendance->check_out) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan check-out pada ' . $attendance->check_out,
                ], 400);
            }

            // Validate and save photo
            if (!preg_match('/^data:image\/(png|jpeg|jpg);base64,(.+)$/', $request->photo, $matches)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format foto tidak valid',
                ], 422);
            }

            $imageData = base64_decode($matches[2]);
            
            if (strlen($imageData) > self::MAX_PHOTO_SIZE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ukuran foto terlalu besar',
                ], 422);
            }

            $photoName = 'attendance/' . $employee->nip . '_out_' . now()->format('YmdHis') . '_' . uniqid() . '.png';
            Storage::disk('public')->put($photoName, $imageData);

            $now = Carbon::now();
            $attendance->update([
                'check_out' => $now->format('H:i:s'),
                'check_out_photo' => $photoName,
            ]);

            Log::info('Check-out recorded', [
                'employee_id' => $employee->id,
                'employee_name' => $employee->name,
                'time' => $now->format('H:i:s'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check-out berhasil! Terima kasih dan selamat beristirahat.',
                'data' => [
                    'employee' => $employee->only(['id', 'name', 'nip', 'department']),
                    'attendance' => $attendance->only(['date', 'check_in', 'check_out', 'status']),
                    'time' => $now->format('H:i:s'),
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Check-out error', [
                'employee_id' => $request->employee_id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat check-out',
            ], 500);
        }
    }
}