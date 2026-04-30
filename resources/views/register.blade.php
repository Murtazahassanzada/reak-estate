<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <title>{{ __('auth.register.title') }}</title>

    <!-- Bootstrap -->
    @if(app()->getLocale() == 'fa')
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.rtl.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    @endif

    <!-- Shared Auth CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

    <style>
        body[dir="rtl"] { text-align: right; }
    </style>
</head>

<body>

<section class="login-page">
  <div class="login-overlay">
    <div class="login-card">

      <h2 class="text-center mb-4">{{ __('auth.register.title') }}</h2>

      {{-- GLOBAL ERROR --}}
      @if ($errors->any())
        <div class="alert alert-danger">
            {{ __('auth.register.error') }}
        </div>
      @endif

      <form id="registerForm" method="POST" action="{{ route('register.submit') }}">
        @csrf

        <!-- NAME -->
        <div class="mb-3">
          <input type="text"
                 name="name"
                 class="form-control @error('name') is-invalid @enderror"
                 placeholder="{{ __('auth.register.name') }}"
                 value="{{ old('name') }}"
                 required>

          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- EMAIL -->
        <div class="mb-3">
          <input type="email"
                 name="email"
                 class="form-control @error('email') is-invalid @enderror"
                 placeholder="{{ __('auth.register.email') }}"
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
                 placeholder="{{ __('auth.register.password') }}"
                 required>

          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="mb-3">
          <input type="password"
                 name="password_confirmation"
                 class="form-control"
                 placeholder="{{ __('auth.register.confirm_password') }}"
                 required>
        </div>

        <button type="submit" class="btn login-btn w-100">
          {{ __('auth.register.button') }}
        </button>

      </form>

      <p class="text-center mt-3">
        <a href="{{ route('login') }}">{{ __('auth.register.back_login') }}</a>
      </p>

    </div>
  </div>
</section>

<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/register.js') }}"></script>

</body>
</html>