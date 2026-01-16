<?php

namespace App\Http\Controllers;

use App\Models\DataReproduksi;
use App\Models\DeteksiRisiko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeteksiRisikoController extends Controller
{
    public function index()
    {
        return view('pages.deteksi-resiko');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Data Reproduksi
            'usia_menikah' => ['required', 'integer', 'min:16', 'max:50'],
            'usia_hamil_pertama' => ['required', 'integer', 'min:16', 'max:50'],
            'gravida' => ['required', 'integer', 'min:1', 'max:20'],
            'para' => ['required', 'integer', 'min:0', 'max:20'],
            'anak_hidup' => ['nullable', 'integer', 'min:0', 'max:20'],
            'keguguran' => ['nullable', 'integer', 'min:0', 'max:10'],
            'riwayat_persalinan' => ['nullable', 'string'],
            'jarak_kehamilan' => ['nullable', 'string', 'max:100'],
            'riwayat_komplikasi' => ['nullable', 'string'],
        ]);

        $user = Auth::guard('web')->user();
        $ibuHamil = $user?->ibuHamil;

        if (!$ibuHamil) {
            abort(403, 'Data ibu hamil tidak ditemukan');
        }

        // Pastikan puskesmas_id tersedia
        if (!$ibuHamil->puskesmas_id) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Data puskesmas tidak ditemukan. Silakan lengkapi profil Anda terlebih dahulu.'
                ], 422);
            }
            return back()->withErrors([
                'puskesmas' => 'Data puskesmas tidak ditemukan. Silakan lengkapi profil Anda terlebih dahulu.'
            ])->withInput();
        }

        $scores = $this->scores();

        $payload = [
            'puskesmas_id' => $ibuHamil->puskesmas_id,
            'ibu_hamil_id' => $ibuHamil->id,
            'primigravida' => true,
        ];

        $totalSkor = 0; // Skor dasar primigravida
        $hasAnyRiskChecked = false; // Flag untuk cek apakah ada risiko yang dipilih

        foreach ($scores as $field => $score) {
            $checked = $request->boolean($field);
            $payload[$field] = $checked;
            if ($checked) {
                $totalSkor += $score;
                $hasAnyRiskChecked = true;
            }
        }

        // Validasi: minimal harus ada 1 kondisi yang diceklis selain primigravida
        if (!$hasAnyRiskChecked) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Silakan pilih minimal satu kondisi risiko yang sesuai dengan kondisi ibu.',
                    'errors' => [
                        'checklist' => ['Minimal pilih satu kondisi risiko']
                    ]
                ], 422);
            }
            return back()->withErrors([
                'checklist' => 'Silakan pilih minimal satu kondisi risiko yang sesuai dengan kondisi ibu.'
            ])->withInput();
        }

        [$kategori, $rekomendasi] = $this->resultForScore($totalSkor);

        $payload['total_skor'] = $totalSkor;
        $payload['kategori'] = $kategori;
        $payload['rekomendasi'] = $rekomendasi;
        $payload['waktu_deteksi'] = now();

        $deteksi = DeteksiRisiko::create($payload);

        // Simpan data reproduksi
        DataReproduksi::create([
            'deteksi_risiko_id' => $deteksi->id,
            'usia_menikah' => $validated['usia_menikah'] ?? null,
            'usia_hamil_pertama' => $validated['usia_hamil_pertama'] ?? null,
            'gravida' => $validated['gravida'],
            'para' => $validated['para'],
            'anak_hidup' => $validated['anak_hidup'] ?? 0,
            'keguguran' => $validated['keguguran'] ?? 0,
            'riwayat_persalinan' => $validated['riwayat_persalinan'] ?? null,
            'jarak_kehamilan' => $validated['jarak_kehamilan'] ?? null,
            'riwayat_komplikasi' => $validated['riwayat_komplikasi'] ?? null,
        ]);

        $result = [
            'id' => $deteksi->id,
            'total_skor' => $totalSkor,
            'kategori' => $kategori,
            'rekomendasi' => $rekomendasi,
        ];

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Deteksi berhasil disimpan',
                'data' => $result,
            ]);
        }

        return redirect()
            ->route('deteksi-risiko')
            ->with('deteksi_result', $result)
            ->withInput();
    }

    private function scores(): array
    {
        return [
            'primigravida_anak_pertama' => 2,
            'primigravida_terlalu_muda' => 4,
            'primigravida_terlalu_tua' => 4,
            'primigravida_tua_sekunder' => 4,
            'tinggi_badan_kurang_atau_sama_145' => 4,
            'pernah_gagal_kehamilan' => 4,
            'pernah_vakum_atau_forceps' => 4,
            'pernah_operasi_sesar' => 4,
            'pernah_melahirkan_bblr' => 4,
            'pernah_melahirkan_cacat_bawaan' => 4,
            'anemia_hb_kurang_11' => 4,
            'riwayat_penyakit_kronis' => 4,
            'riwayat_kelainan_obstetri_sebelumnya' => 4,
            'anak_terkecil_kurang_2_tahun' => 4,
            'hamil_kembar' => 4,
            'hidramnion' => 4,
            'bayi_mati_dalam_kandungan' => 4,
            'kehamilan_lebih_bulan' => 4,
            'letak_sungsang' => 8,
            'letak_lintang' => 8,
            'perdarahan_dalam_kehamilan_ini' => 8,
            'preeklampsia' => 8,
            'eklampsia' => 8,
        ];
    }

    private function resultForScore(int $totalSkor): array
    {
        if ($totalSkor >= 2 && $totalSkor <= 6) {
            return [
                'Risiko Rendah (KRR)',
                [
                    'Ibu dapat melahirkan di Puskesmas atau Polindes',
                    'Lakukan pemeriksaan kehamilan rutin minimal 4 kali (1-1-2)',
                    'Konsumsi tablet tambah darah dan vitamin sesuai anjuran',
                    'Jaga pola makan bergizi seimbang',
                    'Istirahat yang cukup dan hindari stress',
                    'Persiapkan persalinan dengan baik',
                ],
            ];
        }

        if ($totalSkor >= 8 && $totalSkor <= 12) {
            return [
                'Risiko Tinggi (KRT)',
                [
                    'Ibu perlu melahirkan di Puskesmas PONED atau Rumah Sakit',
                    'Diperlukan pemeriksaan lebih intensif oleh tenaga kesehatan',
                    'Konsultasi dengan dokter spesialis kandungan',
                    'Perhatikan tanda-tanda bahaya kehamilan',
                    'Siapkan donor darah dan transportasi darurat',
                    'Pertimbangkan untuk tinggal dekat fasilitas kesehatan menjelang persalinan',
                ],
            ];
        }

        return [
            'Risiko Sangat Tinggi (KRST)',
            [
                'IBU HARUS melahirkan di Rumah Sakit',
                'Segera konsultasi dengan dokter spesialis kandungan',
                'Pemeriksaan dan monitoring ketat sangat diperlukan',
                'Persiapkan biaya, donor darah, dan transportasi darurat',
                'Jika terjadi tanda bahaya segera ke Rumah Sakit',
                'Pertimbangkan rawat inap jika diperlukan',
                'Keluarga harus siap mendampingi kapan saja',
            ],
        ];
    }
}
