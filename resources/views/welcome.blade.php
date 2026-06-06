@extends('layouts.site')

@php
    $title = 'Software, Marketing, Lead Generation & CRO';
    $description = 'Software, lead generation, marketing and conversion rate optimisation for growing businesses — one partner from build to growth.';
    $heroItems = [
        ['word' => 'Software', 'verb' => 'We build'],
        ['word' => 'Lead Generation', 'verb' => 'We generate'],
        ['word' => 'Marketing', 'verb' => 'We grow'],
        ['word' => 'CRO', 'verb' => 'We optimise'],
    ];
@endphp

@section('full-width')
    <section class="home-hero">
        <div class="hero-media" aria-hidden="true">
            <video class="hero-video" autoplay muted loop playsinline preload="auto" poster="">
                <source src="{{ asset('videos/hero-bg.mp4') }}" type="video/mp4" />
            </video>
            <canvas class="hero-video-canvas" id="hero-video-canvas"></canvas>
            <div class="hero-media-overlay"></div>
        </div>

        <div class="container home-hero-layout">
            <div class="home-hero-intro">
                <p class="home-hero-eyebrow">
                    <span class="home-hero-dot" aria-hidden="true"></span>
                    <span class="home-hero-eyebrow-text" id="hero-eyebrow">zynx1 / software</span>
                </p>

                <h1 class="home-hero-title">
                    <span class="hero-prefix" id="hero-prefix">{{ $heroItems[0]['verb'] }}</span>
                    <span class="hero-scroll" aria-hidden="true">
                        <span class="hero-scroll-glow"></span>
                        <span class="hero-scroll-inner" id="hero-scroll-inner">
                            @foreach ($heroItems as $item)
                                <span class="hero-scroll-word">{{ $item['word'] }}</span>
                            @endforeach
                        </span>
                        <span class="hero-scroll-cursor" aria-hidden="true"></span>
                    </span>
                    <span class="sr-only" aria-live="polite" id="hero-scroll-live">{{ $heroItems[0]['verb'] }} {{ $heroItems[0]['word'] }}</span>
                    <span class="home-hero-tagline" id="hero-tagline">Apps, platforms & digital marketing under one roof</span>
                </h1>
            </div>

            <div class="hero-visual" id="hero-visual">
                {{-- Software (+ digital marketing services) --}}
                <div class="hero-visual-panel is-active" data-index="0" data-verb="We build" data-eyebrow="zynx1 / software" data-tagline="Apps, platforms & digital marketing under one roof">
                    <div class="hero-panel-window hero-panel-software">
                        <div class="hero-panel-bar">
                            <span></span><span></span><span></span>
                            <span class="hero-panel-tab">services</span>
                        </div>
                        <div class="hero-panel-body">
                            <div class="hero-service-group">
                                <h3 class="hero-service-heading">Software</h3>
                                <ul class="hero-service-list">
                                    <li>Web apps & platforms</li>
                                    <li>APIs & integrations</li>
                                    <li>Automation & workflows</li>
                                    <li>Data & AI tooling</li>
                                </ul>
                            </div>
                            <div class="hero-service-group hero-service-group--nested">
                                <h3 class="hero-service-heading">Digital marketing</h3>
                                <ul class="hero-service-list">
                                    <li>SEO & content</li>
                                    <li>PPC & paid social</li>
                                    <li>Analytics & reporting</li>
                                    <li>Landing pages</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Lead Generation --}}
                <div class="hero-visual-panel" data-index="1" data-verb="We generate" data-eyebrow="zynx1 / leads" data-tagline="Funnels, ads & qualified pipeline">
                    <div class="hero-panel-window hero-panel-leads">
                        <div class="hero-panel-bar">
                            <span></span><span></span><span></span>
                            <span class="hero-panel-tab">Lead funnel</span>
                        </div>
                        <div class="hero-panel-body">
                            <div class="hero-funnel">
                                <div class="hero-funnel-step">
                                    <span>Visitors</span>
                                    <strong>8,420</strong>
                                </div>
                                <div class="hero-funnel-step">
                                    <span>Leads</span>
                                    <strong>1,240</strong>
                                </div>
                                <div class="hero-funnel-step hero-funnel-step--hot">
                                    <span>Qualified</span>
                                    <strong>386</strong>
                                </div>
                            </div>
                            <div class="hero-lead-sources">
                                <span>Landing pages</span>
                                <span>Paid ads</span>
                                <span>Forms</span>
                                <span>Outbound</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Marketing --}}
                <div class="hero-visual-panel" data-index="2" data-verb="We grow" data-eyebrow="zynx1 / marketing" data-tagline="Brand, campaigns & content that converts">
                    <div class="hero-panel-window hero-panel-marketing">
                        <div class="hero-panel-bar">
                            <span></span><span></span><span></span>
                            <span class="hero-panel-tab">Campaign Q2</span>
                        </div>
                        <div class="hero-panel-body">
                            <div class="hero-metric-row">
                                <span class="hero-metric-label">Reach</span>
                                <span class="hero-metric-val">124k</span>
                                <span class="hero-metric-up">+38%</span>
                            </div>
                            <div class="hero-metric-row">
                                <span class="hero-metric-label">Engagement</span>
                                <span class="hero-metric-val">6.2%</span>
                                <span class="hero-metric-up">+12%</span>
                            </div>
                            <div class="hero-channel-tags">
                                <span>Social</span>
                                <span>Email</span>
                                <span>Content</span>
                                <span>Brand</span>
                            </div>
                            <p class="hero-panel-copy">Campaigns and messaging that reach the right audience.</p>
                        </div>
                    </div>
                </div>

                {{-- CRO --}}
                <div class="hero-visual-panel" data-index="3" data-verb="We optimise" data-eyebrow="zynx1 / cro" data-tagline="Test, optimise & lift conversion rates">
                    <div class="hero-panel-window hero-panel-cro">
                        <div class="hero-panel-bar">
                            <span></span><span></span><span></span>
                            <span class="hero-panel-tab">A/B tests</span>
                        </div>
                        <div class="hero-panel-body">
                            <div class="hero-cro-highlight">
                                <span class="hero-cro-label">Conversion rate</span>
                                <span class="hero-cro-val">4.8%</span>
                                <span class="hero-metric-up">+34%</span>
                            </div>
                            <div class="hero-cro-tests">
                                <div class="hero-cro-test hero-cro-test--win">
                                    <span>Hero CTA variant B</span>
                                    <strong>+22%</strong>
                                </div>
                                <div class="hero-cro-test hero-cro-test--win">
                                    <span>Checkout flow</span>
                                    <strong>+18%</strong>
                                </div>
                                <div class="hero-cro-test">
                                    <span>Form fields</span>
                                    <strong>Running</strong>
                                </div>
                            </div>
                            <div class="hero-channel-tags">
                                <span>A/B testing</span>
                                <span>UX audits</span>
                                <span>Funnel fixes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="home-hero-cta">
                <p class="home-hero-lead">
                    Software, lead generation, marketing and CRO — tailored to your business,
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
