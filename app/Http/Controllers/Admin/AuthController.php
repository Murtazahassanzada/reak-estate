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
    $validated = $request->validate([
        'name' => ['required','string','max:100'],
        'email' => ['required','email','unique:users,email'],
        'password' => ['required','min:6','confirmed'],
    ]);

    // ✅ ساخت user
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'user', // default
    ]);

    // ✅ auto login
    auth()->login($user);

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
        'email' => ['required','email','exists:users,email']
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

    // 🔥 مستقیم redirect (بدون ایمیل)
    return redirect()->route('password.reset', [
        'token' => $token,
        'email' => $request->email
    ]);
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
    // ✅ validation کامل
    $request->validate([
        'email' => ['required','email'],
        'password' => ['required','min:6','confirmed'],
        'token' => ['required']
    ]);

    // ✅ پیدا کردن رکورد
    $reset = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->where('token', $request->token)
        ->first();

    // ❌ اگر پیدا نشد
    if(!$reset){
        return back()->withErrors([
            'email' => 'Token or email invalid'
        ]);
    }

    // ✅ اپدیت پسورد
    User::where('email', $request->email)->update([
        'password' => Hash::make($request->password)
    ]);

    // ✅ حذف توکن
    DB::table('password_reset_tokens')
        ->where('email', $request->email)
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
    $credentials = $request->validate([
        'email' => ['required','email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        $user = Auth::user();

        $role = strtolower(trim($user->role));

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'user') {
            return redirect()->route('user.panel');
        }

        Auth::logout();
        return back()->withErrors(['email' => 'Invalid role']);
    }

    return back()->withErrors([
        'email' => 'Email or password incorrect'
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

    return redirect('/');
}
   /* public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');

    }*/

}
