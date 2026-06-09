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
            $table->string('detail_alamat')->nullable()->after('alamat');
            $table->string('provinsi')->nullable()->after('detail_alamat');
            $table->string('provinsi_id')->nullable()->after('provinsi');
            $table->string('kota_kabupaten')->nullable()->after('provinsi_id');
            $table->string('kota_id')->nullable()->after('kota_kabupaten');
            $table->string('kecamatan')->nullable()->after('kota_id');
            $table->string('kecamatan_id')->nullable()->after('kecamatan');
        });
    }

    public function down(): void
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropColumn([
                'detail_alamat', 'provinsi', 'provinsi_id',
                'kota_kabupaten', 'kota_id',
                'kecamatan', 'kecamatan_id',
            ]);
        });
    }
};
