<?php


use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\SeasonController as AdminSeasonController;
use App\Http\Controllers\Admin\AgeCategoryController as AdminAgeCategoryController;
use App\Http\Controllers\Admin\PlayerController as AdminPlayerController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\AdminAuthController as AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;


// Route::get('/',  function () {
//      return view('welcome');
// })->name('home');



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
               });


          Route::controller(AdminPlayerController::class)
               ->prefix('players')
               ->name('player.')
               ->group(function () {
                    Route::get('list', 'index')->name('index');
               });


          Route::controller(AdminPostController::class)
               ->prefix('posts')
               ->name('post.')
               ->group(function () {
                    Route::get('list', 'index')->name('index');
               });

          // Route::controller(AdminPostController::class)
          // CRUD registrations → "admin.registrations.index", etc.

          Route::resource('registrations', AdminRegistrationController::class)
               ->names('registrations');

          // Validation → "admin.registrations.validate"
          Route::post('registrations/{registration}/approve', [AdminRegistrationController::class, 'validate'])
               ->name('registrations.approve');
          // Annulation → "admin.registrations.cancel"

          Route::post('registrations/{registration}/reject', [AdminRegistrationController::class, 'cancel'])
               ->name('registrations.reject');



          // Logout → "admin.logout"
          Route::post('logout', [AdminAuthController::class, 'logout'])
               ->name('logout');
     });
