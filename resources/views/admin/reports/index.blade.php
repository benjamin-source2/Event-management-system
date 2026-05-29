@extends('layouts.app', ['title' => 'Reports'])

@section('content')
<div class="py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Reports & Analytics</h1>
        <p class="text-gray-500 dark:text-gray-400">Insights and data about your platform</p>
    </div>

    <!-- User Stats -->
    <div class="grid lg:grid-cols-2 gap-8 mb-8">
        <div class="premium-card p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Users by Role</h2>
            <div class="space-y-4">
                @foreach($userStats['by_role'] as $role => $count)
                    @php
                        $total = array_sum($userStats['by_role']);
                        $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
                        $color = match($role) { 'super_admin' => 'primary', 'event_manager' => 'accent', default => 'emerald' };
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $role)) }}</span>
                            <span class="text-gray-500">{{ $count }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-bar-fill bg-{{ $color }}-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="premium-card p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Users by Status</h2>
            <div class="space-y-4">
                @foreach($userStats['by_status'] as $status => $count)
                    @php
                        $total = array_sum($userStats['by_status']);
                        $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
                        $color = match($status) { 'active' => 'emerald', 'suspended' => 'rose', default => 'amber' };
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ ucfirst($status) }}</span>
                            <span class="text-gray-500">{{ $count }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-bar-fill bg-{{ $color }}-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Event Stats -->
    <div class="grid lg:grid-cols-2 gap-8 mb-8">
        <div class="premium-card p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Events by Category</h2>
            <div class="space-y-4">
                @forelse($eventStats['by_category'] as $category => $count)
                    @php
                        $total = array_sum($eventStats['by_category']);
                        $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ ucfirst($category) }}</span>
                            <span class="text-gray-500">{{ $count }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-bar-fill" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No events yet</p>
                @endforelse
            </div>
        </div>

        <div class="premium-card p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Events by Province</h2>
            <div class="space-y-4">
                @forelse($eventStats['by_province'] as $province => $count)
                    @php
                        $total = array_sum($eventStats['by_province']);
                        $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ ucfirst($province) }}</span>
                            <span class="text-gray-500">{{ $count }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-bar-fill bg-accent-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No events yet</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top Events & Export -->
    <div class="grid lg:grid-cols-2 gap-8 mb-8">
        <div class="premium-card p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Top Events</h2>
            @if($topEvents->count() > 0)
                <div class="space-y-4">
                    @foreach($topEvents as $event)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-xs font-bold flex items-center justify-center">{{ $loop->iteration }}</span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ Str::limit($event->title, 25) }}</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $event->approvedInvitations()->count() }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No events yet</p>
            @endif
        </div>

        <div class="premium-card p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Export Reports</h2>
            <div class="space-y-4">
                <a href="{{ route('admin.reports.users.pdf') }}" class="btn-secondary w-full justify-start">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Export Users Report (PDF)
                </a>
                <a href="{{ route('admin.reports.events.pdf') }}" class="btn-secondary w-full justify-start">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Export Events Report (PDF)
                </a>
            </div>
        </div>
    </div>

    <!-- Daily Activity Chart -->
    <div class="premium-card p-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Daily Activity (30 Days)</h2>
        <div class="space-y-6">
            @php $maxEv = max(1, max($dailyActivity['events'])); @endphp
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Events Created</p>
                <div class="flex items-end gap-1 h-20">
                    @foreach($dailyActivity['events'] as $value)
                        <div class="flex-1 bg-primary-500/30 dark:bg-primary-900/40 rounded-t relative transition-all" style="height: {{ max(4, ($value / $maxEv) * 100) }}%"></div>
                    @endforeach
                </div>
            </div>
            @php $maxReg = max(1, max($dailyActivity['registrations'])); @endphp
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">New Registrations</p>
                <div class="flex items-end gap-1 h-20">
                    @foreach($dailyActivity['registrations'] as $value)
                        <div class="flex-1 bg-emerald-500/30 dark:bg-emerald-900/40 rounded-t relative transition-all" style="height: {{ max(4, ($value / $maxReg) * 100) }}%"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
