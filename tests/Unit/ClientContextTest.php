<?php

namespace Tests\Unit;

use App\Support\ClientContext;
use Illuminate\Http\Request;
use Tests\TestCase;

class ClientContextTest extends TestCase
{
    public function test_it_collects_client_identifying_information(): void
    {
        $request = Request::create('/contact', 'POST', [], [], [], [
            'REMOTE_ADDR' => '10.0.0.1',
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
            'HTTP_ACCEPT_LANGUAGE' => 'en-GB,en;q=0.9',
            'HTTP_REFERER' => 'https://zynx1.co.uk/contact',
            'HTTP_CF_CONNECTING_IP' => '203.0.113.44',
            'HTTP_CF_IPCOUNTRY' => 'GB',
            'HTTP_SEC_CH_UA' => '"Chromium";v="120", "Google Chrome";v="120"',
            'HTTP_SEC_CH_UA_MOBILE' => '?1',
            'HTTP_SEC_CH_UA_PLATFORM' => '"iOS"',
        ]);

        $client = ClientContext::from($request);

        $this->assertSame('203.0.113.44', $client->ipAddress);
        $this->assertSame('mobile', $client->deviceType);
        $this->assertSame('Safari', $client->browser);
        $this->assertSame('iOS', $client->platform);
        $this->assertSame('en-GB,en;q=0.9', $client->acceptLanguage);
        $this->assertSame('https://zynx1.co.uk/contact', $client->referer);
        $this->assertSame('GB', $client->metadata['cf_ipcountry'] ?? null);
    }
}
