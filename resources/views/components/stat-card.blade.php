@props(['title', 'value', 'icon', 'color' => 'primary', 'trend' => null, 'trendUp' => true])

@php
    $colors = [
        'primary' => 'from-primary-500 to-accent-500 shadow-primary-500/20',
        'emerald' => 'from-emerald-500 to-emerald-600 shadow-emerald-500/20',
        'amber' => 'from-amber-500 to-amber-600 shadow-amber-500/20',
        'rose' => 'from-rose-500 to-rose-600 shadow-rose-500/20',
        'accent' => 'from-accent-500 to-violet-600 shadow-accent-500/20',
    ];
    $bgColor = $colors[$color] ?? $colors['primary'];
@endphp

<div class="stat-card">
    <div class="flex items-start justify-between">
        <div class="space-y-2">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
            @if($trend)
                <div class="flex items-center gap-1 {{ $trendUp ? 'text-emerald-500' : 'text-rose-500' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($trendUp)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        @endif
                    </svg>
                    <span class="text-xs font-medium">{{ $trend }}</span>
                </div>
            @endif
        </div>
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $bgColor }} flex items-center justify-center shadow-lg">
            {!! $icon !!}
        </div>
    </div>
</div>
