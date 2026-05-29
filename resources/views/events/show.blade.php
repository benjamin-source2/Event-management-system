@extends('layouts.app', ['title' => $event->title])

@section('content')
<div class="py-8">
    <!-- Event Header -->
    <div class="relative rounded-3xl overflow-hidden mb-8 bg-gradient-to-br from-primary-500/10 to-accent-500/10">
        @if($event->event_image)
            <div class="absolute inset-0">
                <img src="{{ Storage::url($event->event_image) }}" alt="{{ $event->title }}"
                     class="w-full h-full object-cover opacity-30">
                <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-navy-950 via-transparent"></div>
            </div>
        @endif

        <div class="relative p-8 md:p-12">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="badge-primary">{{ $event->category_name }}</span>
                @if($event->featured)
                    <span class="badge-amber">
                        <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        Featured
                    </span>
                @endif
            </div>

            <h1 class="text-4xl md:text-5xl font-display font-bold text-gray-900 dark:text-white mb-4">{{ $event->title }}</h1>

            <div class="flex flex-wrap items-center gap-6 text-gray-500 dark:text-gray-400">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $event->event_date->format('l, F d, Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $event->start_time->format('h:i A') }} - {{ $event->end_time->format('h:i A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $event->location }}, {{ $event->district }}, {{ $event->province_name }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Countdown -->
            @if($event->event_date > now())
                <div class="premium-card p-6" x-data="countdown('{{ $event->event_date->format('Y-m-d H:i:s') }}')" x-init="init()">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Event Countdown</h3>
                    <div class="flex gap-4">
                        <div class="countdown-item">
                            <span class="countdown-value" x-text="days">00</span>
                            <span class="countdown-label">Days</span>
                        </div>
                        <div class="countdown-item">
                            <span class="countdown-value" x-text="hours">00</span>
                            <span class="countdown-label">Hours</span>
                        </div>
                        <div class="countdown-item">
                            <span class="countdown-value" x-text="minutes">00</span>
                            <span class="countdown-label">Minutes</span>
                        </div>
                        <div class="countdown-item">
                            <span class="countdown-value" x-text="seconds">00</span>
                            <span class="countdown-label">Seconds</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Description -->
            <div class="premium-card p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">About This Event</h3>
                <div class="prose prose-gray dark:prose-invert max-w-none">
                    {!! nl2br(e($event->description)) !!}
                </div>
            </div>

            <!-- Organizer Info -->
            <div class="premium-card p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Organized By</h3>
                <div class="flex items-center gap-4">
                    @if($event->organizer->profile_photo)
                        <img src="{{ Storage::url($event->organizer->profile_photo) }}" alt=""
                             class="w-16 h-16 rounded-full object-cover border-2 border-primary-500/30">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white font-bold text-xl">
                            {{ $event->organizer->initials }}
                        </div>
                    @endif
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $event->organizer->full_name ?: $event->organizer->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $event->organizer->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Request Invitation Card -->
            <div class="premium-card p-6 sticky top-20">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Join This Event</h3>

                @auth
                    @php
                        $existingInvitation = \App\Models\Invitation::where('user_id', auth()->id())
                            ->where('event_id', $event->id)
                            ->first();
                    @endphp

                    @if($existingInvitation)
                        <div class="space-y-3">
                            @if($existingInvitation->approval_status === 'approved')
                                <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl p-4 text-center">
                                    <svg class="w-12 h-12 mx-auto text-emerald-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="font-semibold text-emerald-700 dark:text-emerald-400">Invitation Approved!</p>
                                    <a href="{{ route('user.invitation-pass', $existingInvitation) }}" class="btn-success btn-sm mt-3 inline-flex">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        View Pass
                                    </a>
                                </div>
                            @elseif($existingInvitation->approval_status === 'pending')
                                <div class="bg-amber-50 dark:bg-amber-900/20 rounded-2xl p-4 text-center">
                                    <svg class="w-12 h-12 mx-auto text-amber-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="font-semibold text-amber-700 dark:text-amber-400">Invitation Pending</p>
                                    <p class="text-sm text-amber-600 dark:text-amber-500 mt-1">Waiting for approval</p>
                                </div>
                            @else
                                <div class="bg-rose-50 dark:bg-rose-900/20 rounded-2xl p-4 text-center">
                                    <svg class="w-12 h-12 mx-auto text-rose-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="font-semibold text-rose-700 dark:text-rose-400">Invitation Rejected</p>
                                    @if($existingInvitation->rejection_reason)
                                        <p class="text-sm text-rose-600 dark:text-rose-500 mt-1">{{ $existingInvitation->rejection_reason }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @elseif($event->is_full)
                        <div class="bg-gray-100 dark:bg-navy-800 rounded-2xl p-4 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="font-semibold text-gray-700 dark:text-gray-300">This Event is Full</p>
                            <p class="text-sm text-gray-500 mt-1">No tickets available</p>
                        </div>
                    @else
                        <form action="{{ route('user.request-invitation', $event) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-primary w-full">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                </svg>
                                Request Invitation
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-primary w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Login to Request Invitation
                    </a>
                @endauth

                <hr class="my-4 border-gray-200 dark:border-navy-700">

                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Status</span>
                        <span class="badge-{{ $event->status === 'approved' ? 'success' : 'warning' }}">{{ $event->status_name }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Tickets Available</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $event->tickets_remaining }} / {{ $event->ticket_limit }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Attendees</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $event->approvedInvitations()->count() }}</span>
                    </div>
                </div>

                @auth
                    @php
                        $isFavorited = \App\Models\FavoriteEvent::where('user_id', auth()->id())
                            ->where('event_id', $event->id)->exists();
                    @endphp
                    <button onclick="toggleFavorite({{ $event->id }})"
                            class="btn-secondary w-full mt-4 {{ $isFavorited ? 'text-rose-500 border-rose-300 dark:border-rose-700' : '' }}">
                        <svg class="w-5 h-5" :class="{ 'fill-current': {{ $isFavorited ? 'true' : 'false' }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span id="fav-text">{{ $isFavorited ? 'Saved' : 'Save to Favorites' }}</span>
                    </button>
                    <form id="fav-form-{{ $event->id }}" action="{{ route('user.toggle-favorite', $event) }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @endauth
            </div>
        </div>
    </div>

    <!-- Related Events -->
    @if($relatedEvents->count() > 0)
        <section class="mt-12">
            <h2 class="text-2xl font-display font-bold text-gray-900 dark:text-white mb-6">Similar Events</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedEvents as $relatedEvent)
                    <x-event-card :event="$relatedEvent" />
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('countdown', (targetDate) => ({
            days: '00',
            hours: '00',
            minutes: '00',
            seconds: '00',
            init() {
                this.update();
                setInterval(() => this.update(), 1000);
            },
            update() {
                const target = new Date(targetDate).getTime();
                const now = new Date().getTime();
                const diff = Math.max(0, target - now);

                this.days = String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, '0');
                this.hours = String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                this.minutes = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                this.seconds = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');
            }
        }));
    });

    function toggleFavorite(eventId) {
        document.getElementById('fav-form-' + eventId).submit();
    }
</script>
@endpush
