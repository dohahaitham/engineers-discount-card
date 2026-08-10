<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // 1️⃣ عرض صفحة تسجيل الدخول
    public function showLogin()
    {
        if (session('is_admin')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    // 2️⃣ التحقق من كلمة السر
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // نحدد اسم المستخدم وكلمة السر هنا (يمكنكِ تغييرها لما تحبين)
        $adminUsername = 'admin';
        $adminPassword = 'password123';

        if ($request->username === $adminUsername && $request->password === $adminPassword) {
            session(['is_admin' => true]);
            return redirect()->route('admin.dashboard')->with('success', 'أهلاً بك في لوحة التحكم! 👋');
        }

        return back()->withErrors(['login_error' => 'اسم المستخدم أو كلمة المرور غير صحيحة!']);
    }

    // 3️⃣ تسجيل الخروج
    public function logout()
    {
        session()->forget('is_admin');
        return redirect()->route('shops.index')->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}