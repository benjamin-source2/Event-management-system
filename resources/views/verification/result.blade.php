@extends('layouts.app', ['title' => 'Verification Result'])

@section('content')
<div class="py-8 max-w-2xl mx-auto">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white">Verification Result</h1>
    </div>

    <div class="glass-card p-8">
        @if($invitation->approval_status === 'approved')
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-emerald-500">Valid Invitation</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">This invitation is approved and valid.</p>
        </div>
        @elseif($invitation->approval_status === 'rejected')
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto bg-rose-100 dark:bg-rose-900/30 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-rose-500">Rejected Invitation</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">This invitation has been rejected.</p>
        </div>
        @else
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-amber-500">Pending Invitation</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">This invitation is still pending approval.</p>
        </div>
        @endif

        <div class="grid grid-cols-2 gap-6 p-6 bg-gray-50 dark:bg-navy-800 rounded-xl">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Invitation Code</p>
                <p class="text-lg font-mono font-bold text-gray-900 dark:text-white mt-1">{{ $invitation->invitation_code }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</p>
                <span class="inline-flex items-center px-3 py-1 mt-1 text-xs font-medium rounded-full
                    @if($invitation->approval_status === 'approved') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                    @elseif($invitation->approval_status === 'rejected') bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400
                    @else bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                    @endif">
                    {{ ucfirst($invitation->approval_status) }}
                </span>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Event</p>
                <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $invitation->event?->title ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Event Date</p>
                <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $invitation->event?->event_date?->format('M d, Y') ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Attendee</p>
                <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $invitation->user?->full_name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</p>
                <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $invitation->user?->email ?? 'N/A' }}</p>
            </div>
        </div>

        @if($invitation->approval_status === 'approved' && !$invitation->attended)
        <div class="mt-6">
            <form action="{{ route('verification.mark-attended', $invitation) }}" method="POST">
                @csrf
                <button type="submit" class="btn-success w-full">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Mark as Attended
                </button>
            </form>
        </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('verification.index') }}" class="btn-secondary w-full flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Verify Another
            </a>
        </div>
    </div>
</div>
@endsection
