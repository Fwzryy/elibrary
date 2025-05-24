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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
              // User yang melakukan pembayaran
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->decimal('amount', 10, 2); // Jumlah nominal yang dibayarkan
            // Status pembayaran (e.g., 'status', ['pending', 'approved', 'rejected'])
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); 
            // Metode pembayaran: e.g., 'transfer_bank', 'dana', 'ovo', dll
            $table->string('payment_method'); 
            // ID transaksi dari payment gateway atau ID internal unik
            $table->string('transaction_id')->unique()->nullable(); 
            // Foreign key ke tabel subscriptions (langganan mana yang dibayar oleh transaksi ini)
            // Nullable karena mungkin ada pembayaran yang belum langsung dikaitkan dengan langganan (misal pending)
            // onDelete('set null') agar pembayaran tetap tercatat meskipun langganan mungkin dihapus
            $table->foreignId('subscription_id')->nullable()->constrained('subscriptions')->onDelete('set null');
            // Path gambar bukti pembayaran (jika pembayaran manual)
            $table->string('proof_image')->nullable();
            // Untuk catatan tambahan seperti detail bukti transfer manual
            $table->text('notes')->nullable(); 
             // Kapan pembayaran dikonfirmasi oleh admin
            $table->timestamp('paid_at')->nullable();
             // created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
