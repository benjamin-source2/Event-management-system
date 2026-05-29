@extends('layouts.app', ['title' => 'Manage Users'])

@section('content')
<div class="py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Users</h1>
            <p class="text-gray-500 dark:text-gray-400">Manage all platform users</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add User
        </a>
    </div>

    <div class="premium-card overflow-hidden">
        <div class="table-container">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    @if($user->profile_photo)
                                        <img src="{{ Storage::url($user->profile_photo) }}" alt="" class="avatar">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white font-semibold text-sm">{{ $user->initials }}</div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $user->full_name ?: $user->name }}</p>
                                        <p class="text-xs text-gray-500">@ {{ $user->username }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-gray-500 dark:text-gray-400">{{ $user->email }}</td>
                            <td>
                                @if($user->isSuperAdmin())
                                    <span class="badge-info">Super Admin</span>
                                @elseif($user->isEventManager())
                                    <span class="badge-primary">Manager</span>
                                @else
                                    <span class="badge">User</span>
                                @endif
                            </td>
                            <td>
                                @if($user->isActive())
                                    <span class="badge-success">Active</span>
                                @elseif($user->isSuspended())
                                    <span class="badge-danger">Suspended</span>
                                @else
                                    <span class="badge-warning">Pending</span>
                                @endif
                            </td>
                            <td class="text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn-secondary btn-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn-secondary btn-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if($user->isActive())
                                        <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn-secondary btn-sm text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn-secondary btn-sm text-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
