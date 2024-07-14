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
        Schema::table('lokets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
            
            $table->dropForeign(['kategori_pelayanan_id']);
            
            $table->foreign('kategori_pelayanan_id')
                ->references('id')
                ->on('kategori_pelayanans')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lokets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dropForeign(['kategori_pelayanan_id']);

            $table->foreign('kategori_pelayanan_id')
                ->references('id')
                ->on('kategori_pelayanans')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
};
