<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Exports\ShopsExport;
use Maatwebsite\Excel\Facades\Excel;

class ShopController extends Controller
{
    /**
     * عرض دليل المحلات والخصومات بدون تقسيم صفحات وبدعم القائمة الجانبية
     */
    public function index(Request $request)
    {
        try {
            $query = Shop::query();

            // 1. البحث
            if ($request->filled('search')) {
                $search = trim($request->search);
                
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('address', 'LIKE', '%' . $search . '%')
                      ->orWhere('branches', 'LIKE', '%' . $search . '%');
                });
            }

            // 2. الفلترة حسب التصنيف (القائمة الجانبية)
            if ($request->filled('category')) {
                $query->where('category', trim($request->category));
            }

            // 3. جلب جميع المحلات دفعة واحدة في صفحة واحدة بدون paginate
            $shops = $query->latest()->get();

            // 4. جلب التصنيفات الفريدة للقائمة الجانبية
            $categories = Shop::whereNotNull('category')
                ->where('category', '!=', '')
                ->pluck('category')
                ->unique();

            return view('shops.index', compact('shops', 'categories'));

        } catch (\Throwable $e) {
            // طباعة سبب الخطأ الحقيقي مباشرة في المتصفح في حال حدثت مشكلة
            dd([
                'ErrorMessage' => $e->getMessage(),
                'File'         => $e->getFile(),
                'Line'         => $e->getLine(),
                'Code'         => $e->getCode(),
            ]);
        }
    }

    /**
     * تصدير ملف Excel
     */
    public function exportExcel()
    {
        return Excel::download(new ShopsExport, 'دليل_خصومات_نقابة_المهندسين.xlsx');
    }

    /**
     * عرض لوحة التحكم للأدمن (Dashboard)
     */
    public function adminDashboard(Request $request)
    {
        $query = Shop::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('category', 'LIKE', '%' . $search . '%');
        }

        $shops = $query->latest()->paginate(10)->appends($request->all());
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
            'name'      => 'required|string|max:255',
            'category'  => 'required|string|max:255',
            'discount'  => 'required|string|max:255',
            'location'  => 'nullable|string|max:255',
            'address'   => 'nullable|string|max:255',
            'branches'  => 'nullable|string',
            'facebook'  => 'nullable|url',
            'instagram' => 'nullable|url',
            'details'   => 'nullable|string',
        ]);

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
     * تحديث بيانات المحل
     */
    public function update(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'category'  => 'required|string|max:255',
            'discount'  => 'required|string|max:255',
            'location'  => 'nullable|string|max:255',
            'address'   => 'nullable|string|max:255',
            'branches'  => 'nullable|string',
            'facebook'  => 'nullable|url',
            'instagram' => 'nullable|url',
            'details'   => 'nullable|string',
        ]);

        $validated['address']  = $validated['address'] ?? $validated['location'] ?? 'غير محدد';
        $validated['location'] = $validated['location'] ?? $validated['address'] ?? 'غير محدد';

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
     * حذف مجموعة محلات محددة
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
     * عرض صفحة التفاصيل الخاصة بمحل محدد
     */
    public function show(Shop $shop)
    {
        // جلب محلات أخرى مقترحة من نفس التصنيف (اختياري للعرض)
        $relatedShops = Shop::where('category', $shop->category)
            ->where('id', '!=', $shop->id)
            ->take(3)
            ->get();

        return view('shops.show', compact('shop', 'relatedShops'));
    }

    /**
     * استيراد المحلات من ملف إكسل
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

            if (empty(empty($rows) ? null : $rows)) { // حماية إضافية للتحقق
                return redirect()->back()->with('error', 'ملف الإكسل فارغ!');
            }

            $importedCount = 0;

            foreach ($rows as $index => $row) {
                if ($index === 0) continue;

                if (empty(array_filter($row, fn($val) => !is_null($val) && trim((string)$val) !== ''))) {
                    continue;
                }

                $name      = isset($row[0]) ? trim((string)$row[0]) : null;
                $category  = isset($row[1]) ? trim((string)$row[1]) : 'عام';
                $discount  = isset($row[2]) ? trim((string)$row[2]) : 'خصم خاص';
                $location  = isset($row[3]) ? trim((string)$row[3]) : 'غير محدد';
                $branches  = isset($row[4]) ? trim((string)$row[4]) : null;
                $details   = isset($row[5]) ? trim((string)$row[5]) : null;
                $facebook  = isset($row[6]) ? trim((string)$row[6]) : null;
                $instagram = isset($row[7]) ? trim((string)$row[7]) : null;

                if (!empty($name)) {
                    Shop::create([
                        'name'      => $name,
                        'category'  => $category ?: 'عام',
                        'discount'  => mb_substr($discount, 0, 45, 'UTF-8'),
                        'address'   => mb_substr($location ?: 'غير محدد', 0, 191, 'UTF-8'),
                        'location'  => mb_substr($location ?: 'غير محدد', 0, 191, 'UTF-8'),
                        'branches'  => $branches,
                        'details'   => $details,
                        'facebook'  => $facebook,
                        'instagram' => $instagram,
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