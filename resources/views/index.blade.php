<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FaceAttend - Sistem Absensi Wajah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    
    <!-- Navbar - Clean & Minimal -->
    <nav class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-lg font-semibold text-gray-900">FaceAttend</span>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="/login" class="px-4 py-2 text-sm text-gray-700 hover:text-gray-900 font-medium transition">
                        Masuk
                    </a>
                    <a href="/register" class="px-5 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition">
                        Daftar 
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section - Simple & Direct -->
    <section class="pt-32 pb-20 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-full text-sm font-medium mb-8">
                <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
            SMKN 9 KOTA BEKASI
            </div>
            
            <h1 class="text-5xl font-bold text-gray-900 mb-6 leading-tight">
                Absensi Otomatis dengan<br/>
                <span class="text-blue-600">Pengenalan Wajah</span>
            </h1>
            
            <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                Sistem absensi modern yang akurat, cepat, dan tanpa sentuhan. 
                Cukup hadapkan wajah Anda ke kamera.
            </p>
            
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <a href="{{route('login')}}" class="px-8 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-semibold text-lg shadow-lg shadow-blue-600/30 transition inline-flex items-center gap-2">
                    <span>Coba Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                
                <a href="#features" class="px-8 py-4 bg-white border-2 border-gray-200 text-gray-700 rounded-xl hover:border-gray-300 font-semibold text-lg transition">
                    Pelajari Lebih Lanjut
                </a>
            </div>
            
            <!-- Stats - Clean -->
            <div class="grid grid-cols-3 gap-8 max-w-2xl mx-auto">
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-1">99.9%</div>
                    <div class="text-sm text-gray-600">Akurasi</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-1">< 2s</div>
                    <div class="text-sm text-gray-600">Kecepatan</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-1">24/7</div>
                    <div class="text-sm text-gray-600">Aktif</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features - Card Simple -->
    <section id="features" class="py-20 px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Kenapa FaceAttend?</h2>
                <p class="text-lg text-gray-600">Tiga alasan utama menggunakan sistem kami</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-8 hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Cepat & Akurat</h3>
                    <p class="text-gray-600">Proses verifikasi dalam hitungan detik dengan akurasi 99.9%</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-8 hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Aman & Terpercaya</h3>
                    <p class="text-gray-600">Data wajah terenkripsi dengan standar keamanan tinggi</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-8 hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Laporan Real-time</h3>
                    <p class="text-gray-600">Dashboard lengkap untuk monitoring kehadiran</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-6">
        <div class="flex flex-wrap justify-center gap-4 mb-12">
        @auth
        @if(auth()->user()->employee && auth()->user()->employee->face_registered)
            <a href="/attendance" class="px-8 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-semibold text-lg shadow-lg shadow-blue-600/30 transition inline-flex items-center gap-2">
                <span>Absen Sekarang</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        @else
            <button onclick="alert('Silakan hubungi admin untuk mendaftarkan wajah Anda terlebih dahulu.')" class="px-8 py-4 bg-gray-400 text-white rounded-xl font-semibold text-lg shadow-lg cursor-not-allowed">
                Wajah Belum Terdaftar
            </button>
        @endif
        @else
        <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-semibold text-lg shadow-lg shadow-blue-600/30 transition inline-flex items-center gap-2">
            <span>Login untuk Absen</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
        </a>
        @endauth
    
    <a href="#features" class="px-8 py-4 bg-white border-2 border-gray-200 text-gray-700 rounded-xl hover:border-gray-300 font-semibold text-lg transition">
        Pelajari Lebih Lanjut
    </a>
    </div>
    </section>

     {{-- <!-- CTA Section -->
    <section class="py-20 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-3xl p-12 text-center text-white shadow-xl">
                <h2 class="text-3xl font-bold mb-4">Mulai Sekarang</h2>
                <p class="text-lg text-blue-100 mb-8">Gratis untuk 30 hari pertama, tanpa kartu kredit</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="/attendance" class="px-8 py-4 bg-white text-blue-600 rounded-xl hover:bg-blue-50 font-semibold text-lg transition">
                        Coba Absen Sekarang
                    </a>
                    <a href="/register" class="px-8 py-4 bg-blue-800 text-white rounded-xl hover:bg-blue-900 font-semibold text-lg transition">
                        Daftar Akun
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-8 px-6 border-t border-gray-100">
        <div class="max-w-6xl mx-auto text-center">
            <div class="flex items-center justify-center gap-2 mb-4">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-lg font-semibold text-gray-900">FaceAttend</span>
            </div>
            <p class="text-gray-600 text-sm">© 2024 FaceAttend. Sistem Absensi Wajah Modern.</p>
        </div>
    </footer>

</body>
</html>