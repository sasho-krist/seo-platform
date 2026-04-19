import '../css/app.css';

import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const COOKIE_CONSENT_KEY = 'seo_platform_cookie_consent_v1';

function initCookieBanner() {
    const banner = document.querySelector('[data-cookie-banner]');
    const acceptBtn = document.getElementById('cookie-banner-accept');
    if (!banner || !acceptBtn) {
        return;
    }

    try {
        if (window.localStorage.getItem(COOKIE_CONSENT_KEY)) {
            banner.remove();
            return;
        }
    } catch {
        /* private mode etc. */
    }

    banner.classList.remove('d-none');
    document.documentElement.classList.add('cookie-banner-visible');

    acceptBtn.addEventListener('click', function () {
        try {
            window.localStorage.setItem(COOKIE_CONSENT_KEY, new Date().toISOString());
        } catch {
            /* ignore */
        }
        document.documentElement.classList.remove('cookie-banner-visible');
        banner.remove();
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCookieBanner);
} else {
    initCookieBanner();
}
