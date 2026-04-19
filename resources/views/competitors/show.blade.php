@extends('layouts.app')

@section('title', 'Конкурентен анализ')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-semibold text-body">Конкурентен анализ</h1>
        <p class="small text-secondary mb-0 text-break">{{ $item->your_url }} · {{ $item->created_at->diffForHumans() }}</p>
    </div>

    <div class="d-flex flex-column gap-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="small text-uppercase text-primary fw-semibold mb-3">AI резюме</h2>
                <div class="text-body small lh-base pre-wrap">{{ $item->analysis }}</div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card border bg-light h-100">
                    <div class="card-body">
                        <h3 class="small text-uppercase text-secondary mb-2">Ваш извадок</h3>
                        <p class="small text-secondary mb-0 lh-sm">{{ \Illuminate\Support\Str::limit($item->your_excerpt, 1200) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border bg-light h-100">
                    <div class="card-body">
                        <h3 class="small text-uppercase text-secondary mb-2">Конкурент извадок</h3>
                        <p class="small text-secondary mb-0 lh-sm">{{ \Illuminate\Support\Str::limit($item->competitor_excerpt, 1200) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
