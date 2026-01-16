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
        Schema::create('data_suamis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ibu_hamil_id')->constrained('ibu_hamils')->onDelete('cascade');
            $table->string('nama_lengkap')->nullable();
            $table->string('umur')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('is_has_bpjs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_suamis');
    }
};
