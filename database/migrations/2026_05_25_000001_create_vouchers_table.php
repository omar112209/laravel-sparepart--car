<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->unique();
            $table->enum('tipe', ['persen', 'nominal'])->default('persen');
            $table->decimal('nilai', 12, 2);
            $table->decimal('min_belanja', 12, 2)->default(0);
            $table->decimal('maks_diskon', 12, 2)->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->integer('batas_pakai')->default(0);
            $table->integer('dipakai')->default(0);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
