@extends('layouts.app', ['title' => 'Events'])

@section('content')
<div class="py-8" x-data="{
    view: localStorage.getItem('eventView') || 'grid',
    setView(view) {
        this.view = view;
        localStorage.setItem('eventView', view);
    }
}">
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
            <!-- List View Button -->
            <button type="button" @click="setView('list')"
                    :class="view === 'list' ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/30' : 'glass text-gray-600 dark:text-gray-400 hover:bg-white/20'"
                    :aria-pressed="view === 'list'"
                    aria-label="List view"
                    class="p-2 rounded-xl transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </button>
            <!-- Grid / Large Icon Button -->
            <button type="button" @click="setView('grid')"
                    :class="view === 'grid' ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/30' : 'glass text-gray-600 dark:text-gray-400 hover:bg-white/20'"
                    :aria-pressed="view === 'grid'"
                    aria-label="Grid view"
                    class="p-2 rounded-xl transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Events Container -->
    @if($events->count() > 0)
        <!-- Grid View -->
        <div x-show="view === 'grid'" x-cloak
             x-transition:enter="transition-all duration-500"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition-all duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($events as $event)
                <x-event-card :event="$event" />
            @endforeach
        </div>

        <!-- List View -->
        <div x-show="view === 'list'" x-cloak
             x-transition:enter="transition-all duration-500"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition-all duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4"
             class="space-y-4">
            @foreach($events as $event)
                <a href="{{ route('events.show', $event->slug) }}"
                   class="group glass-heavy rounded-2xl p-5 flex items-center gap-5 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                    <!-- Date Badge -->
                    <div class="shrink-0">
                        <div class="glass-dark rounded-xl px-4 py-3 text-center shadow-lg">
                            <p class="text-xl font-bold text-white leading-none">{{ $event->event_date->format('d') }}</p>
                            <p class="text-xs font-medium text-white/80 uppercase">{{ $event->event_date->format('M') }}</p>
                        </div>
                    </div>

                    <!-- Thumbnail -->
                    <div class="shrink-0 w-24 h-24 rounded-xl overflow-hidden">
                        @if($event->event_image)
                            <img src="{{ Storage::url($event->event_image) }}" alt="{{ $event->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary-500/20 via-accent-500/10 to-emerald-500/20 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="glass-dark text-xs text-white px-2.5 py-1 rounded-lg">{{ $event->category_name }}</span>
                            @if($event->is_full)
                                <span class="text-xs font-semibold text-rose-500 bg-rose-500/10 px-2.5 py-1 rounded-lg">Sold Out</span>
                            @endif
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-primary-500 transition-colors truncate">
                            {{ $event->title }}
                        </h3>
                        <div class="flex items-center gap-4 mt-1.5 text-sm text-gray-500 dark:text-gray-400">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $event->location }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $event->start_time->format('h:i A') }}
                            </span>
                        </div>
                    </div>

                    <!-- Tickets Info -->
                    <div class="shrink-0 text-right">
                        <div class="text-sm">
                            <span class="text-lg font-bold text-primary-500 dark:text-primary-400">{{ $event->tickets_remaining }}</span>
                            <span class="text-xs text-gray-400">/ {{ $event->ticket_limit }}</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">tickets left</p>
                    </div>

                    <!-- Arrow -->
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-500 group-hover:translate-x-1 transition-all duration-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
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
