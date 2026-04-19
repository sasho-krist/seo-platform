<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title')@yield('title') · {{ config('app.name') }}@else{{ config('app.name') }}@endif</title>
    @include('partials.seo-meta')
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
</head>
<body class="d-flex flex-column min-vh-100 text-body">
    <header class="app-strip-on-blue shadow-sm">
        <div class="container-xl py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <a href="{{ url('/') }}" class="d-flex align-items-center gap-2 text-decoration-none text-body">
                <img src="{{ asset('images/logo.svg') }}" width="36" height="36" alt="" class="flex-shrink-0 rounded-3 shadow-sm"/>
                <span class="fs-5 fw-semibold text-primary">{{ config('app.name') }}</span>
            </a>
            <nav class="d-flex flex-wrap align-items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">Табло</a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-link btn-sm text-body text-decoration-none">Вход</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Регистрация</a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>
    <main class="flex-grow-1 py-3 py-md-4">
        <div class="container-xl px-3 px-md-4">
            <div class="app-content-surface px-3 px-md-5 py-4 py-md-5">
                @yield('content')
            </div>
        </div>
    </main>
    @include('partials.site-footer')
    @include('partials.cookie-banner')
</body>
</html>
