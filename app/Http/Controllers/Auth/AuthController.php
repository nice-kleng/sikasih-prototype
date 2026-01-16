<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\IbuHamil;
use App\Models\DataSuami;
use App\Models\DataReproduksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        // Redirect jika sudah login
        if (Auth::check()) {
            return redirect()->intended('/dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        // Coba login dengan guard 'web'
        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            $user = Auth::guard('web')->user();

            // Pastikan yang login adalah ibu_hamil
            if ($user->hasRole('ibu_hamil')) {
                $request->session()->regenerate();

                // Redirect ke dashboard frontend
                return redirect()->intended('/dashboard')
                    ->with('success', 'Selamat datang, ' . $user->name);
            }

            // Jika bukan ibu hamil, logout dan tolak akses
            Auth::guard('web')->logout();

            return back()->withErrors([
                'email' => 'Halaman ini khusus untuk ibu hamil. Admin silakan login melalui panel admin.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan form register
     */
    public function showRegisterForm()
    {
        // Redirect jika sudah login
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi ibu hamil
     */
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            // Data Akun
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],

            // Data Pribadi Ibu
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16', 'unique:ibu_hamils,nik'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'alamat_lengkap' => ['required', 'string'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'no_telp' => ['required', 'string', 'min:10', 'max:15'],
            'golongan_darah' => ['nullable', 'string', 'max:10'],
            'pendidikan_terakhir' => ['required', 'string'],
            'pekerjaan' => ['nullable', 'string', 'max:100'],
            'status_pernikahan' => ['required', 'string'],

            // Data Suami
            'nama_suami' => ['required', 'string', 'max:255'],
            'umur_suami' => ['nullable', 'integer', 'min:18', 'max:80'],
            'pendidikan_suami' => ['nullable', 'string'],
            'pekerjaan_suami' => ['required', 'string', 'max:100'],
            'is_has_bpjs' => ['nullable', 'boolean'],

            // Data Reproduksi
            'usia_menikah' => ['nullable', 'integer', 'min:16', 'max:50'],
            'usia_hamil_pertama' => ['nullable', 'integer', 'min:16', 'max:50'],
            'gravida' => ['required', 'integer', 'min:1', 'max:20'],
            'para' => ['required', 'integer', 'min:0', 'max:20'],
            'anak_hidup' => ['nullable', 'integer', 'min:0', 'max:20'],
            'keguguran' => ['nullable', 'integer', 'min:0', 'max:10'],
            'riwayat_persalinan' => ['nullable', 'string'],
            'jarak_kehamilan' => ['nullable', 'string', 'max:100'],
            'riwayat_komplikasi' => ['nullable', 'string'],
        ], [
            // Custom error messages
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.digits' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid',
            'alamat_lengkap.required' => 'Alamat lengkap harus diisi',
            'kelurahan.required' => 'Kelurahan harus diisi',
            'kecamatan.required' => 'Kecamatan harus diisi',
            'no_telp.required' => 'Nomor telepon harus diisi',
            'no_telp.min' => 'Nomor telepon minimal 10 digit',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir harus diisi',
            'status_pernikahan.required' => 'Status pernikahan harus diisi',
            'nama_suami.required' => 'Nama suami harus diisi',
            'pekerjaan_suami.required' => 'Pekerjaan suami harus diisi',
            'gravida.required' => 'Gravida harus diisi',
            'gravida.min' => 'Gravida minimal 1',
            'para.required' => 'Para harus diisi',
        ]);

        try {
            DB::beginTransaction();

            // 1. Buat akun user
            $user = User::create([
                'name' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'ibu_hamil', // Set role sebagai ibu_hamil
            ]);

            // 2. Buat data ibu hamil
            $ibuHamil = IbuHamil::create([
                'user_id' => $user->id,
                'nama_lengkap' => $validated['nama_lengkap'],
                'nik' => $validated['nik'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'alamat_lengkap' => $validated['alamat_lengkap'],
                'kelurahan' => $validated['kelurahan'],
                'kecamatan' => $validated['kecamatan'],
                'no_telp' => $validated['no_telp'],
                'golongan_darah' => $validated['golongan_darah'] ?? null,
                'pendidikan_terakhir' => $validated['pendidikan_terakhir'],
                'pekerjaan' => $validated['pekerjaan'] ?? null,
                'status_pernikahan' => $validated['status_pernikahan'],
            ]);

            // 3. Buat data suami
            DataSuami::create([
                'ibu_hamil_id' => $ibuHamil->id,
                'nama_lengkap' => $validated['nama_suami'],
                'umur' => $validated['umur_suami'] ?? null,
                'pendidikan_terakhir' => $validated['pendidikan_suami'] ?? null,
                'pekerjaan' => $validated['pekerjaan_suami'],
                'is_has_bpjs' => $validated['is_has_bpjs'] ?? false,
            ]);

            // 4. Buat data reproduksi
            // DataReproduksi::create([
            //     'ibu_hamil_id' => $ibuHamil->id,
            //     'usia_menikah' => $validated['usia_menikah'] ?? null,
            //     'usia_hamil_pertama' => $validated['usia_hamil_pertama'] ?? null,
            //     'gravida' => $validated['gravida'],
            //     'para' => $validated['para'],
            //     'anak_hidup' => $validated['anak_hidup'] ?? 0,
            //     'keguguran' => $validated['keguguran'] ?? 0,
            //     'riwayat_persalinan' => $validated['riwayat_persalinan'] ?? null,
            //     'jarak_kehamilan' => $validated['jarak_kehamilan'] ?? null,
            //     'riwayat_komplikasi' => $validated['riwayat_komplikasi'] ?? null,
            // ]);

            DB::commit();

            // Auto login setelah registrasi
            Auth::guard('web')->login($user);

            return redirect('/dashboard')
                ->with('success', 'Pendaftaran berhasil! Selamat datang di SIKASIH, ' . $user->name);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.']);
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Anda telah berhasil logout');
    }
}
