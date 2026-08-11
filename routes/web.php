<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1️⃣ الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 2️⃣ صفحة عرض المحلات والخصومات
Route::get('/discounts', [ShopController::class, 'index'])->name('shops.index');

// 3️⃣ مسارات تسجيل الدخول والخروج
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 4️⃣ مسارات لوحة التحكم محمية بحساب الإدارة
Route::middleware('admin.auth')->prefix('admin')->group(function () {
    
    Route::get('/dashboard', [ShopController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');
    Route::post('/shops', [ShopController::class, 'store'])->name('shops.store');

    Route::get('/shops/{shop}/edit', [ShopController::class, 'edit'])->name('shops.edit');
    Route::put('/shops/{shop}', [ShopController::class, 'update'])->name('shops.update');

    Route::delete('/shops/{shop}', [ShopController::class, 'destroy'])->name('shops.destroy');
    Route::post('/shops/destroy-multiple', [ShopController::class, 'destroyMultiple']);

    Route::post('/shops/import-csv', [ShopController::class, 'importCSV']);
});