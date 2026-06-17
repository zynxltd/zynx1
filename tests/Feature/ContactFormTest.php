<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
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

    private function submitContact(array $payload = [])
    {
        return $this->withSession([
            'contact_form_loaded_at' => now()->subSeconds(5),
        ])->post('/contact', $payload ?: $this->validPayload());
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

        $this->withSession([
            'contact_form_loaded_at' => now()->subSeconds(5),
        ])->post('/contact', [
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
        }

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])
            ->get('/contact')
            ->assertOk()
            ->assertSee('maximum number of contact form submissions')
            ->assertDontSee('Send message');

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])
            ->post('/contact', $this->validPayload())
            ->assertRedirect(route('contact'))
            ->assertSessionHas('blocked');

        $this->assertDatabaseCount('contact_messages', 3);
    }

    public function test_submission_requires_valid_fields(): void
    {
        $this->withSession([
            'contact_form_loaded_at' => now()->subSeconds(5),
        ])->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'message' => '',
        ])
            ->assertSessionHasErrors(['name', 'email', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }
}
