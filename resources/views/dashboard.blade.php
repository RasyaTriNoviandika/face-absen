@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Welcome Header -->
        <div class="bg-white rounded-2xl shadow-sm p-8 mb-8 border border-gray-100">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                Selamat Datang, {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-gray-600">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
        </div>

        @if(!auth()->user()->employee)
        <!-- Warning - User Belum Terhubung -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-xl mb-8 shadow-sm">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-yellow-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-yellow-800 mb-1">Akun Belum Terhubung</h3>
                    <p class="text-sm text-yellow-700 mb-3">
                        Akun Anda belum terhubung dengan data karyawan. Untuk menggunakan fitur absensi wajah, silakan hubungi administrator.
                    </p>
                    <a href="mailto:admin@faceattend.com" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Hubungi Admin
                    </a>
                </div>
            </div>
        </div>
        @else
        
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Absensi Card -->
            <a href="{{ route('attendance.page') }}" target="_blank" class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:border-blue-200 transition-all">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Absensi Karyawan</h3>
                <p class="text-sm text-gray-600">Lakukan absensi dengan face recognition</p>
            </a>

            @if(auth()->user()->isAdmin())
            <!-- Admin Card -->
            <a href="{{ route('admin.dashboard') }}" class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:border-green-200 transition-all">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center group-hover:bg-green-200 transition-colors">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Dashboard Admin</h3>
                <p class="text-sm text-gray-600">Kelola karyawan & laporan</p>
            </a>
            @endif

            <!-- Laporan Card -->
            <a href="{{ route('user.attendance') }}" class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:border-purple-200 transition-all">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Riwayat Kehadiran</h3>
                <p class="text-sm text-gray-600">Pantau riwayat kehadiran Anda</p>
            </a>
        </div>

        @php
            $employee = auth()->user()->employee;
            $todayAttendance = $employee->attendances()->whereDate('date', now())->first();
            
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

        <!-- Status Hari Ini -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-gray-100">
            <h2 class="text-xl font-bold mb-6 text-gray-800">Status Hari Ini</h2>
            
            @if($todayAttendance)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-green-700">Check In</span>
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-green-900">{{ $todayAttendance->check_in }}</p>
                </div>
                
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-blue-700">Check Out</span>
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-blue-900">{{ $todayAttendance->check_out ?? '-' }}</p>
                </div>
                
                <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-purple-700">Status</span>
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-xl font-bold text-purple-900">{{ ucfirst($todayAttendance->status) }}</p>
                </div>
            </div>
            @else
            <div class="text-center py-12 bg-gray-50 rounded-xl">
                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-600 mb-4 text-lg">Belum ada absensi hari ini</p>
                <a href="{{ route('attendance.page') }}" target="_blank" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-semibold shadow-lg transition-all">
                    Absen Sekarang
                </a>
            </div>
            @endif
        </div>

        <!-- Statistik Bulan Ini -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-xl font-bold mb-6 text-gray-800">Statistik {{ now()->format('F Y') }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-6 bg-green-50 rounded-xl border border-green-100">
                    <div class="text-4xl font-bold text-green-600 mb-2">{{ $totalHadir }}</div>
                    <div class="text-sm text-gray-600 font-medium">Hadir</div>
                </div>
                <div class="text-center p-6 bg-yellow-50 rounded-xl border border-yellow-100">
                    <div class="text-4xl font-bold text-yellow-600 mb-2">{{ $totalTerlambat }}</div>
                    <div class="text-sm text-gray-600 font-medium">Terlambat</div>
                </div>
                <div class="text-center p-6 bg-blue-50 rounded-xl border border-blue-100">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ $totalIzin }}</div>
                    <div class="text-sm text-gray-600 font-medium">Izin/Sakit</div>
                </div>
                <div class="text-center p-6 bg-red-50 rounded-xl border border-red-100">
                    <div class="text-4xl font-bold text-red-600 mb-2">{{ $totalAlfa }}</div>
                    <div class="text-sm text-gray-600 font-medium">Alfa</div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection