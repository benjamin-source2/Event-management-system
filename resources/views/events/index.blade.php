@extends('layouts.app', ['title' => 'Events'])

@section('content')
<div class="py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Discover Events</h1>
        <p class="text-gray-500 dark:text-gray-400">Find the perfect event to attend across Rwanda</p>
    </div>

    <!-- Filters - Glass -->
    <div class="glass-heavy rounded-2xl p-6 mb-8">
        <form method="GET" action="{{ route('events.index') }}" class="grid md:grid-cols-4 gap-4">
            <div class="input-group">
                <label class="input-label">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search events..." class="input-field">
            </div>

            <div class="input-group">
                <label class="input-label">Category</label>
                <select name="category" class="input-field">
                    <option value="">All Categories</option>
                    @foreach($categories as $key => $category)
                        <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-group">
                <label class="input-label">Province</label>
                <select name="province" class="input-field">
                    <option value="">All Provinces</option>
                    @foreach($provinces as $key => $province)
                        <option value="{{ $key }}" {{ request('province') === $key ? 'selected' : '' }}>{{ $province }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="btn-primary flex-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'category', 'province']))
                    <a href="{{ route('events.index') }}" class="btn-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Results Info -->
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Showing {{ $events->firstItem() ?? 0 }} - {{ $events->lastItem() ?? 0 }} of {{ $events->total() }} events
        </p>
        <div class="flex items-center gap-2">
            <button class="p-2 rounded-xl glass text-gray-600 dark:text-gray-400 hover:bg-white/20 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </button>
            <button class="p-2 rounded-xl bg-primary-500 text-white hover:bg-primary-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Events Grid -->
    @if($events->count() > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($events as $event)
                <x-event-card :event="$event" />
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $events->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <svg class="w-20 h-20 mx-auto text-gray-300 dark:text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Events Found</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Try adjusting your search or filter criteria</p>
            <a href="{{ route('events.index') }}" class="btn-primary">Clear Filters</a>
        </div>
    @endif
</div>
@endsection
