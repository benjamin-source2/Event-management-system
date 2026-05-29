<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Invitation;
use App\Models\AppNotification;
use Illuminate\Support\Facades\DB;


class InvitationService
{
    /**
     * Request an invitation to an event.
     */
    public function requestInvitation(int $userId, int $eventId): Invitation
    {
        return DB::transaction(function () use ($userId, $eventId) {
            $event = Event::findOrFail($eventId);

            if ($event->is_full) {
                throw new \Exception('This event is fully booked.');
            }

            $existingInvitation = Invitation::where('user_id', $userId)
                ->where('event_id', $eventId)
                ->first();

            if ($existingInvitation) {
                throw new \Exception('You have already requested an invitation for this event.');
            }

            $invitation = Invitation::create([
                'user_id' => $userId,
                'event_id' => $eventId,
                'approval_status' => 'pending',
            ]);

            // Notify organizers
            AppNotification::create([
                'user_id' => $event->organizer_id,
                'title' => 'New Invitation Request',
                'message' => "A new invitation request has been submitted for \"{$event->title}\".",
                'type' => 'info',
                'icon' => 'user-plus',
                'action_url' => route('admin.invitations'),
            ]);

            return $invitation;
        });
    }

    /**
     * Approve an invitation request.
     */
    public function approveInvitation(Invitation $invitation, int $approvedBy): Invitation
    {
        return DB::transaction(function () use ($invitation, $approvedBy) {
            $invitation->update([
                'approval_status' => 'approved',
                'approved_by' => $approvedBy,
                'verified_at' => now(),
            ]);

            // Generate QR code data
            $qrData = json_encode([
                'invitation_code' => $invitation->invitation_code,
                'event_id' => $invitation->event_id,
                'user_id' => $invitation->user_id,
            ]);

            // Attempt QR code generation if package is available
            if (class_exists('\SimpleSoftwareIO\QrCode\Facades\QrCode')) {
                try {
                    $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(200)->generate($qrData));
                    $invitation->update(['qr_code' => $qrCode]);
                } catch (\Exception $e) {
                    // QR generation failed, continue without it
                }
            }

            // Notify user
            AppNotification::create([
                'user_id' => $invitation->user_id,
                'title' => 'Invitation Approved!',
                'message' => "Your invitation for \"{$invitation->event->title}\" has been approved. You can now download your pass.",
                'type' => 'success',
                'icon' => 'check-circle',
                'action_url' => route('user.invitations'),
            ]);

            return $invitation->fresh();
        });
    }

    /**
     * Reject an invitation request.
     */
    public function rejectInvitation(Invitation $invitation, int $approvedBy, string $reason = null): Invitation
    {
        return DB::transaction(function () use ($invitation, $approvedBy, $reason) {
            $invitation->update([
                'approval_status' => 'rejected',
                'approved_by' => $approvedBy,
                'rejected_at' => now(),
                'rejection_reason' => $reason,
            ]);

            AppNotification::create([
                'user_id' => $invitation->user_id,
                'title' => 'Invitation Rejected',
                'message' => "Your invitation for \"{$invitation->event->title}\" has been rejected." . ($reason ? " Reason: {$reason}" : ''),
                'type' => 'error',
                'icon' => 'x-circle',
            ]);

            return $invitation->fresh();
        });
    }

    /**
     * Verify an invitation by QR code or invitation code.
     */
    public function verifyInvitation(string $code): ?Invitation
    {
        $invitation = Invitation::where('invitation_code', $code)
            ->orWhere('id', $code)
            ->with(['user', 'event'])
            ->first();

        if (!$invitation || $invitation->approval_status !== 'approved') {
            return null;
        }

        return $invitation;
    }

    /**
     * Mark attendee as checked in.
     */
    public function markAttended(Invitation $invitation): void
    {
        $invitation->update([
            'attended' => true,
            'attended_at' => now(),
        ]);
    }

    /**
     * Get user's invitations.
     */
    public function getUserInvitations(int $userId, string $status = null)
    {
        $query = Invitation::where('user_id', $userId)
            ->with(['event']);

        if ($status) {
            $query->where('approval_status', $status);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }
}
