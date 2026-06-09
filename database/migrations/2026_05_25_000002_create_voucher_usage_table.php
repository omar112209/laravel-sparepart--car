<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voucher_usage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voucher_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('diskon', 12, 2);
            $table->timestamps();

            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('order')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voucher_usage');
    }
};
