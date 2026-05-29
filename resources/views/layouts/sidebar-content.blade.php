@php
    $user = auth()->user();
    $isAdmin = $user->isSuperAdmin();
    $currentRoute = request()->route() ? request()->route()->getName() : '';
@endphp

<!-- Logo -->
<div class="flex items-center h-16 px-6 border-b border-gray-200 dark:border-navy-700">
    <a href="{{ $isAdmin ? route('admin.dashboard') : route('dashboard') }}" class="flex items-center gap-3">
        <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-accent-500 rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-sm">RE</span>
        </div>
        <div>
            <span class="text-lg font-display font-bold bg-gradient-to-r from-primary-500 to-accent-500 bg-clip-text text-transparent">Rwanda</span>
            <span class="text-lg font-display font-bold text-gray-700 dark:text-gray-300">EventHub</span>
        </div>
    </a>
</div>

<!-- User Info -->
<div class="px-6 py-4 border-b border-gray-200 dark:border-navy-700">
    <div class="flex items-center gap-3">
        <div class="relative">
            @if($user->profile_photo)
                <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->full_name }}"
                     class="w-10 h-10 rounded-full object-cover border-2 border-primary-500/30 shadow-md">
            @else
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                    {{ $user->initials }}
                </div>
            @endif
            <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white dark:border-navy-900 rounded-full"></div>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $user->full_name ?: $user->name }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                @if($isAdmin)
                    <span class="badge-primary text-xs">Super Admin</span>
                @elseif($user->isEventManager())
                    <span class="badge-info text-xs">Event Manager</span>
                @else
                    <span class="badge text-xs bg-gray-100 dark:bg-navy-700">User</span>
                @endif
            </p>
        </div>
    </div>
</div>

<!-- Navigation -->
<nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
    @if($isAdmin)
        <!-- Admin Navigation -->
        <p class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Main</p>

        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ str_contains($currentRoute, 'admin.dashboard') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <p class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-6 mb-2">Management</p>

        <a href="{{ route('admin.users') }}"
           class="sidebar-link {{ str_contains($currentRoute, 'admin.users') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
            </svg>
            <span>Users</span>
        </a>

        <a href="{{ route('admin.events') }}"
           class="sidebar-link {{ str_contains($currentRoute, 'admin.events') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Events</span>
            <span class="ml-auto text-xs bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 px-2 py-0.5 rounded-full">{{ \App\Models\Event::where('status', 'pending')->count() }}</span>
        </a>

        <a href="{{ route('admin.invitations') }}"
           class="sidebar-link {{ str_contains($currentRoute, 'admin.invitations') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
            <span>Invitations</span>
            <span class="ml-auto text-xs bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 px-2 py-0.5 rounded-full">{{ \App\Models\Invitation::pending()->count() }}</span>
        </a>

        <p class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-6 mb-2">Analytics</p>

        <a href="{{ route('admin.reports') }}"
           class="sidebar-link {{ str_contains($currentRoute, 'admin.reports') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span>Reports</span>
        </a>

        <p class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-6 mb-2">System</p>

        <a href="{{ route('admin.logs') }}"
           class="sidebar-link {{ str_contains($currentRoute, 'admin.logs') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Logs</span>
        </a>

        <a href="{{ route('admin.settings') }}"
           class="sidebar-link {{ str_contains($currentRoute, 'admin.settings') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>Settings</span>
        </a>
    @else
        <!-- User Navigation -->
        <p class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Dashboard</p>

        <a href="{{ route('dashboard') }}"
           class="sidebar-link {{ $currentRoute === 'dashboard' ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Overview</span>
        </a>

        <p class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-6 mb-2">Events</p>

        <a href="{{ route('events.index') }}"
           class="sidebar-link {{ str_contains($currentRoute, 'events') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <span>Browse Events</span>
        </a>

        <a href="{{ route('user.invitations') }}"
           class="sidebar-link {{ str_contains($currentRoute, 'user.invitations') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
            <span>My Invitations</span>
            <span class="ml-auto text-xs bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 px-2 py-0.5 rounded-full">{{ \App\Models\Invitation::where('user_id', auth()->id())->pending()->count() }}</span>
        </a>

        <a href="{{ route('user.favorites') }}"
           class="sidebar-link {{ str_contains($currentRoute, 'user.favorites') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <span>Favorites</span>
        </a>

        <p class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-6 mb-2">Account</p>

        <a href="{{ route('user.notifications') }}"
           class="sidebar-link {{ str_contains($currentRoute, 'user.notifications') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span>Notifications</span>
            <span class="ml-auto text-xs bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 px-2 py-0.5 rounded-full">{{ \App\Models\AppNotification::where('user_id', auth()->id())->unread()->count() }}</span>
        </a>

        <a href="{{ route('user.settings') }}"
           class="sidebar-link {{ str_contains($currentRoute, 'user.settings') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>Settings</span>
        </a>
    @endif
</nav>

<!-- Bottom Section -->
<div class="px-3 py-4 border-t border-gray-200 dark:border-navy-700">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-link w-full text-gray-500 dark:text-gray-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span>Logout</span>
        </button>
    </form>
</div>
