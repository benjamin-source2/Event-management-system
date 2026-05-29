<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Hidden(['password', 'remember_token', 'two_factor_secret'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'first_name',
        'last_name',
        'email',
        'phone',
        'profile_photo',
        'password',
        'role',
        'language',
        'theme_preference',
        'status',
        'otp_code',
        'otp_expires_at',
        'two_factor_enabled','two_factor_secret',
            'email_verified_at',
            'last_login_at',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    // Roles
    const ROLE_SUPER_ADMIN = 'super_admin';
    const ROLE_EVENT_MANAGER = 'event_manager';
    const ROLE_USER = 'user';

    // Statuses
    const STATUS_ACTIVE = 'active';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_PENDING = 'pending';

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isEventManager(): bool
    {
        return $this->role === self::ROLE_EVENT_MANAGER;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isSuspended(): bool
    {
        return $this->status === self::STATUS_SUSPENDED;
    }

    // Relationships
    public function organizedEvents()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function appNotifications()
    {
        return $this->hasMany(AppNotification::class);
    }

    public function loginLogs()
    {
        return $this->hasMany(LoginLog::class);
    }

    public function favoriteEvents()
    {
        return $this->hasMany(FavoriteEvent::class);
    }

    public function approvedInvitations()
    {
        return $this->hasMany(Invitation::class, 'approved_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getInitialsAttribute(): string
    {
        $first = substr($this->first_name ?? $this->name, 0, 1);
        $last = substr($this->last_name ?? '', 0, 1);
        return strtoupper($first . $last);
    }
}
