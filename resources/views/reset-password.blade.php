<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>

<body>

<section class="login-page">
<div class="login-overlay">
<div class="login-card">

<h3 class="text-center mb-3">Reset Password</h3>

<form method="POST" action="{{ route('password.update') }}">
@csrf

<input type="hidden" name="token" value="{{ $token }}">

<div class="mb-3">
<input type="password" name="password"
class="form-control" placeholder="New Password" required>
</div>

<div class="mb-3">
<input type="password" name="password_confirmation"
class="form-control" placeholder="Confirm Password" required>
</div>

<button class="btn login-btn w-100">
Update Password
</button>

</form>

</div>
</div>
</section>

</body>
</html>
