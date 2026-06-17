<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;

class ContactFormLogger
{
    private const CHANNEL = 'contact';

    public static function received(int $messageId, array $submission, array $client): void
    {
        self::write('received', 'info', [
            'contact_message_id' => $messageId,
            'name' => $submission['name'] ?? null,
            'email' => $submission['email'] ?? null,
            'company' => $submission['company'] ?? null,
            ...$client,
        ]);
    }

    public static function spamRejected(?string $email, bool $honeypot, array $client): void
    {
        self::write('spam_rejected', 'info', [
            'email' => $email,
            'honeypot' => $honeypot,
            ...$client,
        ]);
    }

    public static function blocked(?string $email, array $client): void
    {
        self::write('blocked', 'warning', [
            'email' => $email,
            ...$client,
        ]);
    }

    private static function write(string $event, string $level, array $context): void
    {
        Log::channel(self::CHANNEL)->{$level}("Contact form {$event}", [
            'event' => $event,
            ...array_filter($context, fn ($value) => filled($value)),
        ]);
    }
}
