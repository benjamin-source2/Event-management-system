@extends('layouts.app', ['title' => 'Admin Dashboard'])

@section('content')
<div class="py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Admin Dashboard</h1>
        <p class="text-gray-500 dark:text-gray-400">Overview of your platform</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card title="Total Users" :value="$stats['total_users']"
            color="primary"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>' />

        <x-stat-card title="Events" :value="$stats['total_events']"
            color="emerald"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>' />

        <x-stat-card title="Pending Invitations" :value="$stats['pending_invitations']"
            color="amber"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>' />

        <x-stat-card title="Attendees" :value="$stats['total_attendees']"
            color="accent"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>' />
    </div>

    <!-- Charts & Recent Activity Row -->
    <div class="grid lg:grid-cols-2 gap-8 mb-8">
        <!-- Daily Activity Chart -->
        <div class="glass-heavy p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Daily Activity (30 Days)</h2>
            <div class="space-y-3">
                @php
                    $maxEvents = max(1, max($dailyActivity['events']));
                    $maxRegistrations = max(1, max($dailyActivity['registrations']));
                @endphp
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Events Created</p>
                    <div class="flex items-end gap-1 h-24">
                        @foreach($dailyActivity['events'] as $key => $value)
                            @php
                                $height = max(4, ($value / $maxEvents) * 100);
                                $isHigh = $value > 0;
                            @endphp
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-primary-500/20 dark:bg-primary-900/30 rounded-t relative" style="height: {{ $height }}%">
                                    @if($value > 0)
                                        <div class="absolute -top-5 left-1/2 -translate-x-1/2 text-xs text-primary-500 font-medium">{{ $value }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">New Registrations</p>
                    <div class="flex items-end gap-1 h-24">
                        @foreach($dailyActivity['registrations'] as $key => $value)
                            @php
                                $height = max(4, ($value / $maxRegistrations) * 100);
                            @endphp
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-emerald-500/20 dark:bg-emerald-900/30 rounded-t relative" style="height: {{ $height }}%">
                                    @if($value > 0)
                                        <div class="absolute -top-5 left-1/2 -translate-x-1/2 text-xs text-emerald-500 font-medium">{{ $value }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Events -->
        <div class="glass-heavy p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Top Events by Attendance</h2>
            @if($topEvents->count() > 0)
                <div class="space-y-4">
                    @foreach($topEvents as $event)
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500/10 to-accent-500/10 flex items-center justify-center shrink-0">
                                <span class="text-sm font-bold text-primary-500">{{ $loop->iteration }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 dark:text-white truncate">{{ $event->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $event->approvedInvitations()->count() }} attendees</p>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $event->approvedInvitations()->count() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-8">No events yet</p>
            @endif
        </div>
    </div>

    <!-- Recent Data -->
    <div class="grid lg:grid-cols-2 gap-8">
        <div class="glass-heavy">
            <div class="p-6 border-b border-gray-200 dark:border-navy-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Recent Users</h2>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-navy-700">
                @forelse($recentUsers as $user)
                    <div class="p-4 flex items-center gap-3">
                        @if($user->profile_photo)
                            <img src="{{ Storage::url($user->profile_photo) }}" alt="" class="w-10 h-10 rounded-full">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white font-semibold text-sm">{{ $user->initials }}</div>
                        @endif
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->full_name ?: $user->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                        </div>
                        <span class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">No users yet</div>
                @endforelse
            </div>
        </div>

        <div class="glass-heavy">
            <div class="p-6 border-b border-gray-200 dark:border-navy-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Recent Events</h2>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-navy-700">
                @forelse($recentEvents as $event)
                    <div class="p-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500/10 to-accent-500/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 dark:text-white">{{ Str::limit($event->title, 35) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $event->status_name }} - {{ $event->event_date->format('M d, Y') }}</p>
                        </div>
                        <span class="badge-{{ $event->status === 'approved' ? 'success' : 'warning' }}">{{ $event->status_name }}</span>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">No events yet</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
