<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">
<head>
<title>{{ __('auth.forgot.title') }}</title>

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

<h3 class="text-center mb-3">{{ __('auth.forgot.title') }}</h3>

{{-- SUCCESS --}}
@if(session('status'))
<div class="alert alert-success">
    {{ __('auth.forgot.sent') }}
</div>
@endif

{{-- ERROR --}}
@if ($errors->any())
<div class="alert alert-danger">
    {{ __('auth.forgot.error') }}
</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
@csrf

<div class="mb-3">
<input type="email"
       name="email"
       class="form-control @error('email') is-invalid @enderror"
       placeholder="{{ __('auth.forgot.email') }}"
       value="{{ old('email') }}"
       required>

@error('email')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<button class="btn login-btn w-100">
{{ __('auth.forgot.button') }}
</button>

</form>

<p class="text-center mt-3">
<a href="{{ route('login') }}">{{ __('auth.forgot.back_login') }}</a>
</p>

</div>
</div>
</section>

<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>