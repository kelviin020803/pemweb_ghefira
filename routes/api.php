<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| All routes here use API middleware
|--------------------------------------------------------------------------
*/

// ============================================
// AUTH ROUTES (JWT)
// ============================================
Route::prefix('auth')->group(function () {
    // Public routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
    });
});

// ============================================
// PRODUCT ROUTES
// ============================================

// PUBLIC - Tidak perlu login
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']); // ⭐ PAKAI SLUG

// Bonus: Filter by category (public)
Route::get('/categories/{category}/products', [ProductController::class, 'byCategory']);

// PROTECTED - Perlu JWT Token
Route::middleware('auth:api')->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::patch('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // Bonus: Low stock products (for admin)
    Route::get('/products/stock/low', [ProductController::class, 'lowStock']);
});

// ============================================
// ORDER ROUTES (SEMUA PROTECTED) ⭐⭐⭐
// ============================================
Route::middleware('auth:api')->group(function () {
    // Get user orders
    Route::get('/orders', [OrderController::class, 'index']);

    // Create order (stock akan berkurang otomatis)
    Route::post('/orders', [OrderController::class, 'store']);

    // Get order by UUID
    Route::get('/orders/{uuid}', [OrderController::class, 'show']);

    // Update order status (bisa return stock jika cancel)
    Route::put('/orders/{id}', [OrderController::class, 'update']);
    Route::patch('/orders/{id}', [OrderController::class, 'update']);

    // Delete order (stock akan kembali)
    Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

    // Bonus: Admin get all orders
    Route::get('/admin/orders', [OrderController::class, 'allOrders']);
});

// ============================================
// FALLBACK ROUTE
// ============================================
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Route not found. Please check API documentation.'
    ], 404);
});
