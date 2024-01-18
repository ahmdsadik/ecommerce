<?php

use App\Http\Controllers\Front\Auth\SocialLoginController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\StripeWebhookController;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', FrontController::class)->name('home');

Route::as('front.')->group(function () {
    Route::get('products', [\App\Http\Controllers\Front\ProductController::class, 'index'])->name('products.index');
    Route::get('products/{product:slug}', [\App\Http\Controllers\Front\ProductController::class, 'show'])
        ->name('products.show');
    Route::post('review/{product}/store',[\App\Http\Controllers\Front\ReviewController::class , 'store'])->name('review.product.store');

    Route::get('cart', [\App\Http\Controllers\Front\CartController::class, 'index'])->name('cart.index');
    Route::post('cart/store/{product:slug}', [\App\Http\Controllers\Front\CartController::class, 'store'])->name('cart.store');
    Route::delete('cart/{id}', [\App\Http\Controllers\Front\CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('checkout', [\App\Http\Controllers\Front\CheckoutController::class, 'create'])->name('checkout');
    Route::post('checkout', [\App\Http\Controllers\Front\CheckoutController::class, 'store']);

    Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])->name('social.login');
    Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('social.callback');

    Route::get('order/{order}/pay', [PaymentController::class, 'create'])->name('payment.create');

    Route::post('stripe/{order}/intent', [PaymentController::class, 'createStripePaymentIntent'])->name('stripe.intent.create');
    Route::get('stripe/{order}/complete', [PaymentController::class, 'completePayment'])->name('stripe.complete-payment');
    Route::any('stripe/webhook',[StripeWebhookController::class,'webhook'])->name('stripe.webhook');
});

Route::post('currency', [\App\Http\Controllers\Front\CurrencyConverterController::class, 'store'])->name('currency.store');

Route::view('livewire','front.livewire');

// TODO:: WATCHLIST AND OTHER IN SHOW PAGE


//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__ . '/auth.php';
