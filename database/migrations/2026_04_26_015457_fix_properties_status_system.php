<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // 👈 اینو حتماً بالا اضافه کن

return new class extends Migration
{
    public function up(): void
    {
        // ✅ 1. اول پاکسازی دیتا
        DB::table('properties')
            ->whereNull('status')
            ->orWhereNotIn('status', ['pending', 'approved', 'rejected'])
            ->update(['status' => 'pending']);

        // ✅ 2. حذف approval_status
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'approval_status')) {
                $table->dropColumn('approval_status');
            }
        });

        // ✅ 3. تبدیل status به ENUM
        DB::statement("
            ALTER TABLE properties
            MODIFY status ENUM('pending','approved','rejected')
            DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('approval_status')->default('pending');
        });

        DB::statement("
            ALTER TABLE properties
            MODIFY status VARCHAR(255) NULL
        ");
    }
};
