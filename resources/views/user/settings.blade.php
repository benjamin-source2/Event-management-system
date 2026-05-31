@extends('layouts.app', ['title' => 'Settings'])

@section('content')
<div class="py-8 max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Settings</h1>
        <p class="text-gray-500 dark:text-gray-400">Manage your account preferences</p>
    </div>

    <!-- Profile Settings -->
    <form action="{{ route('user.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="glass-card p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Profile Information</h2>

            <!-- Profile Photo -->
            <div class="flex items-center gap-6 mb-6 pb-6 border-b border-gray-200 dark:border-navy-700">
                <div class="relative shrink-0">
                    @if($user->profile_photo)
                        <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->full_name }}"
                             class="w-20 h-20 rounded-full object-cover border-2 border-primary-500/30 shadow-md">
                    @else
                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white font-bold text-2xl shadow-md">
                            {{ $user->initials }}
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <label class="input-label">Profile Photo</label>
                    <div class="mt-1">
                        <input type="file" name="profile_photo" accept="image/*"
                               class="input-field @error('profile_photo') input-error @enderror">
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG or GIF. Max 10MB.</p>
                    </div>
                    @error('profile_photo') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                <div class="input-group">
                    <label class="input-label">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                           class="input-field @error('first_name') input-error @enderror" required>
                    @error('first_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                           class="input-field @error('last_name') input-error @enderror" required>
                    @error('last_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">Email</label>
                    <input type="email" value="{{ $user->email }}" class="input-field bg-gray-100 dark:bg-navy-700" disabled>
                    <p class="text-xs text-gray-400 mt-1">Email cannot be changed</p>
                </div>

                <div class="input-group">
                    <label class="input-label">Phone</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="input-field @error('phone') input-error @enderror" placeholder="+250 7XX XXX XXX">
                    @error('phone') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Preferences -->
        <div class="glass-card p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Preferences</h2>

            <div class="grid sm:grid-cols-2 gap-6">
                <div class="input-group">
                    <label class="input-label">Language</label>
                    <select name="language" class="input-field">
                        <option value="en" {{ $user->language === 'en' ? 'selected' : '' }}>English</option>
                        <option value="fr" {{ $user->language === 'fr' ? 'selected' : '' }}>Français</option>
                        <option value="rw" {{ $user->language === 'rw' ? 'selected' : '' }}>Kinyarwanda</option>
                    </select>
                </div>

                <div class="input-group">
                    <label class="input-label">Theme</label>
                    <select name="theme_preference" class="input-field">
                        <option value="light" {{ $user->theme_preference === 'light' ? 'selected' : '' }}>Light Mode</option>
                        <option value="dark" {{ $user->theme_preference === 'dark' ? 'selected' : '' }}>Dark Mode</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Save Changes</button>
        </div>
    </form>

    <!-- Account Security -->
    <div class="mt-8">
        <div class="glass-card p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Account Security</h2>
            <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-navy-700">
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Password</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Last changed {{ $user->updated_at->diffForHumans() }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="btn-secondary btn-sm">Change Password</a>
            </div>
        </div>
    </div>
</div>
@endsection
