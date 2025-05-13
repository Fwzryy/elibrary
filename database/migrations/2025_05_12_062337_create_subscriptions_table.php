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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
             // Foreign key ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->decimal('amount', 10, 2); // Jumlah Pembayaran: 20000.00
            $table->string('currency')->default('IDR'); // Mata uang, default IDR

            $table->integer('duration_days'); // Durasi langganan dalam hari

            $table->timestamp('start_date'); // Kapan langganan dimulai
            $table->timestamp('end_date');   // Kapan langganan berakhir

            $table->string('status')->default('pending'); // Status transaksi (e.g., 'pending', 'completed', 'failed', 'refunded')
            $table->string('payment_method')->nullable(); // Metode pembayaran (e.g., 'transfer_bank', 'ewallet_dana')
            $table->string('transaction_id')->unique()->nullable(); // ID transaksi dari payment gateway atau internal

             $table->text('notes')->nullable(); // Untuk catatan tambahan seperti bukti transfer

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
