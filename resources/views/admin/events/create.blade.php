@extends('layouts.app', ['title' => 'Create Event'])

@section('content')
<div class="py-8 max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Create Event</h1>
        <p class="text-gray-500 dark:text-gray-400">Add a new event to the platform</p>
    </div>

    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="premium-card p-6 space-y-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-navy-700 pb-3">Basic Information</h3>

            <div class="input-group">
                <label class="input-label">Event Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="input-field" required>
                @error('title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="input-group">
                <label class="input-label">Description</label>
                <textarea name="description" rows="5" class="input-field" required>{{ old('description') }}</textarea>
                @error('description') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                <div class="input-group">
                    <label class="input-label">Category</label>
                    <select name="category" class="input-field" required>
                        <option value="">Select a category</option>
                        @foreach(App\Models\Event::CATEGORIES as $value => $label)
                            <option value="{{ $value }}" {{ old('category') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">Event Date</label>
                    <input type="date" name="event_date" value="{{ old('event_date') }}" class="input-field" required>
                    @error('event_date') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                <div class="input-group">
                    <label class="input-label">Start Time</label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}" class="input-field" required>
                    @error('start_time') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">End Time</label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}" class="input-field" required>
                    @error('end_time') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="premium-card p-6 space-y-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-navy-700 pb-3">Location</h3>

            <div class="grid sm:grid-cols-2 gap-6">
                <div class="input-group">
                    <label class="input-label">Province</label>
                    <select name="province" class="input-field" required>
                        <option value="">Select a province</option>
                        @foreach(App\Models\Event::PROVINCES as $value => $label)
                            <option value="{{ $value }}" {{ old('province') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('province') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">District</label>
                    <input type="text" name="district" value="{{ old('district') }}" class="input-field" required>
                    @error('district') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="input-group">
                <label class="input-label">Location / Venue</label>
                <input type="text" name="location" value="{{ old('location') }}" class="input-field" required>
                @error('location') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="premium-card p-6 space-y-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-navy-700 pb-3">Tickets & Status</h3>

            <div class="input-group">
                <label class="input-label">Ticket Limit</label>
                <input type="number" name="ticket_limit" value="{{ old('ticket_limit') }}" class="input-field" min="0" placeholder="0 = unlimited">
                @error('ticket_limit') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <input type="hidden" name="status" value="approved">
            <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Events created by admin are automatically <strong>approved</strong> and visible to all users.
            </p>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                       class="w-5 h-5 rounded-lg border-gray-300 dark:border-navy-600 text-primary-500 focus:ring-primary-500">
                <label for="featured" class="text-sm font-medium text-gray-700 dark:text-gray-300">Featured Event</label>
            </div>
        </div>

        <div class="premium-card p-6 space-y-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-navy-700 pb-3">Event Image</h3>

            <div class="input-group">
                <label class="input-label">Upload event image (optional)</label>
                <input type="file" name="event_image" class="input-field" accept="image/*">
                @error('event_image') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.events') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Create Event</button>
        </div>
    </form>
</div>
@endsection
