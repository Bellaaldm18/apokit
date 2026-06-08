<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('manajemen_obats', function (Blueprint $table) {
            $table->boolean('is_obat_keras')->default(false)->after('catatan');
            $table->text('komposisi')->nullable()->after('is_obat_keras');
        });
    }

    public function down(): void
    {
        Schema::table('manajemen_obats', function (Blueprint $table) {
            $table->dropColumn(['is_obat_keras', 'komposisi']);
        });
    }
};
