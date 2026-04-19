@extends('layouts.app')

@section('title', 'Профил')

@section('meta_description', 'Профил и настройки на акаунта в '.config('app.name').'.')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-semibold text-body">Профил</h1>
        <p class="text-secondary small mb-0">Управление на името, снимка, парола и акаунт.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    @if ($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="" width="120" height="120" class="rounded-circle object-fit-cover mb-3 border border-light shadow-sm" style="object-fit: cover;"/>
                    @else
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center fw-semibold mb-3 border border-primary border-opacity-25 mx-auto" style="width: 120px; height: 120px; font-size: 2.5rem;">
                            {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" class="d-flex flex-column gap-2">
                        @csrf
                        <label class="form-label small text-start mb-0">Нова снимка (JPG, PNG, WebP — до 2 MB)</label>
                        <input type="file" name="avatar" accept="image/jpeg,image/png,image/gif,image/webp" class="form-control form-control-sm" required/>
                        <button type="submit" class="btn btn-primary btn-sm">Качи</button>
                    </form>

                    @if ($user->avatar_path)
                        <form method="POST" action="{{ route('profile.avatar.destroy') }}" class="mt-3" onsubmit="return confirm('Премахване на снимката?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-secondary btn-sm">Премахни снимката</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8 d-flex flex-column gap-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h6 text-uppercase text-primary fw-semibold mb-3">Име</h2>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label small">Показвано име</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-control" maxlength="255"/>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Запази името</button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h6 text-uppercase text-primary fw-semibold mb-3">Смяна на парола</h2>
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label small">Текуща парола</label>
                            <div class="input-group">
                                <input id="profile-current-password" name="current_password" type="password" required autocomplete="current-password" class="form-control"/>
                                <button type="button" class="btn btn-outline-secondary" data-password-toggle="profile-current-password">Покажи</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Нова парола</label>
                            <div class="input-group">
                                <input id="profile-password" name="password" type="password" required autocomplete="new-password" class="form-control"/>
                                <button type="button" class="btn btn-outline-secondary" data-password-toggle="profile-password">Покажи</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Потвърди новата парола</label>
                            <input name="password_confirmation" type="password" required autocomplete="new-password" class="form-control"/>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Смени паролата</button>
                    </form>
                </div>
            </div>

            <div class="card border border-danger border-opacity-25 bg-danger bg-opacity-10">
                <div class="card-body p-4">
                    <h2 class="h6 text-danger fw-semibold mb-2">Опасна зона</h2>
                    <p class="small text-secondary mb-3">Изтриването на акаунта е необратимо: статии, анализи, ключови списъци и настройки се премахват заедно с профила.</p>
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Изтрий акаунта</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h2 class="modal-title h5 fw-semibold" id="deleteAccountModalLabel">Потвърди изтриване</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Затвори"></button>
                </div>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body pt-0">
                        <p class="small text-secondary">Въведете текущата си парола, за да изтриете акаунта завинаги.</p>
                        <label class="form-label small">Парола</label>
                        <div class="input-group">
                            <input id="delete-account-password" name="password" type="password" required class="form-control" autocomplete="current-password"/>
                            <button type="button" class="btn btn-outline-secondary" data-password-toggle="delete-account-password">Покажи</button>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Отказ</button>
                        <button type="submit" class="btn btn-danger">Изтрий завинаги</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
