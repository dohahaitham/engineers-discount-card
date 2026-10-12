<?php

namespace App\Exports;

use App\Models\Shop;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ShopsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    /**
     * جلب كافة المحلات
     */
    public function collection()
    {
        return Shop::all();
    }

    /**
     * عناوين أعمدة ملف الإكسل
     */
    public function headings(): array
    {
        return [
            'اسم المحل',
            'التصنيف',
            'نسبة / تفاصيل الخصم',
            'العنوان الرئيسي',
            'الفروع والعناوين',
            'تفاصيل العرض',
            'فيسبوك',
            'إنستغرام',
        ];
    }

    /**
     * تنظيم البيانات المطبوعة في كل صف
     */
    public function map($shop): array
    {
        return [
            $shop->name,
            $shop->category,
            $shop->discount,
            $shop->address,
            $shop->branches,
            $shop->details,
            $shop->facebook,
            $shop->instagram,
        ];
    }

    /**
     * تنسيق الألوان والخلفيات والخطوط (Styles)
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // تنسيق الصف الأول (صف العناوين)
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['argb' => 'FFFFFF'], // لون الخط أبيض
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '4F46E5'], // لون الخلفية بنفسجي/كحلي أنيق (Indigo)
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * إعدادات المحاذاة والاتجاه (RTL + Alignment)
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // ضبط اتجاه ورقة العمل من اليمين لليسار (RTL)
                $event->sheet->getDelegate()->setRightToLeft(true);

                // ضبط ارتفاع صف العناوين
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);

                // محاذاة كافة الخلايا بالمنتصف عمودياً
                $event->sheet->getDelegate()->getStyle('A1:H' . ($this->collection()->count() + 1))
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }
}