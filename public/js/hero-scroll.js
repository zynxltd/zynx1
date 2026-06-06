(function () {
    var interval = 4000;
    var transitionMs = 450;

    var live = document.getElementById('hero-scroll-live');
    var prefix = document.getElementById('hero-prefix');
    var eyebrow = document.getElementById('hero-eyebrow');
    var tagline = document.getElementById('hero-tagline');
    var visual = document.getElementById('hero-visual');
    var scroll = document.querySelector('.hero-scroll');
    var scrollInner = document.getElementById('hero-scroll-inner');
    var scrollWords = document.querySelectorAll('.hero-scroll-word');

    if (!live || !visual || !scrollInner) return;

    var panels = Array.from(visual.querySelectorAll('.hero-visual-panel'));
    var words = Array.from(scrollWords).map(function (el) { return el.textContent.trim(); });
    var verbs = panels.map(function (p) { return p.dataset.verb || 'We build'; });
    var index = 0;
    var slotH = 0;
    var timer = null;

    function fitScrollBox() {
        if (!scroll || !scrollWords.length) return;

        var maxW = 0;
        var maxH = 0;
        var probe = document.createElement('span');
        probe.style.cssText = [
            'position:absolute',
            'visibility:hidden',
            'white-space:nowrap',
            'pointer-events:none',
            'font-family:"JetBrains Mono",monospace',
            'font-weight:500',
            'line-height:1',
        ].join(';');

        var title = document.querySelector('.home-hero-title');
        var titleSize = title ? getComputedStyle(title).fontSize : '3rem';
        probe.style.fontSize = 'calc(' + titleSize + ' * 0.92)';

        document.body.appendChild(probe);

        words.forEach(function (word) {
            probe.textContent = word;
            maxW = Math.max(maxW, probe.offsetWidth);
            maxH = Math.max(maxH, probe.offsetHeight);
        });

        document.body.removeChild(probe);

        slotH = Math.ceil(maxH * 1.4) + 6;
        var parentW = scroll.parentElement ? scroll.parentElement.clientWidth : window.innerWidth;
        var boxW = Math.min(Math.ceil(maxW + 28), Math.max(parentW - 32, 0));

        scroll.style.setProperty('--hero-slot', slotH + 'px');
        scroll.style.height = slotH + 'px';
        scroll.style.minWidth = boxW + 'px';

        scrollWords.forEach(function (el) {
            el.style.height = slotH + 'px';
        });

        scrollInner.style.transition = 'none';
        scrollInner.style.transform = 'translateY(-' + (index * slotH) + 'px)';
    }

    function setTransform(i, animate) {
        scrollInner.style.transition = animate
            ? 'transform ' + transitionMs + 'ms cubic-bezier(0.4, 0, 0.2, 1)'
            : 'none';
        scrollInner.style.transform = 'translateY(-' + (i * slotH) + 'px)';
    }

    function showSlide(i) {
        index = i;
        var panel = panels[index];

        panels.forEach(function (p) {
            p.classList.toggle('is-active', p === panel);
        });

        if (prefix && panel.dataset.verb) {
            prefix.textContent = panel.dataset.verb;
        }

        if (live) {
            live.textContent = (panel.dataset.verb || verbs[index]) + ' ' + words[index];
        }

        if (eyebrow && panel.dataset.eyebrow) eyebrow.textContent = panel.dataset.eyebrow;
        if (tagline && panel.dataset.tagline) tagline.textContent = panel.dataset.tagline;
    }

    function tick() {
        var next = (index + 1) % words.length;

        if (next === 0) {
            setTransform(0, false);
            showSlide(0);
            return;
        }

        setTransform(next, true);
        showSlide(next);
    }

    function start() {
        if (timer) clearInterval(timer);
        timer = setInterval(tick, interval);
    }

    fitScrollBox();
    showSlide(0);
    setTransform(0, false);
    start();

    window.addEventListener('resize', function () {
        fitScrollBox();
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
