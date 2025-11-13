<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\FaceDescriptor;
use App\Models\Attendance;
use App\Models\Setting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FaceRecognitionController extends Controller
{
    // Register face untuk employee
    public function registerFace(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'descriptor' => 'required|array',
            'photo' => 'required|string', // Base64 image
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        // Save photo
        $photoData = $request->photo;
        $photoData = str_replace('data:image/png;base64,', '', $photoData);
        $photoData = str_replace(' ', '+', $photoData);
        $photoName = 'faces/' . $employee->nip . '_' . time() . '.png';
        Storage::disk('public')->put($photoName, base64_decode($photoData));

        // Save descriptor
        FaceDescriptor::create([
            'employee_id' => $employee->id,
            'descriptor' => json_encode($request->descriptor),
            'photo_path' => $photoName,
        ]);

        // Update employee face_registered status
        $employee->update(['face_registered' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Wajah berhasil didaftarkan',
        ]);
    }

    // Get all registered faces untuk matching
    public function getRegisteredFaces()
    {
        $descriptors = FaceDescriptor::with('employee')->get()->map(function ($desc) {
            return [
                'employee_id' => $desc->employee_id,
                'employee_name' => $desc->employee->name,
                'employee_nip' => $desc->employee->nip,
                'descriptor' => json_decode($desc->descriptor),
            ];
        });

        return response()->json($descriptors);
    }

    // Check-in attendance
    public function checkIn(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'photo' => 'required|string', // Base64 image
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $today = Carbon::today();

        // Check if already checked in
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first();

        if ($attendance && $attendance->check_in) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check-in hari ini',
            ], 400);
        }

        // Save photo
        $photoData = str_replace('data:image/png;base64,', '', $request->photo);
        $photoData = str_replace(' ', '+', $photoData);
        $photoName = 'attendance/' . $employee->nip . '_' . date('YmdHis') . '.png';
        Storage::disk('public')->put($photoName, base64_decode($photoData));

        // Determine status (late or on time)
        $workStartTime = Setting::get('work_start_time', '08:00:00');
        $lateTolerance = Setting::get('late_tolerance_minutes', 15);
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

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil',
            'data' => [
                'employee' => $employee,
                'attendance' => $attendance,
                'status' => $status,
                'time' => $now->format('H:i:s'),
            ],
        ]);
    }

    // Check-out attendance
    public function checkOut(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'photo' => 'required|string',
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $today = Carbon::today();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance || !$attendance->check_in) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan check-in',
            ], 400);
        }

        if ($attendance->check_out) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check-out',
            ], 400);
        }

        // Save photo
        $photoData = str_replace('data:image/png;base64,', '', $request->photo);
        $photoData = str_replace(' ', '+', $photoData);
        $photoName = 'attendance/' . $employee->nip . '_out_' . date('YmdHis') . '.png';
        Storage::disk('public')->put($photoName, base64_decode($photoData));

        $now = Carbon::now();
        $attendance->update([
            'check_out' => $now->format('H:i:s'),
            'check_out_photo' => $photoName,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-out berhasil',
            'data' => [
                'employee' => $employee,
                'attendance' => $attendance,
                'time' => $now->format('H:i:s'),
            ],
        ]);
    }
}