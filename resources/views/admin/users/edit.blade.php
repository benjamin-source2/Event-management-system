@extends('layouts.app', ['title' => 'Edit User'])

@section('content')
<div class="py-8 max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Edit User</h1>
        <p class="text-gray-500 dark:text-gray-400">Update user information</p>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="glass-heavy p-6 space-y-6">
            <div class="grid sm:grid-cols-2 gap-6">
                <div class="input-group">
                    <label class="input-label">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-field" required>
                </div>
                <div class="input-group">
                    <label class="input-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-field" required>
                </div>
                <div class="input-group">
                    <label class="input-label">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="input-field" required>
                </div>
                <div class="input-group">
                    <label class="input-label">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="input-field" required>
                </div>
                <div class="input-group">
                    <label class="input-label">Phone</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="input-field">
                </div>
                <div class="input-group">
                    <label class="input-label">Role</label>
                    <select name="role" class="input-field" required>
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                        <option value="event_manager" {{ $user->role === 'event_manager' ? 'selected' : '' }}>Event Manager</option>
                        <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                </div>
                <div class="input-group">
                    <label class="input-label">Status</label>
                    <select name="status" class="input-field" required>
                        <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ $user->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        <option value="pending" {{ $user->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.users') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Update User</button>
        </div>
    </form>
</div>
@endsection
