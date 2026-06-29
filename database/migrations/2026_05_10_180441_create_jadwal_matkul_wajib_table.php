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
        Schema::create('jadwal_matkul', function (Blueprint $table) {
            $table->id();
            $table->string('hari');
            $table->foreignId('ruangan_id')->constrained('ruangans')->cascadeOnDelete();
            $table->string('nama_matkul');
            $table->string('dosen')->nullable();
            $table->time('shift_mulai');
            $table->time('shift_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_matkul');
    }
};
