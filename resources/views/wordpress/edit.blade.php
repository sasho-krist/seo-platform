@extends('layouts.app')

@section('title', 'WordPress')

@section('content')
    <div class="mb-4" style="max-width: 42rem;">
        <h1 class="h3 fw-semibold text-body">WordPress интеграция</h1>
        <p class="text-secondary small mb-0">REST API с Application Password (Потребители → профил → Пароли за приложения). Коренът е URL без <code class="small">/wp-admin</code>.</p>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 42rem;">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('wordpress.update') }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label small">Site URL</label>
                    <input name="site_url" type="url" required
                           value="{{ old('site_url', $connection->site_url ?? '') }}"
                           class="form-control" placeholder="https://example.com"/>
                </div>
                <div class="mb-3">
                    <label class="form-label small">Потребителско име (WP)</label>
                    <input name="username" type="text" required autocomplete="username"
                           value="{{ old('username', $connection->username ?? '') }}"
                           class="form-control"/>
                </div>
                <div class="mb-3">
                    <label class="form-label small">Application password</label>
                    <div class="input-group">
                        <input id="wp-app-password" name="app_password" type="password" autocomplete="new-password"
                               class="form-control" placeholder="{{ $connection ? 'Оставете празно за да запазите текущата' : 'Парола за приложение' }}"/>
                        <button type="button" class="btn btn-outline-secondary" data-password-toggle="wp-app-password">Покажи</button>
                    </div>
                </div>
                @error('wp')
                    <p class="small text-danger">{{ $message }}</p>
                @enderror
                <button type="submit" class="btn btn-primary">Запази връзката</button>
            </form>
        </div>
    </div>
@endsection
