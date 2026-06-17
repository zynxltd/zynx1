<x-mail::message>
# New contact message

Someone submitted the contact form on zynx1.

**Name:** {{ $contactMessage->name }}

**Email:** {{ $contactMessage->email }}

@if ($contactMessage->company)
**Company:** {{ $contactMessage->company }}
@endif

**Message:**

{{ $contactMessage->message }}

@if ($contactMessage->ip_address)
**IP address:** {{ $contactMessage->ip_address }}
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
