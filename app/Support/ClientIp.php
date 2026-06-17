<?php

namespace App\Support;

use Illuminate\Http\Request;

class ClientIp
{
    public static function from(Request $request): ?string
    {
        foreach (['CF-Connecting-IP', 'X-Real-IP', 'X-Forwarded-For'] as $header) {
            $value = $request->header($header);

            if (filled($value)) {
                return trim(explode(',', $value)[0]);
            }
        }

        $ip = $request->ip();

        return filled($ip) ? $ip : null;
    }
}
