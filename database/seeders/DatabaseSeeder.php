<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DataSuami;
use App\Models\Puskesmas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ============================================
        // 1. CREATE ROLES
        // ============================================

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'filament']);
        $puskesmasRole = Role::firstOrCreate(['name' => 'puskesmas', 'guard_name' => 'filament']);
        // $tenagaKesehatanRole = Role::firstOrCreate(['name' => 'tenaga_kesehatan', 'guard_name' => 'filament']);
        $ibuHamilRole = Role::firstOrCreate(['name' => 'ibu_hamil', 'guard_name' => 'web']);

        // ============================================
        // 2. CREATE SUPER ADMIN USER
        // ============================================

        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@sikasih.id'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'status' => 'active',
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // ============================================
        // 3. CREATE PUSKESMAS
        // ============================================

        $userPuskesmas = User::firstOrCreate(
            ['email' => 'puskesmas@sikasih.id'],
            [
                'name' => 'Admin Puskesmas Sukolilo',
                'password' => bcrypt('password'),
                'status' => 'active',
            ]
        );
        $userPuskesmas->assignRole($puskesmasRole);

        $puskesmas = Puskesmas::firstOrCreate(
            ['kode_puskesmas' => 'PKM-SBY-001'],
            [
                'user_id' => $userPuskesmas->id,
                'nama_puskesmas' => 'Puskesmas Sukolilo',
                'alamat' => 'Jl. Raya Sukolilo No. 100',
                'kecamatan' => 'Sukolilo',
                'kabupaten' => 'Surabaya',
                'provinsi' => 'Jawa Timur',
                'kode_pos' => '60111',
                'no_telepon' => '031-5993456',
                'email' => 'puskesmas.sukolilo@surabaya.go.id',
                'kepala_puskesmas' => 'dr. Ahmad Fauzi',
                'fasilitas' => ['Ruang KIA', 'Laboratorium', 'Apotik', 'Ruang Persalinan'],
                'tipe' => 'poned',
                'status' => 'aktif',
            ]
        );

        // ============================================
        // 3. CREATE IBU HAMIL
        // ============================================

        $bumil = User::create([
            'name' => 'Ibu Hamil',
            'email' => 'bumil@sikasih.id',
            'password' => bcrypt('bumil'),
        ]);

        $bumil->assignRole($ibuHamilRole);

        $databumil = $bumil->ibuHamil()->create([
            'puskesmas_id' => $puskesmas->id,
            'nama_lengkap' => 'Ibu Hamil',
            'nik' => '3205082001010001',
            'tanggal_lahir' => '2001-01-01',
            'alamat_lengkap' => 'Jl. Bumil No. 1',
            'kelurahan' => 'Bumil',
            'kecamatan' => 'Bumil',
            'no_telp' => '081234567890',
            'pendidikan_terakhir' => 'SMA',
            'pekerjaan' => 'Pegawai Swasta',
            'status_pernikahan' => 'Belum Menikah',
        ]);

        DataSuami::create([
            'ibu_hamil_id' => $databumil->id,
            'nama_lengkap' => 'Suami Ibu Hamil',
            'umur' => '30',
            'pendidikan_terakhir' => 'SMA',
            'pekerjaan' => 'Pegawai Swasta',
            'is_has_bpjs' => 'Ya',
        ]);

        $this->call([
            ArtikelSeeder::class,
            VideoSeeder::class,
        ]);
    }
}
