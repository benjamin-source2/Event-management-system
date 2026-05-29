@extends('layouts.guest', ['title' => 'Contact'])

@section('content')
<div class="min-h-screen hero-gradient pt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <h1 class="text-5xl font-display font-bold text-white mb-6">Get in Touch</h1>
        <p class="text-xl text-gray-300 max-w-2xl mx-auto">Have a question or want to partner with us? We'd love to hear from you.</p>
    </div>
</div>

<div class="py-20 bg-white dark:bg-navy-900">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="premium-card p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Send us a Message</h2>
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
                <button type="submit" class="btn-primary w-full">Send Message</button>
            </form>
        </div>
    </div>
</div>
@endsection
