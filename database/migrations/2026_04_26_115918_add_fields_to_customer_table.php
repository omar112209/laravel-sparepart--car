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
        Schema::table('customer', function (Blueprint $table) {
            $table->string('nama')->nullable()->after('user_id');
            $table->string('email')->nullable()->after('nama');
            $table->string('hp')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropColumn(['nama', 'email', 'hp']);
        });
    }
};
