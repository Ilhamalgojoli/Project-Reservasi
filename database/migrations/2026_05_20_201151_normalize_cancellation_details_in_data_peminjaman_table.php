<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_peminjaman', function (Blueprint $table) {
            $table->dropColumn(['alasan_penolakan', 'alasan_pembatalan', 'cancel_by']);
        });

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
        Schema::dropIfExists('pembatalan_peminjaman');

        Schema::table('data_peminjaman', function (Blueprint $table) {
            $table->string('alasan_penolakan')->nullable()->after('keterangan_peminjaman');
            $table->string('alasan_pembatalan')->nullable()->after('alasan_penolakan');
            $table->string('cancel_by')->nullable()->after('alasan_pembatalan');
        });
    }
};
