@extends('layouts.site')

@section('content')
    <div class="page-head">
        <span class="section-label">// {{ $slug }}</span>
        <h1>{{ $service['title'] }}</h1>
        <p>{{ $service['intro'] }}</p>
    </div>

    <div class="card" style="max-width:720px;">
        <h2 style="margin:0 0 1rem;font-size:1.1rem;">What we deliver</h2>
        <ul style="margin:0;padding:0;list-style:none;display:grid;gap:0.65rem;">
            @foreach ($service['features'] as $feature)
                <li style="display:flex;align-items:flex-start;gap:0.6rem;color:var(--muted);font-size:0.95rem;">
                    <span style="color:var(--accent);font-weight:700;flex-shrink:0;">&rarr;</span>
                    {{ $feature }}
                </li>
            @endforeach
        </ul>
    </div>

    <div style="margin-top:2rem;display:flex;flex-wrap:wrap;gap:0.75rem;">
        <a href="{{ route('book') }}" class="button button-primary">Book a consultation</a>
        <a href="{{ route('home') }}#services" class="button button-ghost">All services</a>
    </div>
@endsection
