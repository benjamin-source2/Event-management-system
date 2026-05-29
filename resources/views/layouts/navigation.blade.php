@php
    $user = auth()->user();
    $isAdmin = $user->isSuperAdmin();
    $unreadNotifications = \App\Models\AppNotification::where('user_id', $user->id)->unread()->count();
@endphp

<nav class="bg-white dark:bg-navy-900 border-b border-gray-200 dark:border-navy-700 shadow-sm sticky top-0 z-20">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Mobile Hamburger -->
            <button @click="mobileMenu = true" class="lg:hidden p-2 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-navy-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Search -->
            <div class="flex-1 max-w-lg mx-4">
                <div x-data="{ search: '', results: [], loading: false, show: false, timer: null }"
                     @click.away="show = false" class="relative">
                    <div class="relative">
                        <input type="text" x-model="search"
                               @input="
                                   show = search.length >= 2;
                                   if (search.length < 2) { results = []; return; }
                                   clearTimeout(timer);
                                   loading = true;
                                   timer = setTimeout(() => {
                                       fetch('{{ route('search.events') }}?q=' + encodeURIComponent(search))
                                           .then(r => r.json())
                                           .then(data => { results = data.events; loading = false; })
                                           .catch(() => { results = []; loading = false; });
                                   }, 300);
                               "
                               @focus="if (search.length >= 2) show = true"
                               placeholder="Search events..."
                               class="input-field w-full bg-gray-100 dark:bg-navy-800 border-0 focus:ring-2 focus:ring-primary-500">

                        <!-- Loading spinner -->
                        <div x-show="loading" class="absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="animate-spin w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Dropdown -->
                    <div x-show="show && !loading" x-cloak
                         class="absolute mt-2 w-full max-w-lg bg-white dark:bg-navy-800 shadow-2xl border border-gray-200 dark:border-navy-700 overflow-hidden z-50 animate-scale-in">
                        <template x-if="results.length === 0">
                            <div class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                No events found
                            </div>
                        </template>
                        <template x-if="results.length > 0">
                            <div>
                                <div class="max-h-80 overflow-y-auto divide-y divide-gray-100 dark:divide-navy-700">
                                    <template x-for="event in results" :key="event.id">
                                        <a :href="'/events/' + event.slug"
                                           class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-navy-700/50 transition-colors">
                                            <div class="w-9 h-9 rounded bg-gradient-to-br from-primary-500/10 to-accent-500/10 flex items-center justify-center shrink-0">
                                                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate" x-text="event.title"></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="event.date + ' · ' + event.location"></p>
                                            </div>
                                            <span class="text-xs px-2 py-1 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 shrink-0" x-text="event.category"></span>
                                        </a>
                                    </template>
                                </div>
                                <a :href="'{{ route('events.index') }}?search=' + encodeURIComponent(search)"
                                   class="block px-4 py-2.5 text-center text-xs font-medium text-primary-500 hover:text-primary-600 border-t border-gray-200 dark:border-navy-700">
                                    View all results
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-2">
                <!-- Theme Toggle -->
                <button x-data="{ dark: {{ $user->theme_preference === 'dark' ? 'true' : 'false' }} }"
                        @click="
                            dark = !dark;
                            document.documentElement.classList.toggle('dark');
                            fetch('{{ route('user.theme.update') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ theme: dark ? 'dark' : 'light' })
                            });
                        "
                        class="theme-toggle" title="Toggle theme">
                    <!-- Sun icon -->
                    <svg x-show="!dark" class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <!-- Moon icon -->
                    <svg x-show="dark" class="w-5 h-5 text-primary-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <!-- Notifications -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                            class="theme-toggle relative">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if($unreadNotifications > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-rose-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse-slow">
                                {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" x-cloak
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-80 bg-white dark:bg-navy-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-navy-700 overflow-hidden z-50 animate-scale-in">
                        <div class="p-4 border-b border-gray-200 dark:border-navy-700">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-gray-900 dark:text-white">Notifications</h3>
                                @if($unreadNotifications > 0)
                                    <form action="{{ route('user.notifications-read-all') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs text-primary-500 hover:text-primary-600 font-medium">Mark all read</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            @forelse(\App\Models\AppNotification::where('user_id', $user->id)->latest()->take(5)->get() as $notification)
                                <a href="{{ $notification->action_url ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-navy-700/50 transition-colors {{ !$notification->is_read ? 'bg-primary-50/50 dark:bg-primary-900/10' : '' }}">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $notification->icon_class }} bg-opacity-10">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($notification->type === 'success')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @elseif($notification->type === 'error')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @elseif($notification->type === 'warning')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @endif
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $notification->title }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2">{{ $notification->message }}</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                        @if(!$notification->is_read)
                                            <div class="w-2 h-2 rounded-full bg-primary-500 mt-2 shrink-0"></div>
                                        @endif
                                    </div>
                                </a>
                            @empty
                                <div class="px-4 py-8 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No notifications yet</p>
                                </div>
                            @endforelse
                        </div>
                        <a href="{{ route('user.notifications') }}" class="block px-4 py-3 text-center text-sm font-medium text-primary-500 hover:text-primary-600 border-t border-gray-200 dark:border-navy-700">
                            View all notifications
                        </a>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                            class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-gray-100 dark:hover:bg-navy-800 transition-colors">
                        @if($user->profile_photo)
                            <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->full_name }}"
                                 class="w-8 h-8 rounded-full object-cover border-2 border-primary-500/30">
                        @else
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white font-semibold text-xs">
                                {{ $user->initials }}
                            </div>
                        @endif
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" x-cloak
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-56 bg-white dark:bg-navy-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-navy-700 overflow-hidden z-50 animate-scale-in">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-navy-700">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->full_name ?: $user->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-navy-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profile Settings
                            </a>
                            <a href="{{ $isAdmin ? route('admin.dashboard') : route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-navy-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                {{ $isAdmin ? 'Admin Dashboard' : 'Dashboard' }}
                            </a>
                            <a href="{{ route('user.settings') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-navy-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Settings
                            </a>
                            <hr class="my-1 border-gray-200 dark:border-navy-700">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
