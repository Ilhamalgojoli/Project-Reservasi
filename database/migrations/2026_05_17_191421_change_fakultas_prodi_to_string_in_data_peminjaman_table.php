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
        Schema::table('data_peminjaman', function (Blueprint $table) {
            $table->dropForeign(['fakultas_id']);
            $table->dropForeign(['prodi_id']);
            $table->dropColumn(['fakultas_id', 'prodi_id']);
            
            $table->string('fakultas')->nullable()->after('id');
            $table->string('prodi')->nullable()->after('fakultas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_peminjaman', function (Blueprint $table) {
            $table->dropColumn(['fakultas', 'prodi']);
            $table->foreignId('fakultas_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('prodi_id')->nullable()->constrained('prodi')->nullOnDelete();
        });
    }
};
