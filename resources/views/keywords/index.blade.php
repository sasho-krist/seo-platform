@extends('layouts.app')

@section('title', 'Ключови думи')

@section('meta_description', 'Генериране на SEO ключови думи с AI за '.config('app.name').'.')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-semibold text-body">Ключови предложения</h1>
        <p class="text-secondary small mb-0">AI генерира списък според тема или контекст.</p>
    </div>

    <div class="card border-0 shadow-sm mb-5" style="max-width: 48rem;">
        <div class="card-body p-4">
            @if (! $aiConfigured)
                <div class="alert alert-warning mb-0 small">Задайте <code class="small">OPENAI_API_KEY</code> в .env.</div>
            @else
                <form method="POST" action="{{ route('keywords.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small">Тема (по избор)</label>
                        <input name="seed_topic" type="text" value="{{ old('seed_topic') }}"
                               class="form-control" placeholder="Напр. локално SEO за кафенета"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Контекст / чернов текст (по избор)</label>
                        <textarea name="seed_text" rows="5" class="form-control">{{ old('seed_text') }}</textarea>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label small">Език</label>
                            <input name="language" type="text" value="{{ old('language', 'bg') }}" class="form-control"/>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small">Свързана статия (по избор)</label>
                            <select name="blog_post_id" class="form-select">
                                <option value="">—</option>
                                @foreach ($posts as $p)
                                    <option value="{{ $p->id }}" @selected((string) old('blog_post_id') === (string) $p->id)>{{ $p->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Генерирай ключови думи</button>
                </form>
            @endif
        </div>
    </div>

    <div>
        <h2 class="h5 fw-semibold text-body mb-3">Последни списъци</h2>
        <div class="d-flex flex-column gap-3">
            @forelse ($history as $row)
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="small text-secondary mb-2">
                            {{ $row->created_at->diffForHumans() }}
                            @if($row->seed_topic) · {{ $row->seed_topic }} @endif
                            @if($row->blogPost)
                                · <span class="text-body">Статия:</span>
                                <a href="{{ route('blog-posts.show', $row->blogPost) }}" class="link-secondary">{{ $row->blogPost->title }}</a>
                            @endif
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($row->keywords as $kw)
                                <span class="badge rounded-pill text-bg-light border">{{ $kw }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <p class="small text-secondary mb-0">Няма записани резултати.</p>
            @endforelse
        </div>
    </div>
@endsection
