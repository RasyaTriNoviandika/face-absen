@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto">
        
        <!-- Welcome Header - Simple -->
        <div class="bg-white rounded-2xl p-8 mb-6 shadow-sm border border-gray-100">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                Welcome, {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-gray-600">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
        </div>

        @if(!auth()->user()->employee)
        <!-- Warning - Clean -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-xl mb-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-yellow-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h3 class="text-sm font-bold text-yellow-800 mb-1">Akun Belum Terhubung</h3>
                    <p class="text-sm text-yellow-700">Akun Anda belum terhubung dengan data karyawan. Hubungi administrator untuk aktivasi.</p>
                </div>
            </div>
        </div>
        @else
        
        <!-- Quick Actions - Card Simple -->
        <div class="grid sm:grid-cols-2 gap-4 mb-6">
            <!-- Absensi Card -->
            <a href="{{ route('attendance.page') }}" target="_blank" class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Absensi Sekarang</h3>
                <p class="text-sm text-gray-600">Check-in/out dengan face recognition</p>
            </a>

            <!-- Riwayat Card -->
            <a href="{{ route('user.attendance') }}" class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md hover:border-purple-200 transition">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center group-hover:bg-purple-200 transition">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Riwayat Absensi</h3>
                <p class="text-sm text-gray-600">Lihat history kehadiran Anda</p>
            </a>
        </div>

        @php
            $employee = auth()->user()->employee;
            $todayAttendance = $employee->attendances()->whereDate('date', now())->first();
        @endphp

        <!-- Status Hari Ini - Clean -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Status Hari Ini</h3>
            
            @if($todayAttendance)
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                    <div class="text-xs text-green-600 font-semibold mb-1">Check In</div>
                    <div class="text-2xl font-bold text-green-900">{{ $todayAttendance->check_in }}</div>
                </div>
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                    <div class="text-xs text-blue-600 font-semibold mb-1">Check Out</div>
                    <div class="text-2xl font-bold text-blue-900">{{ $todayAttendance->check_out ?? '-' }}</div>
                </div>
                <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                    <div class="text-xs text-purple-600 font-semibold mb-1">Status</div>
                    <div class="text-xl font-bold text-purple-900">{{ ucfirst($todayAttendance->status) }}</div>
                </div>
            </div>
            @else
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-600 mb-4">Belum ada absensi hari ini</p>
                <a href="{{ route('attendance.page') }}" target="_blank" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-semibold transition">
                    Absen Sekarang
                </a>
            </div>
            @endif
        </div>

        @php
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
        @endphp

        <!-- Statistik Bulan Ini - Simple Grid -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Statistik {{ now()->format('F Y') }}</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-gray-50 rounded-xl">
                    <div class="text-3xl font-bold text-green-600">{{ $totalHadir }}</div>
                    <div class="text-xs text-gray-600 mt-1 font-medium">Hadir</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-xl">
                    <div class="text-3xl font-bold text-yellow-600">{{ $totalTerlambat }}</div>
                    <div class="text-xs text-gray-600 mt-1 font-medium">Terlambat</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-xl">
                    <div class="text-3xl font-bold text-blue-600">{{ $totalIzin }}</div>
                    <div class="text-xs text-gray-600 mt-1 font-medium">Izin/Sakit</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-xl">
                    <div class="text-3xl font-bold text-red-600">{{ $totalAlfa }}</div>
                    <div class="text-xs text-gray-600 mt-1 font-medium">Alfa</div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection