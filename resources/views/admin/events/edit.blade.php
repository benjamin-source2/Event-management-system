@extends('layouts.app', ['title' => 'Edit Event - ' . $event->title])

@section('content')
<div class="py-8 max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">Edit Event</h1>
        <p class="text-gray-500 dark:text-gray-400">Update event details and settings</p>
    </div>

    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="premium-card p-6 space-y-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-navy-700 pb-3">Basic Information</h3>

            <div class="input-group">
                <label class="input-label">Event Title</label>
                <input type="text" name="title" value="{{ old('title', $event->title) }}" class="input-field" required>
                @error('title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="input-group">
                <label class="input-label">Description</label>
                <textarea name="description" rows="5" class="input-field" required>{{ old('description', $event->description) }}</textarea>
                @error('description') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                <div class="input-group">
                    <label class="input-label">Category</label>
                    <select name="category" class="input-field" required>
                        @foreach(App\Models\Event::CATEGORIES as $value => $label)
                            <option value="{{ $value }}" {{ old('category', $event->category) === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">Event Date</label>
                    <input type="date" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" class="input-field" required>
                    @error('event_date') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                <div class="input-group">
                    <label class="input-label">Start Time</label>
                    <input type="time" name="start_time" value="{{ old('start_time', $event->start_time->format('H:i')) }}" class="input-field" required>
                    @error('start_time') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">End Time</label>
                    <input type="time" name="end_time" value="{{ old('end_time', $event->end_time->format('H:i')) }}" class="input-field" required>
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
                        @foreach(App\Models\Event::PROVINCES as $value => $label)
                            <option value="{{ $value }}" {{ old('province', $event->province) === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('province') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">District</label>
                    <input type="text" name="district" value="{{ old('district', $event->district) }}" class="input-field" required>
                    @error('district') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="input-group">
                <label class="input-label">Location / Venue</label>
                <input type="text" name="location" value="{{ old('location', $event->location) }}" class="input-field" required>
                @error('location') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="premium-card p-6 space-y-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-navy-700 pb-3">Tickets & Status</h3>

            <div class="grid sm:grid-cols-2 gap-6">
                <div class="input-group">
                    <label class="input-label">Ticket Limit</label>
                    <input type="number" name="ticket_limit" value="{{ old('ticket_limit', $event->ticket_limit) }}" class="input-field" min="0">
                    @error('ticket_limit') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">Status</label>
                    <select name="status" class="input-field" required>
                        @foreach(App\Models\Event::STATUSES as $value => $label)
                            <option value="{{ $value }}" {{ old('status', $event->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured', $event->featured) ? 'checked' : '' }}
                       class="w-5 h-5 rounded-lg border-gray-300 dark:border-navy-600 text-primary-500 focus:ring-primary-500">
                <label for="featured" class="text-sm font-medium text-gray-700 dark:text-gray-300">Featured Event</label>
            </div>
        </div>

        <div class="premium-card p-6 space-y-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-navy-700 pb-3">Event Image</h3>

            @if($event->event_image)
                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-2">Current image:</p>
                    <img src="{{ Storage::url($event->event_image) }}" alt="{{ $event->title }}" class="w-48 h-32 object-cover rounded-xl border border-gray-200 dark:border-navy-700">
                </div>
            @endif

            <div class="input-group">
                <label class="input-label">Upload new image (leave empty to keep current)</label>
                <input type="file" name="event_image" class="input-field" accept="image/*">
                @error('event_image') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.events.show', $event) }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Update Event</button>
        </div>
    </form>
</div>
@endsection
