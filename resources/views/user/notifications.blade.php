@extends('layouts.app', ['title' => 'Notifications'])

@section('content')
<div class="py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Notifications</h1>
            <p class="text-gray-500 dark:text-gray-400">Stay updated with your events</p>
        </div>

        @if($notifications->where('is_read', false)->count() > 0)
            <form action="{{ route('user.notifications-read-all') }}" method="POST">
                @csrf
                <button type="submit" class="btn-secondary btn-sm">Mark All Read</button>
            </form>
        @endif
    </div>

    @if($notifications->count() > 0)
        <div class="premium-card overflow-hidden">
            <div class="divide-y divide-gray-100 dark:divide-navy-700">
                @foreach($notifications as $notification)
                    <div class="p-4 flex items-start gap-3 hover:bg-gray-50 dark:hover:bg-navy-800/50 transition-colors {{ !$notification->is_read ? 'bg-primary-50/50 dark:bg-primary-900/10' : '' }}">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $notification->icon_class }} bg-opacity-10 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($notification->type === 'success')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @elseif($notification->type === 'error')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @elseif($notification->type === 'warning')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @endif
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $notification->title }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $notification->message }}</p>
                                </div>
                                <div class="flex items-center gap-2 ml-4">
                                    <span class="text-xs text-gray-400 whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
                                    @if(!$notification->is_read)
                                        <form action="{{ route('user.notification-read', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-2 h-2 rounded-full bg-primary-500 hover:bg-primary-600 cursor-pointer" title="Mark as read"></button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <svg class="w-20 h-20 mx-auto text-gray-300 dark:text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Notifications</h3>
            <p class="text-gray-500 dark:text-gray-400">You'll see notifications here when there's activity</p>
        </div>
    @endif
</div>
@endsection
