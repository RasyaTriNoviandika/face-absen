<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="grid md:grid-cols-3 gap-6">

        <!-- Karyawan -->
        <div class="bg-white p-6 rounded-xl shadow border border-gray-100 hover:shadow-lg transition">
            <h3 class="font-semibold text-lg text-gray-900 mb-2">Absensi Karyawan</h3>
            <p class="text-gray-600 text-sm mb-4">Lakukan absensi menggunakan wajah Anda.</p>

            <a href="{{ route('attendance.page') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
               Mulai Absensi
            </a>
        </div>

        <!-- Admin -->
        <div class="bg-white p-6 rounded-xl shadow border border-gray-100 hover:shadow-lg transition">
            <h3 class="font-semibold text-lg text-gray-900 mb-2">Kelola Data</h3>
            <p class="text-gray-600 text-sm mb-4">Manajemen karyawan & laporan absensi.</p>

            <a href="{{ route('admin.dashboard') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
               Dashboard Admin
            </a>
        </div>

        <!-- Laporan -->
        <div class="bg-white p-6 rounded-xl shadow border border-gray-100 hover:shadow-lg transition">
            <h3 class="font-semibold text-lg text-gray-900 mb-2">Laporan Kehadiran</h3>
            <p class="text-gray-600 text-sm mb-4">Pantau riwayat kehadiran Anda.</p>

            <a href="{{ route('user.attendance') }}"
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow">
               Lihat Laporan
            </a>
        </div>

    </div>

</x-app-layout>
