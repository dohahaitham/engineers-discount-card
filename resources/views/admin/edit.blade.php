<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل بيانات المحل - لوحة التحكم 📝</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Tajawal', sans-serif; } 
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-sky-50/40 to-indigo-50/20 min-h-screen flex flex-col justify-between text-slate-800">

    <div>
        <!-- 1️⃣ الهيدر العلوي -->
        <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50 shadow-sm">
            <div class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo.jpeg') }}" alt="شعار النقابة" class="h-10 w-10 object-contain">
                    <div>
                        <h1 class="text-base font-extrabold text-slate-900">تعديل بيانات المحل 📝</h1>
                        <p class="text-xs text-indigo-600 font-bold">لوحة تحكم نقابة المهندسين</p>
                    </div>
                </div>

                <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-slate-600 hover:text-indigo-600 bg-slate-100 px-3.5 py-2 rounded-xl transition">
                    ← العودة للوحة التحكم
                </a>
            </div>
        </header>

        <!-- 2️⃣ نموذج التعديل -->
        <main class="max-w-2xl mx-auto px-6 py-10">
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm">
                
                <h2 class="text-lg font-bold text-slate-900 mb-6 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span>✏️</span> تعديل بيانات: <span class="text-indigo-600">{{ $shop->name }}</span>
                </h2>

                <form action="{{ route('shops.update', $shop->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- اسم المحل -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">اسم المحل أو الشركة:</label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $shop->name) }}" 
                            required 
                            class="w-full text-sm p-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition"
                        >
                    </div>

                    <!-- نسبة الخصم والتصنيف -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">نسبة الخصم (%):</label>
                            <input 
                                type="number" 
                                name="discount" 
                                value="{{ old('discount', $shop->discount) }}" 
                                step="0.1" 
                                required 
                                class="w-full text-sm p-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition"
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">تصنيف المجال:</label>
                            <select name="category" required class="w-full text-sm p-3.5 rounded-2xl border border-slate-200 bg-white focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition">
                                <option value="مطاعم وكافيهات 🍽️" {{ old('category', $shop->category) == 'مطاعم وكافيهات 🍽️' ? 'selected' : '' }}>مطاعم وكافيهات 🍽️</option>
                                <option value="مكتبات ومطابع 📚" {{ old('category', $shop->category) == 'مكتبات ومطابع 📚' ? 'selected' : '' }}>مكتبات ومطابع 📚</option>
                                <option value="مراكز طبية وصيدليات 🏥" {{ old('category', $shop->category) == 'مراكز طبية وصيدليات 🏥' ? 'selected' : '' }}>مراكز طبية وصيدليات 🏥</option>
                                <option value="مواد بناء وتجهيزات 🏗️" {{ old('category', $shop->category) == 'مواد بناء وتجهيزات 🏗️' ? 'selected' : '' }}>مواد بناء وتجهيزات 🏗️</option>
                                <option value="ملابس ومستلزمات 👕" {{ old('category', $shop->category) == 'ملابس ومستلزمات 👕' ? 'selected' : '' }}>ملابس ومستلزمات 👕</option>
                                <option value="خدمات أخرى 🛠️" {{ old('category', $shop->category) == 'خدمات أخرى 🛠️' ? 'selected' : '' }}>خدمات أخرى 🛠️</option>
                            </select>
                        </div>
                    </div>

                    <!-- العنوان -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">العنوان أو الفرع:</label>
                        <input 
                            type="text" 
                            name="address" 
                            value="{{ old('address', $shop->address) }}" 
                            required 
                            class="w-full text-sm p-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition"
                        >
                    </div>

                    <!-- التفاصيل الإضافية -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">تفاصيل الخصم أو الخدمات (اختياري):</label>
                        <textarea 
                            name="details" 
                            rows="3" 
                            class="w-full text-sm p-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition"
                        >{{ old('details', $shop->details) }}</textarea>
                    </div>

                    <!-- الأزرار -->
                    <div class="pt-4 flex items-center gap-3">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm py-3.5 rounded-2xl shadow transition">
                            حفظ التعديلات 💾
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="w-1/3 text-center bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm py-3.5 rounded-2xl transition">
                            إلغاء
                        </a>
                    </div>

                </form>

            </div>
        </main>
    </div>

    <!-- الفوتر -->
    <footer class="bg-white border-t border-slate-200/80 py-4 text-center text-xs text-slate-500 font-bold">
        <p>جميع الحقوق محفوظة © نقابة المهندسين - فلسطين 🇵🇸</p>
    </footer>

</body>
</html>