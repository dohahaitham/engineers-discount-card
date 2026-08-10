<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دليل خصومات بطاقة المهندس 🛡️</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Tajawal', sans-serif; }
        /* إخفاء شريط التمرير لأزرار التصنيفات مع الحفاظ على إمكانية السحب */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-sky-50/40 to-indigo-50/20 min-h-screen flex flex-col justify-between text-slate-800">

    <div>
        <!-- 1️⃣ الهيدر العلوي -->
        <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50 shadow-sm">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-slate-50 border border-slate-200 p-2 rounded-2xl shadow-sm">
                        <img src="{{ asset('logo.jpeg') }}" alt="شعار نقابة المهندسين" class="h-12 w-12 object-contain">
                    </div>
                    <div>
                        <h1 class="text-lg md:text-xl font-extrabold text-slate-900 leading-tight">نقابة المهندسين - فلسطين 🇵🇸</h1>
                        <p class="text-xs text-indigo-600 font-bold mt-0.5">دليل الخصومات والمزايا للأعضاء 💳</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="text-xs font-bold text-slate-600 hover:text-indigo-600 transition hidden sm:inline">
                        🏠 الرئيسية
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="bg-indigo-50 hover:bg-indigo-100 border border-indigo-200/80 text-indigo-700 text-xs md:text-sm font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2">
                        <span>⚙️</span> لوحة التحكم
                    </a>
                </div>
            </div>
        </header>

        <!-- 2️⃣ قسم الترحيب الرئيسي -->
        <section class="max-w-4xl mx-auto px-6 pt-10 pb-6 text-center">
            <span class="inline-block bg-indigo-100/80 text-indigo-800 font-bold text-xs px-4 py-1.5 rounded-full mb-3 border border-indigo-200/60 shadow-sm">
                ✨ دليل الخصومات الحصري
            </span>
            <h2 class="text-2xl md:text-4xl font-extrabold text-slate-900 leading-snug mb-3">
                استفد من خصومات <span class="text-indigo-600">بطاقة المهندس</span> لدى كافة المحلات المعتمدة
            </h2>
            <p class="text-slate-600 text-sm md:text-base max-w-2xl mx-auto">
                تصفح أو ابحث عن الشركات والمؤسسات المشاركة حسب المجال الذي تحتاجه بكل سهولة.
            </p>
        </section>

        <!-- 3️⃣ شبكة عرض الخصومات والتصنيفات -->
        <main class="max-w-6xl mx-auto px-6 pb-16">

            
            <form action="{{ route('shops.index') }}" method="GET" class="mb-6">
                <!-- الاحتفاظ بالتصنيف المحدد أثناء البحث -->
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <div class="relative max-w-xl mx-auto flex items-center">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="ابحث باسم المحل، المنطقة، أو التفاصيل..." 
                        class="w-full text-sm p-4 pr-12 rounded-2xl border border-slate-200 bg-white shadow-sm focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition"
                    >
                    <span class="absolute right-4 text-slate-400 text-lg">🔍</span>
                    
                    @if(request('search'))
                        <a href="{{ route('shops.index', request()->only('category')) }}" class="absolute left-3 text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold px-3 py-2 rounded-xl transition">
                            إلغاء البحث ✕
                        </a>
                    @else
                        <button type="submit" class="absolute left-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow">
                            بحث
                        </button>
                    @endif
                </div>
            </form>

            <!-- 🏷️ أزرار الفلترة بالتصنيفات -->
            <div class="flex items-center justify-center gap-2 overflow-x-auto pb-4 mb-8 no-scrollbar">
                @foreach($categories as $cat)
                    @php
                        // خيار "الكل" يكون مفعلاً تلقائياً إلا إذا اختار المهندس تصنيفاً معافاً
                        $isActive = request('category') == $cat || (!request('category') && $cat == 'الكل');
                    @endphp
                    <a 
                        href="{{ route('shops.index', array_merge(request()->only('search'), ['category' => $cat])) }}"
                        class="whitespace-nowrap px-4 py-2 rounded-2xl text-xs font-bold transition shadow-sm border {{ $isActive ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-100' }}"
                    >
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
            
            <div class="flex items-center justify-between mb-6 pb-3 border-b border-slate-200/80">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <span>🏬</span> المحلات المعتمدة
                    @if(request('category') && request('category') != 'الكل')
                        <span class="text-xs bg-indigo-50 text-indigo-700 px-3 py-1 rounded-xl font-bold border border-indigo-100">
                            قسم: {{ request('category') }}
                        </span>
                    @endif
                </h3>
                <span class="text-xs font-bold text-slate-600 bg-white border border-slate-200 px-3.5 py-1.5 rounded-full shadow-sm">
                    العدد: {{ $shops->count() }}
                </span>
            </div>

            <!-- شبكة عرض الكروت -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($shops as $shop)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between relative overflow-hidden group">
                        
                        <!-- شريط جانبي تجميلي -->
                        <div class="absolute top-0 right-0 w-2 h-full bg-indigo-600 rounded-r-full"></div>

                        <div>
                            <!-- اسم المحل والتصنيف -->
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition">
                                        {{ $shop->name }}
                                    </h4>
                                    <span class="inline-block mt-1 text-[11px] bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-lg font-bold">
                                        {{ $shop->category ?? 'خدمات أخرى 🛠️' }}
                                    </span>
                                </div>
                                
                                <span class="bg-rose-50 text-rose-600 border border-rose-200/70 font-extrabold text-xs px-3 py-1.5 rounded-2xl whitespace-nowrap shadow-sm">
                                    خصم {{ $shop->discount }}%
                                </span>
                            </div>

                            <!-- العنوان والتفاصيل -->
                            <div class="space-y-2 text-xs text-slate-600 mb-4 mt-2">
                                <p class="flex items-center gap-2">
                                    <span class="text-slate-400">📍</span>
                                    <span class="font-medium text-slate-700">{{ $shop->address }}</span>
                                </p>

                                @if($shop->details)
                                    <p class="bg-slate-50 p-3 rounded-2xl border border-slate-100 text-slate-500 leading-relaxed">
                                        {{ $shop->details }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400 font-medium">
                            <span>نقابة المهندسين</span>
                            <span class="text-indigo-600 font-bold">بطاقة مهندس نشطة 💳</span>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-sm">
                        <div class="text-4xl mb-3">🔍</div>
                        <h4 class="text-base font-bold text-slate-700">لم يتم العثور على أي محلات</h4>
                        <p class="text-xs text-slate-400 mt-1">جرب اختيار تصنيف آخر أو البحث بكلمة مختلفة.</p>
                        <a href="{{ route('shops.index') }}" class="inline-block mt-4 text-xs font-bold bg-indigo-50 text-indigo-600 px-4 py-2 rounded-xl border border-indigo-100 hover:bg-indigo-100 transition">
                            عرض جميع المحلات والخصومات
                        </a>
                    </div>
                @endforelse
            </div>

        </main>
    </div>

    <!-- 4️⃣ الفوتر السفلي -->
    <footer class="bg-white border-t border-slate-200/80 py-6 text-center text-xs text-slate-500 font-bold">
        <p>جميع الحقوق محفوظة © نقابة المهندسين - فلسطين 🇵🇸</p>
    </footer>

</body>
</html>