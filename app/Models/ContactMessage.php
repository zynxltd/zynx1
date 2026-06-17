<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\RateLimiter;

class ContactMessage extends Model
{
    public const MAX_SUBMISSIONS_PER_IP = 3;

    public const RATE_LIMIT_DECAY_SECONDS = 86400;

    protected $fillable = [
        'name',
        'email',
        'company',
        'message',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'accept_language',
        'referer',
        'client_metadata',
    ];

    protected function casts(): array
    {
        return [
            'client_metadata' => 'array',
        ];
    }

    public static function ipIsBlocked(?string $ip): bool
    {
        if (blank($ip)) {
            return false;
        }

        if (RateLimiter::tooManyAttempts(self::rateLimitKey($ip), self::MAX_SUBMISSIONS_PER_IP)) {
            return true;
        }

        return static::query()
            ->where('ip_address', $ip)
            ->count() >= self::MAX_SUBMISSIONS_PER_IP;
    }

    public static function recordSubmission(?string $ip): void
    {
        if (blank($ip)) {
            return;
        }

        RateLimiter::hit(self::rateLimitKey($ip), self::RATE_LIMIT_DECAY_SECONDS);
    }

    private static function rateLimitKey(string $ip): string
    {
        return 'contact-form:'.$ip;
    }
}
