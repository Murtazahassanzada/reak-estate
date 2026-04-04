<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Front\PropertyFrontController;

// =======================
// Login (Global)
// =======================
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');
// =======================
// Register
// =======================
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.submit');
// =======================
// Logout (Global)
// =======================
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// =======================
// Forgot Password
// =======================
Route::get('/forgot-password', [AuthController::class,'forgotPassword'])
    ->name('password.request');

Route::post('/forgot-password', [AuthController::class,'sendResetLink'])
    ->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class,'resetPassword'])
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class,'updatePassword'])
    ->name('password.update');
// =======================
// Admin Routes
// =======================
Route::prefix('admin')->group(function () {

    // فقط Admin
    Route::middleware(['auth','admin'])->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::post('logout', [AuthController::class, 'logout'])
            ->name('admin.logout');

        Route::resource('properties', PropertyController::class);

        // TRASH ROUTES
        Route::get('properties-trash',[PropertyController::class,'trash'])
            ->name('properties.trash');

        Route::get('properties-restore/{id}',[PropertyController::class,'restore'])
            ->name('properties.restore');

        Route::delete('properties-force-delete/{id}',
            [PropertyController::class,'forceDelete'])
            ->name('properties.force.delete');

        Route::resource('users', UserController::class);

        Route::get('report', [ReportController::class, 'index'])
            ->name('admin.report');
    });

});


// =======================
// User Routes
// =======================
Route::middleware(['auth','user'])->group(function () {

    Route::get('/user', [PropertyFrontController::class, 'index'])
        ->name('user.panel');

});


// =======================
// Property Front (Public)
// =======================
Route::get('/properties', [PropertyFrontController::class, 'properties'])
    ->name('user.properties');

//Route::get('/properties/{id}', [PropertyFrontController::class, 'show'])
  //  ->name('property.view');
Route::get('/properties/{id}', [PropertyFrontController::class, 'show'])
    ->middleware(['auth'])
    ->name('property.view');

/*Route::get('/compare-properties', [PropertyFrontController::class, 'compare'])
    ->name('property.compare');*/
    Route::get('/compare-properties', [PropertyFrontController::class, 'compare'])
    ->middleware(['auth'])
    ->name('property.compare');

Route::get('/search-properties', [PropertyFrontController::class, 'search'])
    ->name('property.search');


// =======================
// Front Pages
// =======================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PropertyFrontController::class, 'dashboard'])
    ->name('dashboard');

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/view', function () {
    return view('view');
});

Route::get('/compare', function () {
    return view('compare');
});


// حذف تصویر property
Route::delete('/property-image/{id}', [PropertyController::class,'deleteImage'])
    ->name('property.image.delete');
