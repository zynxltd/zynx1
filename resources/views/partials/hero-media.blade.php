@php
    $videos = $videos ?? [asset('videos/hero-bg-1.mp4')];
    $rotate = ($rotate ?? false) && count($videos) > 1;
@endphp

<div
    class="hero-media{{ $rotate ? ' hero-media--rotate' : '' }}"
    aria-hidden="true"
    @if ($rotate)
        data-hero-rotate="{{ $rotateInterval ?? 6000 }}"
        data-hero-videos='@json($videos)'
        data-hero-tone="0"
    @endif
>
    @if ($rotate)
        <div class="hero-video-stack">
            <div class="hero-video-layer" data-layer="a">
                <video class="hero-video" muted playsinline preload="auto"></video>
            </div>
            <div class="hero-video-layer" data-layer="b">
                <video class="hero-video" muted playsinline preload="auto"></video>
            </div>
        </div>
        <div class="hero-media-vignette"></div>
        <div class="hero-media-grain"></div>
        <div class="hero-media-progress" aria-hidden="true">
            @foreach ($videos as $i => $video)
                <span class="hero-media-progress-dot{{ $i === 0 ? ' is-active' : '' }}" data-index="{{ $i }}">
                    <span class="hero-media-progress-fill"></span>
                </span>
            @endforeach
        </div>
    @else
        <video class="hero-video" autoplay muted loop playsinline preload="auto">
            <source src="{{ $videos[0] }}" type="video/mp4" />
        </video>
    @endif
    <canvas class="hero-video-canvas" id="hero-video-canvas"></canvas>
    <div class="hero-media-overlay"></div>
</div>
