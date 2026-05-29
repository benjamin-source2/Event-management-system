@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
<div class="py-8">
    <!-- Welcome -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">
            Welcome back, {{ auth()->user()->first_name }}! 👋
        </h1>
        <p class="text-gray-500 dark:text-gray-400">Here's what's happening with your events</p>
    </div>

    <!-- Stats -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card title="Total Invitations" :value="$stats['total_invitations']"
            color="primary"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>' />

        <x-stat-card title="Approved" :value="$stats['approved_invitations']"
            color="emerald"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' />

        <x-stat-card title="Pending" :value="$stats['pending_invitations']"
            color="amber"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' />

        <x-stat-card title="Favorites" :value="$stats['favorite_events']"
            color="rose"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>' />
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Recent Invitations -->
        <div class="glass-card">
            <div class="p-6 border-b border-gray-200 dark:border-navy-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Recent Invitations</h2>
                    <a href="{{ route('user.invitations') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium">View All</a>
                </div>
            </div>

            <div class="divide-y divide-gray-100 dark:divide-navy-700">
                @forelse($recentInvitations as $invitation)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-navy-800/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500/10 to-accent-500/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ Str::limit($invitation->event->title, 30) }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $invitation->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="badge-{{ $invitation->status_badge }}">{{ ucfirst($invitation->approval_status) }}</span>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">No invitations yet</p>
                        <a href="{{ route('events.index') }}" class="btn-primary btn-sm mt-4 inline-flex">Browse Events</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Notifications -->
        <div class="glass-card">
            <div class="p-6 border-b border-gray-200 dark:border-navy-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Notifications</h2>
                    <a href="{{ route('user.notifications') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium">View All</a>
                </div>
            </div>

            <div class="divide-y divide-gray-100 dark:divide-navy-700">
                @forelse($notifications as $notification)
                    <div class="p-4 flex items-start gap-3 hover:bg-gray-50 dark:hover:bg-navy-800/50 transition-colors {{ !$notification->is_read ? 'bg-primary-50/50 dark:bg-primary-900/10' : '' }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $notification->icon_class }} bg-opacity-10 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($notification->type === 'success')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @elseif($notification->type === 'error')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @endif
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $notification->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ Str::limit($notification->message, 80) }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        @if(!$notification->is_read)
                            <div class="w-2 h-2 rounded-full bg-primary-500 mt-2 shrink-0"></div>
                        @endif
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">No notifications yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
