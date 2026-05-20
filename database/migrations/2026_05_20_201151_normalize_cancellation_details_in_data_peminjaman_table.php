<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Drop columns from data_peminjaman
        Schema::table('data_peminjaman', function (Blueprint $table) {
            $table->dropColumn(['alasan_penolakan', 'alasan_pembatalan', 'cancel_by']);
        });

        // 2. Create the 1:1 pembatalan_peminjaman table
        Schema::create('pembatalan_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_peminjaman_id')
                ->unique()
                ->constrained('data_peminjaman')
                ->cascadeOnDelete();
            
            $table->string('alasan_penolakan')->nullable();
            $table->string('alasan_pembatalan')->nullable();
            $table->string('cancel_by')->nullable();
            $table->boolean('cancel_requested')->default(false);
            $table->string('cancel_request_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // 1. Drop the table
        Schema::dropIfExists('pembatalan_peminjaman');

        // 2. Restore columns in data_peminjaman
        Schema::table('data_peminjaman', function (Blueprint $table) {
            $table->string('alasan_penolakan')->nullable()->after('keterangan_peminjaman');
            $table->string('alasan_pembatalan')->nullable()->after('alasan_penolakan');
            $table->string('cancel_by')->nullable()->after('alasan_pembatalan');
        });
    }
};
