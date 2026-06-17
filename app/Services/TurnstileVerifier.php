<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TurnstileVerifier
{
    public function isEnabled(): bool
    {
        return filled(config('services.turnstile.secret'));
    }

    public function verify(?string $token, ?string $ip): bool
    {
        if (! $this->isEnabled()) {
            return true;
        }

        if (blank($token)) {
            return false;
        }

        $response = Http::asForm()
            ->timeout(5)
            ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => config('services.turnstile.secret'),
                'response' => $token,
                'remoteip' => $ip,
            ]);

        if (! $response->successful()) {
            return false;
        }

        return $response->json('success') === true;
    }
}
