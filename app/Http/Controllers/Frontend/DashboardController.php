<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Halaman Dashboard Ibu Hamil
     */
    public function index()
    {
        // Data dummy artikel
        $artikels = Artikel::latest(5)->get();
        $user = Auth::guard('web')->user();
        $ibuHamil = $user->ibuHamil;

        // Load relasi
        $ibuHamil->load(['dataSuami']);

        return view('pages.home', compact('user', 'ibuHamil', 'artikels'));
    }

    /**
     * Halaman Profil
     */
    public function profil()
    {
        $user = Auth::guard('web')->user();
        $ibuHamil = $user->ibuHamil;

        // Load relasi
        $ibuHamil->load(['dataReproduksi', 'dataSuami']);

        return view('frontend.profil', compact('user', 'ibuHamil'));
    }

    /**
     * Update Profil
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::guard('web')->user();
        $ibuHamil = $user->ibuHamil;

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_telp' => 'required|string|min:10|max:15',
            'alamat_lengkap' => 'required|string',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
        ]);

        // Update data ibu hamil
        $ibuHamil->update($validated);

        // Update nama di user juga
        $user->update([
            'name' => $validated['nama_lengkap']
        ]);

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Halaman Konsultasi
     */
    public function konsultasi()
    {
        $user = Auth::guard('web')->user();
        $ibuHamil = $user->ibuHamil;

        return view('frontend.konsultasi', compact('user', 'ibuHamil'));
    }

    /**
     * Halaman Artikel
     */
    public function artikel()
    {
        $user = Auth::guard('web')->user();

        // TODO: Ambil data artikel dari database
        $artikels = [];

        return view('frontend.artikel', compact('user', 'artikels'));
    }

    /**
     * Halaman Perawatan
     */
    public function perawatan()
    {
        $user = Auth::guard('web')->user();

        return view('pages.perawatan', compact('user'));
    }

    /**
     * Detail Artikel
     */
    public function artikelDetail($id)
    {
        $user = Auth::guard('web')->user();

        // TODO: Ambil data artikel by ID

        return view('frontend.artikel-detail', compact('user'));
    }

    /**
     * Halaman Jadwal Pemeriksaan
     */
    public function jadwal()
    {
        $user = Auth::guard('web')->user();
        $ibuHamil = $user->ibuHamil;

        // TODO: Ambil jadwal pemeriksaan dari database
        $jadwals = [];

        return view('frontend.jadwal', compact('user', 'ibuHamil', 'jadwals'));
    }

    /**
     * Halaman Riwayat Pemeriksaan
     */
    public function riwayat()
    {
        $user = Auth::guard('web')->user();
        $ibuHamil = $user->ibuHamil;

        // TODO: Ambil riwayat pemeriksaan dari database
        $riwayats = [];

        return view('frontend.riwayat', compact('user', 'ibuHamil', 'riwayats'));
    }
}
