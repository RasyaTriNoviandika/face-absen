@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
    
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-6 sm:p-8 text-white mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
        <p class="text-indigo-100">Kelola absensi dan pantau kehadiran Anda dengan mudah</p>
    </div>

    @if(!auth()->user()->employee)
    <!-- Warning Alert -->
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 sm:p-6 rounded-lg mb-8">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Akun Belum Terhubung</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>Akun Anda belum terhubung dengan data karyawan. Silakan hubungi administrator.</p>
                </div>
            </div>
        </div>
    </div>
    @else
    
    <!-- Quick Actions -->
    <div class="grid sm:grid-cols-2 gap-4 mb-8">
        <!-- Absensi Card -->
        <a href="{{ route('attendance.page') }}" target="_blank" class="block bg-white rounded-lg shadow hover:shadow-lg p-6 border border-gray-200 transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Absensi Sekarang</h3>
            <p class="text-sm text-gray-600">Check-in/out menggunakan face recognition</p>
        </a>

        <!-- Riwayat Card -->
        <a href="{{ route('user.attendance') }}" class="block bg-white rounded-lg shadow hover:shadow-lg p-6 border border-gray-200 transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Riwayat Absensi</h3>
            <p class="text-sm text-gray-600">Lihat history kehadiran Anda</p>
        </a>
    </div>

    @php
        $employee = auth()->user()->employee;
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        
        $totalHadir = $employee->attendances()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['hadir', 'terlambat'])
            ->count();
        
        $totalTerlambat = $employee->attendances()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->where('status', 'terlambat')
            ->count();
        
        $totalIzin = $employee->attendances()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['izin', 'sakit'])
            ->count();
        
        $totalAlfa = $employee->attendances()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->where('status', 'alfa')
            ->count();
            
        $todayAttendance = $employee->attendances()
            ->whereDate('date', now())
            ->first();
    @endphp

    <!-- Status Hari Ini -->
    <div class="bg-white rounded-lg shadow p-6 border border-gray-200 mb-8">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Status Absensi Hari Ini</h3>
        
        @if($todayAttendance)
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                <div class="text-xs text-green-600 font-medium mb-1">Check In</div>
                <div class="text-2xl font-bold text-green-900">{{ $todayAttendance->check_in }}</div>
            </div>
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                <div class="text-xs text-blue-600 font-medium mb-1">Check Out</div>
                <div class="text-2xl font-bold text-blue-900">{{ $todayAttendance->check_out ?? '-' }}</div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                <div class="text-xs text-purple-600 font-medium mb-1">Status</div>
                <div class="text-2xl font-bold text-purple-900">{{ ucfirst($todayAttendance->status) }}</div>
            </div>
        </div>
        @else
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-gray-600 mb-4">Anda belum melakukan absensi hari ini</p>
            <a href="{{ route('attendance.page') }}" target="_blank" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Absen Sekarang
            </a>
        </div>
        @endif
    </div>

    <!-- Statistik Bulan Ini -->
    <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Statistik {{ now()->format('F Y') }}</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ $totalHadir }}</div>
                <div class="text-xs text-gray-600 mt-1">Hadir</div>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-yellow-600">{{ $totalTerlambat }}</div>
                <div class="text-xs text-gray-600 mt-1">Terlambat</div>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ $totalIzin }}</div>
                <div class="text-xs text-gray-600 mt-1">Izin/Sakit</div>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-red-600">{{ $totalAlfa }}</div>
                <div class="text-xs text-gray-600 mt-1">Alfa</div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection