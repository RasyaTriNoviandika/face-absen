@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-3xl p-8 text-white shadow-2xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-indigo-100">Kelola absensi dan pantau kehadiran Anda dengan mudah</p>
            </div>
            <div class="hidden lg:block">
                <svg class="w-24 h-24 text-white/20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
    </div>

    @if(!auth()->user()->employee)
    <!-- Warning Alert -->
    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-400 p-6 rounded-2xl shadow-lg">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-yellow-400 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4 flex-1">
                <h3 class="text-lg font-bold text-yellow-800 mb-1">Akun Belum Terhubung</h3>
                <p class="text-sm text-yellow-700 mb-3">
                    Akun Anda belum terhubung dengan data karyawan. Silakan hubungi administrator untuk mengaktifkan fitur absensi.
                </p>
                <a href="mailto:admin@faceattend.com" class="inline-flex items-center px-4 py-2 bg-yellow-400 text-yellow-900 rounded-lg hover:bg-yellow-500 transition-colors font-medium text-sm">
                    Hubungi Admin
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @else
    <!-- Quick Actions -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Absensi Card -->
        <a href="{{ route('attendance.page') }}" target="_blank" class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl p-8 transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <svg class="w-6 h-6 text-gray-300 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Absensi Sekarang</h3>
            <p class="text-gray-600 text-sm">Lakukan check-in/out menggunakan face recognition</p>
        </a>

        <!-- Riwayat Card -->
        <a href="{{ route('user.attendance') }}" class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl p-8 transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <svg class="w-6 h-6 text-gray-300 group-hover:text-purple-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Riwayat Absensi</h3>
            <p class="text-gray-600 text-sm">Lihat history kehadiran Anda</p>
        </a>
    </div>

    @php
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $employee = auth()->user()->employee;
        
        // Hitung statistik real dari database
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
            
        // Absensi hari ini
        $todayAttendance = $employee->attendances()
            ->whereDate('date', now())
            ->first();
    @endphp

    <!-- Status Absensi Hari Ini -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Absensi Hari Ini</h3>
        
        @if($todayAttendance)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-green-600 font-medium">Check In</p>
                        <p class="text-lg font-bold text-green-900">{{ $todayAttendance->check_in }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-blue-600 font-medium">Check Out</p>
                        <p class="text-lg font-bold text-blue-900">{{ $todayAttendance->check_out ?? 'Belum' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-purple-600 font-medium">Status</p>
                        <p class="text-lg font-bold text-purple-900">{{ ucfirst($todayAttendance->status) }}</p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Anda belum melakukan absensi hari ini</p>
            <a href="{{ route('attendance.page') }}" target="_blank" class="inline-block mt-4 px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                Absen Sekarang
            </a>
        </div>
        @endif
    </div>

    <!-- Statistik Bulan Ini -->
    <div>
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Statistik Bulan {{ now()->format('F Y') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Total Hadir</p>
                        <p class="text-3xl font-bold text-green-600">{{ $totalHadir }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Terlambat</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $totalTerlambat }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Izin/Sakit</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalIzin }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Alfa</p>
                        <p class="text-3xl font-bold text-red-600">{{ $totalAlfa }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection