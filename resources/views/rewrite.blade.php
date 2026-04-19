@extends('layouts.app')

@section('title', 'Преформулиране')

@section('content')
    <div class="mb-4" style="max-width: 48rem;">
        <h1 class="h3 fw-semibold text-body">AI подобрение на текст</h1>
        <p class="text-secondary small mb-0">Опишете как искате да пренапишете съдържанието (по-кратко, по-продажно, по-формално и т.н.).</p>
    </div>

    @if (! $aiConfigured)
        <div class="alert alert-warning small" style="max-width: 48rem;">Задайте <code>OPENAI_API_KEY</code> в .env.</div>
    @else
        <form method="POST" action="{{ route('rewrite.update') }}" style="max-width: 48rem;">
            @csrf
            <div class="mb-3">
                <label class="form-label small">Инструкция</label>
                <input name="instruction" type="text" value="{{ old('instruction', $instruction) }}" required
                       class="form-control" placeholder="Напр. Направи текста по-кратък и с ясен CTA"/>
            </div>
            <div class="mb-3">
                <label class="form-label small">Език</label>
                <input name="language" type="text" value="{{ old('language', 'bg') }}" class="form-control"/>
            </div>
            <div class="mb-3">
                <label class="form-label small">Текст</label>
                <textarea name="text" rows="12" required class="form-control">{{ old('text', $inputText) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Подобри</button>
        </form>

        @if (! empty($error))
            <p class="mt-4 text-danger small">{{ $error }}</p>
        @endif

        @if (! empty($result))
            <div class="mt-5 card border border-primary border-opacity-25 bg-primary bg-opacity-10" style="max-width: 48rem;">
                <div class="card-body p-4">
                    <h2 class="small fw-semibold text-body mb-3">Резултат</h2>
                    <div class="text-body small lh-base pre-wrap">{{ $result }}</div>
                </div>
            </div>
        @endif
    @endif
@endsection
