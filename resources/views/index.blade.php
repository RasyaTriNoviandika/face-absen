<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FaceAttend - Sistem Absensi Wajah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    
    <!-- Navbar -->
    <nav class="fixed w-full top-0 z-50 bg-white/90 backdrop-blur-sm border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">FaceAttend</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <a href="/login" class="px-4 py-2 text-sm text-gray-700 hover:text-gray-900">
                        Login
                    </a>
                    <a href="/register" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 pb-16 px-4 sm:px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <div class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium mb-6">
                        <span class="w-2 h-2 bg-indigo-600 rounded-full"></span>
                        AI-Powered System
                    </div>
                    
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                        Absensi Modern dengan <span class="text-indigo-600">Face Recognition</span>
                    </h1>
                    
                    <p class="text-lg text-gray-600 mb-8">
                        Sistem absensi cerdas menggunakan AI untuk pengenalan wajah. Cepat, akurat, dan tanpa sentuhan.
                    </p>
                    
                    <div class="flex flex-wrap gap-3 mb-8">
                        <a href="/attendance" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium inline-flex items-center gap-2">
                            <span>Mulai Absensi</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        
                        <a href="#features" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:border-gray-400 font-medium">
                            Lihat Fitur
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6">
                        <div>
                            <div class="text-2xl font-bold text-indigo-600">99.9%</div>
                            <div class="text-sm text-gray-600">Akurasi</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-indigo-600">< 2s</div>
                            <div class="text-sm text-gray-600">Kecepatan</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-indigo-600">24/7</div>
                            <div class="text-sm text-gray-600">Tersedia</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Image -->
                <div class="relative">
                    <div class="bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl p-8 aspect-square flex items-center justify-center">
                        <svg class="w-64 h-64 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    
                    <!-- Floating Cards -->
                    <div class="absolute -top-4 -right-4 bg-white px-4 py-2 rounded-lg shadow-lg border border-gray-100">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="font-semibold text-gray-900">Verified</span>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-4 -left-4 bg-white px-4 py-2 rounded-lg shadow-lg border border-gray-100">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span class="font-semibold text-gray-900">Secure</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 px-4 sm:px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">Fitur Unggulan</h2>
                <p class="text-lg text-gray-600">Teknologi terdepan untuk sistem absensi modern</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Face Recognition AI</h3>
                    <p class="text-gray-600">Teknologi AI dengan akurasi 99.9% untuk pengenalan wajah yang cepat dan tepat.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Real-time Processing</h3>
                    <p class="text-gray-600">Proses absensi instan dalam hitungan detik tanpa delay atau antrian panjang.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Analytics Dashboard</h3>
                    <p class="text-gray-600">Laporan lengkap dan dashboard interaktif untuk monitoring kehadiran.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 px-4 sm:px-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 sm:p-12 text-center text-white">
                <h2 class="text-3xl font-bold mb-4">Siap Untuk Transformasi Digital?</h2>
                <p class="text-lg opacity-90 mb-6">Bergabunglah dengan sistem absensi modern</p>
                <div class="flex flex-wrap gap-3 justify-center">
                    <a href="/attendance" class="px-6 py-3 bg-white text-indigo-600 rounded-lg hover:bg-gray-50 font-semibold">
                        Coba Sekarang
                    </a>
                    <a href="/admin" class="px-6 py-3 bg-white/20 text-white border border-white/50 rounded-lg hover:bg-white/30 font-semibold">
                        Login Admin
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 px-4 sm:px-6 bg-gray-900 text-white">
        <div class="max-w-6xl mx-auto text-center">
            <div class="flex items-center justify-center gap-2 mb-4">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-lg font-bold">FaceAttend</span>
            </div>
            <p class="text-gray-400 text-sm mb-2">© 2024 FaceAttend. All rights reserved.</p>
            <p class="text-gray-500 text-sm">Powered by AI & Laravel</p>
        </div>
    </footer>

</body>
</html>