<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// ROOT → langsung ke login
Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    if (auth()->check()) {
        return redirect()->route('user.dashboard');
    }
    return view('auth.register');
})->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// BERANDA (CATEGORY)
Route::view('/home', 'home')->name('home');

// LIST PRODUCT (by category via query param)
Route::get('/products', function () {
    $products = Product::where('stock', '>', 0)->get();
    return view('products', compact('products'));
})->name('products');

/*
|--------------------------------------------------------------------------
| USER ROUTES (authenticated users)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // User Dashboard / Profile
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Orders (using UUID in URL)
    Route::get('/orders', [UserController::class, 'orders'])->name('orders');
    Route::get('/orders/{order:uuid}', [UserController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{order:uuid}/cancel', [UserController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('/orders/{order:uuid}/whatsapp', [UserController::class, 'redirectToWhatsApp'])->name('orders.whatsapp');

    // Checkout (using slug in URL)
    Route::get('/checkout/{product:slug}', [UserController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{product:slug}', [UserController::class, 'placeOrder'])->name('checkout.post');
    Route::get('/order-success/{order:uuid}', [UserController::class, 'orderSuccess'])->name('order.success');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Orders Management (using UUID in URL)
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order:uuid}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{order:uuid}/confirm', [AdminController::class, 'confirmOrder'])->name('orders.confirm');
    Route::patch('/orders/{order:uuid}/complete', [AdminController::class, 'completeOrder'])->name('orders.complete');
    Route::patch('/orders/{order:uuid}/cancel', [AdminController::class, 'cancelOrder'])->name('orders.cancel');

    // Products Management (using slug in URL)
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product:slug}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product:slug}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product:slug}', [AdminController::class, 'deleteProduct'])->name('products.delete');
    Route::patch('/products/{product:slug}/stock', [AdminController::class, 'updateStock'])->name('products.stock');

    // Users Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
});

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return redirect('/login');
});
