<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','User Panel')</title>

    @if(app()->getLocale() == 'en')
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.rtl.min.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @stack('styles')
</head>
<body class="user-dashboard"
      dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">

@include('partials.header-master')

@yield('content')

@include('partials.footer')

<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@stack('scripts')
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
            {{ app()->getLocale() == 'fa' ? 'تأیید خروج' : 'Confirm Logout' }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <p>
            {{ app()->getLocale() == 'fa'
                ? 'آیا مطمئن هستید که می‌خواهید از سیستم خارج شوید؟'
                : 'Are you sure you want to logout?' }}
        </p>
      </div>

      <div class="modal-footer justify-content-center">

        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            {{ app()->getLocale() == 'fa' ? 'انصراف' : 'Cancel' }}
        </button>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">
                {{ app()->getLocale() == 'fa' ? 'بله، خروج' : 'Yes, Logout' }}
            </button>
        </form>

      </div>

    </div>

  </div>
</div>
</body>
</html>

