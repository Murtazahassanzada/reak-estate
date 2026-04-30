<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','User Panel')</title>
<a href="{{ route('inbox') }}" class="nav-link position-relative">
    🔔 Inbox

    @if($unreadMessages > 0)
        <span class="badge bg-danger">
            {{ $unreadMessages }}
        </span>
    @endif
</a>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

    @stack('styles')
</head>
<body>

{{-- ✅ فقط محتوای صفحه --}}
@yield('content')

<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@stack('scripts')
</body>
</html>