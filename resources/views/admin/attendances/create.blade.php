@extends('layouts.admin')

@section('title', 'Tambah Absensi Manual')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Tambah Absensi Manual</h3>
            <p class="text-sm text-gray-600 mt-1">Input data absensi secara manual untuk karyawan</p>
        </div>

        <form action="{{ route('admin.attendances.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Karyawan *</label>
                <select name="employee_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('employee_id') border-red-500 @enderror"
                        required>
                    <option value="">Pilih Karyawan</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }} ({{ $employee->nip }})
                        </option>
                    @endforeach
                </select>
                @error('employee_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal *</label>
                <input type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date') border-red-500 @enderror"
                       required>
                @error('date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Check In *</label>
                    <input type="time" name="check_in" value="{{ old('check_in') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('check_in') border-red-500 @enderror"
                           required>
                    @error('check_in')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Check Out</label>
                    <input type="time" name="check_out" value="{{ old('check_out') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('check_out') border-red-500 @enderror">
                    @error('check_out')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <select name="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
required>
<option value="">Pilih Status</option>
<option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
<option value="terlambat" {{ old('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
<option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
<option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
<option value="alfa" {{ old('status') == 'alfa' ? 'selected' : '' }}>Alfa</option>
</select>
@error('status')
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>
<div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
            <textarea name="notes" rows="3" 
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
            @error('notes')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('admin.attendances.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Kembali
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                Simpan Absensi
            </button>
        </div>
    </form>
</div>
</div>
@endsection