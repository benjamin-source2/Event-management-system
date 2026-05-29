@extends('layouts.app', ['title' => 'Invitation Pass'])

@section('content')
<div class="py-8 max-w-2xl mx-auto">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Your Invitation Pass</h1>
        <p class="text-gray-500 dark:text-gray-400">Show this pass at the event entrance</p>
    </div>

    <!-- Digital Pass Card -->
    <div class="premium-card overflow-hidden animate-scale-in">
        <!-- Pass Header -->
        <div class="bg-gradient-to-r from-primary-500 via-accent-500 to-rose-500 p-8 text-white text-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white rounded-full translate-y-1/2 -translate-x-1/2"></div>
            </div>
            <div class="relative">
                <div class="w-16 h-16 mx-auto mb-4 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold">VIP Access Pass</h2>
                <p class="text-white/80 mt-1">{{ $invitation->event->title }}</p>
            </div>
        </div>

        <!-- Pass Body -->
        <div class="p-8">
            <div class="flex justify-center mb-8">
                <div class="bg-white dark:bg-navy-800 rounded-2xl p-4 shadow-lg border border-gray-200 dark:border-navy-700">
                    @if($invitation->qr_code)
                        <img src="data:image/png;base64,{{ $invitation->qr_code }}" alt="QR Code"
                             class="w-48 h-48">
                    @else
                        <div class="w-48 h-48 flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-navy-700">
                    <span class="text-gray-500 dark:text-gray-400">Invitation Code</span>
                    <span class="font-mono font-bold text-gray-900 dark:text-white">{{ $invitation->invitation_code }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-navy-700">
                    <span class="text-gray-500 dark:text-gray-400">Event</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $invitation->event->title }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-navy-700">
                    <span class="text-gray-500 dark:text-gray-400">Date</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $invitation->event->event_date->format('l, F d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-navy-700">
                    <span class="text-gray-500 dark:text-gray-400">Time</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $invitation->event->start_time->format('h:i A') }} - {{ $invitation->event->end_time->format('h:i A') }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-navy-700">
                    <span class="text-gray-500 dark:text-gray-400">Location</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $invitation->event->location }}</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-gray-500 dark:text-gray-400">Status</span>
                    <span class="badge-success">Verified</span>
                </div>
            </div>

            <div class="mt-8 p-4 bg-gray-50 dark:bg-navy-800 rounded-2xl text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    This pass is digitally verified. Please present this QR code at the event entrance for scanning.
                </p>
            </div>
        </div>
    </div>

    <!-- Download Button -->
    <div class="text-center mt-6">
        <button onclick="window.print()" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Download / Print Pass
        </button>
    </div>
</div>
@endsection

@push('styles')
<style media="print">
    @page { margin: 0; }
    body * { visibility: hidden; }
    .premium-card, .premium-card * { visibility: visible; }
    .premium-card { position: absolute; left: 0; top: 0; width: 100%; }
</style>
@endpush
