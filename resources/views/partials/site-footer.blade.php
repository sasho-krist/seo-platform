<footer class="app-footer-strip mt-auto sticky-bottom shadow py-3" style="z-index: 1030;">
    <div class="container-xl px-3 px-md-4">
        <div class="row align-items-center gy-3">
            <div class="col-12 col-md-7">
                <nav class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 small">
                    @if(Route::has('terms'))
                        <a href="{{ route('terms') }}" class="link-primary text-decoration-none">Условия за ползване</a>
                    @endif
                    @if(Route::has('privacy'))
                        <a href="{{ route('privacy') }}" class="link-primary text-decoration-none">Поверителност</a>
                    @endif
                    @if(Route::has('faq'))
                        <a href="{{ route('faq') }}" class="link-primary text-decoration-none">ЧЗВ</a>
                    @endif
                    @if(Route::has('sitemap.page'))
                        <a href="{{ route('sitemap.page') }}" class="link-primary text-decoration-none">Карта на сайта</a>
                    @endif
                    @if(Route::has('docs.api'))
                        <a href="{{ route('docs.api') }}" class="link-primary text-decoration-none">API упътване</a>
                    @endif
                    <a href="{{ url('/sitemap.xml') }}" class="link-primary text-decoration-none">sitemap.xml</a>
                </nav>
            </div>
            <div class="col-12 col-md-5 text-center text-md-end small text-secondary">
                <span class="d-inline-flex flex-wrap align-items-center justify-content-center justify-content-md-end gap-2">
                    <span>&copy; {{ date('Y') }} {{ config('app.name') }}. Всички права запазени.</span>
                    <span class="text-muted">·</span>
                    <span class="d-inline-flex align-items-center gap-2">
                        <a href="https://sasho-dev.com/portfolio/" target="_blank" rel="noopener noreferrer" class="fw-medium link-primary text-decoration-none">sasho-dev</a>
                        <img src="{{ asset('images/logo/Sasho Dev 1-01.png') }}" alt="SASHO-DEV" class="rounded-2 flex-shrink-0" style="height: 2.25rem; width: auto;" loading="lazy" decoding="async"/>
                    </span>
                </span>
            </div>
        </div>
    </div>
</footer>
