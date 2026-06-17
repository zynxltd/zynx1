<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Services\TurnstileVerifier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(): array
    {
        return [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'company' => 'Acme Ltd',
            'message' => 'I would like to discuss a project.',
        ];
    }

    private function submitContact(array $payload = [], array $server = [])
    {
        $request = $this->withSession([
            'contact_form_loaded_at' => now()->subSeconds(5),
        ]);

        if ($server !== []) {
            $request = $request->withServerVariables($server);
        }

        return $request->post('/contact', $payload ?: $this->validPayload());
    }

    public function test_contact_page_loads(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertSee('Get in touch')
            ->assertSee('Send message');
    }

    public function test_valid_submission_stores_message_with_ip(): void
    {
        Mail::fake();

        $this->submitContact()
            ->assertRedirect(route('contact'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'company' => 'Acme Ltd',
            'message' => 'I would like to discuss a project.',
            'ip_address' => '127.0.0.1',
        ]);
    }

    public function test_honeypot_submission_is_silently_rejected(): void
    {
        Mail::fake();

        $this->submitContact([
            ...$this->validPayload(),
            'website' => 'https://spam.example',
        ])
            ->assertRedirect(route('contact'))
            ->assertSessionHas('success');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_fast_submission_is_silently_rejected(): void
    {
        Mail::fake();

        $this->withSession([
            'contact_form_loaded_at' => now(),
        ])->post('/contact', $this->validPayload())
            ->assertRedirect(route('contact'))
            ->assertSessionHas('success');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_ip_is_blocked_after_three_submissions(): void
    {
        Mail::fake();

        for ($i = 0; $i < 3; $i++) {
            ContactMessage::create([
                'name' => 'Previous User',
                'email' => "user{$i}@example.com",
                'message' => 'Earlier message',
                'ip_address' => '203.0.113.10',
            ]);
            ContactMessage::recordSubmission('203.0.113.10');
        }

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])
            ->get('/contact')
            ->assertOk()
            ->assertSee('maximum number of contact form submissions')
            ->assertDontSee('Send message');

        $this->submitContact(server: ['REMOTE_ADDR' => '203.0.113.10'])
            ->assertRedirect(route('contact'))
            ->assertSessionHas('blocked');

        $this->assertDatabaseCount('contact_messages', 3);
    }

    public function test_cloudflare_client_ip_header_is_used(): void
    {
        Mail::fake();

        $this->submitContact(server: [
            'REMOTE_ADDR' => '10.0.0.1',
            'HTTP_CF_CONNECTING_IP' => '198.51.100.25',
        ])
            ->assertRedirect(route('contact'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'ip_address' => '198.51.100.25',
        ]);
    }

    public function test_submission_requires_valid_fields(): void
    {
        $this->submitContact([
            'name' => '',
            'email' => 'not-an-email',
            'message' => '',
        ])
            ->assertSessionHasErrors(['name', 'email', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_turnstile_is_required_when_enabled(): void
    {
        config([
            'services.turnstile.site_key' => 'test-site-key',
            'services.turnstile.secret' => 'test-secret-key',
        ]);

        $this->submitContact()
            ->assertSessionHasErrors('captcha');
    }

    public function test_turnstile_verifies_token_when_enabled(): void
    {
        config([
            'services.turnstile.site_key' => 'test-site-key',
            'services.turnstile.secret' => 'test-secret-key',
        ]);

        $this->mock(TurnstileVerifier::class, function ($mock) {
            $mock->shouldReceive('isEnabled')->andReturn(true);
            $mock->shouldReceive('verify')->once()->andReturn(true);
        });

        Mail::fake();

        $this->submitContact([
            ...$this->validPayload(),
            'cf-turnstile-response' => 'valid-token',
        ])
            ->assertRedirect(route('contact'))
            ->assertSessionHas('success');
    }

    protected function tearDown(): void
    {
        RateLimiter::clear('contact-form:127.0.0.1');
        RateLimiter::clear('contact-form:203.0.113.10');
        RateLimiter::clear('contact-form:198.51.100.25');

        parent::tearDown();
    }
}
