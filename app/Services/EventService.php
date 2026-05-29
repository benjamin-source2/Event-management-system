<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Invitation;
use App\Models\AppNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventService
{
    /**
     * Create a new event.
     */
    public function create(array $data, int $organizerId): Event
    {
        return DB::transaction(function () use ($data, $organizerId) {
            $data['organizer_id'] = $organizerId;
            $data['slug'] = Str::slug($data['title']) . '-' . Str::random(6);
            $data['tickets_available'] = $data['ticket_limit'] ?? 0;

            if (isset($data['event_image'])) {
                $data['event_image'] = $data['event_image']->store('events', 'public');
            }

            return Event::create($data);
        });
    }

    /**
     * Update an existing event.
     */
    public function update(Event $event, array $data): Event
    {
        return DB::transaction(function () use ($event, $data) {
            if (isset($data['event_image']) && $data['event_image'] instanceof \Illuminate\Http\UploadedFile) {
                if ($event->event_image) {
                    Storage::disk('public')->delete($event->event_image);
                }
                $data['event_image'] = $data['event_image']->store('events', 'public');
            }

            if (isset($data['ticket_limit'])) {
                $data['tickets_available'] = $data['ticket_limit'];
            }

            $event->update($data);
            return $event->fresh();
        });
    }

    /**
     * Approve an event.
     */
    public function approve(Event $event): void
    {
        DB::transaction(function () use ($event) {
            $event->update(['status' => 'approved']);

            AppNotification::create([
                'user_id' => $event->organizer_id,
                'title' => 'Event Approved!',
                'message' => "Your event \"{$event->title}\" has been approved and is now visible to the public.",
                'type' => 'success',
                'icon' => 'check-circle',
                'action_url' => route('events.show', $event->slug),
            ]);
        });
    }

    /**
     * Reject an event.
     */
    public function reject(Event $event, string $reason = null): void
    {
        DB::transaction(function () use ($event, $reason) {
            $event->update(['status' => 'rejected']);

            AppNotification::create([
                'user_id' => $event->organizer_id,
                'title' => 'Event Rejected',
                'message' => "Your event \"{$event->title}\" has been rejected." . ($reason ? " Reason: {$reason}" : ''),
                'type' => 'error',
                'icon' => 'x-circle',
            ]);
        });
    }

    /**
     * Cancel an event.
     */
    public function cancel(Event $event): void
    {
        DB::transaction(function () use ($event) {
            $event->update(['status' => 'cancelled']);

            // Notify all approved invitees
            $invitations = $event->approvedInvitations()->get();
            $notifications = $invitations->map(function ($invitation) use ($event) {
                return [
                    'user_id' => $invitation->user_id,
                    'title' => 'Event Cancelled',
                    'message' => "The event \"{$event->title}\" has been cancelled. We apologize for the inconvenience.",
                    'type' => 'warning',
                    'icon' => 'alert-triangle',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            if (!empty($notifications)) {
                AppNotification::insert($notifications);
            }
        });
    }

    /**
     * Search events by title, location, or category.
     */
    public function search(string $query)
    {
        return Event::approved()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('location', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('category', 'like', "%{$query}%");
            })
            ->upcoming()
            ->orderBy('event_date')
            ->paginate(12);
    }

    /**
     * Get featured upcoming events.
     */
    public function getFeaturedEvents(int $limit = 6)
    {
        return Event::approved()
            ->featured()
            ->upcoming()
            ->orderBy('event_date')
            ->take($limit)
            ->get();
    }

    /**
     * Get upcoming events by category.
     */
    public function getEventsByCategory(?string $category = null, int $perPage = 12)
    {
        $query = Event::approved()->upcoming()->orderBy('event_date');

        if ($category) {
            $query->byCategory($category);
        }

        return $query->paginate($perPage);
    }
}
