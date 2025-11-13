@extends('layouts.admin')

@section('title', 'Daftar Karyawan')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold">Daftar Karyawan</h3>
        <a href="{{ route('admin.employees.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            + Tambah Karyawan
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-3 px-4">Foto</th>
                    <th class="text-left py-3 px-4">Nama</th>
                    <th class="text-left py-3 px-4">NIP</th>
                    <th class="text-left py-3 px-4">Departemen</th>
                    <th class="text-left py-3 px-4">Status Wajah</th>
                    <th class="text-left py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">
                            @if($employee->photo)
                                <img src="{{ Storage::url($employee->photo) }}" class="w-12 h-12 rounded-full object-cover" alt="{{ $employee->name }}">
                            @else
                                <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                                    {{ substr($employee->name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $employee->name }}</td>
                        <td class="py-3 px-4">{{ $employee->nip }}</td>
                        <td class="py-3 px-4">{{ $employee->department }}</td>
                        <td class="py-3 px-4">
                            @if($employee->face_registered)
                                <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">Terdaftar</span>
                            @else
                                <a href="{{ route('admin.employees.register-face', $employee) }}" class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-800 hover:bg-red-200">
                                    Belum Daftar
                                </a>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.employees.show', $employee) }}" class="text-blue-500 hover:text-blue-700">Detail</a>
                                <a href="{{ route('admin.employees.edit', $employee) }}" class="text-green-500 hover:text-green-700">Edit</a>
                                <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Yakin hapus karyawan ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Belum ada karyawan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $employees->links() }}
    </div>
</div>
@endsection