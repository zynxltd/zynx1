<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Support\ClientContext;
use App\Support\ContactFormLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(Request $request): View
    {
        session(['contact_form_loaded_at' => now()]);

        $client = ClientContext::from($request);
        $ipBlocked = ContactMessage::ipIsBlocked($client->ipAddress);

        return view('contact', [
            'title' => 'Contact Us',
            'description' => 'Get in touch with Zynx. Ask a question, tell us about your project, or book a consultation to discuss custom software, data, AI and automation.',
            'ipBlocked' => $ipBlocked,
            'turnstileSiteKey' => config('services.turnstile.site_key'),
        ]);
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $client = ClientContext::from($request);
        $clientContext = $client->toLogContext();

        if (ContactMessage::ipIsBlocked($client->ipAddress)) {
            ContactFormLogger::blocked($request->input('email'), $clientContext);

            return redirect()
                ->route('contact')
                ->with('blocked', true);
        }

        if ($request->isSpam()) {
            ContactFormLogger::spamRejected(
                $request->input('email'),
                filled($request->input('website')),
                $clientContext,
            );

            return redirect()
                ->route('contact')
                ->with('success', 'Thanks for your message. We\'ll be in touch shortly.');
        }

        $contactMessage = ContactMessage::create([
            ...$request->safe()->only(['name', 'email', 'company', 'message']),
            ...$client->toStorageArray(),
        ]);

        ContactMessage::recordSubmission($client->ipAddress);

        ContactFormLogger::received(
            $contactMessage->id,
            $request->safe()->only(['name', 'email', 'company']),
            $clientContext,
        );

        try {
            Mail::to(config('booking.notification_email'))
                ->send(new ContactMessageMail($contactMessage));
        } catch (\Throwable $e) {
            report($e);
        }

        session()->forget('contact_form_loaded_at');

        return redirect()
            ->route('contact')
            ->with('success', 'Thanks for your message. We\'ll be in touch shortly.');
    }
}
