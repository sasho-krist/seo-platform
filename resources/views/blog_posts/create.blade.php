@extends('layouts.app')

@section('title', 'Нова статия')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-semibold text-body">Нова статия</h1>
        <p class="text-secondary small">Ръчно съдържание или генериране от тема с AI.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h2 class="h5 fw-semibold mb-3">Генериране с AI</h2>
                    @if (! $aiConfigured)
                        <div class="alert alert-warning mb-0 small">Задайте <code>OPENAI_API_KEY</code> в .env за да активирате AI.</div>
                    @else
                        <form method="POST" action="{{ route('blog-posts.generate') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small">Тема</label>
                                <textarea name="topic" rows="3" required class="form-control"
                                    placeholder="Напр. Как да подобрим скоростта на WordPress без плъгини"></textarea>
                            </div>
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <label class="form-label small">Тон</label>
                                    <input name="tone" type="text" value="{{ old('tone', 'експертен') }}" class="form-control"/>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label small">Език</label>
                                    <input name="language" type="text" value="{{ old('language', 'bg') }}" class="form-control"/>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Генерирай чернова</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h2 class="h5 fw-semibold mb-3">Ръчно създаване</h2>
                    <form method="POST" action="{{ route('blog-posts.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small">Заглавие</label>
                            <input name="title" type="text" value="{{ old('title') }}" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Съдържание (HTML)</label>
                            <textarea name="body" rows="10" class="form-control font-monospace small">{{ old('body') }}</textarea>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label small">Език</label>
                                <input name="language" type="text" value="{{ old('language', 'bg') }}" class="form-control"/>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label small">Статус</label>
                                <select name="status" class="form-select">
                                    <option value="draft" @selected(old('status') === 'draft')>Чернова</option>
                                    <option value="published" @selected(old('status') === 'published')>Публикувана</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Запис</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
