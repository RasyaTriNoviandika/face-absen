<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi Wajah</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-t-2xl shadow-2xl p-8 text-center">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Sistem Absensi Wajah</h1>
                <p class="text-gray-600 text-lg">Sistem absensi modern menggunakan teknologi pengenalan wajah</p>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-b-2xl shadow-2xl p-8">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Employee Section -->
                    <div class="text-center">
                        <div class="bg-blue-50 rounded-lg p-6 mb-6">
                            <svg class="w-16 h-16 mx-auto mb-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Karyawan</h2>
                            <p class="text-gray-600 mb-6">Lakukan absensi menggunakan wajah Anda</p>
                            <a href="{{ route('attendance.page') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-300">
                                Mulai Absensi
                            </a>
                        </div>
                    </div>

                    <!-- Admin Section -->
                    <div class="text-center">
                        <div class="bg-green-50 rounded-lg p-6 mb-6">
                            <svg class="w-16 h-16 mx-auto mb-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Administrator</h2>
                            <p class="text-gray-600 mb-6">Kelola data karyawan dan laporan absensi</p>
                            @auth
                                <a href="{{ route('admin.dashboard') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-300">
                                    Dashboard Admin
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-300">
                                    Login Admin
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="mt-12 text-center">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Fitur Utama</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <svg class="w-12 h-12 mx-auto mb-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <h4 class="font-semibold text-gray-800">Pengenalan Wajah</h4>
                            <p class="text-gray-600 text-sm">Teknologi AI untuk identifikasi akurat</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <svg class="w-12 h-12 mx-auto mb-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h4 class="font-semibold text-gray-800">Real-time</h4>
                            <p class="text-gray-600 text-sm">Absensi instan tanpa menunggu lama</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <svg class="w-12 h-12 mx-auto mb-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <h4 class="font-semibold text-gray-800">Laporan Lengkap</h4>
                            <p class="text-gray-600 text-sm">Monitoring dan analisis kehadiran</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
