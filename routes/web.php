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





// Route::get('/check-session', function () {
//     return [
//         'web' => Auth::guard('web')->check(),
//         'admin' => Auth::guard('admin')->check(),
//         'default' => Auth::check(),
//     ];
// });

Route::get('/check-admin', function () {
    return response()->json([
        'admin' => Auth::guard('admin')->check(),
        'web' => Auth::guard('web')->check(),
        'user' => Auth::guard('admin')->user(),
    ]);
});


Route::middleware('web')->group(function () {
    Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

// Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


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
