@extends('layouts.public')

@section('title', 'Начало')

@section('meta_description', 'AI платформа за блог съдържание, SEO мета заглавия и описания, ключови думи и анализ на конкуренти — '.config('app.name').'.')

@section('meta_keywords', 'SEO, AI съдържание, генератор на статии, meta title, meta description, ключови думи, WordPress, sasho-dev')

@section('content')
    <div class="row justify-content-center mb-5">
        <div class="col-lg-10 text-center">
            <p class="small text-uppercase text-primary fw-medium mb-2">SEO &amp; AI съдържание</p>
            <h1 class="h2 fw-semibold text-body mb-3">{{ config('app.name') }}</h1>
            <p class="lead text-secondary mb-0">Генерирайте статии, мета заглавия и описания, предложения за ключови думи и сравнявайте конкуренти — от едно табло. Има и <strong>REST API</strong> за автоматизация.</p>
            <div class="d-flex flex-wrap justify-content-center gap-2 gap-md-3 mt-4">
                @guest
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">Регистрация</a>
                    @endif
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-4">Вход</a>
                    @endif
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4">Към таблото</a>
                @endguest
            </div>
        </div>
    </div>

    <section class="border-top pt-5 mt-2" aria-labelledby="features-heading">
        <h2 id="features-heading" class="h4 fw-semibold text-body text-center mb-2">Функционалности</h2>
        <p class="text-secondary text-center small mb-4 mx-auto" style="max-width: 40rem;">Инструментите са достъпни след вход от страничното меню. По-долу е обобщение какво получавате.</p>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3 d-flex justify-content-center" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="4rem" height="4rem" fill="currentColor" class="flex-shrink-0" viewBox="0 0 24 24"><path d="M4 4a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H6l-4 4V6a2 2 0 0 1 2-2zm0 2v10.172L5.828 14H13a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H6a2 2 0 0 1-2-2zm16-1v12a2 2 0 0 1-2 2h-2v-2h2V5h-5V3h5a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        <h3 class="h6 fw-semibold text-body mb-2">Блог статии с AI</h3>
                        <p class="small text-secondary mb-0">Чернови по тема и тон, редакция на HTML съдържание, експорт (JSON, Markdown, HTML) и публикуване към WordPress.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3 d-flex justify-content-center" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="4rem" height="4rem" fill="currentColor" class="flex-shrink-0" viewBox="0 0 24 24"><path d="M3.5 5.5A1.5 1.5 0 0 1 5 4h5l2 3h7a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-10zm6.75 5.75a.75.75 0 1 0 0 1.5h4a.75.75 0 0 0 0-1.5h-4zm0 3a.75.75 0 1 0 0 1.5h4a.75.75 0 0 0 0-1.5h-4z"/></svg>
                        </div>
                        <h3 class="h6 fw-semibold text-body mb-2">SEO мета</h3>
                        <p class="small text-secondary mb-0">Генериране на meta title, meta description и focus keyword за всяка статия с помощта на AI.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3 d-flex justify-content-center" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="4rem" height="4rem" fill="currentColor" class="flex-shrink-0" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C8.01 14 6 11.99 6 9.5S8.01 5 10.5 5 15 7.01 15 9.5 12.99 14 10.5 14z"/></svg>
                        </div>
                        <h3 class="h6 fw-semibold text-body mb-2">Ключови думи</h3>
                        <p class="small text-secondary mb-0">Списъци с ключови фрази по тема и контекст; история на генерациите и връзка към статии.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3 d-flex justify-content-center" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="4rem" height="4rem" fill="currentColor" class="flex-shrink-0" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/></svg>
                        </div>
                        <h3 class="h6 fw-semibold text-body mb-2">Преформулиране</h3>
                        <p class="small text-secondary mb-0">Подобряване на произволен текст по ваша инструкция — по-кратко, по-продажно, по-формално и др.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3 d-flex justify-content-center" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="4rem" height="4rem" fill="currentColor" class="flex-shrink-0" viewBox="0 0 24 24"><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6h-6z"/></svg>
                        </div>
                        <h3 class="h6 fw-semibold text-body mb-2">Конкуренти</h3>
                        <p class="small text-secondary mb-0">Сравнение на видим текст от вашата страница и страница на конкурент чрез AI анализ и запазени отчети.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3 d-flex justify-content-center" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="4rem" height="4rem" fill="currentColor" class="flex-shrink-0" viewBox="0 0 24 24"><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                        </div>
                        <h3 class="h6 fw-semibold text-body mb-2">WordPress</h3>
                        <p class="small text-secondary mb-0">Връзка към вашия сайт и публикуване на статии директно от платформата.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-5 pt-4 border-top" aria-labelledby="api-heading">
        <div class="card border-primary border-opacity-25 shadow-sm overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-start g-4">
                    <div class="col-md-auto text-center text-md-start">
                        <div class="text-primary d-inline-flex rounded-3 bg-primary bg-opacity-10 p-3" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="5rem" height="5rem" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h6v2H6v12h4v2H4V4zm16 0h-6v2h4v12h-4v2h6V4zm-8 6h2v4h-2v-4z"/></svg>
                        </div>
                    </div>
                    <div class="col-md">
                        <h2 id="api-heading" class="h4 fw-semibold text-body mb-2">REST API <code class="small bg-light px-2 py-1 rounded">/api/v1</code></h2>
                        <p class="text-secondary small mb-3">Автентикация с <strong>Bearer token</strong> (Laravel Sanctum). Подходящо за скриптове, мобилни приложения или външни системи.</p>
                        <ul class="small text-body mb-4 ps-3">
                            <li class="mb-1"><strong>Статии</strong> — CRUD, AI генериране от тема, SEO мета, експорт.</li>
                            <li class="mb-1"><strong>Ключови думи и преформулиране</strong> — като уеб инструментите.</li>
                            <li class="mb-1"><strong>Конкуренти и WordPress</strong> — запис на анализи и публикуване.</li>
                            <li class="mb-0"><strong>Профил и табло</strong> — базови потребителски данни и статистика.</li>
                        </ul>
                        @if (Route::has('docs.api'))
                            <a href="{{ route('docs.api') }}" class="btn btn-primary">API упътване и примери</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
