<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('employee');

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        } else {
            $query->whereDate('date', Carbon::today());
        }

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->latest('date')
            ->latest('check_in')
            ->paginate(20);

        $employees = Employee::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.attendances.index', compact('attendances', 'employees'));
    }

    public function show(Attendance $attendance)
    {
        $attendance->load('employee');
        return view('admin.attendances.show', compact('attendance'));
    }

    public function create()
    {
        $employees = Employee::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('admin.attendances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'status' => 'required|in:hadir,terlambat,izin,sakit,alfa',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if attendance already exists
        $exists = Attendance::where('employee_id', $validated['employee_id'])
            ->whereDate('date', $validated['date'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Absensi untuk karyawan ini pada tanggal tersebut sudah ada.');
        }

        Attendance::create($validated);

        return redirect()->route('admin.attendances.index')
            ->with('success', 'Data absensi berhasil ditambahkan.');
    }

    public function edit(Attendance $attendance)
    {
        $employees = Employee::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('admin.attendances.edit', compact('attendance', 'employees'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'status' => 'required|in:hadir,terlambat,izin,sakit,alfa',
            'notes' => 'nullable|string|max:500',
        ]);

        $attendance->update($validated);

        return redirect()->route('admin.attendances.index')
            ->with('success', 'Data absensi berhasil diupdate.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('admin.attendances.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }
}