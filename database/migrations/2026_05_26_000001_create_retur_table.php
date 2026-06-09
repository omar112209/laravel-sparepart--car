<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('retur', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('order_item_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('produk_id');
            $table->integer('quantity');
            $table->text('alasan');
            $table->string('foto')->nullable();
            $table->string('status')->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('order')->onDelete('cascade');
            $table->foreign('order_item_id')->references('id')->on('order_item')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('retur');
    }
};
