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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreignId('subscription_package_id')
                  ->nullable()
                  ->after('user_id')
                  ->constrained('subscription_packages') 
                  ->onDelete('set null');

            $table->foreignId('payment_id')
                  ->nullable()
                  ->after('status') 
                  ->constrained('payments') 
                  ->onDelete('set null')
                  ->unique(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('subscription_package_id');
            $table->dropConstrainedForeignId('payment_id');
        });
    }
};
