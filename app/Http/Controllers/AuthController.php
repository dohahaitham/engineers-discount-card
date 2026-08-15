<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 👈 مهم جداً لمنع خطأ Class Auth not found

class AuthController extends Controller
{
    // 1️⃣ عرض صفحة تسجيل الدخول
    public function showLogin()
    {
        // التحقق بالنظام المعياري لتفادي حلقة التوجيه
            if (\Illuminate\Support\Facades\Auth::check()) {
                    return redirect()->route('admin.dashboard');
                        }
                            
                                return view('admin.login');
                                }
        

        public function showChangePasswordForm()
        {
            return view('admin.change-password');
            }

            public function updatePassword(Request $request)
            {
                $request->validate([
                        'current_password' => 'required',
                                'new_password' => 'required|min:8|confirmed',
                                    ], [
                                            'current_password.required' => 'يرجى إدخال كلمة المرور الحالية.',
                                                    'new_password.required' => 'يرجى إدخال كلمة المرور الجديدة.',
                                                            'new_password.min' => 'يجب ألا تقل كلمة المرور عن 8 خانات.',
                                                                    'new_password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
                                                                        ]);

                                                                            $user = auth()->user();

                                                                                // التحقق من صحة كلمة المرور الحالية
                                                                                    if (!Hash::check($request->current_password, $user->password)) {
                                                                                            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
                                                                                                }

                                                                                                    // تحديث كلمة المرور
                                                                                                        $user->password = Hash::make($request->new_password);
                                                                                                            $user->save();

                                                                                                                return redirect()->route('admin.dashboard')->with('success', 'تم تغيير كلمة المرور بنجاح!');
                                                                                                                }

    // 2️⃣ التحقق المشفّر وتسجيل الدخول الآمن
public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ], [
        'username.required' => 'يرجى إدخال اسم المستخدم.',
        'password.required' => 'يرجى إدخال كلمة المرور.',
    ]);

    // محاولة تسجيل الدخول باسم المستخدم أو الإيميل
    $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    if (Auth::attempt([$fieldType => $request->username, 'password' => $request->password])) {
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard')->with('success', 'أهلاً بك!');
    }

    return back()->withErrors(['login_error' => 'اسم المستخدم أو كلمة المرور غير صحيحة!']);
}

    // 3️⃣ تسجيل الخروج الآمن
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('shops.index')->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}