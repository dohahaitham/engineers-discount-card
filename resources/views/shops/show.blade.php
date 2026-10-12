<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}?v=3">
    <link rel="shortcut icon" href="{{ asset('logo.jpeg') }}?v=3">
    <link rel="apple-touch-icon" href="{{ asset('logo.jpeg') }}?v=3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $shop->name }} | تفاصيل الخصم المعتمد</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- خط Tajawal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Tajawal', sans-serif; }
    </style>
</head>
<body class="bg-slate-50/80 text-gray-800 min-h-screen flex flex-col justify-between selection:bg-indigo-500 selection:text-white">

    <!-- الهيدر العلوي -->
    <header class="bg-white/90 backdrop-blur-md border-b border-gray-200/60 sticky top-0 z-30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl border border-gray-100 bg-white p-1 flex items-center justify-center shadow-xs">
                    <img src="{{ asset('logo.jpeg') }}" alt="نقابة المهندسين" class="max-h-full max-w-full object-contain">
                </div>
                <div>
                    <h1 class="text-xs sm:text-sm font-bold text-gray-900 leading-tight">نقابة المهندسين - غزة</h1>
                    <p class="text-[10px] text-indigo-600 font-semibold">دليل الخصومات</p>
                </div>
            </a>

            <a href="{{ route('shops.index') }}" class="bg-gray-100 hover:bg-gray-200/80 text-gray-700 text-xs font-bold px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 active:scale-95">
                <span>🔙</span>
                <span>العودة للدليل</span>
            </a>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 py-6 sm:py-8 flex-1 w-full">

        <!-- البطاقة الرئيسية -->
        <div class="bg-white rounded-3xl border border-gray-200/80 shadow-sm overflow-hidden">
            
            <!-- الهيدر الأنيق بدون أيقونات جانبية -->
            <div class="bg-gradient-to-b from-slate-50/80 to-white p-6 sm:p-8 border-b border-gray-100">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    
                    <div class="space-y-2">
                        <!-- وسم التصنيف والاعتماد -->
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="inline-flex items-center gap-1 bg-indigo-50 text-indigo-700 text-[11px] font-bold px-2.5 py-1 rounded-lg border border-indigo-100/80">
                                🏷️ {{ $shop->category }}
                            </span>
                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-[11px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100">
                                ✓ خصم معتمد
                            </span>
                        </div>

                        <!-- اسم المحل صافي وأنيق -->
                        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight leading-tight pt-1">
                            {{ $shop->name }}
                        </h1>
                    </div>

                    <!-- شارة الخصم -->
                    <div class="self-start sm:self-center shrink-0">
                        <div class="bg-gradient-to-r from-rose-500 to-pink-600 text-white text-xs sm:text-sm font-black px-4 py-2.5 rounded-2xl shadow-xs text-center border border-rose-400/20 flex items-center gap-1.5">
                            <span>🔥</span>
                            <span>{{ Str::contains((string)$shop->discount, 'خصم') ? $shop->discount : 'خصم ' . ($shop->discount ?? 'خاص') }}</span>
                        </div>
                    </div>

                </div>

            </div>

            <!-- محتوى البيانات -->
            <div class="p-6 sm:p-8 space-y-6">

                <!-- تفاصيل الخصم والشروط -->
                @if($shop->details)
                    <div class="space-y-2">
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                            <span>📝</span>
                            <span>تفاصيل الخصم والعرض</span>
                        </h2>
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 text-xs sm:text-sm text-gray-700 leading-relaxed font-medium whitespace-pre-line">
                            {{ $shop->details }}
                        </div>
                    </div>
                @endif

                <!-- فروع المحل -->
                @if($shop->branches)
                    <div class="space-y-2">
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                            <span>🏢</span>
                            <span>فروع المحل والعناوين</span>
                        </h2>
                        <div class="bg-indigo-50/40 rounded-2xl p-4 border border-indigo-100/60 text-xs sm:text-sm text-gray-800 leading-relaxed font-medium whitespace-pre-line">
                            {{ $shop->branches }}
                        </div>
                    </div>
                @endif

                <!-- العنوان الرئيسي وصفحات التواصل -->
                <div class="space-y-3 pt-2">
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                        <span>📍</span>
                        <span>الموقع والتواصل الاجتماعي</span>
                    </h2>

                    <!-- العنوان -->
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-base shrink-0 border border-amber-100/80">
                            📍
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">العنوان الرئيسي</p>
                            <p class="text-xs font-bold text-gray-800">{{ $shop->address ?? 'غير محدد' }}</p>
                        </div>
                    </div>

                    <!-- أزرار التواصل -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @if($shop->facebook)
                            <a href="{{ $shop->facebook }}" target="_blank" class="bg-blue-50/60 hover:bg-blue-100/80 transition rounded-2xl p-3.5 border border-blue-100/80 flex items-center justify-between text-xs font-bold text-blue-700 group">
                                <span class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs font-black">f</span>
                                    <span>صفحة الفيسبوك</span>
                                </span>
                                <span class="group-hover:translate-x-[-2px] transition-transform">👈</span>
                            </a>
                        @endif

                        @if($shop->instagram)
                            <a href="{{ $shop->instagram }}" target="_blank" class="bg-pink-50/60 hover:bg-pink-100/80 transition rounded-2xl p-3.5 border border-pink-100/80 flex items-center justify-between text-xs font-bold text-pink-700 group">
                                <span class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-lg bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 text-white flex items-center justify-center text-xs">📸</span>
                                    <span>حساب الإنستغرام</span>
                                </span>
                                <span class="group-hover:translate-x-[-2px] transition-transform">👈</span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- زر مشاركة الرابط -->
                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button onclick="shareOffer()" class="bg-gray-100 hover:bg-gray-200/80 text-gray-700 text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 cursor-pointer active:scale-95">
                        <span>🔗</span>
                        <span>مشاركة هذا الخصم</span>
                    </button>
                </div>

            </div>

        </div>

    </main>

    <!-- الفوتر -->
    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-400 font-medium">
        جميع الحقوق محفوظة &copy; {{ date('Y') }} نقابة المهندسين - فرع غزة
    </footer>

    <!-- سكربت نسخ الرابط -->
    <script>
        function shareOffer() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $shop->name }} - خصم نقابة المهندسين',
                    text: 'استفد من خصم {{ $shop->discount }} لدى {{ $shop->name }} المعتمد لدى نقابة المهندسين!',
                    url: window.location.href,
                });
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert('تم نسخ رابط الخصم بنجاح!');
            }
        }
    </script>

</body>
</html>