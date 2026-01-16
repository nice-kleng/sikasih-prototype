<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DeteksiRisiko;
use App\Models\IbuHamil;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        $ibuHamil = $user?->ibuHamil;

        if (!$ibuHamil) {
            return redirect()->route('dashboard')->with('error', 'Data ibu hamil tidak ditemukan');
        }

        // Load relasi
        $ibuHamil->load(['dataSuami']);

        // Mapping data model ke format view yang sudah ada
        $profil = [
            'nama' => $ibuHamil->nama_lengkap,
            'nik' => $ibuHamil->nik,
            'tanggal_lahir' => $ibuHamil->tanggal_lahir, // Perlu format date jika perlu
            'umur' => \Carbon\Carbon::parse($ibuHamil->tanggal_lahir)->age,
            'alamat' => $ibuHamil->alamat_lengkap,
            'no_telepon' => $ibuHamil->no_telp,
            'golongan_darah' => $ibuHamil->golongan_darah ?? '-',
            'pendidikan' => $ibuHamil->pendidikan_terakhir,
            'pekerjaan' => $ibuHamil->pekerjaan,

            // Data kehamilan dari dataReproduksi
            'usia_kehamilan' => $ibuHamil->dataReproduksi?->usia_kehamilan ?? '-',
            'satuan_kehamilan' => 'Minggu',
            'status_obstetri' => $ibuHamil->dataReproduksi?->riwayat_obstetri ?? '-', // G2P1A1 etc
            'hpht' => $ibuHamil->dataReproduksi?->hpht ?? '-',
            'hpl' => $ibuHamil->dataReproduksi?->hpl ?? '-',
            'berat_badan' => $ibuHamil->dataReproduksi?->berat_badan_awal ?? '-', // Atau BB terakhir
            'tinggi_badan' => $ibuHamil->dataReproduksi?->tinggi_badan ?? '-',

            // TODO: Ambil dari deteksi risiko terakhir
            'status_risiko' => 'Belum ada data',
            'status_risiko_class' => 'normal',

            // Statistik
            'jumlah_anc' => 0, // Bisa hitung dari tabel pemeriksaan

            // Data suami
            'nama_suami' => $ibuHamil->dataSuami?->nama_lengkap ?? '-',
            'pekerjaan_suami' => $ibuHamil->dataSuami?->pekerjaan ?? '-',
            'bpjs' => 'Ya' // Perlu field BPJS di DB
        ];

        // Ambil status risiko terakhir
        $lastRisk = DeteksiRisiko::where('ibu_hamil_id', $ibuHamil->id)
            ->latest('waktu_deteksi')
            ->first();

        if ($lastRisk) {
            $profil['status_risiko'] = $lastRisk->kategori;
            $profil['status_risiko_class'] = strtolower($lastRisk->kategori) == 'risiko tinggi' ? 'danger' : (strtolower($lastRisk->kategori) == 'risiko sedang' ? 'warning' : 'normal');
        }

        return view('pages.profile.index', compact('profil'));
    }

    public function riwayat()
    {
        $user = Auth::guard('web')->user();
        $ibuHamil = $user?->ibuHamil;

        if (!$ibuHamil) {
            return redirect()->route('dashboard');
        }

        // Ambil riwayat deteksi risiko
        $risikoHistory = DeteksiRisiko::where('ibu_hamil_id', $ibuHamil->id)
            ->orderBy('waktu_deteksi', 'desc')
            ->get();

        return view('pages.profile.riwayat', compact('ibuHamil', 'risikoHistory'));
    }

    public function edit()
    {
        $user = Auth::guard('web')->user();
        $ibuHamil = $user?->ibuHamil;

        if (!$ibuHamil) abort(404);

        // Mapping untuk form edit
        $profil = [
            'nama' => $ibuHamil->nama_lengkap,
            'nik' => $ibuHamil->nik,
            'tanggal_lahir' => $ibuHamil->tanggal_lahir,
            'alamat' => $ibuHamil->alamat_lengkap,
            'no_telepon' => $ibuHamil->no_telp,
            'golongan_darah' => $ibuHamil->golongan_darah,
            'pendidikan' => $ibuHamil->pendidikan_terakhir,
            'pekerjaan' => $ibuHamil->pekerjaan,
            'nama_suami' => $ibuHamil->dataSuami?->nama_suami,
            'pekerjaan_suami' => $ibuHamil->dataSuami?->pekerjaan_suami,
        ];

        return view('pages.profile.edit', compact('profil', 'ibuHamil'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('web')->user();
        $ibuHamil = $user?->ibuHamil;

        if (!$ibuHamil) abort(404);

        // Validasi data
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|min:10|max:15',
            'golongan_darah' => 'nullable|string',
            'pendidikan' => 'nullable|string',
            'pekerjaan' => 'nullable|string',
            'nama_suami' => 'nullable|string',
            'pekerjaan_suami' => 'nullable|string',
        ]);

        // Update Ibu Hamil
        $ibuHamil->update([
            'nama_lengkap' => $validated['nama'],
            'nik' => $validated['nik'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'alamat_lengkap' => $validated['alamat'],
            'no_telp' => $validated['no_telepon'],
            'pendidikan_terakhir' => $validated['pendidikan'],
            'pekerjaan' => $validated['pekerjaan'],
        ]);

        // Update User Name
        $user->update(['name' => $validated['nama']]);

        // Update Data Suami (create or update)
        $ibuHamil->dataSuami()->updateOrCreate(
            ['ibu_hamil_id' => $ibuHamil->id],
            [
                'nama_lengkap' => $validated['nama_suami'],
                'pekerjaan' => $validated['pekerjaan_suami'],
                // 'no_telp_suami' => '-', // Field tidak ada di fillable DataSuami
            ]
        );

        return redirect()->route('profile')->with('success', 'Data profil berhasil diperbarui');
    }
}
