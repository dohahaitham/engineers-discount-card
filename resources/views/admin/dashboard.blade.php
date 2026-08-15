<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}?v=3">
    <link rel="shortcut icon" href="{{ asset('logo.jpeg') }}?v=3">
    <link rel="apple-touch-icon" href="{{ asset('logo.jpeg') }}?v=3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - إدارة المحلات</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen">

    <!-- الهيدر العلوي -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-2xl">🏬</span>
                <h1 class="text-xl font-bold text-gray-900">لوحة إدارة المحلات والمؤسسات</h1>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-sm font-semibold">
                    إجمالي المحلات: {{ $totalShopsCount }}
                </span>
                
                <a href="{{ route('shops.index') }}" target="_blank" class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition flex items-center gap-1 bg-gray-50 hover:bg-gray-100 px-3 py-1.5 rounded-xl border border-gray-200">
                    🌐 عرض الموقع
                </a>

                <!-- زر تغيير كلمة المرور المضاف -->
                <a href="{{ route('admin.change-password') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-xl border border-indigo-200 transition flex items-center gap-1">
                    🔑 تغيير كلمة المرور
                </a>

                <!-- زر تسجيل الخروج -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-xl border border-rose-200 transition flex items-center gap-1 cursor-pointer">
                        🚪 تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- التنبيهات والرسائل -->
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-6 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <span>✅</span>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl mb-6 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <span>⚠️</span>
                    <p class="font-medium text-sm">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- نموذج الحذف الجماعي -->
        <form action="{{ route('admin.shops.destroyMultiple') }}" method="POST" id="bulk-delete-form" onsubmit="return confirmBulkDelete()">
            @csrf

            <!-- الحاوية الخفية لـ IDs المحددة عبر الصفحات -->
            <div id="hidden-inputs-container"></div>

            <!-- شريط العمليات -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-8 space-y-4">
                
                <div class="space-y-4 md:space-y-0 md:flex md:items-center md:justify-between gap-4">
                    <!-- البحث -->
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <input type="text" name="search_input" value="{{ request('search') }}" placeholder="البحث باسم المحل أو التصنيف..." 
                                   onkeydown="if(event.key === 'Enter'){ event.preventDefault(); window.location.href='{{ route('admin.dashboard') }}?search='+this.value; }"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition">
                            <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
                        </div>
                    </div>

                    <!-- الأزرار التفاعلية -->
                    <div class="flex flex-wrap items-center gap-3">
                        
                        <!-- زر الحذف الجماعي -->
                        <button type="submit" id="delete-selected-btn" disabled class="bg-rose-50 border border-rose-200 text-rose-600 opacity-50 cursor-not-allowed px-4 py-2.5 rounded-xl font-bold text-sm transition flex items-center gap-2">
                            <span>🗑️</span>
                            <span>حذف المحددة (<span id="selected-count">0</span>)</span>
                        </button>

                        <!-- رفع ملف إكسل -->
                        <label class="cursor-pointer bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 px-4 py-2.5 rounded-xl font-bold text-sm transition flex items-center gap-2">
                            <span>📊</span>
                            <span>استيراد إكسل</span>
                            <input type="file" form="import-form" name="file" accept=".xlsx,.xls,.csv" class="hidden" onchange="document.getElementById('import-form').submit()">
                        </label>

                        <!-- زر إضافة محل جديد -->
                        <a href="{{ route('admin.shops.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg flex items-center gap-2">
                            <span>➕</span>
                            <span>إضافة محل جديد</span>
                        </a>
                    </div>
                </div>

                <!-- ملاحظة توضيحية لترتيب أعمدة الإكسل -->
                <div class="pt-3 border-t border-gray-100">
                    <div class="p-3.5 bg-blue-50/80 border-r-4 border-blue-400 rounded-xl text-sm text-blue-900">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-base">💡</span>
                            <span class="font-bold">ملاحظة هامة عند استيراد ملف الإكسل:</span>
                        </div>
                        <p class="text-xs text-blue-700 mb-2 mr-6">يرجى التأكد من ترتيب الأعمدة بداخل ملف الإكسل كالتالي من اليسار إلى اليمين:</p>
                        <ol class="list-decimal list-inside text-xs space-y-1 text-blue-800 font-bold mr-6">
                            <li>اسم المحل</li>
                            <li>التصنيفات</li>
                            <li>نسبة الخصم</li>
                            <li>العنوان</li>
                            <li>تفاصيل الخصم</li>
                        </ol>
                    </div>
                </div>

            </div>

            <!-- جدول المحلات -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 text-xs font-bold uppercase">
                                <th class="py-4 px-4 text-center w-12">
                                    <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                </th>
                                <th class="py-4 px-6">المحل / المؤسسة</th>
                                <th class="py-4 px-6">التصنيف</th>
                                <th class="py-4 px-6">نسبة الخصم</th>
                                <th class="py-4 px-6">تفاصيل الخصم والعرض</th>
                                <th class="py-4 px-6">العنوان / الفرع</th>
                                <th class="py-4 px-6 text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse ($shops as $shop)
                                <tr class="hover:bg-gray-50/80 transition">
                                    <td class="py-4 px-4 text-center">
                                        <input type="checkbox" value="{{ $shop->id }}" class="shop-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    </td>
                                    <td class="py-4 px-6 font-bold text-gray-900">
                                        {{ $shop->name }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-lg text-xs font-semibold">
                                            {{ $shop->category }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg text-xs font-bold">
                                            {{ $shop->discount }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-xs text-gray-600 max-w-xs leading-relaxed">
                                        {{ $shop->details ?? 'لا توجد تفاصيل إضافية' }}
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">
                                        {{ $shop->location ?? $shop->address ?? 'غير محدد' }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.shops.edit', $shop->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="تعديل">
                                                ✏️
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-gray-400 font-medium">
                                        لا توجد محلات لعرضها حالياً.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- أزرار التنقل بين الصفحات -->
                @if($shops->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $shops->links() }}
                    </div>
                @endif
            </div>
        </form>

        <!-- نموذج رفع الإكسل -->
        <form action="{{ route('admin.shops.import') }}" method="POST" enctype="multipart/form-data" id="import-form" class="hidden">
            @csrf
        </form>

    </main>

    <script>
        const STORAGE_KEY = 'selected_shops_ids';

        function getSelectedIds() {
            return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
        }

        function setSelectedIds(ids) {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(ids));
            updateUI();
        }

        function updateUI() {
            const selectedIds = getSelectedIds();
            const deleteBtn = document.getElementById('delete-selected-btn');
            const countSpan = document.getElementById('selected-count');
            const checkboxes = document.querySelectorAll('.shop-checkbox');
            const selectAll = document.getElementById('select-all');

            countSpan.textContent = selectedIds.length;

            if (selectedIds.length > 0) {
                deleteBtn.disabled = false;
                deleteBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                deleteBtn.classList.add('hover:bg-rose-100', 'shadow-sm');
            } else {
                deleteBtn.disabled = true;
                deleteBtn.classList.add('opacity-50', 'cursor-not-allowed');
                deleteBtn.classList.remove('hover:bg-rose-100', 'shadow-sm');
            }

            let allCurrentChecked = checkboxes.length > 0;
            checkboxes.forEach(cb => {
                const isChecked = selectedIds.includes(parseInt(cb.value));
                cb.checked = isChecked;
                if (!isChecked) allCurrentChecked = false;
            });

            if (selectAll) selectAll.checked = allCurrentChecked && checkboxes.length > 0;
        }

        document.querySelectorAll('.shop-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                let selectedIds = getSelectedIds();
                const id = parseInt(this.value);

                if (this.checked) {
                    if (!selectedIds.includes(id)) selectedIds.push(id);
                } else {
                    selectedIds = selectedIds.filter(item => item !== id);
                }

                setSelectedIds(selectedIds);
            });
        });

        const selectAll = document.getElementById('select-all');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                let selectedIds = getSelectedIds();
                const checkboxes = document.querySelectorAll('.shop-checkbox');

                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                    const id = parseInt(cb.value);
                    if (this.checked) {
                        if (!selectedIds.includes(id)) selectedIds.push(id);
                    } else {
                        selectedIds = selectedIds.filter(item => item !== id);
                    }
                });

                setSelectedIds(selectedIds);
            });
        }

        function confirmBulkDelete() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length === 0) return false;

            if (!confirm(`هل أنتِ متأكدة من حذف المحلات المحددة (${selectedIds.length} محل) من كافة الصفحات؟`)) {
                return false;
            }

            const container = document.getElementById('hidden-inputs-container');
            container.innerHTML = '';

            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                container.appendChild(input);
            });

            localStorage.removeItem(STORAGE_KEY);
            return true;
        }

        @if (session('success'))
            localStorage.removeItem(STORAGE_KEY);
        @endif

        document.addEventListener('DOMContentLoaded', updateUI);
    </script>

</body>
</html>