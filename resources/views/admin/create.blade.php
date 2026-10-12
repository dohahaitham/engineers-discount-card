<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}?v=3">
    <link rel="shortcut icon" href="{{ asset('logo.jpeg') }}?v=3">
    <link rel="apple-touch-icon" href="{{ asset('logo.jpeg') }}?v=3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة محل / مؤسسة جديدة</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-10 flex justify-center items-center">

    <div class="w-full max-w-2xl px-4">
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
            
            <!-- الهيدر -->
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    ➕ إضافة محل / مؤسسة جديدة
                </h2>
                <a href="/admin/dashboard" class="text-sm font-semibold text-gray-500 hover:text-indigo-600 transition">
                    ← رجوع لوحة التحكم
                </a>
            </div>

            <!-- أخطاء الإدخال إن وجدت -->
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/admin/shops" method="POST" class="space-y-5">
                @csrf

                <!-- اسم المحل / المؤسسة -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">اسم المحل / المؤسسة *</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="مثال: مطعم السلام" required
                           class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700 transition">
                </div>

                <!-- التصنيف -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">التصنيف *</label>
                    <input type="text" name="category" value="{{ old('category') }}" placeholder="مثال: مطاعم، ملابس، حواسب، أطباء..." required
                           class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700 transition">
                </div>

                <!-- نسبة الخصم -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">نسبة الخصم (%) *</label>
                    <input type="text" name="discount" value="{{ old('discount') }}" placeholder="مثال: 15" required
                           class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700 transition">
                </div>

                <!-- العنوان الرئيسي -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">العنوان الرئيسي</label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="مثال: غزة - الرمال"
                           class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700 transition">
                </div>

                <!-- فروع المحل -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">فروع المحل وعناوينها (اختياري)</label>
                    <textarea name="branches" rows="3" placeholder="مثال:&#10;- فرع الرمال: شارع عمر المختار&#10;- فرع خان يونس: شارع البحر"
                              class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700 transition">{{ old('branches') }}</textarea>
                </div>

                <!-- رابط الفيسبوك -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">رابط صفحة الفيسبوك (اختياري)</label>
                    <input type="url" name="facebook" value="{{ old('facebook') }}" placeholder="https://facebook.com/yourpage"
                           class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700 transition">
                </div>

                <!-- رابط الإنستغرام -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">رابط صفحة الإنستغرام (اختياري)</label>
                    <input type="url" name="instagram" value="{{ old('instagram') }}" placeholder="https://instagram.com/youraccount"
                           class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700 transition">
                </div>

                <!-- تفاصيل الخصم -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">تفاصيل الخصم (اختياري)</label>
                    <textarea name="details" rows="3" placeholder="مثال: الخصم يشمل كافة الوجبات العائلية"
                              class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700 transition">{{ old('details') }}</textarea>
                </div>

                <!-- زر الحفظ والإضافة -->
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                    💾 حفظ وإضافة المحل
                </button>
            </form>
        </div>
    </div>

</body>
</html>