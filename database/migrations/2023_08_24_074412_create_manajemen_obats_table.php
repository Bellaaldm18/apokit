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
        Schema::create('manajemen_obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_batch');
            $table->date('tgl_kadaluarsa');
            $table->integer('stok');
            $table->date('tgl_penerimaan');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manajemen_obats');
    }
};
