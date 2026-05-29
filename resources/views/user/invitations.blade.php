@extends('layouts.app', ['title' => 'My Invitations'])

@section('content')
<div class="py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">My Invitations</h1>
            <p class="text-gray-500 dark:text-gray-400">Manage your event invitations</p>
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="flex gap-2 mb-6">
        <a href="{{ route('user.invitations') }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 {{ !request('status') ? 'bg-primary-500 text-white shadow-md' : 'bg-gray-100 dark:bg-navy-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-navy-700' }}">
            All
        </a>
        <a href="{{ route('user.invitations', ['status' => 'pending']) }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-md' : 'bg-gray-100 dark:bg-navy-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-navy-700' }}">
            Pending
        </a>
        <a href="{{ route('user.invitations', ['status' => 'approved']) }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 {{ request('status') === 'approved' ? 'bg-emerald-500 text-white shadow-md' : 'bg-gray-100 dark:bg-navy-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-navy-700' }}">
            Approved
        </a>
        <a href="{{ route('user.invitations', ['status' => 'rejected']) }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 {{ request('status') === 'rejected' ? 'bg-rose-500 text-white shadow-md' : 'bg-gray-100 dark:bg-navy-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-navy-700' }}">
            Rejected
        </a>
    </div>

    <!-- Invitations List -->
    @if($invitations->count() > 0)
        <div class="space-y-4">
            @foreach($invitations as $invitation)
                <div class="glass-card p-5 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500/10 to-accent-500/10 flex items-center justify-center">
                            <svg class="w-7 h-7 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $invitation->event->title }}</h3>
                            <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <span>{{ $invitation->event->event_date->format('M d, Y') }}</span>
                                <span>{{ $invitation->event->location }}, {{ $invitation->event->province_name }}</span>
                                <span>Code: {{ $invitation->invitation_code }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="badge-{{ $invitation->status_badge }}">{{ ucfirst($invitation->approval_status) }}</span>
                        @if($invitation->approval_status === 'approved')
                            <a href="{{ route('user.invitation-pass', $invitation) }}" class="btn-primary btn-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Pass
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $invitations->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <svg class="w-20 h-20 mx-auto text-gray-300 dark:text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Invitations</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">You haven't requested any invitations yet</p>
            <a href="{{ route('events.index') }}" class="btn-primary">Browse Events</a>
        </div>
    @endif
</div>
@endsection
