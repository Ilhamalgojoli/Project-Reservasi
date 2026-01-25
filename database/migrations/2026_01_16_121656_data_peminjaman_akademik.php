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
        Schema::create('data_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('fakultas');
            $table->string('prodi');
            $table->string('jenis_peminjaman');
            $table->string('kode_matkul')->nullable();
            $table->integer('lantai');
            $table->integer('ruangan');
            $table->string('tanggal_peminjaman');
            $table->integer('muatan');
            $table->string('penanggung_jawab');
            $table->string('kontak_penanggung_jawab');
            $table->string('keterangan_peminjaman');
            $table->enum('status', ['Waiting', 'Approve', 'Reject'])->default('Waiting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_peminjaman');
    }
};
