<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppNotification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
        'icon',
        'action_url',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    const TYPES = [
        'info' => 'Info',
        'success' => 'Success',
        'warning' => 'Warning',
        'error' => 'Error',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getIconClassAttribute(): string
    {
        return match($this->type) {
            'success' => 'text-emerald-500',
            'warning' => 'text-amber-500',
            'error' => 'text-rose-500',
            default => 'text-primary-500',
        };
    }
}
