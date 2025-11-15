@extends('layouts.app')

@section('content')
    Dashboard

<div class="grid md:grid-cols-3 gap-6">
    <!-- Karyawan -->
    <div class="bg-white p-6 rounded-xl shadow border border-gray-100 hover:shadow-lg transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <h3 class="font-semibold text-lg text-gray-900 mb-2">Absensi Karyawan</h3>
        <p class="text-gray-600 text-sm mb-4">Lakukan absensi menggunakan wajah Anda.</p>
        <a href="{{ route('attendance.page') }}"
           class="inline-block w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition-colors font-medium">
           Mulai Absensi
        </a>
    </div>

    @if(auth()->user()->isAdmin())
    <!-- Admin -->
    <div class="bg-white p-6 rounded-xl shadow border border-gray-100 hover:shadow-lg transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
        <h3 class="font-semibold text-lg text-gray-900 mb-2">Kelola Data</h3>
        <p class="text-gray-600 text-sm mb-4">Manajemen karyawan & laporan absensi.</p>
        <a href="{{ route('admin.dashboard') }}"
           class="inline-block w-full text-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition-colors font-medium">
           Dashboard Admin
        </a>
    </div>
    @endif

    <!-- Laporan -->
    <div class="bg-white p-6 rounded-xl shadow border border-gray-100 hover:shadow-lg transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
        <h3 class="font-semibold text-lg text-gray-900 mb-2">Laporan Kehadiran</h3>
        <p class="text-gray-600 text-sm mb-4">Pantau riwayat kehadiran Anda.</p>
        <a href="{{ route('user.attendance') }}"
           class="inline-block w-full text-center bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow transition-colors font-medium">
           Lihat Laporan
        </a>
    </div>
</div>

@if(!auth()->user()->employee)
    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    <strong class="font-medium">Perhatian:</strong> Akun Anda belum terhubung dengan data karyawan. 
                    Silakan hubungi administrator untuk mengaktifkan fitur absensi.
                </p>
            </div>
        </div>
    </div>
@endif

@endsection