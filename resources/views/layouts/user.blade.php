<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','User Panel')</title>

    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

    @stack('styles')
</head>
<body>

{{-- ✅ فقط محتوای صفحه --}}
@yield('content')

<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@include('partials.footer')
@stack('scripts')
</body>
</html>
