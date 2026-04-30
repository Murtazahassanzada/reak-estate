<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', __('admin.meta.title'))</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Admin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Style.css') }}">

    @stack('styles')
</head>

<body>

    <!-- HEADER -->
    @include('partials.header-master')

    <!-- MAIN WRAPPER -->
    <div class="admin-layout">

        <!-- SIDEBAR -->
        @include('partials.adminsidebar')

        <!-- CONTENT -->
        <div class="admin-content">
            <main>
                @yield('content')
            </main>
        </div>

    </div>

    <!-- FOOTER -->
    @include('partials.footer')
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@stack('scripts')
</body>
</html>
