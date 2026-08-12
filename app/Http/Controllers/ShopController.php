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

        // جلب التصنيفات بدون تكرار وبدون مسافات مخفية زائدة
        $categories = Shop::whereNotNull('category')
            ->where('category', '!=', '')
            ->pluck('category')
            ->map(fn($cat) => trim($cat))
            ->unique()
            ->values();

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
        return view('admin.create');
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
            'details'  => 'nullable|string',
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
        return view('admin.edit', compact('shop'));
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
            'details'  => 'nullable|string',
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
     * الترتيب المقروء الذكي:
     * A: اسم المحل | B: التصنيفات | C: نسبة الخصم | D: العنوان | E: تفاصيل الخصم
     */
    public function importCSV(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $file = $request->file('file');
            $filePath = $file->getRealPath();

            $reader = IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true); 
            $spreadsheet = $reader->load($filePath);

            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            if (empty($rows)) {
                return redirect()->back()->with('error', 'ملف الإكسل فارغ!');
            }

            $importedCount = 0;

            foreach ($rows as $index => $row) {
                if ($index === 0) continue; // تخطي الهيدر

                // تخطي الصفوف الفارغة تماماً
                if (empty(array_filter($row, fn($val) => !is_null($val) && trim((string)$val) !== ''))) {
                    continue;
                }

                $name     = isset($row[0]) ? trim((string)$row[0]) : null;
                $category = isset($row[1]) ? trim((string)$row[1]) : 'عام';
                
                $colC = isset($row[2]) ? trim((string)$row[2]) : '';
                $colD = isset($row[3]) ? trim((string)$row[3]) : '';
                $colE = isset($row[4]) ? trim((string)$row[4]) : '';

                // معالجة ونسبة الخصم الذكية
                $discount = 'خصم خاص';
                $location = 'غير محدد';
                $details  = null;

                // فحص إذا كان العمود C يحتوي على نسبة أو رقم
                if (is_numeric($colC)) {
                    $val = (float)$colC;
                    $discount = ($val > 0 && $val <= 1) ? round($val * 100) . '%' : $val . '%';
                    $location = $colD;
                    $details  = $colE;
                } elseif (preg_match('/^\d+(\s*-\s*\d+)?\s*%?$/', $colC) || strlen($colC) <= 15) {
                    // إذا كانت قيمة الخصم قصيرة مثل "10%" أو "10 - 20%"
                    $discount = $colC ?: 'خصم خاص';
                    $location = $colD;
                    $details  = $colE;
                } else {
                    // في حال كانت الأعمدة مبدلة أو الخصم نص طويلاً
                    $discount = 'خصم خاص';
                    $location = $colC;
                    $details  = trim($colD . ' ' . $colE);
                }

                if (!empty($name)) {
                    Shop::create([
                        'name'     => $name,
                        'category' => $category ?: 'عام',
                        'discount' => mb_substr($discount, 0, 45, 'UTF-8'), // قص حقل الخصم لحجم آمن جداً لقواعد البيانات
                        'address'  => mb_substr($location ?: 'غير محدد', 0, 191, 'UTF-8'),
                        'location' => mb_substr($location ?: 'غير محدد', 0, 191, 'UTF-8'),
                        'phone'    => null,
                        'details'  => $details ?: null,
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