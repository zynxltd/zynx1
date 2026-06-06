@php
    $href = $href ?? route('home');
    $asLink = $asLink ?? true;
    $compact = $compact ?? false;
@endphp

@if ($asLink)
    <a href="{{ $href }}" class="brand @if($compact) brand-compact @endif" aria-label="zynx1 home">
@else
    <span class="brand @if($compact) brand-compact @endif">
@endif
        <span class="brand-word">zynx</span><span class="brand-one">1</span>
@if ($asLink)
    </a>
@else
    </span>
@endif
