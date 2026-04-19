@extends('layouts.auth')

@section('title', 'Вход')

@section('meta_description', 'Вход в '.config('app.name').' — AI SEO платформа за съдържание и маркетинг.')

@section('content')
<div class="card shadow border-0" style="max-width: 28rem; width: 100%;">
    <div class="card-body p-4 p-md-5">
        <h1 class="h4 fw-semibold text-body">Вход</h1>
        <p class="small text-secondary mb-4">{{ config('app.name') }}</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small">Имейл</label>
                <input name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="form-control"/>
            </div>
            <div class="mb-3">
                <label class="form-label small">Парола</label>
                <div class="input-group">
                    <input id="login-password" name="password" type="password" required autocomplete="current-password"
                           class="form-control"/>
                    <button type="button" class="btn btn-outline-secondary" data-password-toggle="login-password" aria-pressed="false">Покажи</button>
                </div>
            </div>
            <div class="mb-4 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label small" for="remember">Запомни ме</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Влез</button>
        </form>
        <p class="small text-secondary text-center mt-4 mb-0">
            Нямате акаунт?
            <a href="{{ route('register') }}" class="link-primary fw-medium">Регистрация</a>
        </p>
    </div>
</div>
@endsection
