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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('fakultas');
            $table->string('prodi');
            $table->string('jenis_peminjaman');
            $table->integer('lantai');
            $table->string('ruangan');
            $table->string('tanggal_peminjaman');
            $table->string('jadwal_peminjaman');
            $table->integer('muatan');
            $table->string('penanggung_jawab');
            $table->integer('kontak_penanggung_jawab');
            $table->string('keterangan_peminjaman');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
