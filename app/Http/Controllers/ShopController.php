<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    /**
     *  عرض صفحة الخصومات والمحلات للجمهور (تظهر كافة المحلات افتراضياً مع ميزة الفلترة والبحث)
     */
    public function index(Request $request)
    {
        $query = Shop::query();

        //  الفلترة بالبحث النصي (اسم المحل، العنوان، أو التفاصيل
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('details', 'like', "%{$search}%");
            });
        }

        // 🏷️ الفلترة بحسب التصنيف (إذا اختار المهندس تصنيفاً معيناً وكان غير "الكل")
        if ($request->filled('category') && $request->category != 'الكل') {
            $query->where('category', $request->category);
        }

        $shops = $query->latest()->get();

        // قائمة التصنيفات المتاحة لعرضهاة
        $categories = [
            'الكل',
            'مطاعم وكافيهات',
            'مكتبات ومطابع ',
            'مراكز طبية',
            'محلات تجارية ',
            'ملابس ومستلزمات ',
            'خدمات أخرى ',
            'مراكز رياضية',
            'مساحات عمل وقاعات أفراح عنه'
        ];

        return view('shops.index', compact('shops', 'categories'));
    }

    /**
     *  عرض لوحة تحكم المدير (Admin Dashboard)
     */
    public function adminDashboard()
    {
        $shops = Shop::latest()->get();
        return view('admin.dashboard', compact('shops'));
    }

    /**
     *  عرض نموذج إضافة محل جديد
     */
    public function create()
    {
        return view('admin.shops.create');
    }

    /**
     *  حفظ المحل الجديد في قاعدة البيانات (مع حقل التصنيف)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'discount' => 'required|numeric',
            'address'  => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'details'  => 'nullable|string',
        ]);

        Shop::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'تمت إضافة المحل بنجاح! ✨');
    }

    /**
     *  عرض نموذج تعديل بيانات محل معين
     */
    public function edit(Shop $shop)
    {
        return view('admin.shops.edit', compact('shop'));
    }

    /**
     *  حفظ التعديلات الجديدة للمحل
     */
    public function update(Request $request, Shop $shop)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'discount' => 'required|numeric',
            'address'  => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'details'  => 'nullable|string',
        ]);

        $shop->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'تم تحديث بيانات المحل بنجاح! 📝');
    }

    /**
     *  حذف محل فردي
     */
    public function destroy(Shop $shop)
    {
        $shop->delete();

        return redirect()->route('admin.dashboard')->with('success', 'تم حذف المحل بنجاح! 🗑️');
    }

    /**
     *  حذف مجموعة محلات محددة دفعة واحدة 
     */
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Shop::whereIn('id', $ids)->delete();
            return redirect()->route('admin.dashboard')->with('success', 'تم حذف المحلات المحددة بنجاح! 🗑️');
        }

        return redirect()->route('admin.dashboard')->with('error', 'يرجى تحديد محل واحد على الأقل للحذف.');
    }

    /**
     *  استيراد المحلات من ملف Excel / CSV
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        
        // تخطي السطر الأول (العناوين)
        fgetcsv($handle);

        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if (isset($data[0]) && isset($data[1]) && isset($data[2])) {
                Shop::create([
                    'name'     => $data[0],
                    'discount' => $data[1],
                    'address'  => $data[2],
                    'category' => $data[3] ?? 'خدمات أخرى 🛠️',
                    'details'  => $data[4] ?? null,
                ]);
            }
        }

        fclose($handle);

        return redirect()->route('admin.dashboard')->with('success', 'تم استيراد المحلات من الملف بنجاح! 📊');
    }
}