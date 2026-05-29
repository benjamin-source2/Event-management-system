@extends('layouts.guest', ['title' => 'About'])

@section('content')
<!-- Hero with background image -->
<div class="relative min-h-[60vh] flex items-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=2070&auto=format&fit=crop" 
             alt="Rwanda landscape" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-950/90 via-navy-950/70 to-navy-950/40"></div>
    </div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <div class="glass-dark rounded-3xl p-8 md:p-12 inline-block">
            <h1 class="text-5xl md:text-6xl font-display font-bold text-white mb-6">About Rwanda EventHub</h1>
            <p class="text-xl text-gray-200 max-w-2xl mx-auto leading-relaxed">Connecting people with the best events across Rwanda. Our platform makes discovering and attending events seamless, secure, and enjoyable.</p>
        </div>
    </div>
</div>

<!-- Stats Banner -->
<div class="relative -mt-16 z-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-heavy rounded-2xl p-8 grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <p class="text-3xl font-bold text-primary-500 dark:text-primary-400">500+</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Events Hosted</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-emerald-500">10K+</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Happy Users</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-accent-500">50+</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Categories</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-amber-500">99%</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Satisfaction</p>
            </div>
        </div>
    </div>
</div>

<!-- Mission / Vision / Values - Glass Cards with image background -->
<div class="relative py-24 overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop" 
             alt="Technology background" class="w-full h-full object-cover opacity-10 dark:opacity-5">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center glass-heavy rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Our Mission</h3>
                <p class="text-gray-500 dark:text-gray-400">To make event discovery and attendance simple, secure, and accessible for everyone in Rwanda.</p>
            </div>
            <div class="text-center glass-heavy rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Our Vision</h3>
                <p class="text-gray-500 dark:text-gray-400">To become the leading event management platform in Rwanda, powering unforgettable experiences.</p>
            </div>
            <div class="text-center glass-heavy rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-accent-100 dark:bg-accent-900/30 flex items-center justify-center">
                    <svg class="w-8 h-8 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Our Values</h3>
                <p class="text-gray-500 dark:text-gray-400">Innovation, security, community, and excellence in everything we do.</p>
            </div>
        </div>
    </div>
</div>
@endsection
