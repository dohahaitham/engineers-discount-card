<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->text('branches')->nullable()->after('address');
            $table->string('facebook')->nullable()->after('phone');
            $table->string('instagram')->nullable()->after('facebook');
        });
    }

    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn(['branches', 'facebook', 'instagram']);
        });
    }
};