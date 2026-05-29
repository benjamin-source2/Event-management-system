@props(['event'])

<div class="group premium-card-hover overflow-hidden">
    <!-- Image -->
    <div class="relative h-48 bg-gradient-to-br from-primary-500/10 to-accent-500/10 overflow-hidden">
        @if($event->event_image)
            <img src="{{ Storage::url($event->event_image) }}" alt="{{ $event->title }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        <!-- Date Badge -->
        <div class="absolute top-3 left-3">
            <div class="bg-white/90 dark:bg-navy-900/90 backdrop-blur-sm rounded-xl px-3 py-2 text-center shadow-lg">
                <p class="text-lg font-bold text-primary-500 leading-none">{{ $event->event_date->format('d') }}</p>
                <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase">{{ $event->event_date->format('M') }}</p>
            </div>
        </div>

        <!-- Category Badge -->
        <div class="absolute top-3 right-3">
            <span class="badge-primary text-xs">{{ $event->category_name }}</span>
        </div>

        <!-- Tickets Availability -->
        @if($event->is_full)
            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                <span class="badge-danger text-sm">Full</span>
            </div>
        @endif
    </div>

    <!-- Content -->
    <div class="p-5">
        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>{{ $event->location }}, {{ $event->province_name }}</span>
        </div>

        <h3 class="font-bold text-gray-900 dark:text-white mb-2 group-hover:text-primary-500 transition-colors">
            <a href="{{ route('events.show', $event->slug) }}">
                {{ Str::limit($event->title, 50) }}
            </a>
        </h3>

        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4">
            {{ Str::limit(strip_tags($event->description), 100) }}
        </p>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ $event->start_time->format('h:i A') }}</span>
            </div>

            <div class="flex items-center gap-1 text-sm">
                <span class="text-xs text-gray-400">{{ $event->tickets_remaining }} / {{ $event->ticket_limit }}</span>
                <span class="text-xs text-gray-400">tickets left</span>
            </div>
        </div>

        <!-- Progress Bar -->
        @if($event->ticket_limit > 0)
            <div class="progress-bar mt-3">
                @php
                    $percentage = $event->ticket_limit > 0
                        ? min(100, ($event->ticket_limit - $event->tickets_remaining) / $event->ticket_limit * 100)
                        : 0;
                @endphp
                <div class="progress-bar-fill" style="width: {{ $percentage }}%"></div>
            </div>
        @endif
    </div>
</div>
