@extends('layouts.app', ['title' => 'Login Logs'])

@section('content')
<div class="py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Login Logs</h1>
            <p class="text-gray-500 dark:text-gray-400">Monitor user login activity</p>
        </div>
    </div>

    <div class="premium-card overflow-hidden">
        <div class="table-container">
            <table class="table-premium">
                <thead>
                    <tr><th>User</th><th>IP Address</th><th>Browser</th><th>Device</th><th>Location</th><th>Login Time</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500/10 to-accent-500/10 flex items-center justify-center text-xs font-bold">{{ $log->user->initials ?? '??' }}</div>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $log->user->full_name ?? $log->user->name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td class="font-mono text-xs">{{ $log->ip_address ?? 'N/A' }}</td>
                            <td class="text-sm">{{ Str::limit($log->browser, 30) ?? 'N/A' }}</td>
                            <td class="text-sm">{{ $log->device ?? 'N/A' }}</td>
                            <td class="text-sm">{{ $log->location ?? 'N/A' }}</td>
                            <td class="text-sm">{{ $log->login_time ? \Carbon\Carbon::parse($log->login_time)->format('M d, Y h:i A') : 'N/A' }}</td>
                            <td>
                                @if($log->is_successful)
                                    <span class="badge-success">Success</span>
                                @else
                                    <span class="badge-danger">Failed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-8 text-gray-500">No login logs found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">{{ $logs->links() }}</div>
</div>
@endsection
