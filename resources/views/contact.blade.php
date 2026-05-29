@extends('layouts.guest', ['title' => 'Contact'])

@section('content')
<!-- Hero with background image -->
<div class="relative min-h-[50vh] flex items-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1423666639041-f56000c27a9a?q=80&w=2074&auto=format&fit=crop" 
             alt="Contact us" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-950/85 via-navy-950/65 to-navy-950/30"></div>
    </div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <div class="glass-dark rounded-3xl p-8 md:p-12 inline-block">
            <h1 class="text-5xl md:text-6xl font-display font-bold text-white mb-6">Get in Touch</h1>
            <p class="text-xl text-gray-200 max-w-2xl mx-auto">Have a question or want to partner with us? We'd love to hear from you.</p>
        </div>
    </div>
</div>

<!-- Contact Form - Glass -->
<div class="relative py-24 overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=2029&auto=format&fit=crop" 
             alt="Abstract background" class="w-full h-full object-cover opacity-5 dark:opacity-10">
    </div>
    <div class="relative max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-heavy rounded-3xl p-8 md:p-10 shadow-xl">
            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-primary-500/20 to-accent-500/20 flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Send us a Message</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-2">We'll get back to you within 24 hours</p>
            </div>
            <form class="space-y-6">
                <div class="grid sm:grid-cols-2 gap-6">
                    <div class="input-group">
                        <label class="input-label">Your Name</label>
                        <input type="text" class="input-field" placeholder="John Doe">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Email</label>
                        <input type="email" class="input-field" placeholder="john@example.com">
                    </div>
                </div>
                <div class="input-group">
                    <label class="input-label">Subject</label>
                    <input type="text" class="input-field" placeholder="How can we help?">
                </div>
                <div class="input-group">
                    <label class="input-label">Message</label>
                    <textarea rows="5" class="input-field" placeholder="Your message..."></textarea>
                </div>
                <button type="submit" class="btn-primary w-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Send Message
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
