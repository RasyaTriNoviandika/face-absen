@extends('layouts.admin')

@section('title', 'Detail Karyawan')

@section('content')
<div class="max-w-6xl space-y-6">
    <!-- Employee Profile Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Profil Karyawan</h3>
                <a href="{{ route('admin.employees.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    ← Kembali
                </a>
            </div>
        </div>

        <div class="p-6">
            <div class="flex items-start space-x-6">
                @if($employee->photo)
                    <img src="{{ Storage::url($employee->photo) }}" 
                         class="w-32 h-32 rounded-xl object-cover shadow-lg" 
                         alt="{{ $employee->name }}">
                @else
                    <div class="w-32 h-32 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold text-5xl shadow-lg">
                        {{ substr($employee->name, 0, 1) }}
                    </div>
                @endif
                
                <div class="flex-1">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $employee->name }}</h2>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 inline-flex text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                    {{ $employee->department }}
                                </span>
                                @if($employee->is_active)
                                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                        Nonaktif
                                    </span>
                                @endif
                                @if($employee->face_registered)
                                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-purple-100 text-purple-800">
                                        ✓ Face Registered
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.employees.edit', $employee) }}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Edit Profil
                            </a>
                            
                            @if(!$employee->face_registered)
                                <a href="{{ route('admin.employees.register-face', $employee) }}" 
                                   class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium inline-flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Registrasi Wajah
                                </a>
                            @else
                                <a href="{{ route('admin.employees.register-face', $employee) }}" 
                                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium inline-flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Update Wajah
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <label class="text-gray-500 font-medium">NIP</label>
                            <p class="text-gray-900">{{ $employee->nip }}</p>
                        </div>
                        <div>
                            <label class="text-gray-500 font-medium">Email</label>
                            <p class="text-gray-900">{{ $employee->email }}</p>
                        </div>
                        @if($employee->phone)
                            <div>
                                <label class="text-gray-500 font-medium">Telepon</label>
                                <p class="text-gray-900">{{ $employee->phone }}</p>
                            </div>
                        @endif
                        @if($employee->position)
                            <div>
                                <label class="text-gray-500 font-medium">Posisi</label>
                                <p class="text-gray-900">{{ $employee->position }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance History -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Absensi</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($attendances as $attendance)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $attendance->date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $attendance->check_in }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $attendance->check_out ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'hadir' => 'bg-green-100 text-green-800',
                                        'terlambat' => 'bg-yellow-100 text-yellow-800',
                                        'izin' => 'bg-blue-100 text-blue-800',
                                        'sakit' => 'bg-purple-100 text-purple-800',
                                        'alfa' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full {{ $statusColors[$attendance->status] }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('admin.attendances.show', $attendance) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Belum ada riwayat absensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($attendances->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>
</div>
@endsection