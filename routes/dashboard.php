<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AdminProfileController;
use App\Http\Controllers\Dashboard\Auth\AdminAuthenticatedSessionController;
use App\Http\Controllers\Dashboard\Auth\AdminConfirmablePasswordController;
use App\Http\Controllers\Dashboard\Auth\AdminEmailVerificationNotificationController;
use App\Http\Controllers\Dashboard\Auth\AdminEmailVerificationPromptController;
use App\Http\Controllers\Dashboard\Auth\AdminNewPasswordController;
use App\Http\Controllers\Dashboard\Auth\AdminPasswordController;
use App\Http\Controllers\Dashboard\Auth\AdminPasswordResetLinkController;
use App\Http\Controllers\Dashboard\Auth\AdminVerifyEmailController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\MessageController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\StoreController;
use App\Http\Controllers\Dashboard\TagController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// TODO: Complete the implementation of manager pattern related to payment.
// TODO: Add search and Filter functionality to homepage using Livewire.
// TODO: Implement the refund process.

Route::middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])->group(function () {

    Route::prefix('dashboard')->as('dashboard.')->group(function () {

        Route::middleware(['guest:admin'])->group(function () {

            ############################# Start Login Routes ############################################
            Route::prefix('login')->group(function () {
                Route::get('/', [AdminAuthenticatedSessionController::class, 'create'])->name('login');
                Route::post('/', [AdminAuthenticatedSessionController::class, 'store'])->name('login');
            });
            ############################# End Login Routes ############################################

            ############################# Start Password Reset Routes ############################################
            Route::get('forgot-password', [AdminPasswordResetLinkController::class, 'create'])
                ->name('password.request');

            Route::post('forgot-password', [AdminPasswordResetLinkController::class, 'store'])
                ->name('password.email');

            Route::get('reset-password/{token}', [AdminNewPasswordController::class, 'create'])
                ->name('password.reset');

            Route::post('reset-password', [AdminNewPasswordController::class, 'store'])
                ->name('password.store');
            ############################# End Password Reset Routes ############################################
        });

        ##################################### Start Admin Routes #########################################

        Route::middleware(['auth:admin', 'AdminStatus'])->group(function () {

            ############################# Start Logout Routes ############################################
            Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');
            ############################# End Logout Routes ############################################

            ############################# Start Email Verification Routes ############################################
            Route::get('verify-email', AdminEmailVerificationPromptController::class)
                ->name('verification.notice');

            Route::get('verify-email/{id}/{hash}', AdminVerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

            Route::post('email/verification-notification', [AdminEmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');
            ############################# End Email Verification Routes ############################################

            ############################# Start Password Routes ############################################
            Route::get('confirm-password', [AdminConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

            Route::post('confirm-password', [AdminConfirmablePasswordController::class, 'store']);
            ############################# End Password Routes ############################################

            ############################################ Start Pages Routes #############################################

//            Route::middleware(['verified:dashboard.verification.notice','password.confirm:dashboard.password.confirm'])->group(function () {
            ############################# Start Dashboard Index ############################################
            Route::get('/', DashboardController::class)->name('index');
            ############################# End Dashboard Index ############################################


            ############################# Start Profile Routes ############################################
            Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');
            ############################# End Profile Routes ############################################

            ############################# Start Admin Update Password ############################################
            Route::put('password', [AdminPasswordController::class, 'update'])->name('password.update');
            ############################# End Admin Update Password ############################################

            ############################# Start Category Routes ############################################
            Route::resource('categories', CategoryController::class)->scoped(['category' => 'slug']);
            ############################# End Category Routes ############################################

            ############################# Start Store Routes ############################################
            Route::resource('stores', StoreController::class)->scoped(['store' => 'slug']);
            ############################# End Store Routes ############################################

            ############################# Start Product Routes ############################################
            Route::resource('products', ProductController::class)->scoped(['product' => 'slug'])->withTrashed();
            ############################# End Product Routes ############################################

            ############################# Start Tag Routes ############################################
            Route::resource('tags', TagController::class)->scoped(['tag' => 'slug']);
            ############################# End Tag Routes ############################################

            ############################# Start Chat ############################################
            Route::get('chat', ChatController::class)->name('chat');
            ############################# End Chat ############################################

            ############################ Start Chat Routes ######################################
            Route::resource('messages', MessageController::class);
            ############################ End Chat Routes ######################################

            ############################ Start Admins Users Routes ######################################
            Route::post('reset-password/{admin}/', [AdminController::class, 'resetAdminPassword'])->name('reset-admin-password');
            Route::resource('admins', AdminController::class)->except('show');
            ############################ End Admin Users Routes ######################################

            ############################ Start Roles Routes ######################################
            Route::resource('roles', RoleController::class)->except('show');
            ############################ End Roles Routes ######################################

//        });
            ############################################ End Pages Routes #############################################
        });
        ##################################### End Admin Routes #########################################
    });

    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle);
    });
});


