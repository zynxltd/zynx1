@php
    $onHome = request()->routeIs('home');
    $homeUrl = route('home');
@endphp

<header class="site-header">
    <div class="site-header-bar">
        <div class="site-header-shine" aria-hidden="true"></div>
        <div class="site-header-inner">
            @include('partials.brand', ['href' => $homeUrl])

            <nav class="nav nav-desktop nav-pills" aria-label="Main">
                <a href="{{ $homeUrl }}" class="nav-pill @if($onHome) is-active @endif">Home</a>
                <a href="{{ route('contact') }}" class="nav-pill @if(request()->routeIs('contact')) is-active @endif">Contact</a>
            </nav>

            <div class="header-actions">
                @include('partials.theme-toggle')
            <a href="{{ route('contact') }}" class="button button-primary header-cta">
                <span class="header-cta-shine" aria-hidden="true"></span>
                <span class="cta-long">Get in touch</span>
                <span class="cta-short">Contact</span>
            </a>
                <button type="button" class="nav-toggle" id="nav-toggle" aria-expanded="false" aria-controls="mobile-nav" aria-label="Open menu">
                    <span class="nav-toggle-bar"></span>
                    <span class="nav-toggle-bar"></span>
                    <span class="nav-toggle-bar"></span>
                </button>
            </div>
        </div>
    </div>

    <nav class="nav-mobile" id="mobile-nav" aria-label="Mobile" hidden>
        <div class="nav-mobile-panel">
            <div class="container nav-mobile-inner">
                <a href="{{ $homeUrl }}" class="nav-mobile-link" @if($onHome) aria-current="page" @endif>
                    <span>Home</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                </a>
                <a href="{{ route('contact') }}" class="nav-mobile-link" @if(request()->routeIs('contact')) aria-current="page" @endif>
                    <span>Contact</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                </a>
                <a href="{{ route('contact') }}" class="button button-primary nav-mobile-cta">Get in touch</a>
            </div>
        </div>
    </nav>
</header>
