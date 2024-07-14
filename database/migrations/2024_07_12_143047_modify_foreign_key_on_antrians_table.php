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
            // Drop existing foreign keys
            $table->dropForeign(['id_kategori_layanan']);
            $table->dropForeign(['id_loket_panggil']);
            $table->dropForeign(['id_loket_layani']);

            // Make id_kategori_layanan nullable
            $table->unsignedBigInteger('id_kategori_layanan')->nullable()->change();

            // Recreate foreign keys with 'set null' on delete
            $table->foreign('id_kategori_layanan')
                ->references('id')
                ->on('kategori_pelayanans')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('id_loket_panggil')
                ->references('id')
                ->on('lokets')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('id_loket_layani')
                ->references('id')
                ->on('lokets')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            // Drop modified foreign keys
            $table->dropForeign(['id_kategori_layanan']);
            $table->dropForeign(['id_loket_panggil']);
            $table->dropForeign(['id_loket_layani']);

            // Revert id_kategori_layanan back to not nullable
            $table->unsignedBigInteger('id_kategori_layanan')->nullable(false)->change();

            // Recreate original foreign keys
            $table->foreign('id_kategori_layanan')
                ->references('id')
                ->on('kategori_pelayanans')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_loket_panggil')
                ->references('id')
                ->on('lokets')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_loket_layani')
                ->references('id')
                ->on('lokets')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
};
