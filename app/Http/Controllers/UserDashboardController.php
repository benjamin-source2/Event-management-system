<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invitation;
use App\Models\AppNotification;
use App\Models\FavoriteEvent;
use App\Services\InvitationService;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    protected InvitationService $invitationService;
    protected NotificationService $notificationService;

    public function __construct(
        InvitationService $invitationService,
        NotificationService $notificationService
    ) {
        $this->invitationService = $invitationService;
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $user = auth()->user();
        $stats = [
            'total_invitations' => Invitation::where('user_id', $user->id)->count(),
            'approved_invitations' => Invitation::where('user_id', $user->id)->approved()->count(),
            'pending_invitations' => Invitation::where('user_id', $user->id)->pending()->count(),
            'favorite_events' => FavoriteEvent::where('user_id', $user->id)->count(),
            'upcoming_events' => Event::approved()->upcoming()->count(),
            'unread_notifications' => AppNotification::where('user_id', $user->id)->unread()->count(),
        ];

        $recentInvitations = Invitation::where('user_id', $user->id)
            ->with('event')
            ->latest()
            ->take(5)
            ->get();

        $notifications = AppNotification::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('stats', 'recentInvitations', 'notifications'));
    }

    public function invitations(Request $request)
    {
        $status = $request->query('status');
        $invitations = $this->invitationService->getUserInvitations(auth()->id(), $status);

        return view('user.invitations', compact('invitations'));
    }

    public function requestInvitation(Event $event)
    {
        try {
            $this->invitationService->requestInvitation(auth()->id(), $event->id);
            return back()->with('success', 'Invitation request submitted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function invitationPass(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($invitation->approval_status !== 'approved') {
            return back()->with('error', 'Your invitation has not been approved yet.');
        }

        return view('user.invitation-pass', compact('invitation'));
    }

    public function favorites()
    {
        $favorites = FavoriteEvent::where('user_id', auth()->id())
            ->with('event')
            ->latest()
            ->paginate(12);

        return view('user.favorites', compact('favorites'));
    }

    public function toggleFavorite(Event $event)
    {
        $userId = auth()->id();
        $favorite = FavoriteEvent::where('user_id', $userId)
            ->where('event_id', $event->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Event removed from favorites.');
        }

        FavoriteEvent::create([
            'user_id' => $userId,
            'event_id' => $event->id,
        ]);

        return back()->with('success', 'Event added to favorites!');
    }

    public function notifications()
    {
        $notifications = $this->notificationService->getUserNotifications(auth()->id());
        return view('user.notifications', compact('notifications'));
    }

    public function markNotificationRead($id)
    {
        $this->notificationService->markAsRead($id);
        return back();
    }

    public function markAllNotificationsRead()
    {
        $this->notificationService->markAllAsRead(auth()->id());
        return back()->with('success', 'All notifications marked as read.');
    }

    public function settings()
    {
        $user = auth()->user();
        return view('user.settings', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'language' => 'required|in:en,fr,rw',
            'theme_preference' => 'required|in:light,dark',
        ]);

        $user->update($validated);

        return back()->with('success', 'Settings updated successfully.');
    }

    public function updateTheme(Request $request)
    {
        $user = auth()->user();
        $theme = $request->theme === 'dark' ? 'dark' : 'light';
        $user->update(['theme_preference' => $theme]);
        return response()->json(['theme' => $theme]);
    }
}
