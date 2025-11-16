<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->employee) {
            return redirect()->route('dashboard')
                ->with('error', 'Akun Anda belum terhubung dengan data karyawan.');
        }

        // Filter by month and year
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        
        $startDate = \Carbon\Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $attendances = $user->employee->attendances()
            ->whereBetween('date', [$startDate, $endDate])
            ->latest('date')
            ->latest('check_in')
            ->paginate(20);

        return view('user.attendance', compact('attendances'));
    }
}