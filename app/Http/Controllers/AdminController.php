<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\AppNotification;
use App\Models\LoginLog;
use App\Models\AppSetting;
use App\Services\AnalyticsService;
use App\Services\EventService;
use App\Services\InvitationService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    protected AnalyticsService $analyticsService;
    protected EventService $eventService;
    protected InvitationService $invitationService;
    protected NotificationService $notificationService;

    public function __construct(
        AnalyticsService $analyticsService,
        EventService $eventService,
        InvitationService $invitationService,
        NotificationService $notificationService
    ) {
        $this->analyticsService = $analyticsService;
        $this->eventService = $eventService;
        $this->invitationService = $invitationService;
        $this->notificationService = $notificationService;
    }

    public function dashboard()
    {
        $stats = $this->analyticsService->getDashboardStats();
        $eventStats = $this->analyticsService->getEventStats();
        $dailyActivity = $this->analyticsService->getDailyActivity();
        $topEvents = $this->analyticsService->getTopEvents(5);
        $recentUsers = User::latest()->take(5)->get();
        $recentEvents = Event::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'eventStats', 'dailyActivity', 'topEvents',
            'recentUsers', 'recentEvents'
        ));
    }

    // Users Management
    public function users()
    {
        $users = User::withCount('invitations')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function userShow(User $user)
    {
        $user->load(['invitations.event', 'loginLogs' => fn($q) => $q->latest()->take(10)]);
        return view('admin.users.show', compact('user'));
    }

    public function userCreate()
    {
        return view('admin.users.create');
    }

    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'role' => 'required|in:super_admin,event_manager,user',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    public function userEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function userUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:super_admin,event_manager,user',
            'status' => 'required|in:active,suspended,pending',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function userSuspend(User $user)
    {
        $user->update(['status' => 'suspended']);
        $this->notificationService->send(
            $user->id,
            'Account Suspended',
            'Your account has been suspended. Please contact support for more information.',
            'error'
        );
        return back()->with('success', 'User suspended successfully.');
    }

    public function userActivate(User $user)
    {
        $user->update(['status' => 'active']);
        $this->notificationService->send(
            $user->id,
            'Account Activated',
            'Your account has been reactivated. You can now access the platform.',
            'success'
        );
        return back()->with('success', 'User activated successfully.');
    }

    // Events Management
    public function events()
    {
        $events = Event::with('organizer')->withCount('invitations')->latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function eventShow(Event $event)
    {
        $event->load(['organizer', 'invitations.user']);
        return view('admin.events.show', compact('event'));
    }

    public function eventApprove(Event $event)
    {
        $this->eventService->approve($event);
        return back()->with('success', 'Event approved successfully.');
    }

    public function eventReject(Request $request, Event $event)
    {
        $validated = $request->validate(['reason' => 'nullable|string|max:500']);
        $this->eventService->reject($event, $validated['reason'] ?? null);
        return back()->with('success', 'Event rejected.');
    }

    public function eventCancel(Event $event)
    {
        $this->eventService->cancel($event);
        return back()->with('success', 'Event cancelled.');
    }

    public function eventCreate()
    {
        return view('admin.events.create');
    }

    public function eventStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:' . implode(',', array_keys(Event::CATEGORIES)),
            'location' => 'required|string|max:255',
            'province' => 'required|string|in:' . implode(',', array_keys(Event::PROVINCES)),
            'district' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'ticket_limit' => 'nullable|integer|min:0',
            'status' => 'required|in:' . implode(',', array_keys(Event::STATUSES)),
            'featured' => 'boolean',
            'event_image' => 'nullable|image|max:2048',
        ]);

        $validated['featured'] = $request->has('featured');

        // Auto-approve events created by super admin so they're immediately visible to all users
        $validated['status'] = 'approved';

        $event = $this->eventService->create($validated, auth()->id());

        return redirect()->route('admin.events.show', $event)->with('success', 'Event created successfully.');
    }

    public function eventEdit(Event $event)
    {
        $event->load('organizer');
        return view('admin.events.edit', compact('event'));
    }

    public function eventUpdate(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:' . implode(',', array_keys(Event::CATEGORIES)),
            'location' => 'required|string|max:255',
            'province' => 'required|string|in:' . implode(',', array_keys(Event::PROVINCES)),
            'district' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'ticket_limit' => 'nullable|integer|min:0',
            'status' => 'required|in:' . implode(',', array_keys(Event::STATUSES)),
            'featured' => 'boolean',
            'event_image' => 'nullable|image|max:2048',
        ]);

        // Include featured checkbox (default false if unchecked)
        $validated['featured'] = $request->has('featured');

        $this->eventService->update($event, $validated);

        return redirect()->route('admin.events.show', $event->fresh())->with('success', 'Event updated successfully.');
    }

    public function eventDestroy(Event $event)
    {
        $this->eventService->delete($event);
        return redirect()->route('admin.events')->with('success', 'Event deleted successfully.');
    }

    public function eventToggleFeatured(Event $event)
    {
        $event->update(['featured' => !$event->featured]);
        return back()->with('success', $event->featured ? 'Event featured.' : 'Event unfeatured.');
    }

    // Invitations Management
    public function invitations(Request $request)
    {
        $query = Invitation::with(['user', 'event']);

        if ($request->status) {
            $query->where('approval_status', $request->status);
        }

        $invitations = $query->latest()->paginate(15);
        return view('admin.invitations.index', compact('invitations'));
    }

    public function invitationApprove(Invitation $invitation)
    {
        try {
            $this->invitationService->approveInvitation($invitation, auth()->id());
            return back()->with('success', 'Invitation approved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function invitationReject(Request $request, Invitation $invitation)
    {
        $validated = $request->validate(['reason' => 'nullable|string|max:500']);
        $this->invitationService->rejectInvitation($invitation, auth()->id(), $validated['reason'] ?? null);
        return back()->with('success', 'Invitation rejected.');
    }

    // Reports
    public function reports()
    {
        $userStats = $this->analyticsService->getUserStats();
        $eventStats = $this->analyticsService->getEventStats();
        $dailyActivity = $this->analyticsService->getDailyActivity();
        $topEvents = $this->analyticsService->getTopEvents(10);

        return view('admin.reports.index', compact('userStats', 'eventStats', 'dailyActivity', 'topEvents'));
    }

    public function exportUsersPdf()
    {
        $users = User::withCount('invitations')->get();
        $pdf = Pdf::loadView('admin.reports.pdf.users', compact('users'));
        return $pdf->download('users-report.pdf');
    }

    public function exportEventsPdf()
    {
        $events = Event::with('organizer')->withCount('invitations')->get();
        $pdf = Pdf::loadView('admin.reports.pdf.events', compact('events'));
        return $pdf->download('events-report.pdf');
    }

    // Logs
    public function logs()
    {
        $logs = LoginLog::with('user')->latest()->paginate(30);
        return view('admin.logs.index', compact('logs'));
    }

    public function activityLogs()
    {
        $notifications = AppNotification::latest()->paginate(30);
        return view('admin.logs.activity', compact('notifications'));
    }

    // Settings
    public function settings()
    {
        return view('admin.settings.index');
    }

    public function settingsUpdate(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'nullable|string',
        ]);

        // Store settings in session for now
        session(['app_settings' => $validated]);

        return back()->with('success', 'Settings updated successfully.');
    }
}
