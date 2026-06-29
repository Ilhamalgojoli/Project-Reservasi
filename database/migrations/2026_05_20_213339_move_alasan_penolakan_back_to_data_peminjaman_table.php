<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_peminjaman', function (Blueprint $table) {
            $table->string('alasan_penolakan')->nullable()->after('keterangan_peminjaman');
        });

        Schema::table('pembatalan_peminjaman', function (Blueprint $table) {
            $table->dropColumn('alasan_penolakan');
        });
    }

    public function down(): void
    {
        Schema::table('pembatalan_peminjaman', function (Blueprint $table) {
            $table->string('alasan_penolakan')->nullable();
        });

        Schema::table('data_peminjaman', function (Blueprint $table) {
            $table->dropColumn('alasan_penolakan');
        });
    }
};
