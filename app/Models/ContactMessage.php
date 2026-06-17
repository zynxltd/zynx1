<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    public const MAX_SUBMISSIONS_PER_IP = 3;

    protected $fillable = [
        'name',
        'email',
        'company',
        'message',
        'ip_address',
    ];

    public static function ipIsBlocked(?string $ip): bool
    {
        if (blank($ip)) {
            return false;
        }

        return static::query()
            ->where('ip_address', $ip)
            ->count() >= self::MAX_SUBMISSIONS_PER_IP;
    }
}
