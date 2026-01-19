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
        Schema::create('waktu_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->time('waktu_peminjaman');
            $table->string('jenis_peminjaman');
            $table->foreignId('peminjaman_id')->constrained('data_peminjaman')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waktu_peminjaman');
    }
};
