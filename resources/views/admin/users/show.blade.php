@extends('layouts.app', ['title' => 'User Details'])

@section('content')
<div class="py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">User Details</h1>
            <p class="text-gray-500 dark:text-gray-400">View user information and activity</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn-primary btn-sm">Edit User</a>
            <a href="{{ route('admin.users') }}" class="btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- User Profile -->
        <div class="glass-heavy p-6 text-center">
            @if($user->profile_photo)
                <img src="{{ Storage::url($user->profile_photo) }}" alt="" class="avatar-xl mx-auto mb-4">
            @else
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white font-bold text-3xl mx-auto mb-4">{{ $user->initials }}</div>
            @endif
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->full_name ?: $user->name }}</h2>
            <p class="text-gray-500 dark:text-gray-400">@ {{ $user->username }}</p>
            <div class="flex justify-center gap-2 mt-3">
                @if($user->isSuperAdmin())
                    <span class="badge-info">Super Admin</span>
                @elseif($user->isEventManager())
                    <span class="badge-primary">Event Manager</span>
                @else
                    <span class="badge">User</span>
                @endif
                @if($user->isActive())
                    <span class="badge-success">Active</span>
                @elseif($user->isSuspended())
                    <span class="badge-danger">Suspended</span>
                @else
                    <span class="badge-warning">Pending</span>
                @endif
            </div>
            <hr class="my-4 border-gray-200 dark:border-navy-700">
            <div class="space-y-2 text-left">
                <div class="flex justify-between"><span class="text-gray-500">Email</span><span class="font-medium">{{ $user->email }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Phone</span><span class="font-medium">{{ $user->phone ?? 'N/A' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Language</span><span class="font-medium">{{ strtoupper($user->language) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Theme</span><span class="font-medium">{{ ucfirst($user->theme_preference) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Joined</span><span class="font-medium">{{ $user->created_at->format('M d, Y') }}</span></div>
            </div>
        </div>

        <!-- User Activity -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-heavy p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Invitations ({{ $user->invitations->count() }})</h2>
                @if($user->invitations->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->invitations as $invitation)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-navy-800 rounded-xl">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $invitation->event->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $invitation->created_at->format('M d, Y') }}</p>
                                </div>
                                <span class="badge-{{ $invitation->status_badge }}">{{ ucfirst($invitation->approval_status) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No invitations yet</p>
                @endif
            </div>

            <div class="glass-heavy p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Login Activity (Last 10)</h2>
                @if($user->loginLogs->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->loginLogs as $log)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-navy-800 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-navy-700 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $log->browser ?? 'Unknown browser' }}</p>
                                        <p class="text-xs text-gray-500">{{ $log->ip_address }} - {{ $log->device ?? 'Unknown device' }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400">{{ $log->login_time ? \Carbon\Carbon::parse($log->login_time)->diffForHumans() : 'N/A' }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No login activity recorded</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
