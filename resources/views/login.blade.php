<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <title>{{ __('auth.login.title') }}</title>

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

      <h2 class="text-center mb-4">{{ __('auth.login.welcome') }}</h2>

      {{-- GLOBAL ERROR --}}
      @if ($errors->any())
        <div class="alert alert-danger">
            {{ __('auth.login.error') }}
        </div>
      @endif

     <form id="loginForm" method="POST" action="{{ route('login.submit') }}">
        @csrf

        <!-- EMAIL -->
        <div class="mb-3">
          <input type="email"
       name="email"
       dir="ltr"
       class="form-control text-start @error('email') is-invalid @enderror"
       placeholder="{{ __('auth.login.email') }}"
       value="{{ old('email') }}"
       required>

          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- PASSWORD -->
        <div class="mb-3">
          <input type="password"
                 name="password"
                 class="form-control @error('password') is-invalid @enderror"
                 placeholder="{{ __('auth.login.password') }}"
                 required>

          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- ROLE -->
        <div class="mb-3">
          <select name="role"
                  class="form-control @error('role') is-invalid @enderror"
                  required>

            <option value="">{{ __('auth.login.login_as') }}</option>
            <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>
                {{ __('auth.login.admin') }}
            </option>
            <option value="user" {{ old('role')=='user' ? 'selected' : '' }}>
                {{ __('auth.login.user') }}
            </option>
          </select>

          @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- REMEMBER -->
        <div class="mb-3 form-check">
          <input type="checkbox" name="remember" class="form-check-input">
          <label class="form-check-label">
            {{ __('auth.login.remember') }}
          </label>
        </div>

        <button type="submit" class="btn login-btn w-100">
          {{ __('auth.login.button') }}
        </button>

      </form>

      <p class="text-center mt-3">
        <a href="{{ route('password.request') }}">{{ __('auth.login.forgot') }}</a><br>
        <a href="{{ route('register') }}">{{ __('auth.login.signup') }}</a>
      </p>

    </div>
  </div>
</section>

<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
