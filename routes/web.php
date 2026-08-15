<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AuthController;
use App\Models\Shop;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1️⃣ الصفحة الرئيسية
Route::get('/', function () {
    $totalShopsCount = Shop::count();
    $shops = Shop::latest()->take(6)->get();

    return view('welcome', compact('totalShopsCount', 'shops'));
})->name('home');

// 2️⃣ صفحة عرض جميع المحلات والخصومات للجمهور
Route::get('/discounts', [ShopController::class, 'index'])->name('shops.index');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.submit');

// 3️⃣ مسارات تسجيل الدخول والخروج الخاصة بالإدارة
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/admin/shops/import', [ShopController::class, 'importCSV'])->name('admin.shops.import');

// 4️⃣ مسارات لوحة التحكم (محمية بجدار الحماية admin.auth)
Route::middleware('admin.auth')->prefix('admin')->name('admin.')->group(function () {
    
        // عرض لوحة التحكم الرئيسية (ستصبح: admin.dashboard)
            Route::get('/dashboard', [ShopController::class, 'adminDashboard'])->name('dashboard');

                // إضافة محل جديد (ستصبح: admin.shops.create)
                    Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');
                        Route::post('/shops', [ShopController::class, 'store'])->name('shops.store');

                            // تعديل بيانات محل (ستصبح: admin.shops.edit)
                                Route::get('/shops/{shop}/edit', [ShopController::class, 'edit'])->name('shops.edit');
                                    Route::put('/shops/{shop}', [ShopController::class, 'update'])->name('shops.update');

                                        // حذف محل (فردي / جماعي)
                                            Route::delete('/shops/{shop}', [ShopController::class, 'destroy'])->name('shops.destroy');
                                                Route::post('/shops/destroy-multiple', [ShopController::class, 'destroyMultiple'])->name('shops.destroyMultiple');

                                                    // استيراد المحلات (ستصبح: admin.shops.import)
                                                        Route::post('/shops/import', [ShopController::class, 'importCSV'])->name('shops.import');
                                                        });