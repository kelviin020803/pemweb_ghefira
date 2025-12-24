<?php

use Illuminate\Support\Facades\Route;

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
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

/*
|--------------------------------------------------------------------------
| USER FLOW
|--------------------------------------------------------------------------
*/

// BERANDA (CATEGORY)
Route::view('/home', 'home')->name('home');

// LIST PRODUCT (by category via query param)
Route::view('/products', 'products')->name('products');

// CHECKOUT
Route::view('/checkout', 'checkout')->name('checkout');

/*
|--------------------------------------------------------------------------
| FALLBACK (OPTIONAL, BIAR GA 404 ANEH)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return redirect('/login');
});
