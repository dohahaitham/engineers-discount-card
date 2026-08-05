<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة محل جديد ➕</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Tajawal', sans-serif; } </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-lg border">
        
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-xl font-bold text-slate-800">إضافة محل جديد للخصومات 🏬</h2>
            <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-800 text-sm font-bold">⬅️ العودة للوحة التحكّم</a>
        </div>

        <form action="{{ route('shops.store') }}" method="POST">
            @csrf

            <!-- اسم المحل -->
            <div class="mb-4">
                <label class="block text-slate-700 font-bold mb-2">اسم المحل / المؤسسة</label>
                <input type="text" name="name" required placeholder="مثال: مطعم السفير" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- نسبة الخصم -->
            <div class="mb-4">
                <label class="block text-slate-700 font-bold mb-2">نسبة الخصم (%)</label>
                <input type="number" name="discount" required placeholder="مثال: 20" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- العنوان -->
            <div class="mb-4">
                <label class="block text-slate-700 font-bold mb-2">العنوان / الفرع</label>
                <input type="text" name="address" required placeholder="مثال: غزة - الرمال" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- تفاصيل الخصم الجديدة -->
            <div class="mb-6">
                <label class="block text-slate-700 font-bold mb-2">تفاصيل الخصم (اختياري)</label>
                <textarea name="details" rows="3" placeholder="مثال: الخصم يشمل كافة المأكولات عند إبراز بطاقة المهندس ولا يشمل المشروبات" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <!-- زر الحفظ -->
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow-md transition">
                💾 حفظ الخصم ونشره
            </button>
        </form>

    </div>

</body>
</html>