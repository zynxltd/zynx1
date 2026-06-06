<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact', [
            'title' => 'Contact Us',
            'description' => 'Get in touch with Zynx. Ask a question, tell us about your project, or book a consultation to discuss custom software, data, AI and automation.',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'company' => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $contactMessage = ContactMessage::create($validated);

        try {
            Mail::to(config('booking.notification_email'))
                ->send(new ContactMessageMail($contactMessage));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()
            ->route('contact')
            ->with('success', 'Thanks for your message. We\'ll be in touch shortly.');
    }
}
