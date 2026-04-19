@extends('layouts.auth')

@section('title', 'Регистрация')

@section('meta_description', 'Създайте безплатен акаунт в '.config('app.name').' — AI и SEO инструменти за агенции и блогъри.')

@section('content')
<div class="card shadow border-0" style="max-width: 28rem; width: 100%;">
    <div class="card-body p-4 p-md-5">
        <h1 class="h4 fw-semibold text-body">Регистрация</h1>
        <p class="small text-secondary mb-4">Създайте акаунт за платформата.</p>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small">Име</label>
                <input name="name" type="text" value="{{ old('name') }}" required autofocus class="form-control"/>
            </div>
            <div class="mb-3">
                <label class="form-label small">Имейл</label>
                <input name="email" type="email" value="{{ old('email') }}" required autocomplete="username" class="form-control"/>
            </div>
            <div class="mb-3">
                <label class="form-label small">Парола</label>
                <div class="input-group">
                    <input id="register-password" name="password" type="password" required autocomplete="new-password" class="form-control"/>
                    <button type="button" class="btn btn-outline-secondary" data-password-toggle="register-password">Покажи</button>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label small">Потвърди парола</label>
                <div class="input-group">
                    <input id="register-password-confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="form-control"/>
                    <button type="button" class="btn btn-outline-secondary" data-password-toggle="register-password-confirmation">Покажи</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Регистрирай се</button>
        </form>
        <p class="small text-secondary text-center mt-4 mb-0">
            Вече имате акаунт?
            <a href="{{ route('login') }}" class="link-primary fw-medium">Вход</a>
        </p>
    </div>
</div>
@endsection
