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
   Schema::create('properties', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->string('title');
    $table->text('description')->nullable();
    $table->string('status')->nullable();
    $table->string('location')->nullable();
    $table->decimal('price', 12, 2);
    $table->integer('bedrooms');
    $table->integer('bathrooms');
    $table->integer('area');
    $table->string('image')->nullable();

    $table->softDeletes();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
