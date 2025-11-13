@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <!-- Stats Cards -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-blue-100 text-sm">Total Karyawan</p>
                <p class="text-3xl font-bold mt-2">{{ $stats['total_employees'] }}</p>
            </div>
            <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-green-100 text-sm">Hadir Hari Ini</p>
                <p class="text-3xl font-bold mt-2">{{ $stats['present_today'] }}</p>
            </div>
            <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>

    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-yellow-100 text-sm">Terlambat</p>
                <p class="text-3xl font-bold mt-2">{{ $stats['late_today'] }}</p>
            </div>
            <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>

    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-red-100 text-sm">Alfa</p>
                <p class="text-3xl font-bold mt-2">{{ $stats['absent_today'] }}</p>
            </div>
            <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
</div>

<!-- Recent Attendances -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-semibold mb-4">Absensi Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-3 px-4">Nama</th>
                    <th class="text-left py-3 px-4">NIP</th>
                    <th class="text-left py-3 px-4">Waktu Check-in</th>
                    <th class="text-left py-3 px-4">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_attendances as $att)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $att->employee->name }}</td>
                        <td class="py-3 px-4">{{ $att->employee->nip }}</td>
                        <td class="py-3 px-4">{{ $att->check_in }}</td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 rounded-full text-sm {{ $att->status == 'hadir' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($att->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">Belum ada absensi hari ini</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection