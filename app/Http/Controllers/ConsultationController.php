<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsultationRequest;
use App\Mail\ConsultationBookedMail;
use App\Models\Consultation;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ConsultationController extends Controller
{
    public function create(): View
    {
        return view('book', [
            'title' => 'Book a Consultation',
            'description' => 'Schedule a free consultation with Zynx. Pick a date and time that works for you — we\'ll discuss software, data, AI and automation for your business.',
        ]);
    }

    public function slots(Request $request, BookingService $booking): JsonResponse
    {
        $request->validate(['date' => ['required', 'date']]);

        $date = Carbon::parse($request->date, config('booking.timezone'));

        return response()->json([
            'date' => $date->toDateString(),
            'bookable' => $booking->isBookableDay($date),
            'slots' => $booking->availableSlots($date),
        ]);
    }

    public function store(StoreConsultationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $consultation = Consultation::create([
            ...$validated,
            'scheduled_at' => Carbon::parse($validated['scheduled_at'])->timezone(config('booking.timezone')),
            'duration_minutes' => config('booking.slot_minutes'),
            'status' => 'pending',
        ]);

        try {
            Mail::to(config('booking.notification_email'))
                ->send(new ConsultationBookedMail($consultation));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()
            ->route('book.confirm', $consultation)
            ->with('success', 'Your consultation has been booked.');
    }

    public function confirm(Consultation $consultation): View
    {
        return view('book-confirm', [
            'title' => 'Consultation Confirmed',
            'description' => 'Your consultation with Zynx has been booked successfully.',
            'consultation' => $consultation,
        ]);
    }
}
