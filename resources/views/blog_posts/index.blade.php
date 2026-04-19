@extends('layouts.app')

@section('title', 'Блог статии')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
        <div>
            <h1 class="h3 fw-semibold text-body">Блог статии</h1>
            <p class="text-secondary small mb-0">Управление на чернови и публикации.</p>
        </div>
        <a href="{{ route('blog-posts.create') }}" class="btn btn-primary">Нова статия</a>
    </div>

    <div class="list-group shadow-sm">
        @forelse ($posts as $post)
            <a href="{{ route('blog-posts.show', $post) }}" class="list-group-item list-group-item-action py-3">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <div class="fw-medium">{{ $post->title }}</div>
                        <div class="small text-secondary mt-1">{{ $post->language }} · {{ $post->status }} · {{ $post->updated_at->diffForHumans() }}</div>
                    </div>
                    <span class="small text-primary">→</span>
                </div>
            </a>
        @empty
            <div class="list-group-item py-5 text-center text-secondary small">Все още няма статии. Създайте първата.</div>
        @endforelse
    </div>
    <div class="mt-4">{{ $posts->links() }}</div>
@endsection
