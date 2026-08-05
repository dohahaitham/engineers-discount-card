<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدير - بطاقة المهندس 🛠️</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Tajawal', sans-serif; } </style>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col justify-between">

    <div>
        <!-- 1️⃣ الهيدر العلوي للوحة التحكم -->
        <header class="bg-slate-900 text-white shadow-lg py-5 px-6">
            <div class="max-w-6xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('logo.jpeg') }}" alt="شعار نقابة المهندسين" class="h-14 w-14 object-contain bg-white rounded-xl p-1.5 shadow">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold">لوحة تحكم إدارة الخصومات ⚙️</h1>
                        <p class="text-slate-400 text-xs md:text-sm mt-0.5">إدارة المحلات والعروض المتاحة لبطاقة المهندس</p>
                    </div>
                </div>

                <a href="{{ route('shops.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs md:text-sm font-bold px-4 py-2.5 rounded-xl transition shadow flex items-center gap-2">
                    <span>👁️</span> معاينة صفحة المهندسين
                </a>
            </div>
        </header>

        <!-- 2️⃣ المحتوى الرئيسي -->
        <main class="max-w-6xl mx-auto px-4 py-8">
            
            @if(session('success'))
                <div class="bg-emerald-50 border-r-4 border-emerald-500 text-emerald-800 p-4 rounded-xl mb-6 text-sm font-bold shadow-sm flex items-center justify-between">
                    <span>✅ {{ session('success') }}</span>
                </div>
            @endif

            <!-- شريط العمليات: إضافة يدوي + رفع CSV -->
            <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-center justify-between mb-8">
                
                <a href="{{ route('shops.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-6 py-3 rounded-2xl shadow transition flex items-center justify-center gap-2">
                    ➕ إضافة محل جديد
                </a>

                <form action="{{ route('shops.import') }}" method="POST" enctype="multipart/form-data" class="bg-white p-3 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center gap-3">
                    @csrf
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-slate-700 mb-1">📊 استيراد مجموعة محلات (CSV):</span>
                        <input type="file" name="file" accept=".csv" required class="text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                    </div>
                    <button type="submit" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow flex items-center justify-center gap-1.5 whitespace-nowrap">
                        📤 رفع الملف
                    </button>
                </form>

            </div>

            <!-- نموذج الحذف المتعدد وجدول المحلات -->
            <form action="{{ route('shops.destroyMultiple') }}" method="POST" id="bulk-delete-form" onsubmit="return confirm('هل أنت تأكد من رغبتك في حذف كافة المحلات المحددة؟');">
                @csrf
                
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-slate-50">
                        <div class="flex items-center gap-3">
                            <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                                📋 المحلات والمؤسسات المضافة حالياً
                            </h2>
                            <span class="text-xs font-bold bg-slate-200 text-slate-700 px-3 py-1 rounded-full">
                                العدد: {{ $shops->count() }}
                            </span>
                        </div>

                        <!-- زر حذف المحلات المحددة -->
                        @if($shops->count() > 0)
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition shadow flex items-center gap-1.5">
                                🗑️ حذف المحلات المحددة
                            </button>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-right border-collapse">
                            <thead>
                                <tr class="bg-slate-100 text-slate-600 text-xs font-bold border-b border-slate-200">
                                    <th class="py-3 px-4 text-center">
                                        <input type="checkbox" id="select-all" class="w-4 h-4 text-indigo-600 rounded cursor-pointer">
                                    </th>
                                    <th class="py-3 px-6">#</th>
                                    <th class="py-3 px-6">اسم المحل / المؤسسة</th>
                                    <th class="py-3 px-6">نسبة الخصم</th>
                                    <th class="py-3 px-6">العنوان</th>
                                    <th class="py-3 px-6">التفاصيل</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                                @forelse($shops as $index => $shop)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-4 px-4 text-center">
                                            <input type="checkbox" name="shop_ids[]" value="{{ $shop->id }}" class="shop-checkbox w-4 h-4 text-indigo-600 rounded cursor-pointer">
                                        </td>
                                        <td class="py-4 px-6 font-bold text-slate-400">{{ $index + 1 }}</td>
                                        <td class="py-4 px-6 font-bold text-slate-900">{{ $shop->name }}</td>
                                        <td class="py-4 px-6">
                                            <span class="bg-red-100 text-red-700 font-bold text-xs px-2.5 py-1 rounded-full">
                                                خصم {{ $shop->discount }}%
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-slate-600">📍 {{ $shop->address }}</td>
                                        <td class="py-4 px-6 text-xs text-slate-500 max-w-xs truncate">
                                            {{ $shop->details ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-12 text-slate-400">
                                            لا توجد محلات مضافة حتى الآن.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

        </main>
    </div>

    <!-- كود JavaScript لتحديد/إلغاء تحديد كافة المحلات -->
    <script>
        document.getElementById('select-all')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.shop-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>

    <footer class="bg-white border-t py-4 text-center text-xs text-slate-400">
        نظام إدارة الخصومات - نقابة المهندسين © جميع الحقوق محفوظة
    </footer>

</body>
</html>