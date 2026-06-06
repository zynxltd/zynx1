(function () {
    const storageKey = 'zynx1-theme';
    const root = document.documentElement;
    const toggle = document.getElementById('theme-toggle');

    function getTheme() {
        return root.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
    }

    function setTheme(theme) {
        if (theme === 'light') {
            root.setAttribute('data-theme', 'light');
        } else {
            root.removeAttribute('data-theme');
        }
        localStorage.setItem(storageKey, theme);
        if (toggle) {
            toggle.setAttribute('aria-pressed', theme === 'light' ? 'true' : 'false');
        }
    }

    if (toggle) {
        toggle.setAttribute('aria-pressed', getTheme() === 'light' ? 'true' : 'false');
        toggle.addEventListener('click', () => {
            setTheme(getTheme() === 'light' ? 'dark' : 'light');
        });
    }
})();
