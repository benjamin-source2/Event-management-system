<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Services\InvitationService;
use Illuminate\Http\Request;

class InvitationVerificationController extends Controller
{
    protected InvitationService $invitationService;

    public function __construct(InvitationService $invitationService)
    {
        $this->invitationService = $invitationService;
    }

    public function index()
    {
        return view('verification.scanner');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $invitation = $this->invitationService->verifyInvitation($request->code);

        if (!$invitation) {
            return back()->with('error', 'Invalid or unapproved invitation code.');
        }

        return view('verification.result', compact('invitation'));
    }

    public function verifyAjax(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $invitation = $this->invitationService->verifyInvitation($request->code);

        if (!$invitation) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid or unapproved invitation.',
            ], 404);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Invitation verified successfully!',
            'invitation' => [
                'code' => $invitation->invitation_code,
                'event' => $invitation->event?->title,
                'event_date' => $invitation->event?->event_date?->format('M d, Y'),
                'attendee' => $invitation->user?->full_name,
                'status' => $invitation->approval_status,
            ],
        ]);
    }

    public function markAttended(Invitation $invitation)
    {
        if ($invitation->approval_status !== 'approved') {
            return back()->with('error', 'Cannot mark unapproved invitation as attended.');
        }

        if ($invitation->attended) {
            return back()->with('info', 'This attendee was already marked as present.');
        }

        $this->invitationService->markAttended($invitation);

        return back()->with('success', 'Attendee marked as present successfully.');
    }
}
