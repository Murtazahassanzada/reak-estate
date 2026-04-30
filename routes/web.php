<?php
use App\Http\Controllers\Api\NotificationApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Front\PropertyFrontController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\User\PropertyController as UserPropertyController;
 // ✅ اضافه شد

// =======================
// Login (Global)
// =======================
Route::post('/contact', [ContactController::class, 'submit'])
    ->middleware('throttle:5,1') // فقط 5 درخواست در 1 دقیقه
    ->name('contact.submit');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// =======================
// Register
// =======================
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// =======================
// Logout
// =======================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =======================
// Forgot Password
// =======================
Route::get('/forgot-password', [AuthController::class,'forgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class,'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class,'resetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class,'updatePassword'])->name('password.update');

// =======================
// Admin Routes
// =======================
Route::prefix('admin')->middleware(['auth','admin'])->group(function () {







        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

        Route::resource('properties', PropertyController::class);

        Route::get('properties-trash',[PropertyController::class,'trash'])->name('properties.trash');
        Route::get('properties-restore/{id}',[PropertyController::class,'restore'])->name('properties.restore');

        Route::delete('properties-force-delete/{id}', [PropertyController::class,'forceDelete'])
            ->name('properties.force.delete');

        Route::resource('users', UserController::class);

        Route::get('report', [ReportController::class, 'index'])->name('admin.report');
        Route::post('properties/{property}/approve', [PropertyController::class, 'approve'])
    ->name('properties.approve');

Route::post('properties/{property}/reject', [PropertyController::class, 'reject'])
    ->name('properties.reject');
    });



// =======================
// User Routes
// =======================
Route::middleware(['auth','user'])->group(function () {

    Route::get('/user', [PropertyFrontController::class, 'index'])
        ->name('user.panel');

    Route::post('/user/property', [PropertyFrontController::class, 'store'])
        ->name('user.property.store');

    Route::put('/user/property/{property}', [PropertyFrontController::class, 'update'])
        ->name('user.property.update');

    Route::delete('/user/property/{property}', [PropertyFrontController::class, 'destroy'])
        ->name('user.property.delete');

    // ======================
    // Phase 3 (Images system)
    // ======================
    Route::delete('/user/property-image/{id}', [PropertyFrontController::class,'deleteImage'])
        ->name('user.property.image.delete');

    Route::post('/user/property-image/{id}/main', [PropertyFrontController::class,'setMainImage'])
        ->name('user.property.image.main');

    Route::post('/user/property-images/reorder', [PropertyFrontController::class,'reorderImages'])
        ->name('user.property.images.reorder');
});

// =======================
// Property Front
// =======================
Route::get('/properties', [PropertyFrontController::class, 'properties'])->name('user.properties');

Route::get('/property/{id}', [PropertyFrontController::class,'show'])->name('property.view');

Route::get('/compare-properties', [PropertyFrontController::class, 'compare'])
    ->middleware(['auth'])
    ->name('property.compare');

Route::get('/search-properties', [PropertyFrontController::class, 'search'])
    ->name('property.search');

// =======================
// Front Pages
// =======================
Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', [PropertyFrontController::class, 'dashboard'])->name('dashboard');

Route::get('/about', fn() => view('about'));
Route::get('/contact', fn() => view('contact'));
//Route::get('/view', fn() => view('view'));

Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'fa'])) abort(400);

    session()->put('locale', $locale);
    return redirect()->back();
})->name('lang');

// =======================
// Favorites & Contact
// =======================
Route::post('/property/{id}/save', [FavoriteController::class,'store'])
    ->middleware('auth')
    ->name('property.save');

Route::post('/property/{id}/contact', [MessageController::class,'send'])
    ->middleware('auth')
    ->name('property.contact');

// =======================
// Property Image Delete
// =======================
Route::delete('/property-image/{id}', [PropertyController::class,'deleteImage'])
    ->name('property.image.delete');

// =======================
// Inbox (Messages) ✅ تغییر نام
// =======================
Route::middleware(['auth'])->group(function () {

    Route::get('/messages', function () {

        $messages = \App\Models\Message::with(['sender','property'])
            ->where('receiver_id', auth()->id())
            ->latest()
            ->get();

        return view('inbox', compact('messages'));

    })->name('messages.inbox'); // ✅ تغییر نام شد

});

// =======================
// Notifications (Inbox اصلی)
Route::middleware(['auth'])->group(function () {

    Route::get('/inbox', [NotificationController::class, 'index'])
        ->name('inbox');

    Route::post('/notification/{id}/read-ajax', [NotificationController::class, 'readAjax'])
        ->name('notification.read.ajax');

    Route::get('/notifications/fetch', [NotificationController::class, 'fetch']);
Route::post('/notifications/mark-all', [NotificationController::class,'markAll']);
});

