@extends('layouts.app', ['title' => 'Create User'])

@section('content')
<div class="py-8 max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Create User</h1>
        <p class="text-gray-500 dark:text-gray-400">Add a new user to the platform</p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="glass-heavy p-6 space-y-6">
            <div class="grid sm:grid-cols-2 gap-6">
                <div class="input-group">
                    <label class="input-label">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" class="input-field" required>
                </div>
                <div class="input-group">
                    <label class="input-label">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="input-field" required>
                </div>
                <div class="input-group">
                    <label class="input-label">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" class="input-field" required>
                </div>
                <div class="input-group">
                    <label class="input-label">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="input-field" required>
                </div>
                <div class="input-group">
                    <label class="input-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input-field" required>
                </div>
                <div class="input-group">
                    <label class="input-label">Phone</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" class="input-field">
                </div>
                <div class="input-group">
                    <label class="input-label">Password</label>
                    <input type="password" name="password" class="input-field" required>
                </div>
                <div class="input-group">
                    <label class="input-label">Role</label>
                    <select name="role" class="input-field" required>
                        <option value="user">User</option>
                        <option value="event_manager">Event Manager</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>
            </div>

            <!-- Profile Photo -->
            <div class="border-t border-gray-200 dark:border-navy-700 pt-6">
                <div class="input-group">
                    <label class="input-label">Profile Photo (optional)</label>
                    <input type="file" name="profile_photo" accept="image/*" class="input-field">
                    @error('profile_photo') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG or GIF. Max 10MB.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.users') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Create User</button>
        </div>
    </form>
</div>
@endsection
