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
        Schema::table('data_reproduksis', function (Blueprint $table) {
            $table->foreignId('deteksi_risiko_id')->constrained('deteksi_risikos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_reproduksi', function (Blueprint $table) {
            $table->dropForeign('deteksi_risiko_id');
            $table->dropColumn('deteksi_risiko_id');
        });
    }
};
