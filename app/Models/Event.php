<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'event_image',
        'location',
        'province',
        'district',
        'event_date',
        'start_time',
        'end_time',
        'ticket_limit',
        'tickets_available',
        'organizer_id',
        'status',
        'featured',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'featured' => 'boolean',
        ];
    }

    const CATEGORIES = [
        'wedding' => 'Wedding',
        'conference' => 'Conference',
        'business' => 'Business Meeting',
        'music' => 'Music Show',
        'vip' => 'VIP Event',
        'church' => 'Church Event',
        'school' => 'School Event',
        'birthday' => 'Birthday Party',
        'technology' => 'Technology Event',
        'other' => 'Other',
    ];

    const PROVINCES = [
        'kigali' => 'Kigali City',
        'eastern' => 'Eastern Province',
        'western' => 'Western Province',
        'northern' => 'Northern Province',
        'southern' => 'Southern Province',
    ];

    const STATUSES = [
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'cancelled' => 'Cancelled',
        'completed' => 'Completed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title) . '-' . Str::random(6);
            }
            if ($event->tickets_available === null) {
                $event->tickets_available = $event->ticket_limit;
            }
        });
    }

    // Relationships
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function approvedInvitations()
    {
        return $this->hasMany(Invitation::class)->where('approval_status', 'approved');
    }

    public function pendingInvitations()
    {
        return $this->hasMany(Invitation::class)->where('approval_status', 'pending');
    }

    public function favoriteEvents()
    {
        return $this->hasMany(FavoriteEvent::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->startOfDay())->where('status', 'approved');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByProvince($query, $province)
    {
        return $query->where('province', $province);
    }

    // Accessors
    public function getTicketsRemainingAttribute(): int
    {
        return max(0, $this->tickets_available - $this->approvedInvitations()->count());
    }

    public function getIsFullAttribute(): bool
    {
        return $this->tickets_remaining <= 0;
    }

    public function getCategoryNameAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    public function getProvinceNameAttribute(): string
    {
        return self::PROVINCES[$this->province] ?? $this->province;
    }

    public function getStatusNameAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
