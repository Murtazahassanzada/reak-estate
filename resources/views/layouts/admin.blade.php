<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>
  @yeild('title','Admin Panel')</title>

  <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/font/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/Admin.css') }}">

  @stack('styles') 
  {{-- ✅ این خیلی مهم --}}
</head>
<body>

@include('partials.admin-header')

<div class="container-fluid">
  <div class="row">

    @include('partials.admin-sidebar')

    <main class="col-md-10 p-4">
      @yield('content')
    </main>

  </div>
</div>

@include('partials.footer')

<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/Admin.js') }}"></script>
<script>
const logoutBtn = document.getElementById('logoutBtn');
if (logoutBtn) {
  logoutBtn.addEventListener('click', function(e){
      e.preventDefault();
      var myModal = new bootstrap.Modal(document.getElementById('logoutModal'));
      myModal.show();
  });
}
</script>
@stack('scripts')
</body>
</html>
