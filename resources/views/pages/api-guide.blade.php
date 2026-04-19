@extends('layouts.public')

@section('title', 'REST API упътване')

@section('meta_description', 'Упътване за REST API на '.config('app.name').' — автентикация с Bearer token, endpoints за блог, ключови думи, анализи и WordPress.')

@section('meta_keywords', 'API, REST, Sanctum, OpenAPI, '.config('app.name').', developer')

@section('content')
    <article class="article-body" style="max-width: 48rem;">
        <h1 class="h3 fw-semibold text-body">REST API (v1)</h1>
        <p class="text-secondary small">Базов адрес: <code class="small">{{ url('/api/v1') }}</code>. Използва се JSON (<code>Content-Type: application/json</code>, при нужда <code>Accept: application/json</code>).</p>

        <h2 class="h5 fw-semibold mt-5 mb-3">Автентикация</h2>
        <p>Първо получете token чрез вход с имейл и парола:</p>
        <pre class="bg-light border rounded p-3 small mb-3 overflow-auto"><code>POST {{ url('/api/v1/auth/token') }}

{
  "email": "you@example.com",
  "password": "••••••••",
  "device_name": "my-app"
}</code></pre>
        <p class="small text-secondary mb-3">Отговорът съдържа <code>token</code> и <code>token_type: Bearer</code>. За всички защитени заявки добавете заглавка:</p>
        <pre class="bg-light border rounded p-3 small mb-4 overflow-auto"><code>Authorization: Bearer ВАШИЯТ_TOKEN</code></pre>
        <p class="small">Изход от текущия token: <code>DELETE {{ url('/api/v1/auth/token') }}</code> със същата заглавка.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3">Защитени endpoints</h2>
        <p class="small text-secondary mb-3">Всички по-долу изискват валиден Bearer token.</p>

        <ul class="list-unstyled small border rounded overflow-hidden mb-4">
            <li class="border-bottom px-3 py-2 bg-light"><strong>GET</strong> <code>/user</code> — текущ потребител + <code>ai_configured</code></li>
            <li class="border-bottom px-3 py-2"><strong>GET</strong> <code>/dashboard/stats</code> — броячи (статии, ключови списъци, анализи)</li>
            <li class="border-bottom px-3 py-2 bg-light"><strong>GET</strong> <code>/blog-posts</code> — списък (опционално <code>?per_page=12</code>)</li>
            <li class="border-bottom px-3 py-2"><strong>POST</strong> <code>/blog-posts</code> — нова статия</li>
            <li class="border-bottom px-3 py-2 bg-light"><strong>GET</strong> <code>/blog-posts/{id}</code> — детайл с SEO мета</li>
            <li class="border-bottom px-3 py-2"><strong>PUT/PATCH</strong> <code>/blog-posts/{id}</code> — редакция</li>
            <li class="border-bottom px-3 py-2 bg-light"><strong>DELETE</strong> <code>/blog-posts/{id}</code> — изтриване</li>
            <li class="border-bottom px-3 py-2"><strong>POST</strong> <code>/blog-posts/generate-from-topic</code> — AI чернова (<code>topic</code>, <code>tone</code>, <code>language</code>)</li>
            <li class="border-bottom px-3 py-2 bg-light"><strong>POST</strong> <code>/blog-posts/{id}/seo</code> — AI SEO мета</li>
            <li class="border-bottom px-3 py-2"><strong>GET</strong> <code>/blog-posts/{id}/export?format=json|markdown|html</code> — експорт</li>
            <li class="border-bottom px-3 py-2 bg-light"><strong>GET</strong> <code>/keywords/history</code> — история на ключови предложения</li>
            <li class="border-bottom px-3 py-2"><strong>POST</strong> <code>/keywords</code> — генериране на ключови думи</li>
            <li class="border-bottom px-3 py-2 bg-light"><strong>GET</strong> <code>/competitors</code> — списък анализи</li>
            <li class="border-bottom px-3 py-2"><strong>POST</strong> <code>/competitors</code> — нов анализ (два URL)</li>
            <li class="border-bottom px-3 py-2 bg-light"><strong>GET</strong> <code>/competitors/{id}</code> — детайл</li>
            <li class="border-bottom px-3 py-2"><strong>POST</strong> <code>/rewrite</code> — AI преформулиране на текст</li>
            <li class="border-bottom px-3 py-2 bg-light"><strong>GET</strong> <code>/wordpress</code> — настройки (без парола)</li>
            <li class="border-bottom px-3 py-2"><strong>PUT</strong> <code>/wordpress</code> — запис на WP връзка</li>
            <li class="px-3 py-2 bg-light"><strong>POST</strong> <code>/blog-posts/{id}/wordpress/publish</code> — публикуване в WordPress</li>
        </ul>

        <h2 class="h5 fw-semibold mt-5 mb-3">Грешки и лимити</h2>
        <p class="small">При валидиращи грешки API връща HTTP 422 с описание на полетата. Неуспешен вход: 422. Невалиден или липсващ token: 401.</p>

        @auth
            <p class="small mt-4 mb-0">
                <a href="{{ route('dashboard') }}" class="link-primary">← Към таблото</a>
            </p>
        @else
            <p class="small mt-4 mb-0">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="link-primary">Регистрация</a>
                    <span class="text-muted">·</span>
                @endif
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="link-primary">Вход</a>
                @endif
            </p>
        @endauth
    </article>
@endsection
