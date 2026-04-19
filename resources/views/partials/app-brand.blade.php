<a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none mb-3 px-1">
    <img src="{{ asset('images/logo.svg') }}" width="40" height="40" alt="" class="flex-shrink-0 rounded-3 shadow-sm" style="max-width: none;"/>
    <span class="fw-semibold lh-sm text-start app-sidebar-brand-title">{{ config('app.name') }}</span>
</a>
<div class="small text-truncate px-1 mb-0 app-sidebar-email" title="{{ auth()->user()->email }}">{{ auth()->user()->email }}</div>
