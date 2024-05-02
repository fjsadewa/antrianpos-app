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
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kategori_layanan');
            $table->integer('nomor_urut');
            $table->enum('status_antrian', ['menunggu', 'dipanggil','dilayani','selesai','lewati']);
            $table->unsignedBigInteger('id_loket_panggil')->nullable();
            $table->timestamp('waktu_panggil')->nullable();
            $table->unsignedBigInteger('id_loket_layani')->nullable();
            $table->timestamp('waktu_selesai_layani')->nullable();

            $table->foreign('id_kategori_layanan')->references('id')->on('kategori_pelayanans')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_loket_panggil')->references('id')->on('lokets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_loket_layani')->references('id')->on('lokets')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};
