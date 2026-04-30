<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {

            // اگر قبلاً FK ندارد اضافه کن
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['property_id']);
        });
    }
};
