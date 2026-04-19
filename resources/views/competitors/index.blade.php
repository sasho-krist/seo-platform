@extends('layouts.app')

@section('title', 'Конкурентни анализи')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-4">
        <div>
            <h1 class="h3 fw-semibold text-body">Конкурентни анализи</h1>
            <p class="text-secondary small mb-0">Сравнение на страници по съдържание чрез AI.</p>
        </div>
        <a href="{{ route('competitors.create') }}" class="btn btn-primary">Нов анализ</a>
    </div>

    <div class="list-group shadow-sm">
        @forelse ($items as $item)
            <a href="{{ route('competitors.show', $item) }}" class="list-group-item list-group-item-action py-3">
                <div class="fw-medium text-truncate">{{ $item->your_url }}</div>
                <div class="small text-secondary text-truncate mt-1">vs {{ $item->competitor_url }}</div>
            </a>
        @empty
            <div class="list-group-item py-5 text-center text-secondary small">Все още няма анализи.</div>
        @endforelse
    </div>
    <div class="mt-4">{{ $items->links() }}</div>
@endsection
