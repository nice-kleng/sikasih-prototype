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
        Schema::create('deteksi_risikos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ibu_hamil_id')->constrained('ibu_hamils')->onDelete('cascade');

            $table->boolean('primigravida')->default(true);
            $table->boolean('primigravida_terlalu_muda')->default(false);
            $table->boolean('primigravida_terlalu_tua')->default(false);
            $table->boolean('primigravida_tua_sekunder')->default(false);
            $table->boolean('tinggi_badan_kurang_atau_sama_145')->default(false);
            $table->boolean('pernah_gagal_kehamilan')->default(false);
            $table->boolean('pernah_vakum_atau_forceps')->default(false);
            $table->boolean('pernah_operasi_sesar')->default(false);

            $table->boolean('pernah_melahirkan_bblr')->default(false);
            $table->boolean('pernah_melahirkan_cacat_bawaan')->default(false);
            $table->boolean('anemia_hb_kurang_11')->default(false);
            $table->boolean('riwayat_penyakit_kronis')->default(false);
            $table->boolean('riwayat_kelainan_obstetri_sebelumnya')->default(false);
            $table->boolean('anak_terkecil_kurang_2_tahun')->default(false);
            $table->boolean('hamil_kembar')->default(false);
            $table->boolean('hidramnion')->default(false);
            $table->boolean('bayi_mati_dalam_kandungan')->default(false);
            $table->boolean('kehamilan_lebih_bulan')->default(false);
            $table->boolean('letak_sungsang')->default(false);
            $table->boolean('letak_lintang')->default(false);

            $table->boolean('perdarahan_dalam_kehamilan_ini')->default(false);
            $table->boolean('preeklampsia')->default(false);
            $table->boolean('eklampsia')->default(false);

            $table->unsignedInteger('total_skor')->default(0);
            $table->string('kategori')->nullable();
            $table->json('rekomendasi')->nullable();
            $table->timestamp('waktu_deteksi')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deteksi_risikos');
    }
};
