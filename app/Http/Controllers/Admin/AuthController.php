<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    // نمایش فرم Login
    public function showLogin()
    {
        return view('login');
    }

// =========================
// Show Register Form
// =========================
public function showRegister()
{
    return view('register');
}


// =========================
// Register User
// =========================
public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user'
    ]);

    Auth::login($user);

    return redirect()->route('user.panel');
}
// =========================
// Forgot Password Form
// =========================
public function forgotPassword()
{
    return view('forgot-password');
}


// =========================
// Send Reset Link
// =========================
public function sendResetLink(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email'
    ]);

    $token = Str::random(64);

    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $request->email],
        [
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]
    );

    return redirect()->route('password.reset', $token);
}


// =========================
// Reset Password Form
// =========================
public function resetPassword($token)
{
    return view('reset-password', compact('token'));
}


// =========================
// Update Password
// =========================
public function updatePassword(Request $request)
{
    $request->validate([
        'password' => 'required|min:6|confirmed'
    ]);

    $reset = DB::table('password_reset_tokens')
        ->where('token', $request->token)
        ->first();

    if(!$reset){
        return back()->withErrors(['token'=>'Token invalid']);
    }

    User::where('email', $reset->email)->update([
        'password' => Hash::make($request->password)
    ]);

    DB::table('password_reset_tokens')
        ->where('email',$reset->email)
        ->delete();

    return redirect()->route('login')
        ->with('success','Password changed successfully');
}
    // =========================
    // Login System (Admin/User)
    // =========================
/*public function login(Request $request)
{

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'role' => 'required'
    ]);


    if (Auth::attempt($request->only('email','password'))) {

        $request->session()->regenerate();

        $user = Auth::user();


        // تصمیم فقط بر اساس دیتابیس
        if (strtolower($user->role) === 'admin') {

            return redirect()->route('admin.dashboard');

        }

        if (strtolower($user->role) === 'user') {

            return redirect()->route('user.panel');

        }


        // اگر role ناشناخته بود
        Auth::logout();

        return back()->withErrors([
            'email' => 'Role not valid'
        ]);

    }


    return back()->withErrors([
        'email' => 'Email or Password incorrect'
    ]);

}*/
public function login(Request $request)
{
  //  dd(session()->getId());
  //  dd(Auth::check(), Auth::user(), session()->all());
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

if (Auth::attempt([
    'email' => $request->email,
    'password' => $request->password
])) {

        $request->session()->regenerate();

        $user = Auth::user();

     if (strtolower($user->role) === 'admin') {
    return redirect()->route('admin.dashboard');
}

if (strtolower($user->role) === 'user') {
    return redirect()->route('user.panel');
}

        Auth::logout();

        return back()->withErrors([
            'email' => 'Role not valid'
        ]);
    }

    return back()->withErrors([
        'email' => 'Email or Password incorrect'
    ]);
}


    // =========================
    // Logout
    // =========================
    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login'); // ✅ تغییر
}
   /* public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');

    }*/

}
