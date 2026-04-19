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
<div class="d-flex flex-fill flex-column flex-md-row min-vh-100">
    <aside class="app-sidebar d-none d-md-flex flex-column border-end bg-white shadow-sm p-3" style="width: 15rem;">
        @include('partials.app-brand')

        <nav class="nav nav-pills flex-column gap-1 small mt-2 flex-grow-1">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Табло</a>

            <div class="app-nav-section-label text-uppercase px-3 pt-3 pb-1 small fw-semibold">Съдържание</div>
            <a href="{{ route('blog-posts.index') }}" class="nav-link {{ request()->routeIs('blog-posts.*') ? 'active' : '' }}">Блог статии</a>
            <a href="{{ route('keywords.index') }}" class="nav-link {{ request()->routeIs('keywords.*') ? 'active' : '' }}">Ключови думи</a>
            <a href="{{ route('rewrite.edit') }}" class="nav-link {{ request()->routeIs('rewrite.*') ? 'active' : '' }}">Преформулиране</a>

            <div class="app-nav-section-label text-uppercase px-3 pt-3 pb-1 small fw-semibold">Анализ</div>
            <a href="{{ route('competitors.index') }}" class="nav-link {{ request()->routeIs('competitors.*') ? 'active' : '' }}">Конкуренти</a>

            <div class="app-nav-section-label text-uppercase px-3 pt-3 pb-1 small fw-semibold">Интеграции</div>
            <a href="{{ route('wordpress.edit') }}" class="nav-link {{ request()->routeIs('wordpress.*') ? 'active' : '' }}">WordPress</a>

            <div class="app-nav-section-label text-uppercase px-3 pt-3 pb-1 small fw-semibold">Помощ</div>
            <a href="{{ route('docs.api') }}" class="nav-link">API упътване</a>

            <div class="app-nav-section-label text-uppercase px-3 pt-3 pb-1 small fw-semibold">Акаунт</div>
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">Профил</a>
        </nav>

        <div class="mt-auto pt-3 border-top">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm w-100">Изход</button>
            </form>
        </div>
    </aside>

    <div class="d-flex flex-column flex-fill min-w-0">
        <header class="d-md-none border-bottom bg-white px-3 py-2 d-flex align-items-center justify-content-between gap-2 shadow-sm">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none text-body text-truncate min-w-0">
                <img src="{{ asset('images/logo.svg') }}" width="32" height="32" alt="" class="flex-shrink-0 rounded-2"/>
                <span class="fw-semibold text-primary small text-truncate">{{ config('app.name') }}</span>
            </a>
            <div class="d-flex align-items-center gap-1 flex-shrink-0">
                <a href="{{ route('profile.edit') }}" class="btn btn-link btn-sm text-body py-1 px-2 text-decoration-none">Профил</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link btn-sm py-1 px-2 text-primary text-decoration-none">Изход</button>
                </form>
            </div>
        </header>

        <div class="d-md-none bg-white border-bottom px-2 py-2 small app-mobile-nav">
            <div class="d-flex flex-wrap gap-1 justify-content-center mb-1">
                <a href="{{ route('dashboard') }}" class="text-decoration-none px-1 {{ request()->routeIs('dashboard') ? 'fw-bold text-primary' : 'text-body' }}">Табло</a>
                <a href="{{ route('blog-posts.index') }}" class="text-decoration-none px-1 {{ request()->routeIs('blog-posts.*') ? 'fw-bold text-primary' : 'text-body' }}">Блог</a>
                <a href="{{ route('keywords.index') }}" class="text-decoration-none px-1 {{ request()->routeIs('keywords.*') ? 'fw-bold text-primary' : 'text-body' }}">Ключови</a>
                <a href="{{ route('rewrite.edit') }}" class="text-decoration-none px-1 {{ request()->routeIs('rewrite.*') ? 'fw-bold text-primary' : 'text-body' }}">Текст</a>
            </div>
            <div class="d-flex flex-wrap gap-1 justify-content-center">
                <a href="{{ route('competitors.index') }}" class="text-decoration-none px-1 {{ request()->routeIs('competitors.*') ? 'fw-bold text-primary' : 'text-body' }}">Конкуренти</a>
                <a href="{{ route('wordpress.edit') }}" class="text-decoration-none px-1 {{ request()->routeIs('wordpress.*') ? 'fw-bold text-primary' : 'text-body' }}">WP</a>
                <a href="{{ route('docs.api') }}" class="text-decoration-none px-1 text-body">API</a>
            </div>
        </div>

        <main class="flex-grow-1 py-3 py-md-4 px-2 px-md-4 mx-auto w-100" style="max-width: 68rem;">
            <div class="app-content-surface px-3 px-md-4 px-lg-5 py-4 py-md-5">
                @if (session('status'))
                    <div class="alert alert-info border-info mb-4" role="alert">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger mb-4" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
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
        btn.textContent = show ? 'Скрий' : 'Покажи';
    });
});
</script>
</body>
</html>
