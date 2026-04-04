<!DOCTYPE html>

<html>
<head>
    <title>Login</title>

```
<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
```

</head>

<body>

<section class="login-page">
  <div class="login-overlay">
    <div class="login-card">

```
  <h2 class="text-center mb-4">Welcome Back</h2>

  {{-- Error Message --}}
  @if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
  @endif

  <form method="POST" action="{{ route('login.submit') }}">
    @csrf

    <div class="mb-3">
      <input
        type="email"
        name="email"
        class="form-control"
        placeholder="Email"
        value="{{ old('email') }}"
        required>
    </div>

    <div class="mb-3">
      <input
        type="password"
        name="password"
        class="form-control"
        placeholder="Password"
        required>
    </div>

    <div class="mb-3">
      <select name="role" class="form-control" required>
        <option value="">Login As</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
      </select>
    </div>

    <button type="submit" class="btn login-btn w-100">
      Login
    </button>

  </form>

  <p class="text-center mt-3">
    <a href="{{ route('password.request') }}">Forgot password?</a>
    <a href="{{ route('register') }}">Sign Up</a>
  </p>

</div>
```

  </div>
</section>

<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/js/login.js') }}"></script>

</body>
</html>
