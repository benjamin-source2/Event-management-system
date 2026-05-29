<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'invitation_code',
        'qr_code',
        'approval_status',
        'approved_by',
        'verified_at',
        'rejected_at',
        'rejection_reason',
        'attended',
        'attended_at',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'rejected_at' => 'datetime',
            'attended_at' => 'datetime',
            'attended' => 'boolean',
        ];
    }

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invitation) {
            $invitation->invitation_code = strtoupper('INV-' . Str::random(10));
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('approval_status', 'rejected');
    }

    public function scopeAttended($query)
    {
        return $query->where('attended', true);
    }

    // Accessors
    public function getStatusBadgeAttribute(): string
    {
        return match($this->approval_status) {
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'warning',
        };
    }

    public function getQrCodeDataAttribute(): string
    {
        return json_encode([
            'invitation_code' => $this->invitation_code,
            'event_id' => $this->event_id,
            'user_id' => $this->user_id,
            'event_title' => $this->event?->title,
            'user_name' => $this->user?->full_name,
            'event_date' => $this->event?->event_date?->format('Y-m-d'),
        ]);
    }
}
