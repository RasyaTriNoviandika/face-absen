@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <!-- Total Karyawan -->
        <div class="group relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl shadow-xl hover:shadow-2xl p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-20 h-20 bg-white/10 rounded-full -ml-10 -mb-10"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-blue-100 text-sm font-medium mb-1">Total Karyawan</p>
                        <p class="text-4xl font-bold">{{ $stats['total_employees'] }}</p>
                    </div>
                </div>
                <div class="flex items-center text-blue-100 text-sm">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Karyawan aktif</span>
                </div>
            </div>
        </div>

        <!-- Hadir Hari Ini -->
        <div class="group relative overflow-hidden bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl shadow-xl hover:shadow-2xl p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-20 h-20 bg-white/10 rounded-full -ml-10 -mb-10"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-green-100 text-sm font-medium mb-1">Hadir Hari Ini</p>
                        <p class="text-4xl font-bold">{{ $stats['present_today'] }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-green-100 text-sm">
                    <span>{{ $stats['total_employees'] > 0 ? round(($stats['present_today'] / $stats['total_employees']) * 100, 1) : 0 }}% kehadiran</span>
                    <div class="w-16 h-2 bg-white/20 rounded-full overflow-hidden">
                        <div class="h-full bg-white rounded-full" style="width: {{ $stats['total_employees'] > 0 ? round(($stats['present_today'] / $stats['total_employees']) * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terlambat -->
        <div class="group relative overflow-hidden bg-gradient-to-br from-yellow-500 to-orange-500 rounded-3xl shadow-xl hover:shadow-2xl p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-20 h-20 bg-white/10 rounded-full -ml-10 -mb-10"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-yellow-100 text-sm font-medium mb-1">Terlambat</p>
                        <p class="text-4xl font-bold">{{ $stats['late_today'] }}</p>
                    </div>
                </div>
                <div class="flex items-center text-yellow-100 text-sm">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Hari ini</span>
                </div>
            </div>
        </div>

        <!-- Tidak Hadir -->
        <div class="group relative overflow-hidden bg-gradient-to-br from-red-500 to-pink-600 rounded-3xl shadow-xl hover:shadow-2xl p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-20 h-20 bg-white/10 rounded-full -ml-10 -mb-10"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-red-100 text-sm font-medium mb-1">Tidak Hadir</p>
                        <p class="text-4xl font-bold">{{ $stats['absent_today'] }}</p>
                    </div>
                </div>
                <div class="flex items-center text-red-100 text-sm">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Belum absen</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Attendances -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">Absensi Terbaru</h3>
                        <p class="text-indigo-100 text-sm mt-1">10 absensi terakhir hari ini</p>
                    </div>
                </div>
                <a href="{{ route('admin.attendances.index') }}" 
                   class="inline-flex items-center space-x-2 px-6 py-3 bg-white text-indigo-600 rounded-xl hover:shadow-xl transition-all font-semibold hover:scale-105">
                    <span>Lihat Semua</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Karyawan</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Departemen</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Check In</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recent_attendances as $attendance)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($attendance->employee->photo)
                                        <img src="{{ Storage::url($attendance->employee->photo) }}" 
                                             class="w-12 h-12 rounded-xl object-cover ring-2 ring-gray-200 shadow-md" 
                                             alt="{{ $attendance->employee->name }}">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold ring-2 ring-gray-200 shadow-md">
                                            {{ substr($attendance->employee->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $attendance->employee->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $attendance->employee->nip }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <span class="px-4 py-2 inline-flex text-xs font-semibold rounded-xl bg-blue-100 text-blue-800">
                                    {{ $attendance->employee->department }}
                                </span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center text-sm font-medium text-gray-900">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $attendance->check_in }}
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                @php
                                    $statusConfig = [
                                        'hadir' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Hadir'],
                                        'terlambat' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Terlambat'],
                                        'izin' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Izin'],
                                        'sakit' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'label' => 'Sakit'],
                                        'alfa' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Alfa'],
                                    ];
                                    $config = $statusConfig[$attendance->status] ?? $statusConfig['alfa'];
                                @endphp
                                <span class="px-4 py-2 inline-flex text-xs leading-5 font-semibold rounded-xl {{ $config['bg'] }} {{ $config['text'] }}">
                                    {{ $config['label'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-semibold text-lg">Belum ada data absensi hari ini</p>
                                    <p class="text-gray-400 text-sm mt-2">Karyawan dapat melakukan absensi melalui halaman Face Recognition</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <a href="{{ route('admin.employees.create') }}" 
           class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl p-8 transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="p-4 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-xl group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <svg class="w-6 h-6 text-gray-300 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Tambah Karyawan</h3>
            <p class="text-sm text-gray-600">Daftarkan karyawan baru dan registrasi wajah mereka untuk sistem absensi</p>
        </a>

        <a href="{{ route('admin.reports.index') }}" 
           class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl p-8 transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="p-4 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-xl group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <svg class="w-6 h-6 text-gray-300 group-hover:text-green-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Lihat Laporan</h3>
            <p class="text-sm text-gray-600">Export dan analisa data kehadiran karyawan dengan berbagai format</p>
        </a>

        <a href="{{ route('attendance.page') }}" target="_blank"
           class="group bg-gradient-to-br from-purple-500 to-pink-600 rounded-3xl shadow-xl hover:shadow-2xl p-8 transition-all duration-300 transform hover:-translate-y-2 text-white">
            <div class="flex items-center justify-between mb-6">
                <div class="p-4 bg-white/20 rounded-2xl shadow-lg backdrop-blur-sm group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <svg class="w-6 h-6 text-white/70 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Face Recognition</h3>
            <p class="text-sm text-purple-100">Buka halaman absensi dengan pengenalan wajah untuk karyawan</p>
        </a>
    </div>
</div>
@endsection