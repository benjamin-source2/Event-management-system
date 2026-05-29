@extends('layouts.app', ['title' => 'Verify Invitation'])

@section('content')
<div class="py-8 max-w-2xl mx-auto">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white">Verify Invitation</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-2">Scan or enter an invitation code to verify</p>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-700 dark:text-emerald-400">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 rounded-xl text-rose-700 dark:text-rose-400">
            {{ session('error') }}
        </div>
    @endif

    @if (session('info'))
        <div class="mb-6 p-4 bg-primary-50 dark:bg-primary-900/30 border border-primary-200 dark:border-primary-800 rounded-xl text-primary-700 dark:text-primary-400">
            {{ session('info') }}
        </div>
    @endif

    <div class="glass-card p-8">
        <form action="{{ route('verification.verify') }}" method="POST" class="space-y-6">
            @csrf
            <div class="input-group">
                <label for="code" class="input-label">Invitation Code</label>
                <input
                    type="text"
                    id="code"
                    name="code"
                    placeholder="Enter invitation code (e.g., INV-XXXXXX)"
                    class="input-field text-center text-lg font-mono tracking-wider"
                    required
                    autofocus
                >
                @error('code')
                    <p class="text-sm text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary w-full">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Verify Invitation
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 dark:border-navy-700">
            <div class="text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-navy-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    You can also use a QR scanner app to scan invitation passes directly.
                </p>
            </div>
        </div>
    </div>

    @if(session('last_result'))
    <div class="mt-6 glass-card p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Last Verification Result</h3>
        <div class="space-y-2 text-sm">
            <p><span class="font-medium text-gray-500 dark:text-gray-400">Status:</span>
                <span class="badge-{{ session('last_result.valid') ? 'success' : 'danger' }}">
                    {{ session('last_result.valid') ? 'Valid' : 'Invalid' }}
                </span>
            </p>
            @if(session('last_result.event'))
            <p><span class="font-medium text-gray-500 dark:text-gray-400">Event:</span> {{ session('last_result.event') }}</p>
            @endif
            @if(session('last_result.attendee'))
            <p><span class="font-medium text-gray-500 dark:text-gray-400">Attendee:</span> {{ session('last_result.attendee') }}</p>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
