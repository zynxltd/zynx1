@extends('layouts.site')

@section('content')
    <div class="confirm-card card">
        <div class="confirm-icon" aria-hidden="true">&#10003;</div>
        <span class="section-label">// confirmed</span>
        <h1>You're booked in</h1>
        <p style="color:var(--muted);margin:0 0 1rem;">Thanks, {{ $consultation->name }}. We've received your consultation request and will send a confirmation to <strong>{{ $consultation->email }}</strong>.</p>

        <dl class="confirm-detail">
            <dt>Date & time</dt>
            <dd>{{ $consultation->scheduled_at->timezone(config('booking.timezone'))->format('l j F Y, g:i A') }} (UK)</dd>
            <dt>Duration</dt>
            <dd>{{ $consultation->duration_minutes }} minutes</dd>
            @if ($consultation->company)
                <dt>Company</dt>
                <dd>{{ $consultation->company }}</dd>
            @endif
            @if ($consultation->message)
                <dt>Notes</dt>
                <dd>{{ $consultation->message }}</dd>
            @endif
        </dl>

        <a href="{{ route('home') }}" class="button button-ghost">Back to home</a>
    </div>
@endsection
