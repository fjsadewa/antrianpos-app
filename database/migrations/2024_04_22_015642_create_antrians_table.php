<?php

use App\Models\KategoriPelayanan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User;
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
            $table->integer('nomor_antrian')->unsigned();
            $table->foreignIdFor(KategoriPelayanan::class)->constrained('kategori_pelayanans')->cascadeOnDelete();
            $table->enum('status', ['belum_dipanggil', 'sedang_dilayani', 'selesai'])->default('belum_dipanggil');
            $table->timestamp('waktu_daftar')->default(now());
            $table->timestamp('waktu_panggilan')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->integer('nomor_loket')->nullable();
            $table->foreignIdFor(User::class)->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
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
