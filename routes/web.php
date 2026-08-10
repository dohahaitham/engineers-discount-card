<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear-cache', function () {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    return 'Cache Cleared Successfully!';
});

/*
|--------------------------------------------------------------------------
| Web Routes - مسارات دليل الخصومات ونقابة المهندسين 💳
|--------------------------------------------------------------------------
*/

// 🌐 1️⃣ المسارات العامة للجمهور (تصفح المحلات والخصومات والبحث)
Route::get('/', function () {
        return view('welcome');
})

// 🔑 2️⃣ مسارات تسجيل الدخول والخروج الخاصة بالمسؤول
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔒 3️⃣ مسارات لوحة التحكم وإدارة المحلات (محمية بجدار الحماية AdminAuth)
Route::middleware('admin.auth')->prefix('admin')->group(function () {

    // عرض لوحة التحكم الرئيسي
    Route::get('/dashboard', [ShopController::class, 'adminDashboard'])->name('admin.dashboard');

    // إضافة محل جديد
    Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');
    Route::post('/shops', [ShopController::class, 'store'])->name('shops.store');

    // تعديل بيانات محل
    Route::get('/shops/{shop}/edit', [ShopController::class, 'edit'])->name('shops.edit');
    Route::put('/shops/{shop}', [ShopController::class, 'update'])->name('shops.update');

    // حذف محل (فردي / جماعي)
    Route::delete('/shops/{shop}', [ShopController::class, 'destroy'])->name('shops.destroy');
    Route::post('/shops/destroy-multiple', [ShopController::class, 'destroyMultiple'])->name('shops.destroyMultiple');

    // استيراد المحلات من ملف CSV
    Route::post('/shops/import-csv', [ShopController::class, 'importCsv'])->name('shops.importCsv');

});