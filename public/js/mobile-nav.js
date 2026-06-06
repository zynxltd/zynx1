(function () {
    const toggle = document.getElementById('nav-toggle');
    const mobileNav = document.getElementById('mobile-nav');

    if (!toggle || !mobileNav) return;

    function setOpen(open) {
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        mobileNav.hidden = !open;
        document.body.classList.toggle('nav-open', open);
    }

    function close() {
        setOpen(false);
    }

    toggle.addEventListener('click', () => {
        setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });

    mobileNav.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', close);
    });

    document.querySelectorAll('.nav-mobile-expand').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const group = btn.closest('.nav-mobile-group');
            const sub = group?.querySelector('.nav-mobile-sub');
            if (!sub) return;

            const open = btn.getAttribute('aria-expanded') === 'true';
            btn.setAttribute('aria-expanded', open ? 'false' : 'true');
            sub.hidden = open;
            group.classList.toggle('is-open', !open);
        });
    });

    document.querySelectorAll('.nav-dropdown-toggle').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const dropdown = btn.closest('.nav-dropdown');
            const open = dropdown?.classList.contains('is-open');
            document.querySelectorAll('.nav-dropdown.is-open').forEach(d => d.classList.remove('is-open'));
            if (!open) dropdown?.classList.add('is-open');
            btn.setAttribute('aria-expanded', open ? 'false' : 'true');
        });
    });

    document.addEventListener('click', (e) => {
        if (e.target.closest('.nav-dropdown')) return;

        document.querySelectorAll('.nav-dropdown.is-open').forEach(d => {
            d.classList.remove('is-open');
            d.querySelector('.nav-dropdown-toggle')?.setAttribute('aria-expanded', 'false');
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') close();
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) close();
    });
})();
