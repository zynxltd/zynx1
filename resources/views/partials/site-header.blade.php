@php
    $onHome = request()->routeIs('home');
    $homeUrl = route('home');
@endphp

<header class="site-header">
    <div class="container site-header-inner">
        @include('partials.brand', ['href' => $homeUrl])

        <nav class="nav nav-desktop" aria-label="Main">
            <a href="{{ $homeUrl }}" @class(['active' => $onHome])>Home</a>
            <a href="{{ route('contact') }}" @class(['active' => request()->routeIs('contact')])>Contact</a>
        </nav>

        <div class="header-actions">
            @include('partials.theme-toggle')
            <a href="{{ route('book') }}" class="button button-primary header-cta">
                <span class="cta-long">Book consultation</span>
                <span class="cta-short">Book</span>
            </a>
            <button type="button" class="nav-toggle" id="nav-toggle" aria-expanded="false" aria-controls="mobile-nav" aria-label="Open menu">
                <span class="nav-toggle-bar"></span>
                <span class="nav-toggle-bar"></span>
                <span class="nav-toggle-bar"></span>
            </button>
        </div>
    </div>

    <nav class="nav-mobile" id="mobile-nav" aria-label="Mobile" hidden>
        <div class="container nav-mobile-inner">
            <a href="{{ $homeUrl }}" class="nav-mobile-link" @if($onHome) aria-current="page" @endif>Home</a>
            <a href="{{ route('contact') }}" class="nav-mobile-link" @if(request()->routeIs('contact')) aria-current="page" @endif>Contact</a>
            <a href="{{ route('book') }}" class="button button-primary nav-mobile-cta">Book consultation</a>
        </div>
    </nav>
</header>
