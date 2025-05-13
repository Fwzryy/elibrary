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
       Schema::create('book_reads', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Foreign key ke tabel books
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');

            $table->integer('last_page_read')->nullable(); // Halaman terakhir yang dibaca 
            $table->decimal('progress_percentage', 5, 2)->nullable(); // Persentase progress baca (misal: 99.99%)
            $table->timestamp('last_read_at')->nullable(); // Waktu terakhir buku ini diakses/dibaca

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_reads');
    }
};
