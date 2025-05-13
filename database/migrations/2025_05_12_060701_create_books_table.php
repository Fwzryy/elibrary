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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel categories
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            $table->string('title');
            $table->string('author')->nullable(); //Penulis
            $table->string('publisher')->nullable(); //Penerbit
            $table->year('publication_year')->nullable(); // Tahun Publikasi
            $table->text('description'); // Deskripsi buku (TEXT untuk panjang)
            $table->string('cover_image'); // Path ke file gambar cover
            $table->string('file_path'); // Path ke file PDF buku
            $table->integer('total_pages')->nullable(); // Jumlah halaman
            $table->string('isbn')->unique()->nullable(); // ISBN, harus unik
            $table->boolean('is_free')->default(false); // true jika gratis, false jika berbayar/terkunci

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
