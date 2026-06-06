<?php

namespace App\Services;

use App\Models\Consultation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BookingService
{
    public function availableSlots(Carbon $date): array
    {
        $timezone = config('booking.timezone');
        $date = $date->copy()->timezone($timezone)->startOfDay();

        if (! $this->isBookableDay($date)) {
            return [];
        }

        $now = Carbon::now($timezone);
        $slotMinutes = (int) config('booking.slot_minutes');
        $startHour = (int) config('booking.start_hour');
        $endHour = (int) config('booking.end_hour');

        $dayStart = $date->copy()->setTime($startHour, 0);
        $dayEnd = $date->copy()->setTime($endHour, 0);

        $booked = Consultation::query()
            ->whereDate('scheduled_at', $date->toDateString())
            ->where('status', '!=', 'cancelled')
            ->pluck('scheduled_at')
            ->map(fn ($dt) => Carbon::parse($dt)->timezone($timezone)->format('H:i'))
            ->all();

        $slots = [];

        foreach (CarbonPeriod::create($dayStart, "{$slotMinutes} minutes", $dayEnd->copy()->subMinutes($slotMinutes)) as $slot) {
            $slot = $slot->copy()->timezone($timezone);

            if ($slot->lessThanOrEqualTo($now)) {
                continue;
            }

            $time = $slot->format('H:i');

            if (in_array($time, $booked, true)) {
                continue;
            }

            $slots[] = [
                'time' => $time,
                'label' => $slot->format('g:i A'),
                'datetime' => $slot->toIso8601String(),
            ];
        }

        return $slots;
    }

    public function isBookableDay(Carbon $date): bool
    {
        $timezone = config('booking.timezone');
        $date = $date->copy()->timezone($timezone)->startOfDay();
        $now = Carbon::now($timezone)->startOfDay();
        $max = $now->copy()->addDays((int) config('booking.advance_days'));

        if ($date->lessThan($now) || $date->greaterThan($max)) {
            return false;
        }

        return in_array((int) $date->dayOfWeekIso, config('booking.working_days'), true);
    }

    public function slotIsAvailable(string $datetime): bool
    {
        $timezone = config('booking.timezone');
        $slot = Carbon::parse($datetime)->timezone($timezone);

        if (! $this->isBookableDay($slot)) {
            return false;
        }

        $available = collect($this->availableSlots($slot->copy()->startOfDay()))
            ->pluck('datetime')
            ->contains($slot->toIso8601String());

        return $available;
    }
}
