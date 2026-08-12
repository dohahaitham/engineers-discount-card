<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}?v=3">
<link rel="shortcut icon" href="{{ asset('logo.jpeg') }}?v=3">
<link rel="apple-touch-icon" href="{{ asset('logo.jpeg') }}?v=3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول الأدمن 🔐</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Tajawal', sans-serif; } </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-sky-50/40 to-indigo-50/20 min-h-screen flex items-center justify-center p-6 text-slate-800">

    <div class="max-w-md w-full bg-white rounded-3xl p-8 border border-slate-200/80 shadow-lg">
        
        <div class="text-center mb-8">
            <div class="bg-indigo-50 border border-indigo-100 p-3 rounded-2xl w-16 h-16 mx-auto flex items-center justify-center mb-3">
                <span class="text-2xl">🔐</span>
            </div>
            <h1 class="text-xl font-extrabold text-slate-900">تسجيل الدخول للوحة التحكم</h1>
            <p class="text-xs text-slate-500 mt-1">خاص بمسؤولي نقابة المهندسين</p>
        </div>

        @if($errors->has('login_error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 text-xs p-3 rounded-2xl mb-6 font-bold text-center">
                {{ $errors->first('login_error') }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">اسم المستخدم:</label>
                <input type="text" name="username" required placeholder="admin" class="w-full text-sm p-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">كلمة المرور:</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full text-sm p-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm py-3.5 rounded-2xl shadow transition mt-2">
                دخول 🚀
            </button>
        </form>

        <div class="mt-6 text-center border-t border-slate-100 pt-4">
            <a href="{{ route('shops.index') }}" class="text-xs font-bold text-slate-500 hover:text-indigo-600 transition">
                ← العودة لصفحة الخصومات
            </a>
        </div>

    </div>

</body>
</html>