<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // استخدام استعلام SQL مباشر يضمن التعديل على جميع أنواع قواعد البيانات دون الحاجة لمكتبات إضافية
        DB::statement("ALTER TABLE shops MODIFY discount VARCHAR(255) NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE shops MODIFY discount DECIMAL(5,2) NULL;");
    }
};