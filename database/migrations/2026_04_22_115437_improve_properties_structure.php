<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {

            // 🔥 FIX 1: ENUM instead of free string (enterprise safe)
            $table->enum('purpose', ['sale', 'rent', 'mortgage'])
                  ->default('sale')
                  ->change();

            $table->enum('type', ['house', 'apartment', 'villa'])
                  ->default('house')
                  ->change();

            // 🔥 FIX 2: performance indexes (VERY IMPORTANT)
            $table->index('location');
            $table->index('purpose');
            $table->index('type');
            $table->index('status');

        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {

            $table->dropIndex(['location']);
            $table->dropIndex(['purpose']);
            $table->dropIndex(['type']);
            $table->dropIndex(['status']);

        });
    }
};
