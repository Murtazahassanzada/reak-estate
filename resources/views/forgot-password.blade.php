<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>

<body>

<section class="login-page">
<div class="login-overlay">
<div class="login-card">

<h3 class="text-center mb-3">Forgot Password</h3>

<form method="POST" action="{{ route('password.email') }}">
@csrf

<div class="mb-3">
<input type="email" name="email" class="form-control"
placeholder="Enter your email" required>
</div>

<button class="btn login-btn w-100">
Send Reset Link
</button>

</form>

</div>
</div>
</section>

</body>
</html>
