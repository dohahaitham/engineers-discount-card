<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('shops', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('discount')->nullable();
        $table->string('address');
        $table->text('details')->nullable(); // 👈 أضيفي هذا السطر هنا
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::table('shops', function (Blueprint $table) {
        $table->dropColumn('details');
    });
}
};


