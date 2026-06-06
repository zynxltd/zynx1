<x-mail::message>
# New consultation booking

Someone has booked a consultation on zynx1.

**Date & time:** {{ $consultation->scheduled_at->timezone(config('booking.timezone'))->format('l j F Y, g:i A') }} (UK)

**Duration:** {{ $consultation->duration_minutes }} minutes

**Name:** {{ $consultation->name }}

**Email:** {{ $consultation->email }}

@if ($consultation->company)
**Company:** {{ $consultation->company }}
@endif

@if ($consultation->phone)
**Phone:** {{ $consultation->phone }}
@endif

@if ($consultation->message)
**Message:**

{{ $consultation->message }}
@endif

<x-mail::button :url="route('book.confirm', $consultation)">
View booking
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
