<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('library_id_number')->unique()->nullable()->after('role'); 

            $table->string('profile_photo_path', 2048)->nullable()->after('library_id_number');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('library_id_number');
            $table->dropColumn('profile_photo_path');
        });
    }
};