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
        Schema::create('subscription_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Premium 30 Hari"
            $table->string('slug')->unique(); // e.g., "premium_30_days", ini yang akan dari URL
            $table->decimal('price', 10, 2); // e.g., 20000.00
            $table->integer('duration_days'); // e.g., 30, 90
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true); // Untuk mengaktifkan/menonaktifkan paket
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_packages');
    }
};
