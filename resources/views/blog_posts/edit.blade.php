@extends('layouts.app')

@section('title', 'Редакция: '.$post->title)

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-semibold text-body">Редакция</h1>
        <p class="text-secondary small">{{ $post->slug }}</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4" style="max-width: 48rem;">
            <form method="POST" action="{{ route('blog-posts.update', $post) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label small">Заглавие</label>
                    <input name="title" type="text" value="{{ old('title', $post->title) }}" required class="form-control"/>
                </div>
                <div class="mb-3">
                    <label class="form-label small">Съдържание (HTML)</label>
                    <textarea name="body" rows="18" class="form-control font-monospace small">{{ old('body', $post->body) }}</textarea>
                </div>
                <div class="row g-2 mb-4">
                    <div class="col-md-4">
                        <label class="form-label small">Тон</label>
                        <input name="tone" type="text" value="{{ old('tone', $post->tone) }}" class="form-control"/>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Език</label>
                        <input name="language" type="text" value="{{ old('language', $post->language) }}" class="form-control"/>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Статус</label>
                        <select name="status" class="form-select">
                            <option value="draft" @selected(old('status', $post->status) === 'draft')>Чернова</option>
                            <option value="published" @selected(old('status', $post->status) === 'published')>Публикувана</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Запази</button>
                    <a href="{{ route('blog-posts.show', $post) }}" class="btn btn-outline-secondary">Назад</a>
                </div>
            </form>
        </div>
    </div>
@endsection
