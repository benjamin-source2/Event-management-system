<?php

namespace App\Services;

use App\Models\AppNotification;
use App\Models\User;

class NotificationService
{
    /**
     * Send a notification to a user.
     */
    public function send(int $userId, string $title, string $message, string $type = 'info', ?string $icon = null, ?string $actionUrl = null): AppNotification
    {
        return AppNotification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'icon' => $icon,
            'action_url' => $actionUrl,
        ]);
    }

    /**
     * Send notification to multiple users.
     */
    public function sendToMany(array $userIds, string $title, string $message, string $type = 'info'): void
    {
        $notifications = [];
        foreach ($userIds as $userId) {
            $notifications[] = [
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        AppNotification::insert($notifications);
    }

    /**
     * Send notification to all users by role.
     */
    public function sendToRole(string $role, string $title, string $message, string $type = 'info'): void
    {
        $userIds = User::byRole($role)->pluck('id')->toArray();
        $this->sendToMany($userIds, $title, $message, $type);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(int $notificationId): void
    {
        AppNotification::where('id', $notificationId)->update(['is_read' => true]);
    }

    /**
     * Mark all notifications as read for a user.
     */
    public function markAllAsRead(int $userId): void
    {
        AppNotification::where('user_id', $userId)->unread()->update(['is_read' => true]);
    }

    /**
     * Get unread notification count for a user.
     */
    public function getUnreadCount(int $userId): int
    {
        return AppNotification::where('user_id', $userId)->unread()->count();
    }

    /**
     * Get paginated notifications for a user.
     */
    public function getUserNotifications(int $userId, int $perPage = 15)
    {
        return AppNotification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
