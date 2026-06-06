<?php

namespace App\Mail;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultationBookedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Consultation $consultation) {}

    public function envelope(): Envelope
    {
        $when = $this->consultation->scheduled_at
            ->timezone(config('booking.timezone'))
            ->format('j M Y, g:i A');

        return new Envelope(
            subject: "New consultation booking — {$this->consultation->name} ({$when})",
            replyTo: [
                new Address($this->consultation->email, $this->consultation->name),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.consultation-booked',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
