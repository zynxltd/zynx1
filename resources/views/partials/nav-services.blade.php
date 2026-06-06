@php
    $services = config('zynx-services');
    $servicesOverview = $servicesOverview ?? route('home') . '#services';
    $isServicePage = request()->routeIs('services.show');
    $currentSlug = request()->route('service');
@endphp

<div class="nav-dropdown">
    <button type="button" class="nav-dropdown-toggle" aria-expanded="false" aria-haspopup="true">
        Services
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
    </button>
    <div class="nav-dropdown-menu" role="menu">
        <a href="{{ $servicesOverview }}" class="nav-dropdown-link" role="menuitem">All services</a>
        @foreach ($services as $slug => $service)
            <a href="{{ route('services.show', $slug) }}" class="nav-dropdown-link @if($isServicePage && $currentSlug === $slug) active @endif" role="menuitem">{{ $service['label'] }}</a>
        @endforeach
    </div>
</div>
