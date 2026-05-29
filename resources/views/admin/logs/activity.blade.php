@extends('layouts.app', ['title' => 'Activity Logs'])

@section('content')
<div class="py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Activity Logs</h1>
            <p class="text-gray-500 dark:text-gray-400">System activity and notifications</p>
        </div>
    </div>

    <div class="glass-heavy overflow-hidden">
        <div class="divide-y divide-gray-100 dark:divide-navy-700">
            @forelse($notifications as $notification)
                <div class="p-4 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $notification->icon_class }} shrink-0">
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
                    <div class="flex-1">
                        <p class="font-medium text-gray-900 dark:text-white">{{ $notification->title }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $notification->message }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">No activity logs</div>
            @endforelse
        </div>
    </div>
    <div class="mt-6">{{ $notifications->links() }}</div>
</div>
@endsection
