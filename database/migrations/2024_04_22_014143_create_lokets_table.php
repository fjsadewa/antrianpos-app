<?php

use App\Models\KategoriPelayanan;
use App\Models\User;
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
        Schema::create('lokets', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_loket')->unique();
            $table->enum('status', ['terbuka', 'tertutup'])->default('terbuka');
            $table->foreignIdFor(KategoriPelayanan::class)->nullable()->constrained('kategori_pelayanans');
            $table->foreignIdFor(User::class)->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokets');
    }
};
