@extends('layouts.public')

@section('title', 'Условия за ползване')

@section('meta_description', 'Условия за ползване на услугите на '.config('app.name').' — правила, отговорност и ползване на платформата.')

@section('meta_keywords', 'условия, ползване, Terms of Service, '.config('app.name'))

@section('content')
    <article class="article-body" style="max-width: 42rem;">
        <h1 class="h3 fw-semibold text-body">Условия за ползване</h1>
        <p class="small text-secondary">Последна актуализация: {{ date('d.m.Y') }}</p>
        <p class="mt-4 text-body">Добре дошли в {{ config('app.name') }}. Използвайки платформата, приемате следните условия. Услугите се предоставят „както са“; препоръчваме да преглеждате генерираното от AI съдържание преди публикуване. Носите отговорност за съответствие с приложимото законодателство и за защита на вашите API ключове и акаунт.</p>
        <p class="text-body">За въпроси свържете се с администратора на услугата или през контактите на <a href="https://sasho-dev.com/portfolio/" class="link-primary" target="_blank" rel="noopener noreferrer">sasho-dev</a>.</p>
    </article>
@endsection
