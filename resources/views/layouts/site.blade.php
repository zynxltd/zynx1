<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @include('partials.seo')
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/site.css') }}" />
    @stack('head')
</head>
<body>
    <div class="ambient" aria-hidden="true">
        <div class="ambient-orb a"></div>
        <div class="ambient-orb b"></div>
        <div class="ambient-grid"></div>
    </div>

    <header class="site-header">
        <div class="container site-header-inner">
            <a href="{{ route('home') }}" class="brand" aria-label="zynx1 home">
                <span class="brand-word">zynx</span><span class="brand-one">1</span>
            </a>
            <nav class="nav" aria-label="Main">
                <a href="{{ route('home') }}#services">Services</a>
                <a href="{{ route('home') }}#process">Process</a>
                <a href="{{ route('contact') }}" @class(['active' => request()->routeIs('contact')])>Contact</a>
            </nav>
            <a href="{{ route('book') }}" class="button button-primary">Book consultation</a>
        </div>
    </header>

    <main class="page">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="site-footer">
        <div class="container" style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
            <span>&copy; {{ date('Y') }} Zynx</span>
            <span>
                <a href="mailto:hello@zynx1.co.uk">hello@zynx1.co.uk</a>
                &middot;
                <a href="{{ route('book') }}">Book consultation</a>
            </span>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
