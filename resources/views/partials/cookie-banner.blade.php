<div id="cookie-banner"
     class="cookie-banner position-fixed bottom-0 start-0 end-0 bg-white border-top shadow d-none"
     role="dialog"
     aria-modal="false"
     aria-labelledby="cookie-banner-title"
     aria-describedby="cookie-banner-desc"
     data-cookie-banner>
    <div class="container-xl px-3 px-md-4 py-3">
        <div class="row align-items-center gy-3">
            <div class="col-md">
                <h2 id="cookie-banner-title" class="h6 fw-semibold mb-1 text-body">Бисквитки и поверителност</h2>
                <p id="cookie-banner-desc" class="small text-secondary mb-0">
                    Използваме бисквитки за основни функции на сайта (напр. вход и сесия). Продължавайки, приемате ползването им съгласно нашата
                    @if(Route::has('privacy'))
                        <a href="{{ route('privacy') }}" class="link-primary">политика за поверителност</a>.
                    @else
                        политика за поверителност.
                    @endif
                </p>
            </div>
            <div class="col-md-auto d-flex flex-wrap gap-2 justify-content-md-end">
                @if(Route::has('privacy'))
                    <a href="{{ route('privacy') }}" class="btn btn-outline-secondary btn-sm">Подробности</a>
                @endif
                <button type="button" class="btn btn-primary btn-sm px-3" id="cookie-banner-accept">Приемам</button>
            </div>
        </div>
    </div>
</div>
