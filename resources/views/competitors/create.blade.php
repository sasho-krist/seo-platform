@extends('layouts.app')

@section('title', 'Нов конкурентен анализ')

@section('content')
    <div class="mb-4" style="max-width: 42rem;">
        <h1 class="h3 fw-semibold text-body">Нов конкурентен анализ</h1>
        <p class="text-secondary small mb-0">Извличаме видим текст от двете страници и генерираме SEO сравнение с AI.</p>
    </div>

    @if (! $aiConfigured)
        <div class="alert alert-warning small" style="max-width: 42rem;">Задайте <code>OPENAI_API_KEY</code> в .env.</div>
    @else
        <div class="card border-0 shadow-sm" style="max-width: 42rem;">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('competitors.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small">Вашата страница (URL)</label>
                        <input name="your_url" type="url" value="{{ old('your_url') }}" required class="form-control"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Конкурентна страница (URL)</label>
                        <input name="competitor_url" type="url" value="{{ old('competitor_url') }}" required class="form-control"/>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small">Език на анализа</label>
                        <input name="language" type="text" value="{{ old('language', 'bg') }}" class="form-control"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Стартирай анализ</button>
                </form>
            </div>
        </div>
    @endif
@endsection
