@extends('layouts.public')

@section('title', 'Често задавани въпроси')

@section('meta_description', 'ЧЗВ за '.config('app.name').' — AI генериране, SEO, WordPress, ключови думи и поверителност.')

@section('meta_keywords', 'ЧЗВ, FAQ, SEO платформа, AI блог, WordPress интеграция')

@section('content')
    <article style="max-width: 42rem;">
        <h1 class="h3 fw-semibold text-body">Често задавани въпроси (ЧЗВ)</h1>
        <dl class="mt-4">
            <div class="mb-4">
                <dt class="fw-semibold text-body">Нужен ли е OpenAI ключ?</dt>
                <dd class="mt-2 small text-secondary">За AI функциите трябва валиден API ключ във файла <code>.env</code> (OPENAI_API_KEY).</dd>
            </div>
            <div class="mb-4">
                <dt class="fw-semibold text-body">Как работи WordPress интеграцията?</dt>
                <dd class="mt-2 small text-secondary">Създайте Application Password в WordPress и запазете връзката в платформата; публикациите се изпращат чрез REST API.</dd>
            </div>
            <div class="mb-4">
                <dt class="fw-semibold text-body">Има ли REST API?</dt>
                <dd class="mt-2 small text-secondary">Да — версия v1 под <code>/api/v1</code>, автентикация с Bearer token (Laravel Sanctum). @if(Route::has('docs.api'))Пълен списък: <a href="{{ route('docs.api') }}" class="link-primary">API упътване</a>.@endif</dd>
            </div>
            <div class="mb-0">
                <dt class="fw-semibold text-body">Къде са картата на сайта и sitemap.xml?</dt>
                <dd class="mt-2 small text-secondary">В долната лента има връзки към <a href="{{ route('sitemap.page') }}" class="link-primary">HTML картата</a> и <a href="{{ url('/sitemap.xml') }}" class="link-primary">sitemap.xml</a> за търсачки.</dd>
            </div>
        </dl>
    </article>
@endsection
