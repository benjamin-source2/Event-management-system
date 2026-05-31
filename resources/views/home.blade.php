@php
    $isGuest = !auth()->check();
@endphp

@extends($isGuest ? 'layouts.guest' : 'layouts.app', ['title' => 'Home'])

@section('content')
    @if($isGuest)
        {{-- Guest Home Page --}}
        <!-- Hero Section -->
        <div class="relative hero-gradient min-h-screen flex items-center overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-20 left-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-accent-500/10 rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/5 rounded-full blur-3xl"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/10">
                            <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                            <span class="text-sm text-gray-300">Discover events across Rwanda</span>
                        </div>

                        <h1 class="text-5xl md:text-7xl font-display font-bold text-white leading-tight">
                            Discover & Experience
                            <span class="gradient-text">Rwanda's</span>
                            Best Events
                        </h1>

                        <p class="text-xl text-gray-300 leading-relaxed">
                            Your gateway to the most exciting events in Rwanda. From tech conferences to cultural festivals, find and book your next unforgettable experience.
                        </p>

                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('events.index') }}"
                               class="btn-primary btn-lg inline-flex items-center gap-2 group">
                                Explore Events
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-medium rounded-2xl transition-all duration-200 border border-white/10">
                                Get Started
                            </a>
                        </div>

                        <!-- Stats -->
                        <div class="flex items-center gap-8 pt-4">
                            <div>
                                <p class="text-3xl font-bold text-white">{{ $totalEvents }}+</p>
                                <p class="text-sm text-gray-400">Events Listed</p>
                            </div>
                            <div class="w-px h-12 bg-white/10"></div>
                            <div>
                                <p class="text-3xl font-bold text-white">{{ $totalOrganizers }}+</p>
                                <p class="text-sm text-gray-400">Organizers</p>
                            </div>
                            <div class="w-px h-12 bg-white/10"></div>
                            <div>
                                <p class="text-3xl font-bold text-white">{{ count($categories) }}</p>
                                <p class="text-sm text-gray-400">Categories</p>
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:block relative">
                        <div class="relative z-10">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-4">
                                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 animate-float">
                                        <div class="w-12 h-12 bg-primary-500/20 rounded-xl flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <p class="text-white font-semibold">10K+ Users</p>
                                        <p class="text-sm text-gray-400">Active community members</p>
                                    </div>
                                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 animate-float" style="animation-delay: 0.5s">
                                        <div class="w-12 h-12 bg-accent-500/20 rounded-xl flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <p class="text-white font-semibold">500+ Events</p>
                                        <p class="text-sm text-gray-400">Happening this month</p>
                                    </div>
                                </div>
                                <div class="space-y-4 pt-8">
                                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 animate-float" style="animation-delay: 1s">
                                        <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <p class="text-white font-semibold">Verified</p>
                                        <p class="text-sm text-gray-400">Secure verification system</p>
                                    </div>
                                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 animate-float" style="animation-delay: 1.5s">
                                        <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                        </div>
                                        <p class="text-white font-semibold">Real-time</p>
                                        <p class="text-sm text-gray-400">Instant notifications</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <section class="py-20 bg-white dark:bg-navy-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="section-title">Browse by Category</h2>
                    <p class="section-subtitle">Find events that match your interests</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach(\App\Models\Event::CATEGORIES as $key => $category)
                        <a href="{{ route('events.index', ['category' => $key]) }}"
                           class="group glass-card-hover p-6 text-center">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-primary-500/10 to-accent-500/10 flex items-center justify-center group-hover:from-primary-500/20 group-hover:to-accent-500/20 transition-all duration-300">
                                @switch($key)
                                    @case('wedding')
                                        <svg class="w-7 h-7 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        @break
                                    @case('conference')
                                        <svg class="w-7 h-7 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        @break
                                    @case('music')
                                        <svg class="w-7 h-7 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                        @break
                                    @case('technology')
                                        <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        @break
                                    @default
                                        <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                @endswitch
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-500 transition-colors">{{ $category }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Featured Events -->
        @if($featuredEvents->count() > 0)
            <section class="py-20 bg-gray-50 dark:bg-navy-950">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-end justify-between mb-12">
                        <div>
                            <h2 class="section-title">Featured Events</h2>
                            <p class="section-subtitle">Hand-picked events you shouldn't miss</p>
                        </div>
                        <a href="{{ route('events.index') }}" class="btn-outline btn-sm hidden sm:flex">View All</a>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($featuredEvents as $event)
                            <x-event-card :event="$event" />
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- How It Works -->
        <section class="py-20 bg-white dark:bg-navy-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="section-title">How It Works</h2>
                    <p class="section-subtitle">Getting started is easy</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-3xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center shadow-xl shadow-primary-500/20">
                            <span class="text-3xl font-bold text-white">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Create Account</h3>
                        <p class="text-gray-500 dark:text-gray-400">Sign up for free and set up your profile to get started with Rwanda EventHub.</p>
                    </div>

                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-3xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-xl shadow-emerald-500/20">
                            <span class="text-3xl font-bold text-white">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Browse Events</h3>
                        <p class="text-gray-500 dark:text-gray-400">Discover events that match your interests across all categories and locations in Rwanda.</p>
                    </div>

                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-3xl bg-gradient-to-br from-amber-500 to-rose-500 flex items-center justify-center shadow-xl shadow-amber-500/20">
                            <span class="text-3xl font-bold text-white">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Get Your Pass</h3>
                        <p class="text-gray-500 dark:text-gray-400">Request an invitation, get approved, and receive your digital pass with QR code.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Upcoming Events -->
        @if($upcomingEvents->count() > 0)
            <section class="py-20 bg-gray-50 dark:bg-navy-950">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-end justify-between mb-12">
                        <div>
                            <h2 class="section-title">Upcoming Events</h2>
                            <p class="section-subtitle">Don't miss out on these amazing events</p>
                        </div>
                        <a href="{{ route('events.index') }}" class="btn-primary btn-sm hidden sm:flex">View All Events</a>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($upcomingEvents as $event)
                            <x-event-card :event="$event" />
                        @endforeach
                    </div>

                    <div class="text-center mt-8 sm:hidden">
                        <a href="{{ route('events.index') }}" class="btn-primary">View All Events</a>
                    </div>
                </div>
            </section>
        @endif

        <!-- CTA -->
        <section class="py-20 hero-gradient relative overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute top-10 right-10 w-64 h-64 bg-primary-500/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 left-10 w-80 h-80 bg-accent-500/10 rounded-full blur-3xl"></div>
            </div>

            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl md:text-5xl font-display font-bold text-white mb-6">
                    Ready to Experience Rwanda's Best Events?
                </h2>
                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                    Join thousands of people already discovering and attending amazing events across the country.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('register') }}" class="btn-primary btn-lg bg-white text-primary-600 hover:bg-gray-100">
                        Get Started Free
                    </a>
                    <a href="{{ route('events.index') }}" class="btn-outline btn-lg border-white/30 text-white hover:bg-white hover:text-navy-900">
                        Browse Events
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-navy-950 text-gray-400 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-4 gap-8">
                    <div class="col-span-2 md:col-span-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-accent-500 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">RE</span>
                            </div>
                            <span class="text-lg font-bold text-white">Rwanda EventHub</span>
                        </div>
                        <p class="text-sm text-gray-500">Your premier destination for discovering and attending the best events across Rwanda.</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Quick Links</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('events.index') }}" class="text-sm hover:text-white transition-colors">Browse Events</a></li>
                            <li><a href="{{ route('about') }}" class="text-sm hover:text-white transition-colors">About Us</a></li>
                            <li><a href="{{ route('contact') }}" class="text-sm hover:text-white transition-colors">Contact</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Categories</h4>
                        <ul class="space-y-2">
                            @foreach(array_slice(\App\Models\Event::CATEGORIES, 0, 5) as $key => $cat)
                                <li><a href="{{ route('events.index', ['category' => $key]) }}" class="text-sm hover:text-white transition-colors">{{ $cat }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Connect</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-sm hover:text-white transition-colors">Twitter</a></li>
                            <li><a href="#" class="text-sm hover:text-white transition-colors">Instagram</a></li>
                            <li><a href="#" class="text-sm hover:text-white transition-colors">LinkedIn</a></li>
                        </ul>
                    </div>
                </div>

                <div class="divider my-8"></div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-sm">
                    <span>&copy; {{ date('Y') }} Rwanda EventHub</span>
                    <span>Developed by Phoenix</span>
                </div>
            </div>
        </footer>
    @else
        {{-- Authenticated Home Redirect --}}
        <div class="py-12">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Welcome back, {{ auth()->user()->first_name }}!</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-8">What would you like to do today?</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('events.index') }}" class="btn-primary">Browse Events</a>
                    <a href="{{ route('dashboard') }}" class="btn-secondary">My Dashboard</a>
                </div>
            </div>
        </div>
    @endif

    <!-- Latest Events -->
    @if($latestEvents->count() > 0)
        <section class="py-20 bg-white dark:bg-navy-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <h2 class="section-title">New Events</h2>
                        <p class="section-subtitle">Recently added events you might be interested in</p>
                    </div>
                    <a href="{{ route('events.index') }}" class="btn-outline btn-sm hidden sm:flex">View All</a>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($latestEvents as $event)
                        <x-event-card :event="$event" />
                    @endforeach
                </div>

                <div class="text-center mt-8 sm:hidden">
                    <a href="{{ route('events.index') }}" class="btn-outline">View All</a>
                </div>
            </div>
        </section>
    @endif
@endsection
