<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - إدارة خصومات المهندسين ⚙️</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Tajawal', sans-serif; } 
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-sky-50/40 to-indigo-50/20 min-h-screen flex flex-col justify-between text-slate-800">

    <div>
        <!-- 1️⃣ الهيدر العلوي -->
        <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50 shadow-sm">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo.jpeg') }}" alt="شعار النقابة" class="h-10 w-10 object-contain">
                    <div>
                        <h1 class="text-base font-extrabold text-slate-900">لوحة تحكم الخصومات ⚙️</h1>
                        <p class="text-xs text-indigo-600 font-bold">نقابة المهندسين - غزة 🇵🇸</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" target="_blank" class="text-xs font-bold text-slate-600 hover:text-indigo-600 bg-slate-100 px-3.5 py-2 rounded-xl transition hidden sm:inline">
                        🌐 عرض الموقع
                    </a>
                    
                    <!-- زر تسجيل الخروج -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-700 text-xs font-bold px-3.5 py-2 rounded-xl transition flex items-center gap-1.5">
                            <span>🚪</span> تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- 2️⃣ المحتوى الرئيسي -->
        <main class="max-w-6xl mx-auto px-6 py-8">

            <!-- رسائل التنبيه والنجاح -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold p-4 rounded-2xl mb-6 flex items-center justify-between shadow-sm">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold p-4 rounded-2xl mb-6 flex items-center justify-between shadow-sm">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold">✕</button>
                </div>
            @endif

            <!-- أدوات التحكم السريعة (إضافة، استيراد CSV) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                
                <!-- إضافة محل جديد -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm mb-1">إضافة محل جديد 🏬</h3>
                        <p class="text-xs text-slate-500 mb-4">إدخال بيانات محل أو شركة جديدة وتحديد نسبة الخصم والتصنيف.</p>
                    </div>
                    <a href="{{ route('shops.create') }}" class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs py-3 rounded-2xl shadow transition">
                        + إضافة محل جديد
                    </a>
                </div>

                <!-- استيراد ملف CSV -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm col-span-1 md:col-span-2">
                    <h3 class="font-bold text-slate-900 text-sm mb-1">استيراد محلات من ملف CSV 📊</h3>
                    <p class="text-xs text-slate-500 mb-3">رفع مجموعة محلات دفعة واحدة عبر ملف Excel / CSV.</p>
                    
                    <form action="{{ route('shops.importCsv') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-3">
                        @csrf
                        <input type="file" name="file" required accept=".csv,.xlsx,.xls" class="w-full text-xs text-slate-500 file:mr-0 file:ml-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-200 rounded-2xl p-1 bg-slate-50">
                        <button type="submit" class="w-full sm:w-auto whitespace-nowrap bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs px-5 py-3 rounded-2xl transition shadow">
                            رفع الملف 📤
                        </button>
                    </form>
                </div>

            </div>

            <!-- جدول عرض وإدارة المحلات -->
            <form action="{{ route('shops.destroyMultiple') }}" method="POST" id="bulk-delete-form">
                @csrf

                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                    
                    <!-- هيدر الجدول والعمليات الجماعية -->
                    <div class="p-5 border-b border-slate-100 flex items-center justify-between flex-wrap gap-3">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-slate-900 text-base">قائمة المحلات والشركات</h3>
                            <span class="text-xs bg-slate-100 text-slate-600 font-bold px-3 py-1 rounded-full border border-slate-200">
                                إجمالي: {{ $shops->count() }}
                            </span>
                        </div>

                        <button type="submit" onclick="return confirm('هل أنت تأكد من حذف المحلات المحددة؟')" class="bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-700 text-xs font-bold px-4 py-2 rounded-xl transition flex items-center gap-1.5">
                            <span>🗑️</span> حذف المحدد
                        </button>
                    </div>

                    <!-- الجدول -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-right text-xs">
                            <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100">
                                <tr>
                                    <th class="p-4 w-10 text-center">
                                        <input type="checkbox" id="select-all" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                    </th>
                                    <th class="p-4">اسم المحل</th>
                                    <th class="p-4">التصنيف</th>
                                    <th class="p-4">نسبة الخصم</th>
                                    <th class="p-4">العنوان</th>
                                    <th class="p-4">التفاصيل</th>
                                    <th class="p-4 text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @forelse($shops as $shop)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="p-4 text-center">
                                            <input type="checkbox" name="ids[]" value="{{ $shop->id }}" class="shop-checkbox rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                        </td>
                                        <td class="p-4 font-bold text-slate-900">
                                            {{ $shop->name }}
                                        </td>
                                        <td class="p-4">
                                            <span class="bg-indigo-50 text-indigo-700 font-bold px-2.5 py-1 rounded-lg border border-indigo-100">
                                                {{ $shop->category ?? 'خدمات أخرى 🛠️' }}
                                            </span>
                                        </td>
                                        <td class="p-4">
                                            <span class="bg-rose-50 text-rose-600 font-extrabold px-2.5 py-1 rounded-lg border border-rose-100">
                                                {{ $shop->discount }}%
                                            </span>
                                        </td>
                                        <td class="p-4 text-slate-600">
                                            📍 {{ $shop->address }}
                                        </td>
                                        <td class="p-4 text-slate-500 max-w-xs truncate">
                                            {{ $shop->details ?? '-' }}
                                        </td>
                                        <td class="p-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- تعديل -->
                                                <a href="{{ route('shops.edit', $shop->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-3 py-1.5 rounded-xl transition">
                                                    ✏️ تعديل
                                                </a>

                                                <!-- حذف فردي -->
                                                <button type="button" onclick="deleteShop({{ $shop->id }})" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold px-3 py-1.5 rounded-xl border border-rose-100 transition">
                                                    🗑️
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-10 text-center text-slate-400">
                                            لا توجد أي محلات مضافة حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </form>

            <!-- نماذج الحذف الفردية (تتنفذ بالسكربت) -->
            @foreach($shops as $shop)
                <form id="delete-form-{{ $shop->id }}" action="{{ route('shops.destroy', $shop->id) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach

        </main>
    </div>

    <!-- الفوتر -->
    <footer class="bg-white border-t border-slate-200/80 py-4 text-center text-xs text-slate-500 font-bold">
        <p>جميع الحقوق محفوظة © نقابة المهندسين - فلسطين 🇵🇸</p>
    </footer>

    <!-- سكربت التحديد والحذف -->
    <script>
        // تحديد كافة المحلات دفعة واحدة
        document.getElementById('select-all')?.addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.shop-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // تأكيد الحذف الفردي
        function deleteShop(id) {
            if (confirm('هل أنت تأكد من حذف هذا المحل؟')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>

</body>
</html>