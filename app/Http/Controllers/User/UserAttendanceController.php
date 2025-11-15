<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->employee) {
            return redirect()->route('dashboard')
                ->with('error', 'Akun Anda belum terhubung dengan data karyawan.');
        }

        $attendances = $user->employee->attendances()
            ->latest('date')
            ->latest('check_in')
            ->paginate(20);

        return view('user.attendance', compact('attendances'));
    }
}