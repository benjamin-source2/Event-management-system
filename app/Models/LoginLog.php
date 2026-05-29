<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'browser',
        'device',
        'platform',
        'location',
        'login_time',
        'logout_time',
        'is_successful',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'login_time' => 'datetime',
            'logout_time' => 'datetime',
            'is_successful' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSuccessful($query)
    {
        return $query->where('is_successful', true);
    }

    public function scopeFailed($query)
    {
        return $query->where('is_successful', false);
    }
}
