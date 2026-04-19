@extends('layouts.public')

@section('title', 'Политика за поверителност')

@section('meta_description', 'Политика за поверителност на '.config('app.name').' — как обработваме данни, бисквитки и AI заявки.')

@section('meta_keywords', 'поверителност, GDPR, лични данни, Privacy Policy, '.config('app.name'))

@section('content')
    <article class="article-body" style="max-width: 42rem;">
        <h1 class="h3 fw-semibold text-body">Политика за поверителност</h1>
        <p class="small text-secondary">Последна актуализация: {{ date('d.m.Y') }}</p>
        <p class="mt-4 text-body">Обработваме лични данни (име, имейл, сесии) изключително за предоставяне на акаунт и услуги. Паролите се съхраняват криптирано. Съдържание, изпращано към външни AI доставчици, подлежи на техните условия — не изпращайте поверителна информация без необходимост.</p>
        <p class="text-body">Можете да поискате изтриване на акаунт чрез администратор. Повече информация за разработката: <a href="https://sasho-dev.com/portfolio/" class="link-primary" target="_blank" rel="noopener noreferrer">sasho-dev portfolio</a>.</p>
    </article>
@endsection
