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
        Schema::table('ibu_hamils', function (Blueprint $table) {
            // Jika kolom belum ada, tambahkan
            if (!Schema::hasColumn('ibu_hamils', 'golongan_darah')) {
                $table->string('golongan_darah', 10)->nullable()->after('no_telp');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ibu_hamils', function (Blueprint $table) {
            if (Schema::hasColumn('ibu_hamils', 'golongan_darah')) {
                $table->dropColumn('golongan_darah');
            }
        });
    }
};
