<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

</head>

<body>

<section class="login-page">
  <div class="login-overlay">
    <div class="login-card">

  <h2 class="text-center mb-4">Sign Up</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
  @endif

  <form method="POST" action="{{ route('register.submit') }}">
    @csrf

    <div class="mb-3">
      <input type="text" name="name" class="form-control"
             placeholder="Full Name" required>
    </div>

    <div class="mb-3">
      <input type="email" name="email" class="form-control"
             placeholder="Email" required>
    </div>

    <div class="mb-3">
      <input type="password" name="password" class="form-control"
             placeholder="Password" required>
    </div>

    <div class="mb-3">
      <input type="password" name="password_confirmation"
             class="form-control"
             placeholder="Confirm Password" required>
    </div>

    <button type="submit" class="btn login-btn w-100">
      Register
    </button>

  </form>

  <p class="text-center mt-3">
    <a href="{{ route('login') }}">Back to Login</a>
  </p>

</div>
  </div>
</section>

</body>
</html>
