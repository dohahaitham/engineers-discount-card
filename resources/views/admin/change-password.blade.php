<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}?v=3">
    <link rel="shortcut icon" href="{{ asset('logo.jpeg') }}?v=3">
    <link rel="apple-touch-icon" href="{{ asset('logo.jpeg') }}?v=3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تغيير كلمة المرور 🔑</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Cairo', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full bg-white rounded-3xl p-8 border border-gray-100 shadow-md">
        
        <div class="text-center mb-6">
            <div class="bg-indigo-50 border border-indigo-100 p-3 rounded-2xl w-16 h-16 mx-auto flex items-center justify-center mb-3">
                <span class="text-2xl">🔑</span>
            </div>
            <h1 class="text-xl font-extrabold text-gray-900">تغيير كلمة المرور</h1>
            <p class="text-xs text-gray-500 mt-1">قم بتحديث كلمة مرور حسابتك لإبقاء النظام آمناً</p>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs p-3 rounded-2xl mb-6 font-bold text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.update-password') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">كلمة المرور الحالية:</label>
                <input type="password" name="current_password" required placeholder="••••••••" 
                       class="w-full text-sm p-3.5 rounded-2xl border border-gray-200 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition">
                @error('current_password') 
                    <span class="text-xs text-rose-500 font-bold mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">كلمة المرور الجديدة:</label>
                <input type="password" name="new_password" required placeholder="••••••••" 
                       class="w-full text-sm p-3.5 rounded-2xl border border-gray-200 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition">
                @error('new_password') 
                    <span class="text-xs text-rose-500 font-bold mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">تأكيد كلمة المرور الجديدة:</label>
                <input type="password" name="new_password_confirmation" required placeholder="••••••••" 
                       class="w-full text-sm p-3.5 rounded-2xl border border-gray-200 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm py-3.5 rounded-2xl shadow transition mt-2">
                حفظ التغييرات 💾
            </button>
        </form>

        <div class="mt-6 text-center border-t border-gray-100 pt-4">
            <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-gray-500 hover:text-indigo-600 transition">
                ← العودة للوحة التحكم
            </a>
        </div>

    </div>

</body>
</html>