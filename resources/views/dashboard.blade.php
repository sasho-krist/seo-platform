@extends('layouts.app')

@section('title', 'Табло')

@section('meta_description', 'Табло на '.config('app.name').' — статистики и бърз достъп до AI инструменти за SEO и съдържание.')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-semibold text-body">Табло</h1>
        <p class="text-secondary small mb-0">AI съдържание и SEO инструменти на едно място.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-uppercase text-primary fw-semibold">Статии</div>
                    <div class="display-6 fw-semibold mt-2">{{ $postCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-uppercase text-primary fw-semibold">Ключови списъци</div>
                    <div class="display-6 fw-semibold mt-2">{{ $keywordCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-uppercase text-primary fw-semibold">Конкурентни анализи</div>
                    <div class="display-6 fw-semibold mt-2">{{ $competitorCount }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h2 class="h5 fw-semibold mb-3">Бързи действия</h2>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('blog-posts.create') }}" class="btn btn-primary">Нова статия</a>
                <a href="{{ route('keywords.index') }}" class="btn btn-outline-primary">Ключови идеи</a>
                <a href="{{ route('competitors.create') }}" class="btn btn-outline-primary">Анализ на конкурент</a>
                <a href="{{ route('rewrite.edit') }}" class="btn btn-outline-primary">Подобри текст</a>
            </div>
        </div>
    </div>
@endsection
