<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title')@yield('title') · {{ config('app.name') }}@else{{ config('app.name') }}@endif</title>
    @include('partials.seo-meta')
    @include('partials.vite-styles')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
</head>
<body class="d-flex flex-column min-vh-100 text-body">
    <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-center py-5 px-3">
        @yield('content')
    </div>
    @include('partials.site-footer')
    @include('partials.cookie-banner')
    @include('partials.vite-scripts-footer')
<script>
document.querySelectorAll('[data-password-toggle]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id = btn.getAttribute('data-password-toggle');
        var input = id && document.getElementById(id);
        if (!input) return;
        var show = input.getAttribute('type') === 'password';
        input.setAttribute('type', show ? 'text' : 'password');
        btn.setAttribute('aria-pressed', show ? 'true' : 'false');
        btn.textContent = show ? 'Скрий' : 'Покажи';
    });
});
</script>
</body>
</html>
