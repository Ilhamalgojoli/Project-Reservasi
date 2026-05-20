<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambahkan alasan_penolakan kembali ke tabel utama
        Schema::table('data_peminjaman', function (Blueprint $table) {
            $table->string('alasan_penolakan')->nullable()->after('keterangan_peminjaman');
        });

        // 2. Hapus alasan_penolakan dari tabel pembatalan_peminjaman
        Schema::table('pembatalan_peminjaman', function (Blueprint $table) {
            $table->dropColumn('alasan_penolakan');
        });
    }

    public function down(): void
    {
        // Kembalikan seperti semula
        Schema::table('pembatalan_peminjaman', function (Blueprint $table) {
            $table->string('alasan_penolakan')->nullable();
        });

        Schema::table('data_peminjaman', function (Blueprint $table) {
            $table->dropColumn('alasan_penolakan');
        });
    }
};
