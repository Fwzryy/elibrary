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
            // Foreign key ke tabel users (siapa yang membayar)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->decimal('amount', 10, 2); // Jumlah pembayaran
            $table->string('status')->default('pending'); // Status pembayaran (e.g., 'pending', 'completed', 'failed', 'refunded')
            $table->string('payment_method')->nullable(); // Metode pembayaran (e.g., 'transfer_bank', 'ewallet_dana', 'kartu_kredit')
            $table->string('transaction_id')->unique()->nullable(); // ID transaksi dari payment gateway atau ID internal unik

            // Foreign key ke tabel subscriptions (langganan mana yang dibayar oleh transaksi ini)
            // Nullable karena mungkin ada pembayaran yang belum langsung dikaitkan dengan langganan (misal pending)
            // onDelete('set null') agar pembayaran tetap tercatat meskipun langganan mungkin dihapus
            $table->foreignId('subscription_id')->nullable()->constrained('subscriptions')->onDelete('set null');

            $table->text('notes')->nullable(); // Untuk catatan tambahan seperti detail bukti transfer manual

            $table->timestamp('paid_at')->nullable(); // Kapan pembayaran benar-benar dikonfirmasi berhasil (opsional, bisa dari created_at juga)

            $table->timestamps(); // created_at dan updated_at
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
