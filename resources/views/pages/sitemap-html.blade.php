@extends('layouts.public')

@section('title', 'Карта на сайта')

@section('meta_description', 'Карта на сайта на '.config('app.name').' — всички основни страници за навигация и SEO.')

@section('meta_keywords', 'sitemap, карта на сайта, навигация, SEO, '.config('app.name'))

@section('content')
    <div style="max-width: 32rem;">
        <h1 class="h3 fw-semibold text-body">Карта на сайта</h1>
        <p class="small text-secondary">Структурирани връзки за потребители и търсачки.</p>
        <ul class="list-unstyled mt-4 mb-0">
            <li class="mb-2"><a class="link-primary" href="{{ url('/') }}">Начало</a></li>
            @if (Route::has('login'))
                <li class="mb-2"><a class="link-primary" href="{{ route('login') }}">Вход</a></li>
            @endif
            @if (Route::has('register'))
                <li class="mb-2"><a class="link-primary" href="{{ route('register') }}">Регистрация</a></li>
            @endif
            <li class="mb-2"><a class="link-primary" href="{{ route('terms') }}">Условия за ползване</a></li>
            <li class="mb-2"><a class="link-primary" href="{{ route('privacy') }}">Поверителност</a></li>
            <li class="mb-2"><a class="link-primary" href="{{ route('faq') }}">ЧЗВ</a></li>
            @if(Route::has('docs.api'))
                <li class="mb-2"><a class="link-primary" href="{{ route('docs.api') }}">REST API упътване</a></li>
            @endif
            <li class="mb-2"><a class="link-primary" href="{{ url('/sitemap.xml') }}">sitemap.xml</a></li>
            <li class="mb-2"><a class="link-primary" href="{{ url('/robots.txt') }}">robots.txt</a></li>
            @auth
                <li class="mb-2"><a class="link-primary" href="{{ route('dashboard') }}">Табло (за влезли потребители)</a></li>
            @endauth
        </ul>
    </div>
@endsection
