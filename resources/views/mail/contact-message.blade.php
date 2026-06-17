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

@if ($contactMessage->device_type || $contactMessage->browser || $contactMessage->platform)
**Device:** {{ collect([$contactMessage->device_type, $contactMessage->browser, $contactMessage->platform])->filter()->implode(' · ') }}
@endif

@if ($contactMessage->accept_language)
**Language:** {{ $contactMessage->accept_language }}
@endif

@if ($contactMessage->referer)
**Referer:** {{ $contactMessage->referer }}
@endif

@if ($contactMessage->user_agent)
**User agent:** {{ $contactMessage->user_agent }}
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
