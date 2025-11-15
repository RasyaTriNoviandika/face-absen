@extends('layouts.admin')

@section('title', 'Detail Absensi')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Detail Absensi</h3>
                <a href="{{ route('admin.attendances.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    ← Kembali
                </a>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Employee Info -->
            <div class="flex items-start space-x-6 pb-6 border-b border-gray-100">
                @if($attendance->employee->photo)
                    <img src="{{ Storage::url($attendance->employee->photo) }}" 
                         class="w-24 h-24 rounded-xl object-cover shadow-md" 
                         alt="{{ $attendance->employee->name }}">
                @else
                    <div class="w-24 h-24 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold text-3xl shadow-md">
                        {{ substr($attendance->employee->name, 0, 1) }}
                    </div>
                @endif
                
                <div class="flex-1">
                    <h4 class="text-xl font-bold text-gray-900 mb-1">{{ $attendance->employee->name }}</h4>
                    <div class="space-y-1 text-sm text-gray-600">
                        <p><span class="font-medium">NIP:</span> {{ $attendance->employee->nip }}</p>
                        <p><span class="font-medium">Departemen:</span> {{ $attendance->employee->department }}</p>
                        @if($attendance->employee->position)
                            <p><span class="font-medium">Posisi:</span> {{ $attendance->employee->position }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Attendance Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="text-sm font-medium text-gray-500 block mb-1">Tanggal</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $attendance->date->format('d F Y') }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="text-sm font-medium text-gray-500 block mb-1">Status</label>
                    @php
                        $statusColors = [
                            'hadir' => 'bg-green-100 text-green-800',
                            'terlambat' => 'bg-yellow-100 text-yellow-800',
                            'izin' => 'bg-blue-100 text-blue-800',
                            'sakit' => 'bg-purple-100 text-purple-800',
                            'alfa' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    <span class="px-4 py-2 inline-flex text-sm font-semibold rounded-lg {{ $statusColors[$attendance->status] }}">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="text-sm font-medium text-gray-500 block mb-1">Check In</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $attendance->check_in }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="text-sm font-medium text-gray-500 block mb-1">Check Out</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $attendance->check_out ?? '-' }}</p>
                </div>
            </div>

            <!-- Photos -->
            @if($attendance->check_in_photo || $attendance->check_out_photo)
                <div class="pt-6 border-t border-gray-100">
                    <h5 class="text-sm font-semibold text-gray-900 mb-4">Foto Absensi</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($attendance->check_in_photo)
                            <div>
                                <label class="text-sm font-medium text-gray-600 block mb-2">Foto Check In</label>
                                <img src="{{ Storage::url($attendance->check_in_photo) }}" 
                                     class="w-full h-64 object-cover rounded-lg border border-gray-200"
                                     alt="Check In Photo">
                            </div>
                        @endif

                        @if($attendance->check_out_photo)
                            <div>
                                <label class="text-sm font-medium text-gray-600 block mb-2">Foto Check Out</label>
                                <img src="{{ Storage::url($attendance->check_out_photo) }}" 
                                     class="w-full h-64 object-cover rounded-lg border border-gray-200"
                                     alt="Check Out Photo">
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Notes -->
            @if($attendance->notes)
                <div class="pt-6 border-t border-gray-100">
                    <label class="text-sm font-semibold text-gray-900 block mb-2">Catatan</label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700">{{ $attendance->notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.attendances.edit', $attendance) }}" 
                   class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Edit Absensi
                </a>
                <form action="{{ route('admin.attendances.destroy', $attendance) }}" 
                      method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus data absensi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                        Hapus Absensi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection