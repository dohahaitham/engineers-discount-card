<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دليل الخصومات والمحلات - نقابة المهندسين</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col justify-between">

    <div>
        <!-- الهيدر / شريط الملاحة -->
        <header class="bg-white border-b border-gray-100 shadow-sm py-4">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-indigo-700">خصومات نقابة المهندسين</h1>
                <a href="/" class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition">الرئيسية</a>
            </div>
        </header>

        <!-- المحتوى الرئيسي -->
        <main class="container mx-auto px-4 py-8">
            <!-- عنوان الصفحة -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">دليل المحلات والخصومات</h2>
                <p class="text-gray-600">استعرض كافة المحلات والشركات الموفرة لخصومات مهندسي نقابة المهندسين</p>
            </div>

            <!-- شريط البحث والفلترة -->
            <div class="bg-white p-6 rounded-2xl shadow-sm mb-8 border border-gray-100">
                <form action="{{ route('shops.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <!-- حقل البحث -->
                    <div class="flex-1">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="ابحث عن اسم المحل أو العنوان..." 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700">
                    </div>

                    <!-- قائمة التصنيفات -->
                    <div class="w-full md:w-64">
                        <select name="category" 
                                onchange="this.form.submit()" 
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700">
                            <option value="">جميع التصنيفات</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- زر البحث -->
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl transition font-medium">
                        بحث
                    </button>
                </form>
            </div>

            <!-- كروت عرض المحلات -->
            @if($shops->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($shops as $shop)
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                            <div>
                                <!-- التصنيف ونسبة الخصم -->
                                <div class="flex items-center justify-between mb-3">
                                    <span class="bg-indigo-50 text-indigo-700 text-xs px-3 py-1 rounded-full font-medium">
                                        {{ $shop->category }}
                                    </span>

                                    <!-- شارة نسبة الخصم والتفاصيل -->
                                    <div class="inline-flex items-center gap-1.5 bg-pink-50 text-pink-700 px-3 py-1 rounded-full text-xs font-bold" dir="auto">
                                        <span dir="ltr">{{ $shop->discount }}</span>
                                        @if(!empty($shop->details))
                                            <span class="text-xs opacity-80 border-r border-pink-200 pr-1.5 mr-0.5">
                                                {{ $shop->details }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- اسم المحل -->
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $shop->name }}</h3>

                                <!-- العنوان -->
                                @if($shop->location || $shop->address)
                                    <p class="text-gray-500 text-sm flex items-center gap-1 mb-2">
                                        📍 <span>{{ $shop->location ?? $shop->address }}</span>
                                    </p>
                                @endif

                                <!-- رقم الهاتف إن وجد -->
                                @if($shop->phone)
                                    <p class="text-gray-500 text-sm flex items-center gap-1">
                                        📞 <span dir="ltr">{{ $shop->phone }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- الترقيم والتنقل بين الصفحات -->
                <div class="mt-8">
                    {{ $shops->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-2xl border border-gray-100">
                    <p class="text-gray-500 text-lg">لا توجد محلات تطابق خيارات البحث حالياً.</p>
                </div>
            @endif
        </main>
    </div>

    <!-- الفوتر -->
    <footer class="bg-white border-t border-gray-100 py-4 text-center text-sm text-gray-500 mt-12">
        جميع الحقوق محفوظة © نقابة المهندسين - فلسطين
    </footer>

</body>
</html>