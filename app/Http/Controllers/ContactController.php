<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Support\ClientIp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(Request $request): View
    {
        session(['contact_form_loaded_at' => now()]);

        $ip = ClientIp::from($request);
        $ipBlocked = ContactMessage::ipIsBlocked($ip);

        return view('contact', [
            'title' => 'Contact Us',
            'description' => 'Get in touch with Zynx. Ask a question, tell us about your project, or book a consultation to discuss custom software, data, AI and automation.',
            'ipBlocked' => $ipBlocked,
            'turnstileSiteKey' => config('services.turnstile.site_key'),
        ]);
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $ip = ClientIp::from($request);

        if (ContactMessage::ipIsBlocked($ip)) {
            return redirect()
                ->route('contact')
                ->with('blocked', true);
        }

        if ($request->isSpam()) {
            return redirect()
                ->route('contact')
                ->with('success', 'Thanks for your message. We\'ll be in touch shortly.');
        }

        $contactMessage = ContactMessage::create([
            ...$request->safe()->only(['name', 'email', 'company', 'message']),
            'ip_address' => $ip,
        ]);

        ContactMessage::recordSubmission($ip);

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
