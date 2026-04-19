@extends('layouts.app')

@section('title', $post->title)

@section('meta_description', optional($post->seoMeta)->meta_description ?? 'Статия: '.$post->title.' — '.config('app.name').'.')

@section('meta_keywords', optional($post->seoMeta)->focus_keyword ? optional($post->seoMeta)->focus_keyword.', блог, SEO' : 'блог, SEO, '.config('app.name'))

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-semibold text-body">{{ $post->title }}</h1>
            <p class="small text-secondary mb-0">{{ $post->slug }} · {{ $post->language }} · {{ $post->status }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('blog-posts.edit', $post) }}" class="btn btn-outline-secondary btn-sm">Редакция</a>
            <a href="{{ route('blog-posts.export', ['blog_post' => $post, 'format' => 'markdown']) }}" class="btn btn-outline-primary btn-sm">MD</a>
            <a href="{{ route('blog-posts.export', ['blog_post' => $post, 'format' => 'html']) }}" class="btn btn-outline-primary btn-sm">HTML</a>
            <a href="{{ route('blog-posts.export', ['blog_post' => $post, 'format' => 'json']) }}" class="btn btn-outline-primary btn-sm">JSON</a>
            @if (auth()->user()->wordpressConnection)
                <form method="POST" action="{{ route('wordpress.publish', $post) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm">WordPress</button>
                </form>
            @else
                <a href="{{ route('wordpress.edit') }}" class="btn btn-outline-secondary btn-sm">WP настройка</a>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 article-body">
                    {!! $post->body !!}
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h6 text-uppercase text-primary fw-semibold mb-3">SEO мета</h2>
                    @if ($post->seoMeta)
                        <dl class="small mb-0">
                            <dt class="text-secondary">Meta title</dt>
                            <dd class="mb-2 fw-medium">{{ $post->seoMeta->meta_title }}</dd>
                            <dt class="text-secondary">Meta description</dt>
                            <dd class="mb-2">{{ $post->seoMeta->meta_description }}</dd>
                            <dt class="text-secondary">Фокус ключова дума</dt>
                            <dd class="mb-0">{{ $post->seoMeta->focus_keyword }}</dd>
                        </dl>
                    @else
                        <p class="small text-secondary mb-0">Още няма записани метаданни.</p>
                    @endif
                    @if ($aiConfigured)
                        <form method="POST" action="{{ route('blog-posts.seo', $post) }}" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 btn-sm">Генерирай с AI</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('blog-posts.destroy', $post) }}" class="mt-5" onsubmit="return confirm('Изтриване на статията?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-link text-danger text-decoration-none p-0 small">Изтрий статията</button>
    </form>
@endsection
