(function () {
    var interval = 4000;
    var transitionMs = 450;

    var live = document.getElementById('hero-scroll-live');
    var prefix = document.getElementById('hero-prefix');
    var eyebrow = document.getElementById('hero-eyebrow');
    var tagline = document.getElementById('hero-tagline');
    var scroll = document.getElementById('hero-scroll');
    var scrollInner = document.getElementById('hero-scroll-inner');
    var scrollWords = scroll ? scroll.querySelectorAll('.hero-scroll-word') : [];

    if (!live || !scroll || !scrollInner || !scrollWords.length) return;

    var slides = [];
    try {
        slides = JSON.parse(scroll.getAttribute('data-slides') || '[]');
    } catch (e) {
        slides = [];
    }

    if (!slides.length) return;

    var words = Array.from(scrollWords).map(function (el) { return el.textContent.trim(); });
    var index = 0;
    var slotH = 0;
    var timer = null;

    function wordScale(i) {
        return i === 3 ? 0.58 : 0.92;
    }

    function fitScrollBox() {
        var maxW = 0;
        var maxH = 0;
        var probe = document.createElement('span');
        probe.style.cssText = [
            'position:absolute',
            'visibility:hidden',
            'pointer-events:none',
            'font-family:"Sora",sans-serif',
            'font-weight:600',
            'letter-spacing:-0.03em',
            'line-height:1.15',
        ].join(';');

        var title = document.querySelector('.home-hero-title');
        var titleSize = title ? getComputedStyle(title).fontSize : '3rem';
        var parentW = scroll.parentElement ? scroll.parentElement.clientWidth : window.innerWidth;
        var maxBoxW = Math.max(parentW - 56, 220);

        document.body.appendChild(probe);

        words.forEach(function (word, i) {
            probe.style.fontSize = 'calc(' + titleSize + ' * ' + wordScale(i) + ')';
            probe.style.whiteSpace = i === 3 ? 'normal' : 'nowrap';
            probe.style.display = 'block';
            probe.style.width = i === 3 ? maxBoxW + 'px' : 'auto';
            probe.style.maxWidth = maxBoxW + 'px';
            probe.textContent = word;
            maxW = Math.max(maxW, probe.offsetWidth);
            maxH = Math.max(maxH, probe.offsetHeight);
        });

        document.body.removeChild(probe);

        slotH = Math.max(Math.ceil(maxH) + 4, 44);
        var boxW = Math.min(Math.ceil(maxW + 40), maxBoxW);

        scroll.style.setProperty('--hero-slot', slotH + 'px');
        scroll.style.setProperty('--hero-scroll-width', boxW + 'px');

        scrollWords.forEach(function (el) {
            el.style.height = slotH + 'px';
        });

        scrollInner.style.transition = 'none';
        scrollInner.style.transform = 'translate3d(0,-' + (index * slotH) + 'px,0)';
    }

    function setTransform(i, animate) {
        scrollInner.style.transition = animate
            ? 'transform ' + transitionMs + 'ms cubic-bezier(0.4, 0, 0.2, 1)'
            : 'none';
        scrollInner.style.transform = 'translate3d(0,-' + (i * slotH) + 'px,0)';
    }

    function fadeText(el, text) {
        if (!el) return;
        el.style.opacity = '0';
        window.setTimeout(function () {
            el.textContent = text;
            el.style.opacity = '1';
        }, 180);
    }

    function setText(el, text, animate) {
        if (!el) return;
        if (animate) {
            fadeText(el, text);
            return;
        }
        el.textContent = text;
        el.style.opacity = '1';
    }

    function showSlide(i, animateText) {
        index = i;
        var slide = slides[index] || {};

        setText(prefix, slide.verb || 'We build', animateText);

        if (live) {
            live.textContent = (slide.verb || 'We build') + ' ' + (slide.word || words[index]);
        }

        setText(eyebrow, slide.eyebrow || '', animateText);
        setText(tagline, slide.tagline || '', animateText);
    }

    function tick() {
        var next = (index + 1) % words.length;

        if (next === 0) {
            setTransform(0, false);
            showSlide(0, true);
            return;
        }

        setTransform(next, true);
        showSlide(next, true);
    }

    function start() {
        if (timer) clearInterval(timer);
        timer = setInterval(tick, interval);
    }

    function init() {
        fitScrollBox();
        showSlide(0, false);
        setTransform(0, false);
        scroll.classList.add('is-ready');
        start();
    }

    init();

    window.addEventListener('resize', function () {
        fitScrollBox();
        setTransform(index, false);
    });

    if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(function () {
            fitScrollBox();
            setTransform(index, false);
        });
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        clearInterval(timer);
        scrollInner.style.transition = 'none';
    }
})();
