
<!DOCTYPE html>

<html lang="ar" dir="rtl">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}?v=3">
<link rel="shortcut icon" href="{{ asset('logo.jpeg') }}?v=3">
<link rel="apple-touch-icon" href="{{ asset('logo.jpeg') }}?v=3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل بيانات المحل</title>
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
                    ✏️ تعديل بيانات المحل
                </h2>
                <a href="/admin/dashboard" class="text-sm font-semibold text-gray-500 hover:text-indigo-600 transition">
                    ← رجوع لوحة التحكم
                </a>
            </div>

            <!-- عرض الأخطاء -->
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- نموذج التعديل موصول بـ ID المحل المباشر -->
            <form action="/admin/shops/{{ $shop->id }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- اسم المحل -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">اسم المحل / المؤسسة *</label>
                    <input type="text" name="name" value="{{ old('name', $shop->name) }}" required
                           class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700 transition">
                </div>

                <!-- التصنيف -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">التصنيف *</label>
                    <input type="text" name="category" value="{{ old('category', $shop->category) }}" required
                           class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700 transition">
                </div>

                <!-- نسبة الخصم -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">نسبة الخصم (%) *</label>
                    <input type="text" name="discount" value="{{ old('discount', $shop->discount) }}" required
                           class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700 transition">
                </div>

                <!-- العنوان -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">العنوان / الفرع</label>
                    <input type="text" name="location" value="{{ old('location', $shop->location ?? $shop->address) }}"
                           class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700 transition">
                </div>

                <!-- تفاصيل الخصم -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">تفاصيل الخصم (اختياري)</label>
                    <textarea name="details" rows="3"
                              class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700 transition">{{ old('details', $shop->details) }}</textarea>
                </div>

                <!-- أزرار الحفظ والإلغاء -->
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-md transition text-center">
                        💾 حفظ التعديلات
                    </button>
                    <a href="/admin/dashboard" class="px-6 py-3.5 rounded-xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition text-center">
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>