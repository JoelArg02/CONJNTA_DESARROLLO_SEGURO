<?php

use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user/invoices', [InvoiceController::class, 'getAuthenticatedUserInvoices']);

Route::middleware('auth:sanctum')->get('/customer/invoices', function (Request $request) {
    return $request->user()->invoices;
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/payments', [PaymentController::class, 'store']);
});


Route::prefix('customer')->group(function () {
    Route::post('/login', [CustomerAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [CustomerAuthController::class, 'me']);
        Route::post('/logout', [CustomerAuthController::class, 'logout']);
        Route::post('/payments', [PaymentController::class, 'store']);

        Route::get('/invoices', function (Request $request) {
            return $request->user()->invoices()->get();
        });
    });
});
Route::middleware('auth:sanctum')->get('/customer/{customerId}/invoices', [InvoiceController::class, 'getInvoicesByCustomer']);
