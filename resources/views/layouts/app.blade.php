<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Absensi Wajah') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">

    <div class="min-h-screen">

        {{-- NAVBAR --}}
        <nav class="bg-white shadow-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

                <a href="/" class="text-xl font-bold text-gray-800">
                    Absensi Wajah
                </a>

                <div class="flex items-center gap-4">
                    @auth
                        <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                           Login
                        </a>
                    @endauth
                </div>

            </div>
        </nav>

        {{-- OPTIONAL PAGE HEADER --}}
        @isset($header)
            <header class="bg-white shadow-sm mb-6">
                <div class="max-w-7xl mx-auto px-6 py-5">
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ $header }}
                    </h2>
                </div>
            </header>
        @endisset

        {{-- MAIN CONTENT --}}
        <main class="max-w-7xl mx-auto px-6 py-6">
            @yield('content')
        </main>

    </div>

</body>
</html>
