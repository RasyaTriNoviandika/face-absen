<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $stats = [
            'total_employees' => Employee::where('is_active', true)->count(),
            'present_today' => Attendance::whereDate('date', $today)
                ->whereIn('status', ['hadir', 'terlambat'])
                ->count(),
            'late_today' => Attendance::whereDate('date', $today)
                ->where('status', 'terlambat')
                ->count(),
            'absent_today' => Employee::where('is_active', true)->count() - 
                Attendance::whereDate('date', $today)->count(),
        ];

        $recent_attendances = Attendance::with('employee')
            ->whereDate('date', $today)
            ->latest('check_in')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_attendances'));
    }
}