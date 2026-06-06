@php
    $onHome = request()->routeIs('home');
    $homeUrl = route('home');
    $servicesOverview = $onHome ? '#services' : $homeUrl . '#services';
@endphp

<header class="site-header">
    <div class="container site-header-inner">
        @include('partials.brand', ['href' => $homeUrl])

        <nav class="nav nav-desktop" aria-label="Main">
            <a href="{{ $homeUrl }}" @class(['active' => $onHome])>Home</a>
            <a href="{{ $onHome ? '#why' : $homeUrl . '#why' }}">Why Zynx</a>
            @include('partials.nav-services', ['servicesOverview' => $servicesOverview])
            <a href="{{ $onHome ? '#process' : $homeUrl . '#process' }}">How we work</a>
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
            <a href="{{ $onHome ? '#why' : $homeUrl . '#why' }}" class="nav-mobile-link">Why Zynx</a>

            <div class="nav-mobile-group">
                <button type="button" class="nav-mobile-expand" aria-expanded="false">
                    Services
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <div class="nav-mobile-sub" hidden>
                    <a href="{{ $servicesOverview }}" class="nav-mobile-sublink">All services</a>
                    @foreach (config('zynx-services') as $slug => $service)
                        <a href="{{ route('services.show', $slug) }}" class="nav-mobile-sublink @if(request()->routeIs('services.show') && request()->route('service') === $slug) active @endif">{{ $service['label'] }}</a>
                    @endforeach
                </div>
            </div>

            <a href="{{ $onHome ? '#process' : $homeUrl . '#process' }}" class="nav-mobile-link">How we work</a>
            <a href="{{ route('contact') }}" class="nav-mobile-link" @if(request()->routeIs('contact')) aria-current="page" @endif>Contact</a>
            <a href="{{ route('book') }}" class="button button-primary nav-mobile-cta">Book consultation</a>
        </div>
    </nav>
</header>
