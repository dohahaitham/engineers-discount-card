<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نقابة المهندسين - فلسطين 👷‍♂️</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;800;900&display=swap" rel="stylesheet">
    <style> body { font-family: 'Tajawal', sans-serif; } </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col justify-between">

    <!-- 1️⃣ الهيدر العلوي الأبيض -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm py-4 px-6 relative z-20 sticky top-0">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo.jpeg') }}" alt="شعار نقابة المهندسين" class="h-14 w-14 md:h-16 md:w-16 object-contain bg-slate-50 rounded-2xl p-1.5 border border-slate-200 shadow-sm">
                <div>
                    <h1 class="text-lg md:text-xl font-black text-slate-900 leading-tight">نقابة المهندسين - فرع غزة 🇵🇸</h1>
                    <p class="text-indigo-600 font-bold text-xs md:text-sm mt-0.5">مركز العمل الهندسي </p>
                </div>
            </div>
            
            <a href="{{ route('shops.index') }}" class="hidden md:inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition">
                💳 كافة الخصومات ({{ $totalShopsCount }})
            </a>
        </div>
    </header>

    <!-- 2️⃣ الواجهة الرئيسية التعريفية -->
    <main class="relative w-full flex-1 flex flex-col items-center justify-center bg-cover bg-center bg-no-repeat py-16 px-4" style="background-image: url('{{ asset('background.jpeg')}}'); min-height: 80vh;">
        
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/65 to-indigo-950/80 backdrop-blur-[2px]"></div>

        <div class="relative z-10 max-w-4xl mx-auto text-center px-4 mb-10">
            
            <span class="inline-flex items-center gap-2 bg-emerald-500/20 text-emerald-300 font-extrabold text-xs md:text-sm px-4 py-2 rounded-full mb-6 border border-emerald-400/40 backdrop-blur-md shadow-md">
                <span>🏗️</span> رؤية الإعمار والنهوض الهندسي
            </span>

            <h2 class="text-3xl md:text-5xl font-extrabold text-white leading-tight mb-6 drop-shadow-md">
                نقابة المهندسين.. دورة البناء والتطوير
            </h2>

            <p class="text-slate-100 text-base md:text-xl leading-relaxed max-w-3xl mx-auto font-medium drop-shadow">
                تسعى نقابة المهندسين إلى تقديم أفضل الخدمات المهنية والاجتماعية لمهندسينا الكرام، وتعزيز دورهم في إعادة الإعمار والبناء، وتوفير شبكة من المزايا والخصومات المخصصة لحملة بطاقة المهندس.
            </p>

        </div>

        <!-- 3️⃣ شريط أبرز 3 محلات + زر الاستعراض الكامل -->
        @if($shops->count() > 0)
        <div class="relative z-10 max-w-6xl w-full mx-auto px-4">
            <div class="bg-white/95 backdrop-blur-md rounded-3xl p-6 shadow-2xl border border-white/20">
                <div class="flex items-center justify-between mb-4 border-b pb-3 border-slate-200">
                    <h3 class="text-sm md:text-base font-bold text-slate-800 flex items-center gap-2">
                        🌟 عينات من الخصومات المتاحة حالياً:
                    </h3>
                    
                    <a href="{{ route('shops.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition">
                        عرض كافة المحلات ({{ $totalShopsCount }}) ←
                    </a>
                </div>

                <!-- كروت أحدث 3 محلات -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($shops as $shop)
                        <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl flex flex-col justify-between hover:border-indigo-300 transition shadow-sm">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <h4 class="font-bold text-slate-900 text-sm truncate">{{ $shop->name }}</h4>
                                <span class="bg-rose-100 text-rose-700 font-extrabold text-[11px] px-2.5 py-0.5 rounded-full whitespace-nowrap">
                                    خصم {{ $shop->discount }}%
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 truncate">📍 {{ $shop->address }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- زر الاستكشاف المباشر بالأسفل -->
                <div class="mt-5 text-center pt-2">
                    <a href="{{ route('shops.index') }}" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs md:text-sm px-8 py-3 rounded-xl transition shadow-md hover:shadow-lg">
                        🔍 استعراض كافة المحلات والخصومات الأخرى
                    </a>
                </div>
            </div>
        </div>
        @endif

    </main>

    <!-- الفوتر السفلي -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500 font-bold">
        جميع الحقوق محفوظة © نقابة المهندسين - فلسطين 🇵🇸
    </footer>

</body>
</html>