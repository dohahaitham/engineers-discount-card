<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}?v=3">
    <link rel="shortcut icon" href="{{ asset('logo.jpeg') }}?v=3">
    <link rel="apple-touch-icon" href="{{ asset('logo.jpeg') }}?v=3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دليل الخصومات المعتمدة | نقابة المهندسين - فرع غزة</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
        
    <!-- خط Tajawal المميز -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
        
    <style>
        body { font-family: 'Tajawal', sans-serif; }
    </style>
</head>
<body class="bg-slate-100/70 text-gray-800 min-h-screen flex flex-col justify-between">

    <!-- الهيدر العلوي -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-30 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl border border-gray-100 bg-white p-1.5 flex items-center justify-center shadow-xs">
                    <img src="{{ asset('logo.jpeg') }}" alt="نقابة المهندسين" class="max-h-full max-w-full object-contain">
                </div>
                <div>
                    <h1 class="text-base sm:text-lg font-bold text-gray-900 leading-tight">نقابة المهندسين - فرع غزة</h1>
                    <p class="text-xs text-indigo-600 font-semibold">دليل الخصومات المعتمدة</p>
                </div>
            </a>

            <div class="flex items-center gap-2">
                <!-- زر تصدير ملف Excel للعمل بدون إنترنت -->
                <a href="{{ route('shops.exportExcel') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition flex items-center gap-1.5 shadow-xs">
                    <span>📊</span>
                    <span class="hidden sm:inline">تحميل الدليل (Excel)</span>
                    <span class="sm:hidden">Excel</span>
                </a>

                <!-- زر لوحة التحكم -->
                <a href="{{ route('login') }}" class="bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 shadow-xs">
                    🔒 لوحة التحكم
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1 w-full">

        <!-- القسم الترحيبي وبحث الفلترة -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200/80 shadow-xs mb-8">
            <div class="max-w-3xl mb-6">
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 leading-snug mb-2">
                    دليل الخصومات والمحلات التجارية المعتمدة 🏷️
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 leading-relaxed font-medium">
                    استفد من العروض والخصومات المخصصة للمهندسين وعائلاتهم لدى المحلات والشركات المشاركة في قطاع غزة.
                </p>
            </div>

            <!-- نموذج البحث والفلترة -->
            <form action="{{ route('shops.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                
                <!-- حقل البحث بحسب الاسم أو العنوان -->
                <div class="sm:col-span-6 relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="ابحث باسم المحل، المنطقة، أو نوع الخدمة..." 
                        class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-xs sm:text-sm rounded-2xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:bg-white transition"
                    >
                </div>

                <!-- قائمة التصنيفات -->
                <div class="sm:col-span-4">
                    <select 
                        name="category" 
                        class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-xs sm:text-sm rounded-2xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:bg-white transition"
                    >
                        <option value="">جميع التصنيفات</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- أزرار الإرسال والترسيت -->
                <div class="sm:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-bold py-3 px-4 rounded-2xl transition shadow-xs">
                        بحث
                    </button>

                    @if(request('search') || request('category'))
                        <a href="{{ route('shops.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold py-3 px-3 rounded-2xl transition text-center">
                            إلغاء
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- شبكة عرض المحلات -->
        @if($shops->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($shops as $shop)
                    <div class="bg-white rounded-3xl p-6 border border-gray-200/80 shadow-xs hover:shadow-md transition flex flex-col justify-between group">
                        
                        <div>
                            <!-- الهيدر الداخلي للكرت: التصنيف ونسبة الخصم -->
                            <div class="flex items-center justify-between gap-2 mb-4">
                                <span class="bg-indigo-50 text-indigo-700 text-[11px] font-bold px-3 py-1 rounded-full border border-indigo-100">
                                    🏷️ {{ $shop->category }}
                                </span>
                                
                                <span class="bg-rose-500 text-white text-xs font-black px-3 py-1 rounded-xl shadow-2xs">
                                    {{ Str::contains((string)$shop->discount, 'خصم') ? $shop->discount : 'خصم ' . ($shop->discount ?? 'خاص') }}
                                </span>
                            </div>

                            <!-- اسم المحل (تحويل لصفحة التفاصيل عند النقر) -->
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition mb-3 leading-snug">
                                <a href="{{ route('shops.show', $shop->id) }}" class="focus:outline-none">
                                    {{ $shop->name }}
                                </a>
                            </h3>

                            <!-- تفاصيل العنوان والتواصل -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-start gap-2 text-xs text-gray-600 font-medium">
                                    <span class="shrink-0">📍</span>
                                    <span class="line-clamp-2">{{ $shop->address ?? 'غير محدد' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- زر التحويل إلى صفحة التفاصيل الكاملة للمحل -->
                        <div class="pt-4 border-t border-gray-100">
                            <a href="{{ route('shops.show', $shop->id) }}" class="w-full bg-gray-50 hover:bg-indigo-50 text-gray-700 hover:text-indigo-700 text-xs font-bold py-2.5 px-4 rounded-xl transition flex items-center justify-center gap-1.5 border border-gray-100 group-hover:border-indigo-100">
                                <span>عرض تفاصيل الخصم</span>
                                <span>👈</span>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- الترقيم والتنقل بين الصفحات -->
            <div class="mt-8">
                {{ $shops->links() }}
            </div>

        @else
            <!-- حالة عدم وجود نتائج -->
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-200/80 shadow-xs max-w-md mx-auto my-12">
                <div class="text-5xl mb-4">🔍</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">لا توجد محلات مطابقة للبحث</h3>
                <p class="text-xs text-gray-500 mb-6 font-medium">جرب البحث بكلمات أخرى أو تغيير الفلتر المختارات.</p>
                <a href="{{ route('shops.index') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2.5 px-6 rounded-xl transition shadow-xs">
                    عرض جميع المحلات
                </a>
            </div>
        @endif

    </main>

    <!-- الفوتر -->
    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-500 font-medium mt-10">
        جميع الحقوق محفوظة &copy; {{ date('Y') }} نقابة المهندسين - فرع غزة
    </footer>

</body>
</html>