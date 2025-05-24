<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
Schema::table('payments', function (Blueprint $table) {
// 1. Ubah kolom subscription_id menjadi unsignedBigInteger
// Ini memastikan tipe data yang benar untuk foreign key.
// Jika foreign key lama masih ada, Laravel akan mencoba mengubahnya atau
// mengabaikan drop implisit jika constraint sudah tidak ada.
$table->unsignedBigInteger('subscription_id')->nullable()->change();

        // 2. Tambahkan foreign key baru yang merujuk ke tabel 'subscription_packages'
        // Laravel akan secara otomatis memberi nama foreign key baru.
        // Jika foreign key lama masih ada dengan nama yang sama, ini bisa menyebabkan konflik.
        // Oleh karena itu, kita asumsikan foreign key lama sudah terlepas atau namanya berbeda.
        $table->foreign('subscription_id')
              ->references('id')
              ->on('subscription_packages')
              ->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('payments', function (Blueprint $table) {
        // Drop foreign key yang baru dibuat (yang merujuk ke subscription_packages)
        // Laravel akan mencoba menebak nama foreign key.
        $table->dropForeign(['subscription_id']);

        // Kembalikan foreign key yang lama (opsional, tergantung kebutuhan rollback)
        // Ini akan menambahkan kembali foreign key ke tabel 'subscriptions'
        $table->foreign('subscription_id')
              ->references('id')
              ->on('subscriptions') // Merujuk kembali ke tabel 'subscriptions'
              ->onDelete('set null');
    });
}
};