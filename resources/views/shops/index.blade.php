<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دليل الخصومات - بطاقة المهندس 👷‍♂️</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Tajawal', sans-serif; } </style>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col justify-between">

    <div>
        <!-- 1️⃣ الهيدر الرئيسي مع زر العودة للرئيسية -->
        <header class="bg-indigo-700 text-white shadow-lg py-6 px-4 mb-8">
            <div class="max-w-6xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('logo.jpeg') }}" alt="شعار نقابة المهندسين" class="h-16 w-16 md:h-20 md:w-20 object-contain bg-white rounded-2xl p-2 shadow-md">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold">دليل الخصومات والشركاء 💳</h1>
                        <p class="text-indigo-200 text-xs md:text-sm mt-0.5">العروض والخصومات المعتمدة لحملة بطاقة المهندس</p>
                    </div>
                </div>

                <!-- زر العودة للصفحة التعريفية الرئيسية -->
                <a href="{{ url('/') }}" class="bg-indigo-800 hover:bg-indigo-900 text-white text-xs md:text-sm font-bold px-4 py-2.5 rounded-xl transition shadow flex items-center gap-2">
                    <span>🏠</span> الصفحة الرئيسية
                </a>
            </div>
        </header>

        <!-- 2️⃣ شبكة الخصومات والعروض -->
        <main class="max-w-6xl mx-auto px-4 pb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    🏷️ المحلات والمؤسسات المعتمدة
                </h2>
                <span class="text-xs font-bold text-slate-500 bg-white px-3 py-1.5 rounded-lg border shadow-sm">
                    إجمالي العروض: {{ $shops->count() }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($shops as $shop)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition duration-300 flex flex-col justify-between">
                        <div class="p-6">
                            <!-- اسم المحل ونسبة الخصم -->
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-bold text-slate-800">{{ $shop->name }}</h3>
                                <span class="bg-red-500 text-white font-bold text-sm px-3 py-1 rounded-full shadow-sm">خصم {{ $shop->discount }}%</span>
                            </div>

                            <!-- العنوان -->
                            <p class="text-slate-500 flex items-center gap-2 text-sm mb-3">
                                📍 <span>{{ $shop->address }}</span>
                            </p>

                            <!-- تفاصيل الخصم -->
                            @if($shop->details)
                                <div class="bg-indigo-50 border-r-4 border-indigo-500 p-3 rounded-l-lg text-xs text-indigo-900 mt-4">
                                    <span class="font-bold block mb-1">📝 تفاصيل الخصم:</span>
                                    <p class="leading-relaxed">{{ $shop->details }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="bg-slate-50 px-6 py-3 border-t text-xs text-slate-500 text-center font-medium">
                            🏷️ أبرز بطاقة المهندس للحصول على الخصم
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-16 bg-white rounded-2xl shadow-sm border border-slate-200 text-slate-500">
                        <p class="text-lg font-bold mb-1">لا توجد خصومات مضافة حالياً 🔍</p>
                        <p class="text-xs text-slate-400">سيتم إضافة العروض الجديدة فور اعتمادها من النقابة.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>

    <!-- الفوتر السفلية -->
    <footer class="bg-white border-t py-4 text-center text-xs text-slate-500">
        نقابة المهندسين - فلسطين © جميع الحقوق محفوظة
    </footer>

</body>
</html>