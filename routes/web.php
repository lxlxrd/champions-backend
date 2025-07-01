<?php


use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\SeasonController as AdminSeasonController;
use App\Http\Controllers\Admin\AgeCategoryController as AdminAgeCategoryController;
use App\Http\Controllers\Admin\PlayerController as AdminPlayerController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\AdminAuthController as AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

Route::get('/check-admin', function () {
    return response()->json([
        'admin' => Auth::guard('admin')->check(),
        'web' => Auth::guard('web')->check(),
        'default' => Auth::check(), // ce qu’utilise Laravel par défaut sur la requête
        'user' => Auth::user(),     // utilisateur courant pour ce guard
    ]);
});


// Route::middleware('web')->group(function () {
//     Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
// });

// Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
// Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


// mot de passe oublié
Route::get('/forgot-password', function () {
    return view('admin.auth.forgot-password');
})->middleware('guest')->name('password.request');


// Affiche le formulaire avec le token dans l'URL
Route::get('/reset-password/{token}', function ($token) {
    return view('admin.auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');



Route::get('/admin/email/verify', function () {
    $user = Auth::guard('admin')->user();

    return view('new.admin.verify-email', [
        'user' => $user,
        'verification_link' => URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->getEmailForVerification()), // ok
            ]
        ),
        'app_name' => config('app.name'),
    ]);
})->middleware('auth:admin')->name('admin.verification.notice');


// Patch global pour éviter toute erreur de redirection vers route('login')
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/create', [AdminAuthController::class, 'form']);
    Route::post('/admin/create', [AdminAuthController::class, 'store']);
});

Route::middleware('auth:admin')
    ->prefix('administration')
    ->name('admin.')
    ->group(function () {


        // Dashboard devient "admin.home"
        Route::get('/', [AdminController::class, 'dashboard'])
            ->name('home');



        Route::controller(AdminSeasonController::class)
            ->prefix('seasons')
            ->name('season.')
            ->group(function () {
                Route::get('list', 'index')->name('index');
                Route::get('archived', 'archived')->name('archived');
                Route::post('{season}/archive', 'archive')->name('archive');
                Route::post('', 'store')->name('store');
                Route::put('{id}', 'update')->name('update');
                Route::delete('/season/{id}', [AdminSeasonController::class, 'destroy'])
                    ->name('destroy');
            });


        /**
         *  CRUD age-categories → "admin.age-categories .
         */

        Route::controller(AdminAgeCategoryController::class)
            ->prefix('age-categories')
            ->name('age-category.')
            ->group(function () {
                Route::get('list', 'index')->name('index');
                Route::post('', [AdminAgeCategoryController::class, 'store'])->name('store');
                Route::put('{id}', 'update')->name('update');
                Route::delete('/age-category/{id}', [AdminAgeCategoryController::class, 'destroy'])
                    ->name('destroy');
            });




        Route::controller(AdminRegistrationController::class)
            ->prefix('registrations')
            ->name('registration.')
            ->group(function () {
                Route::get('list', 'index')->name('index');
                Route::get('archived', 'archived')->name('archived');
                Route::post('{registration}/archive', 'archive')->name('archive');
                Route::put('{id}', 'update')->name('update');

                Route::post('{registration}/validate', 'validate')->name('validate');
                Route::post('{registration}/reject', 'cancel')->name('reject');
                Route::delete('/{id}', [AdminRegistrationController::class, 'destroy'])
                    ->name('destroy');
            });


        Route::controller(AdminPlayerController::class)
            ->prefix('players')
            ->name('player.')
            ->group(function () {
                Route::get('list', 'index')->name('index');
                Route::get('list', 'index')->name('index');
                Route::put('{id}', 'update')->name('update');
                Route::delete('/{id}', [AdminPlayerController::class, 'destroy'])
                    ->name('destroy');
            });


        Route::controller(AdminPostController::class)
            ->prefix('posts')
            ->name('post.')
            ->group(function () {
                Route::get('list', 'index')->name('index');
                Route::post('', 'store')->name('store');
                Route::put('{id}', [AdminPostController::class, 'update'])->name('update');  // Utilisation de PUT pour les modifications
                Route::delete('{id}', 'destroy')->name('destroy');
            });


        // Route::resource('registrations', AdminRegistrationController::class)
        //     ->names('registrations');

        // Validation → "admin.registrations.validate"
        // Route::post('registrations/{registration}/approve', [AdminRegistrationController::class, 'validate'])
        //     ->name('registrations.approve');
        // // Annulation → "admin.registrations.cancel"

        // Route::post('registrations/{registration}/reject', [AdminRegistrationController::class, 'cancel'])
        //     ->name('registrations.reject');



        // Logout → "admin.logout"
        Route::post('logout', [AdminAuthController::class, 'logout'])
            ->name('logout');
    });
require __DIR__ . '/auth.php';
