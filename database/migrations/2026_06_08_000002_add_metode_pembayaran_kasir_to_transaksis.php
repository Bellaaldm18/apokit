<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->enum('metode_pembayaran', ['cash', 'qris', 'transfer'])->default('cash')->after('kembalian');
            $table->unsignedBigInteger('kasir_id')->nullable()->after('metode_pembayaran');
            $table->foreign('kasir_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['kasir_id']);
            $table->dropColumn(['metode_pembayaran', 'kasir_id']);
        });
    }
};
