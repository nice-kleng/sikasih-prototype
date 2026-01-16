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
        Schema::create('data_reproduksis', function (Blueprint $table) {
            $table->id();
            $table->string('usia_pertama_menikah')->nullable();
            $table->string('usia_hamil_pertama')->nullable();
            $table->string('jumlah_kehamilan')->nullable();
            $table->string('jumlah_persalinan')->nullable();
            $table->string('jumlah_anak_hidup')->nullable();
            $table->string('jumlah_keguguran')->nullable();
            $table->string('riwayat_persalinan_sebelumnya')->nullable();
            $table->string('jarak_antar_kehamilan_terakhir')->nullable();
            $table->text('riwayat_komplikasi_kehamilan_sebelumnya')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_reproduksis');
    }
};
