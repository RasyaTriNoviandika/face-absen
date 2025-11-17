<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Gunakan query yang lebih efisien
        $stats = [
            'total_employees' => Employee::where('is_active', true)->count(),
            'present_today' => Attendance::whereDate('date', $today)
                ->whereIn('status', ['hadir', 'terlambat'])
                ->count(),
            'late_today' => Attendance::whereDate('date', $today)
                ->where('status', 'terlambat')
                ->count(),
        ];
        
        // Calculate absent using existing data
        $stats['absent_today'] = $stats['total_employees'] - 
            Attendance::whereDate('date', $today)->distinct('employee_id')->count();

        // Eager loading untuk menghindari N+1 query
        $recent_attendances = Attendance::with('employee:id,name,nip,photo,department')
            ->whereDate('date', $today)
            ->latest('check_in')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_attendances'));
    }
}