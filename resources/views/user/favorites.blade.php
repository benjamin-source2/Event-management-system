@extends('layouts.app', ['title' => 'Favorites'])

@section('content')
<div class="py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Favorite Events</h1>
        <p class="text-gray-500 dark:text-gray-400">Events you've saved for later</p>
    </div>

    @if($favorites->count() > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favorites as $favorite)
                <x-event-card :event="$favorite->event" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $favorites->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <svg class="w-20 h-20 mx-auto text-gray-300 dark:text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Favorites Yet</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Save events you're interested in to find them easily later</p>
            <a href="{{ route('events.index') }}" class="btn-primary">Browse Events</a>
        </div>
    @endif
</div>
@endsection
