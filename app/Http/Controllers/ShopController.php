<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ShopController extends Controller
{
    /**
     * عرض دليل المحلات والخصومات للجمهور (صفحة الخصومات والمحلات)
     */
    public function index(Request $request)
    {
        $query = Shop::query();

        // البحث حسب الكلمة المفتاحية (اسم المحل أو العنوان)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // الفلترة حسب التصنيف
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $shops = $query->latest()->paginate(12);
        $categories = Shop::select('category')->distinct()->pluck('category');

        return view('shops.index', compact('shops', 'categories'));
    }

    /**
     * عرض لوحة التحكم للأدمن (Dashboard)
     */
    public function adminDashboard(Request $request)
    {
        $query = Shop::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        $shops = $query->latest()->paginate(10);
        $totalShopsCount = Shop::count();

        return view('admin.dashboard', compact('shops', 'totalShopsCount'));
    }

    /**
     * عرض صفحة إنشاء محل جديد
     */
    public function create()
    {
        return view('admin.shops.create');
    }

    /**
     * حفظ محل جديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'discount' => 'required|string|max:255',
            'phone'    => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'address'  => 'nullable|string|max:255',
        ]);

        // ضمان عدم وجود قيمة فارغة لـ address أو location
        $validated['address']  = $validated['address'] ?? $validated['location'] ?? 'غير محدد';
        $validated['location'] = $validated['location'] ?? $validated['address'] ?? 'غير محدد';

        Shop::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'تمت إضافة المحل بنجاح!');
    }

    /**
     * عرض صفحة تعديل بيانات محل
     */
    public function edit(Shop $shop)
    {
        return view('admin.shops.edit', compact('shop'));
    }

    /**
     * تحديث بيانات المحل في قاعدة البيانات
     */
    public function update(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'discount' => 'required|string|max:255',
            'phone'    => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'address'  => 'nullable|string|max:255',
        ]);

        $shop->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'تم تعديل بيانات المحل بنجاح!');
    }

    /**
     * حذف محل فردي
     */
    public function destroy(Shop $shop)
    {
        $shop->delete();

        return redirect()->route('admin.dashboard')->with('success', 'تم حذف المحل بنجاح!');
    }

    /**
     * حذف مجموعة محلات محددة (حذف جماعي)
     */
    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:shops,id',
        ]);

        Shop::whereIn('id', $request->ids)->delete();

        return redirect()->route('admin.dashboard')->with('success', 'تم حذف المحلات المحددة بنجاح!');
    }

    /**
     * استيراد المحلات من كافة أنواع ملفات الإكسل (xlsx, xls, csv)
     * الترتيب المقروء: A: اسم المحل | B: التصنيفات | C: نسبة الخصم | D: العنوان | E: تفاصيل الخصم
     */
    public function importCSV(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            if (empty($rows)) {
                return redirect()->back()->with('error', 'ملف الإكسل فارغ!');
            }

            $importedCount = 0;

            // قراءة الصفوف مع تخطي الصف الأول (عناوين الأعمدة)
            foreach ($rows as $index => $row) {
                if ($index === 0) continue; // تخطي الهيدر

                // تخطي الأسطر الفارغة تماماً
                if (empty(array_filter($row, fn($val) => !is_null($val) && trim($val) !== ''))) {
                    continue;
                }

                // قراءة الأعمدة بحسب ترتيب ملفكِ
                $name     = $row[0] ?? null; // العمود A: اسم المحل
                $category = $row[1] ?? 'عام'; // العمود B: التصنيفات
                $discount = $row[2] ?? 'خصم خاص'; // العمود C: نسبة الخصم
                $location = $row[3] ?? 'غير محدد'; // العمود D: العنوان
                $details  = $row[4] ?? null; // العمود E: تفاصيل الخصم

                // دمج نسبة الخصم مع تفاصيل الخصم إن وُجدت
                $fullDiscount = trim($discount);
                if (!empty($details) && trim($details) !== '') {
                    $fullDiscount .= ' - ' . trim($details);
                }

                if (!empty($name)) {
                    Shop::create([
                        'name'     => trim($name),
                        'category' => trim($category),
                        'discount' => $fullDiscount,
                        'address'  => trim($location) ?: 'غير محدد', // حل مشكلة NOT NULL address
                        'location' => trim($location) ?: 'غير محدد',
                        'phone'    => null,
                        'details'  => $details ? trim($details) : null,
                    ]);
                    $importedCount++;
                }
            }

            return redirect()->back()->with('success', "تم استيراد {$importedCount} محلاً بنجاح من ملف الإكسل!");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء قراءة ملف الإكسل: ' . $e->getMessage());
        }
    }
}