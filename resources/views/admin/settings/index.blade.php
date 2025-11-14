@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Pengaturan Sistem</h3>
            <p class="text-sm text-gray-600 mt-1">Kelola konfigurasi sistem absensi</p>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Company Info -->
            <div class="space-y-4">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Informasi Perusahaan</h4>
                
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Perusahaan
                    </label>
                    <input type="text" 
                           id="company_name" 
                           name="company_name" 
                           value="{{ old('company_name', $settings['company_name']) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('company_name') border-red-500 @enderror"
                           required>
                    @error('company_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <!-- Working Hours -->
            <div class="space-y-4">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Jam Kerja</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="work_start_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Jam Masuk
                        </label>
                        <input type="time" 
                               id="work_start_time" 
                               name="work_start_time" 
                               value="{{ old('work_start_time', substr($settings['work_start_time'], 0, 5)) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('work_start_time') border-red-500 @enderror"
                               required>
                        @error('work_start_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="work_end_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Jam Pulang
                        </label>
                        <input type="time" 
                               id="work_end_time" 
                               name="work_end_time" 
                               value="{{ old('work_end_time', substr($settings['work_end_time'], 0, 5)) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('work_end_time') border-red-500 @enderror"
                               required>
                        @error('work_end_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="late_tolerance_minutes" class="block text-sm font-medium text-gray-700 mb-2">
                        Toleransi Keterlambatan (Menit)
                    </label>
                    <input type="number" 
                           id="late_tolerance_minutes" 
                           name="late_tolerance_minutes" 
                           value="{{ old('late_tolerance_minutes', $settings['late_tolerance_minutes']) }}"
                           min="0" 
                           max="60"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('late_tolerance_minutes') border-red-500 @enderror"
                           required>
                    <p class="mt-1 text-xs text-gray-500">Waktu toleransi sebelum dianggap terlambat</p>
                    @error('late_tolerance_minutes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <!-- Face Recognition -->
            <div class="space-y-4">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Face Recognition</h4>
                
                <div>
                    <label for="face_recognition_threshold" class="block text-sm font-medium text-gray-700 mb-2">
                        Threshold Pengenalan Wajah
                    </label>
                    <div class="flex items-center gap-4">
                        <input type="range" 
                               id="face_recognition_threshold" 
                               name="face_recognition_threshold" 
                               value="{{ old('face_recognition_threshold', $settings['face_recognition_threshold']) }}"
                               min="0" 
                               max="1" 
                               step="0.05"
                               class="flex-1"
                               oninput="document.getElementById('threshold_value').textContent = this.value">
                        <span id="threshold_value" class="text-sm font-medium text-gray-700 min-w-[3rem]">
                            {{ $settings['face_recognition_threshold'] }}
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Semakin tinggi nilai (mendekati 1), semakin ketat pengenalan wajah. 
                        Nilai yang direkomendasikan: 0.5 - 0.7
                    </p>
                    @error('face_recognition_threshold')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">Tips Pengaturan Threshold:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>0.4 - 0.5: Lebih permisif, cocok untuk kondisi pencahayaan bervariasi</li>
                                <li>0.6 - 0.7: Seimbang, direkomendasikan untuk penggunaan umum</li>
                                <li>0.8 - 1.0: Sangat ketat, hanya untuk kondisi optimal</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    ← Kembali ke Dashboard
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    <!-- Info Card -->
    <div class="mt-6 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
        <h4 class="text-lg font-semibold mb-2">Tentang Sistem</h4>
        <p class="text-purple-100 text-sm mb-4">
            Sistem Absensi Face Recognition v1.0 - Menggunakan teknologi AI untuk pengenalan wajah yang akurat dan aman.
        </p>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-purple-200">Framework</p>
                <p class="font-semibold">Laravel 11</p>
            </div>
            <div>
                <p class="text-purple-200">Face Recognition</p>
                <p class="font-semibold">Face-API.js</p>
            </div>
        </div>
    </div>
</div>
@endsection