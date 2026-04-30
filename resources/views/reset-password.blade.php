<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">
<head>
<title>{{ __('auth.reset.title') }}</title>

@if(app()->getLocale() == 'fa')
<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.rtl.min.css') }}">
@else
<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
@endif

<link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

<style>
body[dir="rtl"] { text-align: right; }
</style>

</head>

<body>

<section class="login-page">
<div class="login-overlay">
<div class="login-card">

<h3 class="text-center mb-3">{{ __('auth.reset.title') }}</h3>

{{-- ERROR --}}
@if ($errors->any())
<div class="alert alert-danger">
    {{ __('auth.reset.error') }}
</div>
@endif

<form method="POST" action="{{ route('password.update') }}">
@csrf

<input type="hidden" name="token" value="{{ $token }}">

<!-- EMAIL -->
<div class="mb-3">
<input type="email" name="email"
class="form-control @error('email') is-invalid @enderror"
placeholder="{{ __('auth.reset.email') }}"
value="{{ old('email', request()->query('email')) }}" required>

@error('email')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<!-- PASSWORD -->
<div class="mb-3">
<input type="password" name="password"
class="form-control @error('password') is-invalid @enderror"
placeholder="{{ __('auth.reset.password') }}" required>

@error('password')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<!-- CONFIRM -->
<div class="mb-3">
<input type="password" name="password_confirmation"
class="form-control"
placeholder="{{ __('auth.reset.confirm') }}" required>
</div>

<button class="btn login-btn w-100">
{{ __('auth.reset.button') }}
</button>

</form>

<p class="text-center mt-3">
<a href="{{ route('login') }}">{{ __('auth.reset.back_login') }}</a>
</p>

</div>
</div>
</section>

<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>