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
        Schema::table('antrians', function (Blueprint $table) {
            $table->string('nama_pelayanan')->nullable()->after('id_kategori_layanan');
            $table->string('nama_petugas')->nullable()->after('nomor_urut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            $table->dropColumn('nama_pelayanan');
            $table->dropColumn('nama_petugas');
        });
    }
};
