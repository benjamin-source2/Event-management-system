@extends('layouts.app', ['title' => $event->title])

@section('content')
<div class="py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">{{ $event->title }}</h1>
            <p class="text-gray-500 dark:text-gray-400">{{ $event->category_name }} - {{ $event->event_date->format('M d, Y') }}</p>
        </div>
        <div class="flex gap-2">
            @if($event->status === 'pending')
                <form action="{{ route('admin.events.approve', $event) }}" method="POST" class="inline">@csrf
                    <button type="submit" class="btn-success btn-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Approve</button>
                </form>
                <form action="{{ route('admin.events.reject', $event) }}" method="POST" class="inline">@csrf
                    <button type="submit" class="btn-danger btn-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Reject</button>
                </form>
            @endif
            <a href="{{ route('admin.events.edit', $event) }}" class="btn-secondary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete
                </button>
            </form>
            <a href="{{ route('admin.events') }}" class="btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-heavy p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Description</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ $event->description }}</p>
            </div>

            <div class="glass-heavy p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Invitations ({{ $event->invitations->count() }})</h3>
                @if($event->invitations->count() > 0)
                    <div class="space-y-3">
                        @foreach($event->invitations as $invitation)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-navy-800 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500/10 to-accent-500/10 flex items-center justify-center text-xs font-bold">{{ $invitation->user->initials }}</div>
                                    <div>
                                        <p class="text-sm font-medium">{{ $invitation->user->full_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $invitation->user->email }}</p>
                                    </div>
                                </div>
                                <span class="badge-{{ $invitation->status_badge }}">{{ ucfirst($invitation->approval_status) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No invitations yet</p>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="glass-heavy p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Event Details</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Status</span><span class="badge-{{ $event->status === 'approved' ? 'success' : 'warning' }}">{{ $event->status_name }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Category</span><span class="font-medium">{{ $event->category_name }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Date</span><span class="font-medium">{{ $event->event_date->format('M d, Y') }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Time</span><span class="font-medium">{{ $event->start_time->format('h:i A') }} - {{ $event->end_time->format('h:i A') }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Location</span><span class="font-medium">{{ $event->location }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Province</span><span class="font-medium">{{ $event->province_name }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">District</span><span class="font-medium">{{ $event->district }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Tickets</span><span class="font-medium">{{ $event->ticket_limit }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Featured</span><span class="font-medium">{{ $event->featured ? 'Yes' : 'No' }}</span></div>
                </div>
            </div>

            <div class="glass-heavy p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Organizer</h3>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white font-bold">{{ $event->organizer->initials }}</div>
                    <div>
                        <p class="font-medium">{{ $event->organizer->full_name ?: $event->organizer->name }}</p>
                        <p class="text-xs text-gray-500">{{ $event->organizer->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
