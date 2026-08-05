<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

// 1️⃣ الصفحة الأولى (التعريفية بالنقابة)
Route::get('/', function () {
    return view('welcome');
});

// 2️⃣ صفحة الخصومات للمهندسين
Route::get('/discounts', [ShopController::class, 'index'])->name('shops.index');

// 3️⃣ مسارات لوحة تحكم المدير
Route::get('/admin/dashboard', [ShopController::class, 'adminDashboard'])->name('admin.dashboard');
Route::get('/admin/add-shop', [ShopController::class, 'create'])->name('shops.create');
Route::post('/admin/add-shop', [ShopController::class, 'store'])->name('shops.store');
Route::delete('/admin/shop/{shop}', [ShopController::class, 'destroy'])->name('shops.destroy');
Route::post('/admin/import-shops', [ShopController::class, 'importCsv'])->name('shops.import');
Route::post('/admin/delete-multiple-shops', [ShopController::class, 'destroyMultiple'])->name('shops.destroyMultiple');