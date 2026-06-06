@extends('layouts.site')

@php
    $title = 'Software, Marketing, Lead Generation & Conversion Rate Optimisation';
    $description = 'Software, lead generation, marketing and conversion rate optimisation for growing businesses — one partner from build to growth.';
    $heroItems = [
        ['word' => 'Software', 'verb' => 'We build', 'eyebrow' => 'zynx1 / software', 'tagline' => 'Apps, platforms & digital marketing under one roof'],
        ['word' => 'Lead Generation', 'verb' => 'We generate', 'eyebrow' => 'zynx1 / leads', 'tagline' => 'Funnels, ads & qualified pipeline'],
        ['word' => 'Marketing', 'verb' => 'We grow', 'eyebrow' => 'zynx1 / marketing', 'tagline' => 'Brand, campaigns & content that converts'],
        ['word' => 'Conversion Rate Optimisation', 'verb' => 'We optimise', 'eyebrow' => 'zynx1 / conversion rate optimisation', 'tagline' => 'Test, optimise & lift conversion rates'],
    ];
@endphp

@section('full-width')
    <section class="home-hero is-entered">
        @include('partials.hero-media', [
            'videos' => [
                asset('videos/hero-bg-1.mp4'),
                asset('videos/hero-bg-2.mp4'),
                asset('videos/hero-bg-3.mp4'),
                asset('videos/hero-bg-4.mp4'),
            ],
            'rotate' => true,
            'rotateInterval' => 5000,
        ])

        <div class="home-hero-spotlight" aria-hidden="true"></div>

        <div class="container home-hero-layout">
            <div class="home-hero-intro">
                <p class="home-hero-eyebrow">
                    <span class="home-hero-dot" aria-hidden="true"></span>
                    <span class="home-hero-eyebrow-text" id="hero-eyebrow">{{ $heroItems[0]['eyebrow'] }}</span>
                </p>

                <h1 class="home-hero-title">
                    <span class="hero-prefix" id="hero-prefix">{{ $heroItems[0]['verb'] }}</span>
                    <span
                        class="hero-scroll"
                        id="hero-scroll"
                        aria-hidden="true"
                        data-slides='@json($heroItems)'
                    >
                        <span class="hero-scroll-viewport">
                            <span class="hero-scroll-inner" id="hero-scroll-inner">
                                @foreach ($heroItems as $item)
                                    <span class="hero-scroll-word">{{ $item['word'] }}</span>
                                @endforeach
                            </span>
                        </span>
                    </span>
                    <span class="sr-only" aria-live="polite" id="hero-scroll-live">{{ $heroItems[0]['verb'] }} {{ $heroItems[0]['word'] }}</span>
                    <span class="home-hero-tagline" id="hero-tagline">{{ $heroItems[0]['tagline'] }}</span>
                </h1>
            </div>

            <div class="home-hero-cta">
                <p class="home-hero-lead">
                    Software, lead generation, marketing and conversion rate optimisation — tailored to your business,
                    focused on measurable outcomes.
                </p>

                <div class="home-hero-actions">
                    <a class="button button-primary" href="{{ route('book') }}">Book a consultation</a>
                    <a class="button button-ghost" href="{{ route('contact') }}">Get in touch</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/hero-video.js') }}" defer></script>
    <script src="{{ asset('js/hero-scroll.js') }}" defer></script>
@endpush
