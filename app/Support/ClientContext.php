<?php

namespace App\Support;

use Illuminate\Http\Request;

class ClientContext
{
    public function __construct(
        public readonly ?string $ipAddress,
        public readonly ?string $userAgent,
        public readonly ?string $deviceType,
        public readonly ?string $browser,
        public readonly ?string $platform,
        public readonly ?string $acceptLanguage,
        public readonly ?string $referer,
        public readonly array $metadata,
    ) {}

    public static function from(Request $request): self
    {
        $userAgent = $request->userAgent();

        return new self(
            ipAddress: ClientIp::from($request),
            userAgent: $userAgent,
            deviceType: self::detectDeviceType($userAgent),
            browser: self::detectBrowser($userAgent),
            platform: self::detectPlatform($userAgent),
            acceptLanguage: $request->header('Accept-Language'),
            referer: $request->headers->get('referer'),
            metadata: self::collectMetadata($request),
        );
    }

    public function toStorageArray(): array
    {
        return [
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
            'device_type' => $this->deviceType,
            'browser' => $this->browser,
            'platform' => $this->platform,
            'accept_language' => $this->acceptLanguage,
            'referer' => $this->referer,
            'client_metadata' => $this->metadata,
        ];
    }

    public function toLogContext(): array
    {
        return array_filter([
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
            'device_type' => $this->deviceType,
            'browser' => $this->browser,
            'platform' => $this->platform,
            'accept_language' => $this->acceptLanguage,
            'referer' => $this->referer,
            'client_metadata' => $this->metadata,
        ], fn ($value) => filled($value));
    }

    private static function collectMetadata(Request $request): array
    {
        $metadata = array_filter([
            'host' => $request->getHost(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'remote_addr' => $request->server('REMOTE_ADDR'),
            'x_forwarded_for' => $request->header('X-Forwarded-For'),
            'x_real_ip' => $request->header('X-Real-IP'),
            'cf_connecting_ip' => $request->header('CF-Connecting-IP'),
            'cf_ipcountry' => $request->header('CF-IPCountry'),
            'sec_ch_ua' => $request->header('Sec-CH-UA'),
            'sec_ch_ua_mobile' => $request->header('Sec-CH-UA-Mobile'),
            'sec_ch_ua_platform' => $request->header('Sec-CH-UA-Platform'),
            'accept' => $request->header('Accept'),
            'accept_encoding' => $request->header('Accept-Encoding'),
            'connection' => $request->header('Connection'),
            'dnt' => $request->header('DNT'),
        ], fn ($value) => filled($value));

        return $metadata;
    }

    private static function detectDeviceType(?string $userAgent): ?string
    {
        if (blank($userAgent)) {
            return null;
        }

        if (preg_match('/iPad|Tablet|Kindle|PlayBook/i', $userAgent)) {
            return 'tablet';
        }

        if (preg_match('/Mobile|Android|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent)) {
            return 'mobile';
        }

        return 'desktop';
    }

    private static function detectBrowser(?string $userAgent): ?string
    {
        if (blank($userAgent)) {
            return null;
        }

        $browsers = [
            'Edg' => 'Edge',
            'OPR' => 'Opera',
            'Chrome' => 'Chrome',
            'Firefox' => 'Firefox',
            'Safari' => 'Safari',
            'MSIE' => 'Internet Explorer',
            'Trident' => 'Internet Explorer',
        ];

        foreach ($browsers as $needle => $name) {
            if (str_contains($userAgent, $needle)) {
                return $name;
            }
        }

        return 'Unknown';
    }

    private static function detectPlatform(?string $userAgent): ?string
    {
        if (blank($userAgent)) {
            return null;
        }

        $platforms = [
            'iPhone' => 'iOS',
            'iPad' => 'iPadOS',
            'Android' => 'Android',
            'Windows' => 'Windows',
            'Macintosh' => 'macOS',
            'Mac OS X' => 'macOS',
            'Linux' => 'Linux',
            'CrOS' => 'ChromeOS',
        ];

        foreach ($platforms as $needle => $name) {
            if (str_contains($userAgent, $needle)) {
                return $name;
            }
        }

        return 'Unknown';
    }
}
