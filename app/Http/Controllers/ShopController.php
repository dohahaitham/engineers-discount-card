<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // 1️⃣ عرض صفحة الخصومات والمحلات للمهندسين
    public function index()
    {
        $shops = Shop::latest()->get();
        return view('shops.index', compact('shops'));
    }

    // 2️⃣ عرض لوحة تحكم المدير
    public function adminDashboard()
    {
        $shops = Shop::latest()->get();
        return view('admin.dashboard', compact('shops'));
    }

    // 3️⃣ عرض صفحة إضافة محل جديد يدويّاً
    public function create()
    {
        return view('admin.create');
    }

    // 4️⃣ حفظ المحل الجديد في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'discount' => 'required|numeric|min:0|max:100',
            'address'  => 'required|string|max:255',
            'details'  => 'nullable|string',
        ]);

        Shop::create([
            'name'     => $request->name,
            'discount' => $request->discount,
            'address'  => $request->address,
            'details'  => $request->details,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'تمت إضافة المحل بنجاح!');
    }

    // 5️⃣ حذف محل من قاعدة البيانات
    public function destroy(Shop $shop)
    {
        $shop->delete();
        return redirect()->route('admin.dashboard')->with('success', 'تم حذف المحل بنجاح!');
    }

    // 6️⃣ استيراد المحلات دفعة واحدة من ملف CSV مع معالجة الخصم التلقائية
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('file');
        $filePath = $file->getRealPath();

        // قراءة محتوى الملف مع مراعاة ترميز اللغة العربية
        $content = file_get_contents($filePath);
        if (!mb_check_encoding($content, 'UTF-8')) {
            $content = mb_convert_encoding($content, 'UTF-8', 'Windows-1256');
        }

        // تقسيم الملف إلى أسطر
        $lines = explode("\n", str_replace("\r", "", $content));

        // تخطي السطر الأول (عناوين الأعمدة)
        array_shift($lines);

        foreach ($lines as $line) {
            if (empty(trim($line))) continue;

            // التعرف التلقائي على الفاصلة (سواء كانت , أو ;)
            $delimiter = strpos($line, ';') !== false ? ';' : ',';
            $data = str_getcsv($line, $delimiter);

            $name = isset($data[0]) ? trim($data[0]) : '';

            // حفظ المحل فقط إذا كان اسم المحل موجوداً
            if (!empty($name)) {
                // استخراج الرقم فقط من عمود الخصم (حتى لو كان مكتوباً 10% أو "خصم 10")
                $rawDiscount = isset($data[1]) ? trim($data[1]) : '0';
                preg_match('/\d+/', $rawDiscount, $matches);
                $discount = isset($matches[0]) ? (float)$matches[0] : 0;

                $address  = isset($data[2]) ? trim($data[2]) : '';
                $details  = isset($data[3]) ? trim($data[3]) : null;

                Shop::create([
                    'name'     => $name,
                    'discount' => $discount,
                    'address'  => $address,
                    'details'  => $details,
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'تم استيراد كافة المحلات بنجاح من الملف!');
    }
    // 7️⃣ حذف مجموعة محلات محددة دفعة واحدة
    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'shop_ids' => 'required|array',
            'shop_ids.*' => 'exists:shops,id',
        ]);

        Shop::whereIn('id', $request->shop_ids)->delete();

        return redirect()->route('admin.dashboard')->with('success', 'تم حذف المحلات المحددة بنجاح!');
    }
}