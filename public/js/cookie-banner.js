/**
 * Fallback when Vite bundle is not loaded (mirror resources/js/app.js cookie logic).
 */
(function () {
    var COOKIE_CONSENT_KEY = 'seo_platform_cookie_consent_v1';

    function initCookieBanner() {
        var banner = document.querySelector('[data-cookie-banner]');
        var acceptBtn = document.getElementById('cookie-banner-accept');
        if (!banner || !acceptBtn) {
            return;
        }

        try {
            if (window.localStorage.getItem(COOKIE_CONSENT_KEY)) {
                banner.remove();
                return;
            }
        } catch (e) {}

        banner.classList.remove('d-none');
        document.documentElement.classList.add('cookie-banner-visible');

        acceptBtn.addEventListener('click', function () {
            try {
                window.localStorage.setItem(COOKIE_CONSENT_KEY, new Date().toISOString());
            } catch (e) {}
            document.documentElement.classList.remove('cookie-banner-visible');
            banner.remove();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCookieBanner);
    } else {
        initCookieBanner();
    }
})();
