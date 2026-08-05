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
<body class="bg-slate-900 min-h-screen flex flex-col justify-between">

    <!-- 1️⃣ الهيدر العلوي -->
    <header class="bg-indigo-700/95 backdrop-blur text-white shadow-lg py-5 px-6 relative z-20">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo.jpeg') }}" alt="شعار نقابة المهندسين" class="h-16 w-16 md:h-20 md:w-20 object-contain bg-white rounded-2xl p-2 shadow-md">
                <div>
                    <h1 class="text-xl md:text-2xl font-bold">نقابة المهندسين - فلسطين 🇵🇸</h1>
                    <p class="text-indigo-200 text-xs md:text-sm mt-0.5">مركز العمل الهندسي والخدمات النقابية</p>
                </div>
            </div>
            
            <a href="{{ route('shops.index') }}" class="hidden md:inline-flex items-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 font-bold px-5 py-2.5 rounded-xl shadow transition">
                💳 برنامج الخصومات
            </a>
        </div>
    </header>

    <!-- 2️⃣ الواجهة الرئيسية التعريفية بعرض الصفحة بالكامل -->
    <main class="relative w-full flex-1 flex items-center justify-center bg-cover bg-center bg-no-repeat py-20 px-4" style="background-image: url('{{ asset('background.jpeg') }}'); min-height: calc(100vh - 100px);">
        
        <!-- طبقة مظللة شفافة -->
        <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-[2px]"></div>

        <div class="relative z-10 max-w-4xl mx-auto text-center px-4">
            
            <span class="inline-block bg-indigo-600/90 text-white font-bold text-xs md:text-sm px-4 py-1.5 rounded-full mb-6 border border-indigo-400/30 shadow-lg">
                👷‍♀️ مرحباً بكم في البوابة النقابية الرقمية
            </span>

            <h2 class="text-3xl md:text-5xl font-extrabold text-white leading-tight mb-6 drop-shadow-lg">
                نقابة المهندسين.. صرح البناء والريادة الوطنية
            </h2>

            <p class="text-slate-200 text-base md:text-xl leading-relaxed max-w-3xl mx-auto mb-10 drop-shadow">
                تسعى نقابة المهندسين إلى تقديم أفضل الخدمات المهنية والاجتماعية لمهندسينا الكرام، وتعزيز دورهم في إعادة الأعمار والبناء، وتوفير شبكة من المزايا والخصومات المخصصة لحملة بطاقة المهندس.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('shops.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-red-600 hover:bg-red-700 text-white font-black text-lg px-8 py-4 rounded-2xl shadow-2xl hover:scale-105 transition duration-300">
                    💳 الاستفادة من الخصومات المتاحة
                    <span class="text-xl">⬅️</span>
                </a>
            </div>

        </div>
    </main>

</body>
</html>