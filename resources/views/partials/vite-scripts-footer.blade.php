@if (! file_exists(public_path('build/manifest.json')) && ! file_exists(public_path('hot')))
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/cookie-banner.js') }}" defer></script>
@endif
