<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}?v=3">
    <link rel="shortcut icon" href="{{ asset('logo.jpeg') }}?v=3">
    <link rel="apple-touch-icon" href="{{ asset('logo.jpeg') }}?v=3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دليل المحلات والخصومات - نقابة المهندسين</title>

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
            
            <!-- اللوجو واسم النقابة -->
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl border border-gray-100 bg-white p-1.5 flex items-center justify-center shadow-xs">
                    <img src="{{ asset('logo.jpeg') }}" alt="نقابة المهندسين" class="max-h-full max-w-full object-contain">
                </div>
                <div>
                    <h1 class="text-base sm:text-lg font-bold text-gray-900 leading-tight flex items-center gap-2">
                        <span>نقابة المهندسين - فرع غزة</span>
                        <!-- علم فلسطين SVG -->
                        <svg class="w-5 h-4 rounded-xs shadow-2xs inline-block" viewBox="0 0 600 300" xmlns="http://www.w3.org/2000/svg">
                            <rect width="600" height="100" fill="#000000"/>
                            <rect y="100" width="600" height="100" fill="#FFFFFF"/>
                            <rect y="200" width="600" height="100" fill="#007A3D"/>
                            <polygon points="0,0 200,150 0,300" fill="#CE1126"/>
                        </svg>
                    </h1>
                    <p class="text-xs text-indigo-600 font-semibold">مركز العمل الهندسي</p>
                </div>
            </a>

            <!-- الأزرار -->
            <div class="flex items-center gap-3">
                <a href="{{ route('shops.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-xs transition flex items-center gap-1.5">
                    💳 كافة الخصومات ({{ $shops->total() ?? 45 }})
                </a>
                
                <a href="{{ route('home') }}" class="text-xs font-bold text-gray-600 hover:text-indigo-600 transition hidden sm:flex items-center gap-1 bg-gray-50 hover:bg-gray-100 px-3 py-2.5 rounded-xl border border-gray-200/60">
                    🏠 الرئيسية
                </a>
            </div>

        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1">

        <!-- العنوان والبحث -->
        <div class="mb-8 text-center max-w-3xl mx-auto">
            <h2 class="text-2xl font-black text-gray-900 mb-2">استكشف جميع الخصومات والعروض</h2>
            <p class="text-gray-600 text-xs sm:text-sm font-medium mb-6">ابحث واكتشف العروض الحصرية المتاحة لك في كافة المجالات والمحافظات</p>

            <!-- نموذج البحث والفلترة -->
            <form action="{{ route('shops.index') }}" method="GET" class="bg-white p-3.5 rounded-2xl shadow-sm border border-gray-200 flex flex-col sm:flex-row gap-2.5">
                <div class="flex-1 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث باسم المحل، الفرع، أو العنوان..." 
                           class="w-full pl-9 pr-3.5 py-2.5 rounded-xl bg-gray-50 border border-gray-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-600 text-xs transition font-medium">
                    <span class="absolute left-3 top-3 text-gray-400 text-xs">🔍</span>
                </div>

                <select name="category" class="py-2.5 px-3 rounded-xl bg-gray-50 border border-gray-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-600 text-xs font-medium transition">
                    <option value="">جميع التصنيفات</option>
                    @foreach (collect($categories)->unique() as $cat)
                        @if (!empty(trim($cat)))
                            <option value="{{ trim($cat) }}" {{ request('category') == trim($cat) ? 'selected' : '' }}>
                                {{ trim($cat) }}
                            </option>
                        @endif
                    @endforeach
                </select>

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl transition shadow-sm text-xs">
                    بحث
                </button>
            </form>
        </div>

        <!-- شبكة الكروت -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($shops as $shop)
                <div class="bg-white rounded-2xl p-4 border border-gray-200/80 shadow-xs hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <!-- اسم المحل ونسبة الخصم -->
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <h3 class="font-bold text-gray-900 text-sm sm:text-base leading-snug">
                                {{ $shop->name }}
                            </h3>
                            <span class="bg-rose-500 text-white text-[11px] font-black px-2.5 py-0.5 rounded-full whitespace-nowrap shadow-xs">
                                {{ Str::contains($shop->discount, 'خصم') ? $shop->discount : 'خصم ' . $shop->discount }}
                            </span>
                        </div>

                        <!-- التصنيف والعنوان -->
                        <div class="space-y-1.5 mb-3 text-xs text-gray-600 font-medium">
                            @if ($shop->category)
                                <div class="flex items-center gap-1.5">
                                    <span>🏷️</span>
                                    <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-md text-[11px]">
                                        {{ $shop->category }}
                                    </span>
                                </div>
                            @endif
                            <div class="flex items-center gap-1.5">
                                <span class="text-rose-600">📍</span>
                                <span class="text-gray-700 leading-relaxed">{{ $shop->location ?? $shop->address ?? 'غير محدد' }}</span>
                            </div>
                        </div>

                        <!-- تفاصيل الخصم والشمول -->
                        @if ($shop->details)
                            <div class="bg-amber-50 border border-amber-200/90 rounded-xl p-2.5 mt-2">
                                <div class="text-[11px] font-bold text-amber-900 mb-0.5 flex items-center gap-1">
                                    <span>📝</span>
                                    <span>ماذا يشمل الخصم؟</span>
                                </div>
                                <p class="text-xs text-amber-950 font-medium leading-relaxed">
                                    {{ $shop->details }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- رقم التواصل -->
                    @if ($shop->phone)
                        <div class="pt-2.5 mt-3 border-t border-gray-100 text-xs text-gray-600 flex items-center justify-between font-medium">
                            <span>📞 التواصل:</span>
                            <a href="tel:{{ $shop->phone }}" class="font-bold text-indigo-700 hover:underline dir-ltr">
                                {{ $shop->phone }}
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-gray-500 text-sm font-bold">
                    لا توجد محلات مطابقة للبحث حالياً.
                </div>
            @endforelse
        </div>

        <!-- التنقل بين الصفحات -->
        @if($shops->hasPages())
            <div class="mt-8">
                {{ $shops->links() }}
            </div>
        @endif

    </main>

    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-500 font-medium mt-10">
        جميع الحقوق محفوظة &copy; {{ date('Y') }} نقابة المهندسين - فرع غزة
    </footer>

</body>
</html>