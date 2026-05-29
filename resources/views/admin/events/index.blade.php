@extends('layouts.app', ['title' => 'Manage Events'])

@section('content')
<div class="py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Events</h1>
            <p class="text-gray-500 dark:text-gray-400">Manage all platform events</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="btn-primary flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Event
        </a>
    </div>

    <div class="premium-card overflow-hidden">
        <div class="table-container">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Organizer</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Invitations</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500/10 to-accent-500/10 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ Str::limit($event->title, 30) }}</p>
                                        <p class="text-xs text-gray-500">{{ $event->location }}, {{ $event->province_name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-sm text-gray-500 dark:text-gray-400">{{ $event->organizer->full_name ?: $event->organizer->name }}</td>
                            <td><span class="badge-primary text-xs">{{ $event->category_name }}</span></td>
                            <td class="text-sm text-gray-500">{{ $event->event_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge-{{ $event->status === 'approved' ? 'success' : ($event->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ $event->status_name }}
                                </span>
                            </td>
                            <td class="text-sm font-semibold text-gray-900 dark:text-white">{{ $event->invitations_count }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.events.show', $event) }}" class="btn-secondary btn-sm flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span class="hidden lg:inline">View</span>
                                    </a>
                                    <a href="{{ route('admin.events.edit', $event) }}" class="btn-secondary btn-sm flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span class="hidden lg:inline">Edit</span>
                                    </a>
                                    @if($event->status === 'pending')
                                        <form action="{{ route('admin.events.approve', $event) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn-success btn-sm flex items-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span class="hidden lg:inline">Approve</span>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.events.featured', $event) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-secondary btn-sm flex items-center gap-1.5 {{ $event->featured ? 'text-amber-500' : '' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                            <span class="hidden lg:inline">{{ $event->featured ? 'Featured' : 'Feature' }}</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger btn-sm flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span class="hidden lg:inline">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $events->links() }}</div>
</div>
@endsection
