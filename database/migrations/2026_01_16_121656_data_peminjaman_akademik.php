<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fakultas_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('prodi_id')->nullable()->constrained('prodi')->nullOnDelete();
            $table->string('jenis_peminjaman');
            $table->string('kode_matkul')->nullable();
            $table->integer('lantai');
            $table->foreignId('ruangan_id')->nullable()->constrained()->nullOnDelete();
            $table->string('tanggal_peminjaman');
            $table->integer('muatan');
            $table->string('penanggung_jawab');
            $table->string('kontak_penanggung_jawab');
            $table->string('user_identifier');
            $table->string('keterangan_peminjaman');
            $table->string('alasan_penolakan')->nullable();
            $table->string('alasan_pembatalan')->nullable();
            $table->string('cancel_by')->nullable();
            $table->enum('status', ['Waiting', 'Approve', 'Reject', 'Canceled', 'Finish'])->default('Waiting');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_peminjaman');
    }
};
