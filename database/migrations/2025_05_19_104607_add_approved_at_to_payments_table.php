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
        
        Schema::table('payments', function (Blueprint $table) {
            // Tambahkan kolom 'approved_at' yang nullable dan bertipe timestamp
            $table->timestamp('approved_at')->nullable()->after('status');
            // 'after('status')' akan menempatkan kolom ini setelah kolom 'status'
            // Anda bisa menyesuaikan penempatannya atau menghapus 'after()' jika tidak peduli posisi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Saat rollback, hapus kolom 'approved_at'
            $table->dropColumn('approved_at');
        });
    }
};
