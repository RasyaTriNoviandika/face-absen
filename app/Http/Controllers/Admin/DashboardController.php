<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Cache stats untuk 5 menit
        $stats = Cache::remember('dashboard_stats_' . $today->format('Y-m-d'), 300, function () use ($today) {
            return [
                'total_employees' => Employee::where('is_active', true)->count(),
                'total_users' => User::where('is_active', true)->count(),
                'users_without_employee' => User::where('is_active', true)
                    ->whereNull('employee_id')
                    ->where('role', 'user')
                    ->count(),
                'employees_without_face' => Employee::where('is_active', true)
                    ->where('face_registered', false)
                    ->count(),
                'present_today' => Attendance::whereDate('date', $today)
                    ->whereIn('status', ['hadir', 'terlambat'])
                    ->count(),
                'late_today' => Attendance::whereDate('date', $today)
                    ->where('status', 'terlambat')
                    ->count(),
                'total_attendance_today' => Attendance::whereDate('date', $today)
                    ->distinct('employee_id')
                    ->count(),
            ];
        });
        
        // Calculate absent
        $stats['absent_today'] = $stats['total_employees'] - $stats['total_attendance_today'];

        // Recent attendances dengan eager loading
        $recent_attendances = Attendance::with(['employee' => function($query) {
                $query->select('id', 'name', 'nip', 'photo', 'department');
            }])
            ->whereDate('date', $today)
            ->latest('check_in')
            ->limit(10)
            ->get();

        // Attendance trend (7 hari terakhir)
        $attendanceTrend = DB::table('attendances')
            ->select(
                DB::raw('DATE(date) as date'),
                DB::raw('COUNT(DISTINCT CASE WHEN status IN ("hadir", "terlambat") THEN employee_id END) as present'),
                DB::raw('COUNT(DISTINCT CASE WHEN status = "terlambat" THEN employee_id END) as late')
            )
            ->where('date', '>=', $today->copy()->subDays(6))
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_attendances', 'attendanceTrend'));
    }
}