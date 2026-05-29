@extends('layouts.app', ['title' => 'Settings'])

@section('content')
<div class="py-8 max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">System Settings</h1>
        <p class="text-gray-500 dark:text-gray-400">Configure platform settings</p>
    </div>

    <div class="premium-card p-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6">General Settings</h2>
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div class="input-group">
                    <label class="input-label">Application Name</label>
                    <input type="text" name="app_name" value="{{ config('app.name') }}" class="input-field">
                </div>
                <div class="input-group">
                    <label class="input-label">Application Description</label>
                    <textarea name="app_description" rows="3" class="input-field" placeholder="Brief description of your platform">{{ config('app.description', '') }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">Save Settings</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
