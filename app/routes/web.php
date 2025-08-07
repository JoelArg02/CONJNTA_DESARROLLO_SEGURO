<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Profile\DeactivateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BasicAuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Hash;

// Ruta raíz - redirige según autenticación
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/login', [BasicAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [BasicAuthController::class, 'login']);
Route::post('/logout', [BasicAuthController::class, 'logout'])->name('logout');
Route::get('/register', [BasicAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [BasicAuthController::class, 'register']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth:web,customer_web', 'verified'])
    ->name('dashboard');

Route::get('/api-test', function () {
    return view('api-test');
})->middleware('auth')->name('api-test');

Route::get('/test', function () {
    $users = User::all()->map(function ($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'tokens' => $user->tokens ?? [],
        ];
    });
    return view('test', ['users' => $users]);
})->middleware('auth')->name('test');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('crearTokenAcceso', [UserController::class, 'createToken'])->name('crearTokenAcceso');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{payment}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
    Route::post('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
});


Route::middleware(['auth', 'check.active'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::get('/users/inactivos', [UserController::class, 'inactive'])
        ->name('users.inactive');
    Route::post('/users/{user}/deactivate', [UserController::class, 'deactivate'])
        ->name('users.deactivate');
    Route::post('/users/{user}/reactivate', [UserController::class, 'reactivate'])->name('users.reactivate');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/activities', [ActivityLogController::class, 'index'])->name('activities.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/invoices-pdf', [ReportController::class, 'invoicesPdf'])->name('reports.invoices-pdf');
    Route::get('/reports/customers', [ReportController::class, 'getCustomers'])->name('reports.customers');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/profile/deactivate', [DeactivateController::class, 'store'])->name('profile.deactivate');

    Route::post('/profile/change-spatie-role', [ProfileController::class, 'changeSpatieRole'])->name('profile.changeSpatieRole');

    Route::post('/profile/roles/create', [ProfileController::class, 'createSpatieRole'])->name('profile.createSpatieRole');
    Route::put('/profile/roles/{role}/update', [ProfileController::class, 'updateSpatieRole'])->name('profile.updateSpatieRole');
    Route::delete('/profile/roles/{role}/delete', [ProfileController::class, 'deleteSpatieRole'])->name('profile.deleteSpatieRole');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.products.')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('create');
    Route::post('/products', [ProductController::class, 'store'])->name('store');

    Route::get('/products/disabled', [ProductController::class, 'disabled']);
    Route::put('/products/{id}/restore', [ProductController::class, 'restore']);

    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.customers.')->group(function () {
    Route::get('/customers', [CustomerController::class, 'index'])->name('index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('store');
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('show');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('edit');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('destroy');
    Route::get('/customers/disabled', [CustomerController::class, 'disabled'])->name('disabled');
    Route::put('/customers/{id}/restore', [CustomerController::class, 'restore'])->name('restore');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('invoices', InvoiceController::class)->parameters(['invoices' => 'invoice']);
    Route::patch('/invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus');

    // Soft delete routes
    Route::get('/invoices-trash', [InvoiceController::class, 'trash'])->name('invoices.trash');
    Route::patch('/invoices/{invoice}/restore', [InvoiceController::class, 'restore'])->name('invoices.restore');
    Route::delete('/invoices/{invoice}/force-delete', [InvoiceController::class, 'forceDelete'])->name('invoices.forceDelete');
});

Route::get('/clientes', [ClienteController::class, 'showLoginForm'])->name('clientes.loginForm');
Route::post('/clientes', [ClienteController::class, 'login'])->name('clientes.login');
Route::get('/clientes/dashboard', [ClienteController::class, 'dashboard'])
    ->middleware('auth:customer_web')
    ->name('clientes.dashboard');


require __DIR__ . '/auth.php';
