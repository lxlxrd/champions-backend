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

               Route::get('/test', [AdminController::class, 'test'])
               ->name('test');

          // CRUD posts → "admin.posts.index", etc.
          Route::resource('posts', AdminPostController::class)
               ->names('posts');



          Route::resource('age_categories', AdminAgeCategoryController::class)
               ->names('age-categories');



          Route::resource('players', AdminPlayerController::class)->names('players');


          // Route::resource('seasons', AdminSeasonController::class)->names("seasons")->except(['show']);;
          // Route::post('seasons/{season}/archive', [AdminSeasonController::class, 'archive'])
          //      ->name('seasons.archive');

          // Route::get('seasons/archived', [AdminSeasonController::class, 'archived'])
          //      ->name('seasons.archived');

          Route::controller(AdminSeasonController::class)
               ->prefix('seasons')
               ->name('seasons.')
               ->group(function () {
                    Route::get('list', 'index')->name('index');
                    Route::get('archived', 'archived')->name('archived');
                    Route::post('{season}/archive', 'archive')->name('archive');
               });


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
