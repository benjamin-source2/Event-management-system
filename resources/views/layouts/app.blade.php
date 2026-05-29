<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ auth()->user()?->theme_preference === 'dark' ? 'dark' : '' }}">
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
<body class="font-sans antialiased bg-gray-50 dark:bg-navy-950 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @auth
            @include('layouts.sidebar')
        @endauth

        <!-- Main Content -->
        <div class="flex-1 flex flex-col @auth lg:ml-64 @endauth">
            <!-- Top Navigation -->
            @auth
                @include('layouts.navigation')
            @endauth

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-navy-900 border-b border-gray-200 dark:border-navy-700 shadow-sm">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">
                                    {{ $header }}
                                </h1>
                                @isset($subheader)
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $subheader }}</p>
                                @endisset
                            </div>
                            @isset($headerActions)
                                <div class="flex items-center gap-3">
                                    {{ $headerActions }}
                                </div>
                            @endisset
                        </div>
                    </div>
                </header>
            @endisset

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

            @if(session('warning'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                     class="fixed top-4 right-4 z-50 max-w-md bg-amber-500 text-white px-6 py-4 shadow-2xl flex items-center gap-3 animate-slide-down">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    <span class="font-medium">{{ session('warning') }}</span>
                    <button @click="show = false" class="ml-auto text-white/80 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        @isset($slot)
                            {{ $slot }}
                        @endisset
                        @yield('content')
                    </div>
                </div>
            </main>

            <!-- Footer -->
            @auth
                <footer class="bg-white dark:bg-navy-900 border-t border-gray-200 dark:border-navy-700 py-4">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                            <span>&copy; {{ date('Y') }} {{ config('app.name', 'Rwanda EventHub') }}</span>
                            <span>Developed by Phoenix</span>
                        </div>
                    </div>
                </footer>
            @endauth
        </div>
    </div>

    @stack('scripts')
</body>
</html>
