(function () {
    var media = document.querySelector('.hero-media');
    var video = document.querySelector('.hero-video');
    var canvas = document.getElementById('hero-video-canvas');
    if (!media || !canvas) return;

    var ctx = canvas.getContext('2d');
    var raf = null;
    var start = performance.now();
    var videoReady = false;

    var blobs = [
        { x: 0.25, y: 0.35, r: 0.48, hue: 225, phase: 0 },
        { x: 0.72, y: 0.28, r: 0.42, hue: 270, phase: 1.8 },
        { x: 0.55, y: 0.68, r: 0.5, hue: 155, phase: 3.2 },
        { x: 0.15, y: 0.72, r: 0.36, hue: 210, phase: 4.5 },
    ];

    function mediaSize() {
        return {
            w: media.clientWidth || window.innerWidth,
            h: media.clientHeight || window.innerHeight,
        };
    }

    function resize() {
        var size = mediaSize();
        var dpr = Math.min(window.devicePixelRatio || 1, 2);
        canvas.width = Math.floor(size.w * dpr);
        canvas.height = Math.floor(size.h * dpr);
        canvas.style.width = size.w + 'px';
        canvas.style.height = size.h + 'px';
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    function draw(t) {
        var size = mediaSize();
        var w = size.w;
        var h = size.h;
        var elapsed = (t - start) * 0.001;

        ctx.fillStyle = '#08080f';
        ctx.fillRect(0, 0, w, h);
        ctx.globalCompositeOperation = 'screen';

        blobs.forEach(function (b) {
            var x = (b.x + Math.sin(elapsed * 0.18 + b.phase) * 0.1) * w;
            var y = (b.y + Math.cos(elapsed * 0.14 + b.phase) * 0.08) * h;
            var radius = b.r * Math.min(w, h) * (0.94 + Math.sin(elapsed * 0.22 + b.phase) * 0.07);
            var grad = ctx.createRadialGradient(x, y, 0, x, y, radius);

            grad.addColorStop(0, 'hsla(' + b.hue + ', 80%, 62%, 0.45)');
            grad.addColorStop(0.4, 'hsla(' + b.hue + ', 70%, 48%, 0.2)');
            grad.addColorStop(1, 'hsla(' + b.hue + ', 60%, 30%, 0)');

            ctx.fillStyle = grad;
            ctx.beginPath();
            ctx.arc(x, y, radius, 0, Math.PI * 2);
            ctx.fill();
        });

        ctx.globalCompositeOperation = 'source-over';
    }

    function loop(t) {
        draw(t);
        raf = requestAnimationFrame(loop);
    }

    function startCanvas() {
        media.classList.add('hero-media--canvas');
        canvas.hidden = false;
        resize();
        if (!raf) raf = requestAnimationFrame(loop);
    }

    function stopCanvas() {
        if (raf) {
            cancelAnimationFrame(raf);
            raf = null;
        }
        canvas.hidden = true;
        media.classList.remove('hero-media--canvas');
    }

    function startVideo() {
        if (videoReady) return;
        videoReady = true;
        media.classList.add('hero-media--video');
        video.classList.add('is-ready');
        stopCanvas();
    }

    function initVideo() {
        if (!video) return;

        video.addEventListener('canplay', startVideo);
        video.addEventListener('loadeddata', startVideo);

        video.addEventListener('error', function () {
            if (!videoReady) startCanvas();
        });

        video.load();

        var playAttempt = video.play();
        if (playAttempt && playAttempt.catch) {
            playAttempt.catch(function () {
                if (!videoReady) startCanvas();
            });
        }
    }

    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    resize();

    if (!reducedMotion && video) {
        initVideo();
        window.setTimeout(function () {
            if (!videoReady) startCanvas();
        }, 1500);
    } else {
        startCanvas();
        if (video) video.pause();
        if (reducedMotion) draw(performance.now());
    }

    window.addEventListener('resize', function () {
        if (!videoReady) resize();
    });
})();
