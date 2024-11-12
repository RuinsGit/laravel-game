<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Ana sayfa -> Login formuna yönlendirme
Route::get('/', function () {
    return redirect()->route('login.form');
});

// Ürün sayfası (giriş yapıldıktan sonra erişilebilir)
Route::get('/products', [ProductController::class, 'index'])->middleware('auth')->name('products');

// Sepete ürün ekleme
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
// Sepetten ürün silme rotası
Route::delete('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Sepet görüntüleme ve onaylama
Route::get('/cart', [CartController::class, 'viewCart'])->middleware('auth')->name('cart.index');
Route::post('/cart/confirm', [CartController::class, 'confirmCart'])->middleware('auth')->name('cart.confirm');

// Kayıt işlemleri
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Giriş işlemleri
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Çıkış işlemi
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin paneli

// Admin login sayfası (Admin giriş yapmamışsa buraya gider)
Route::get('/admin', [AdminController::class, 'showLoginForm'])->name('admin.login');

// Admin login işlemi
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

// Admin dashboard (Login olmadan erişim engellenmiş olacak)
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Admin çıkış
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin işlemleri, giriş yapan admin için
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/admins', [AdminController::class, 'admins'])->name('admin.admins');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/products/edit/{id}', [AdminController::class, 'editProduct'])->name('admin.editProduct');
    Route::put('/admin/products/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.updateProduct');
    Route::post('/admin/products/add', [AdminController::class, 'addProduct'])->name('admin.addProduct');
    Route::delete('/admin/products/delete/{id}', [AdminController::class, 'deleteProduct'])->name('admin.deleteProduct');  // Ürün silme rotası
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
});
