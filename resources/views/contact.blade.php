@extends('layouts.site')

@section('content')
    <div class="page-head">
        <span class="section-label">// contact</span>
        <h1>Get in touch</h1>
        <p>Have a question or want to tell us about a project? Send a message and we'll get back to you. Prefer to talk? <a href="{{ route('book') }}" style="color:var(--accent);">Book a consultation</a> instead.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <div class="contact-layout">
        <div class="card">
            <h2 style="margin:0 0 1rem;font-size:1.1rem;">Contact details</h2>
            <p style="margin:0 0 0.75rem;color:var(--muted);font-size:0.92rem;">
                <strong style="color:var(--text);display:block;margin-bottom:0.2rem;">Email</strong>
                <a href="mailto:hello@zynx1.co.uk" style="color:var(--accent);">hello@zynx1.co.uk</a>
            </p>
            <p style="margin:0;color:var(--muted);font-size:0.92rem;">
                <strong style="color:var(--text);display:block;margin-bottom:0.2rem;">Consultations</strong>
                Free 30-minute calls — Mon–Fri, 9am–5pm UK.
                <br />
                <a href="{{ route('book') }}" style="color:var(--accent);">Book online &rarr;</a>
            </p>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('contact.store') }}" class="form-grid">
                @csrf
                <div class="field">
                    <label for="name">Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" />
                    @error('name')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" />
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label for="company">Company</label>
                    <input type="text" id="company" name="company" value="{{ old('company') }}" autocomplete="organization" />
                </div>
                <div class="field">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                    @error('message')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="button button-primary">Send message</button>
            </form>
        </div>
    </div>
@endsection

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ContactPage',
    'name' => 'Contact Zynx',
    'url' => route('contact'),
    'mainEntity' => [
        '@type' => 'Organization',
        'name' => 'Zynx',
        'email' => 'hello@zynx1.co.uk',
        'url' => config('app.url'),
    ],
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush
