<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0F172A">

    <title>{{ config('app.name', 'Rwanda EventHub') }} @isset($title) - {{ $title }} @endisset</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800|poppins:300,400,500,600,700,800|manrope:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased">
    <!-- Guest Navigation -->
    <nav class="absolute top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center shadow-lg shadow-primary-500/30">
                        <span class="text-white font-bold">RE</span>
                    </div>
                    <span class="text-xl font-display font-bold text-white">Rwanda EventHub</span>
                </a>

                <div class="flex items-center gap-4">
                    <a href="{{ route('events.index') }}" class="text-gray-300 hover:text-white transition-colors font-medium">Events</a>
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors font-medium">Login</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-medium transition-all duration-200 border border-white/10">
                        Sign Up
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Toast Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
             class="fixed top-4 right-4 z-50 max-w-md bg-emerald-500 text-white px-6 py-4 shadow-2xl flex items-center gap-3 animate-slide-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto text-white/80 hover:text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
             class="fixed top-4 right-4 z-50 max-w-md bg-rose-500 text-white px-6 py-4 shadow-2xl flex items-center gap-3 animate-slide-down">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
            <button @click="show = false" class="ml-auto text-white/80 hover:text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Page Content -->
    <main>
        @isset($slot)
            {{ $slot }}
        @endisset
        @isset($section)
            {{ $section }}
        @endisset
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
