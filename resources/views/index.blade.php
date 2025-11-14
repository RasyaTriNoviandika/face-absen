<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FaceAttend - Sistem Absensi Wajah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50">
    
    <!-- Navbar -->
    <nav class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-200/50">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        FaceAttend
                    </span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="/login" class="px-6 py-2.5 text-gray-700 hover:text-indigo-600 font-medium transition-colors">
                        Login
                    </a>
                    <a href="/register" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-200 font-medium">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-8">
                    <div class="inline-flex items-center space-x-2 bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full">
                        <span class="w-2 h-2 bg-indigo-600 rounded-full animate-pulse"></span>
                        <span class="text-sm font-semibold">AI-Powered Attendance System</span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-6xl font-bold leading-tight">
                        <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                            Revolusi Absensi
                        </span>
                        <br/>
                        dengan Teknologi Wajah
                    </h1>
                    
                    <p class="text-xl text-gray-600 leading-relaxed">
                        Sistem absensi modern yang menggunakan AI untuk pengenalan wajah. 
                        Cepat, akurat, dan tanpa sentuhan fisik.
                    </p>
                    
                    <div class="flex flex-wrap gap-4">
                        <a href="/attendance" class="group px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:shadow-2xl hover:scale-105 transition-all duration-200 font-semibold inline-flex items-center space-x-2">
                            <span>Mulai Absensi</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        
                        <a href="#features" class="px-8 py-4 bg-white border-2 border-indigo-200 text-indigo-700 rounded-xl hover:border-indigo-400 hover:shadow-lg transition-all duration-200 font-semibold">
                            Lihat Fitur
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-8 pt-8">
                        <div>
                            <div class="text-3xl font-bold text-indigo-600">99.9%</div>
                            <div class="text-sm text-gray-600">Akurasi</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-purple-600">< 2s</div>
                            <div class="text-sm text-gray-600">Kecepatan</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-pink-600">24/7</div>
                            <div class="text-sm text-gray-600">Tersedia</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Image -->
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl transform rotate-6 opacity-20"></div>
                    <div class="relative bg-white rounded-3xl shadow-2xl p-8 float-animation">
                        <div class="aspect-square bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center">
                            <svg class="w-64 h-64 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        
                        <!-- Floating Cards -->
                        <div class="absolute -top-6 -right-6 bg-green-500 text-white px-6 py-3 rounded-2xl shadow-xl">
                            <div class="flex items-center space-x-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="font-semibold">Verified</span>
                            </div>
                        </div>
                        
                        <div class="absolute -bottom-6 -left-6 bg-blue-500 text-white px-6 py-3 rounded-2xl shadow-xl">
                            <div class="flex items-center space-x-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span class="font-semibold">Secure</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-6 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600">Teknologi terdepan untuk sistem absensi modern</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-3xl p-8 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Face Recognition AI</h3>
                    <p class="text-gray-600">Teknologi AI terbaru dengan akurasi 99.9% untuk pengenalan wajah yang cepat dan tepat.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="group bg-gradient-to-br from-purple-50 to-purple-100 rounded-3xl p-8 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Real-time Processing</h3>
                    <p class="text-gray-600">Proses absensi instan dalam hitungan detik tanpa delay atau antrian panjang.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="group bg-gradient-to-br from-pink-50 to-pink-100 rounded-3xl p-8 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Analytics Dashboard</h3>
                    <p class="text-gray-600">Laporan lengkap dan dashboard interaktif untuk monitoring kehadiran karyawan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-3xl p-12 text-center text-white gradient-animate">
                <h2 class="text-4xl font-bold mb-6">Siap Untuk Transformasi Digital?</h2>
                <p class="text-xl mb-8 opacity-90">Bergabunglah dengan ribuan perusahaan yang sudah menggunakan FaceAttend</p>
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="/attendance" class="px-8 py-4 bg-white text-indigo-600 rounded-xl hover:shadow-2xl hover:scale-105 transition-all duration-200 font-semibold">
                        Coba Sekarang
                    </a>
                    <a href="/admin" class="px-8 py-4 bg-white/20 backdrop-blur-lg text-white border-2 border-white/50 rounded-xl hover:bg-white/30 transition-all duration-200 font-semibold">
                        Login Admin
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-6 bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto text-center">
            <div class="flex items-center justify-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold">FaceAttend</span>
            </div>
            <p class="text-gray-400 mb-4">© 2024 FaceAttend. All rights reserved.</p>
            <p class="text-gray-500 text-sm">Powered by AI & Laravel</p>
        </div>
    </footer>

</body>
</html>