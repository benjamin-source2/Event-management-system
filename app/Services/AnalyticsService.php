<?php

namespace App\Services;

use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\LoginLog;
use App\Models\AppNotification;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Get dashboard statistics.
     */
    public function getDashboardStats(): array
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::active()->count(),
            'total_events' => Event::count(),
            'approved_events' => Event::approved()->count(),
            'upcoming_events' => Event::upcoming()->count(),
            'total_invitations' => Invitation::count(),
            'pending_invitations' => Invitation::pending()->count(),
            'approved_invitations' => Invitation::approved()->count(),
            'total_attendees' => Invitation::attended()->count(),
            'total_managers' => User::byRole('event_manager')->count(),
            'total_admins' => User::byRole('super_admin')->count(),
            'unread_notifications' => AppNotification::unread()->count(),
        ];
    }

    /**
     * Get event statistics.
     */
    public function getEventStats(): array
    {
        return [
            'by_category' => Event::approved()
                ->select('category', DB::raw('count(*) as total'))
                ->groupBy('category')
                ->get()
                ->pluck('total', 'category')
                ->toArray(),
            'by_province' => Event::approved()
                ->select('province', DB::raw('count(*) as total'))
                ->groupBy('province')
                ->get()
                ->pluck('total', 'province')
                ->toArray(),
            'by_status' => Event::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get()
                ->pluck('total', 'status')
                ->toArray(),
            'monthly_events' => Event::select(
                DB::raw("strftime('%Y-%m', created_at) as month"),
                DB::raw('count(*) as total')
            )
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('total', 'month')
                ->toArray(),
        ];
    }

    /**
     * Get user registration statistics.
     */
    public function getUserStats(): array
    {
        return [
            'by_role' => User::select('role', DB::raw('count(*) as total'))
                ->groupBy('role')
                ->get()
                ->pluck('total', 'role')
                ->toArray(),
            'by_status' => User::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get()
                ->pluck('total', 'status')
                ->toArray(),
            'monthly_registrations' => User::select(
                DB::raw("strftime('%Y-%m', created_at) as month"),
                DB::raw('count(*) as total')
            )
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('total', 'month')
                ->toArray(),
        ];
    }

    /**
     * Get daily activity for the past 30 days.
     */
    public function getDailyActivity(): array
    {
        $days = collect(range(29, 0))->map(function ($i) {
            return now()->subDays($i)->format('Y-m-d');
        });

        $events = Event::select(
            DB::raw("date(created_at) as date"),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->get()
            ->pluck('total', 'date');

        $registrations = User::select(
            DB::raw("date(created_at) as date"),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->get()
            ->pluck('total', 'date');

        return [
            'dates' => $days->values()->toArray(),
            'events' => $days->map(fn($d) => $events->get($d, 0))->values()->toArray(),
            'registrations' => $days->map(fn($d) => $registrations->get($d, 0))->values()->toArray(),
        ];
    }

    /**
     * Get top events by invitations.
     */
    public function getTopEvents(int $limit = 5)
    {
        return Event::approved()
            ->withCount('approvedInvitations')
            ->orderBy('approved_invitations_count', 'desc')
            ->take($limit)
            ->get();
    }
}
