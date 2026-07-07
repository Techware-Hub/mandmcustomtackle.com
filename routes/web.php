<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminContactMessageController;
use App\Http\Controllers\AdminGalleryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\AdminTestimonialController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TrackOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/testimonials', [PageController::class, 'testimonials'])->name('testimonials');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/shop', [ProductController::class, 'index'])->name('products.index');
Route::get('/shop/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove/{product}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/my-account', CustomerAccountController::class)->name('customer.account');
    Route::get('/my-orders', [CustomerOrderController::class, 'index'])->name('customer.orders');
    Route::get('/my-orders/{order}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');
});

Route::get('/track-order', [TrackOrderController::class, 'index'])->name('customer.track');
Route::post('/track-order', [TrackOrderController::class, 'search'])->name('customer.track.search');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::get('inventory', [AdminProductController::class, 'index'])->defaults('stock', 'low')->name('inventory.index');
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::resource('blogs', AdminBlogController::class)->except(['show']);
    Route::resource('gallery', AdminGalleryController::class)->parameters(['gallery' => 'gallery'])->except(['show']);
    Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);
    Route::get('messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [AdminContactMessageController::class, 'show'])->name('messages.show');
    Route::put('messages/{message}/read', [AdminContactMessageController::class, 'toggleRead'])->name('messages.toggleRead');
    Route::delete('messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');
    Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/integration', [AdminPaymentController::class, 'integration'])->name('payments.integration');
    Route::put('payments/integration', [AdminPaymentController::class, 'updateIntegration'])->name('payments.integration.update');
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
});

Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms');
Route::get('/return-policy', [PageController::class, 'returns'])->name('returns');
