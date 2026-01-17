<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            [
                'judul' => 'Persiapan Kehamilan: Apa yang Harus Dilakukan?',
                'slug' => 'persiapan-kehamilan-apa-yang-harus-dilakukan',
                'deskripsi' => 'Panduan lengkap persiapan kehamilan mulai dari pemeriksaan kesehatan hingga nutrisi yang tepat',
                'youtube_id' => 'dQw4w9WgXcQ',
                // 'thumbnail' => 'thumbnails/persiapan-kehamilan.jpg',
                'kategori' => 'persiapan_kehamilan',
                'durasi_detik' => 780,
                'views' => 1250,
                'urutan' => 1,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(30),
            ],
            [
                'judul' => 'Perkembangan Janin Trimester Pertama',
                'slug' => 'perkembangan-janin-trimester-pertama',
                'deskripsi' => 'Mengenal tahap perkembangan janin di 12 minggu pertama kehamilan',
                'youtube_id' => 'J7HIxqDpJ0Q',
                // 'thumbnail' => 'thumbnails/trimester-1.jpg',
                'kategori' => 'perkembangan_janin',
                'durasi_detik' => 650,
                'views' => 2100,
                'urutan' => 2,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(25),
            ],
            [
                'judul' => 'Senam Hamil untuk Ibu Hamil Trimester 2',
                'slug' => 'senam-hamil-trimester-2',
                'deskripsi' => 'Gerakan senam yang aman dan bermanfaat untuk ibu hamil di trimester kedua',
                'youtube_id' => 'kJQP7kiw5Fk',
                // 'thumbnail' => 'thumbnails/senam-hamil-t2.jpg',
                'kategori' => 'senam_hamil',
                'durasi_detik' => 900,
                'views' => 3400,
                'urutan' => 3,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(20),
            ],
            [
                'judul' => 'Nutrisi Penting Selama Kehamilan',
                'slug' => 'nutrisi-penting-selama-kehamilan',
                'deskripsi' => 'Makanan dan nutrisi yang wajib dikonsumsi ibu hamil untuk kesehatan ibu dan janin',
                'youtube_id' => 'lXMskKTw3Bc',
                // 'thumbnail' => 'thumbnails/nutrisi-hamil.jpg',
                'kategori' => 'nutrisi',
                'durasi_detik' => 720,
                'views' => 1890,
                'urutan' => 4,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(15),
            ],
            [
                'judul' => 'Perkembangan Janin Trimester Ketiga',
                'slug' => 'perkembangan-janin-trimester-ketiga',
                'deskripsi' => 'Fase akhir perkembangan janin menjelang persalinan',
                'youtube_id' => 'fJ9rUzIMcZQ',
                // 'thumbnail' => 'thumbnails/trimester-3.jpg',
                'kategori' => 'perkembangan_janin',
                'durasi_detik' => 680,
                'views' => 1560,
                'urutan' => 5,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'judul' => 'Persiapan Menghadapi Persalinan Normal',
                'slug' => 'persiapan-persalinan-normal',
                'deskripsi' => 'Tips dan persiapan mental serta fisik untuk menghadapi persalinan normal',
                'youtube_id' => 'qeMFqkcPYcg',
                // 'thumbnail' => 'thumbnails/persiapan-persalinan.jpg',
                'kategori' => 'persiapan_persalinan',
                'durasi_detik' => 840,
                'views' => 2890,
                'urutan' => 6,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(7),
            ],
            [
                'judul' => 'Perawatan Bayi Baru Lahir: Panduan Lengkap',
                'slug' => 'perawatan-bayi-baru-lahir',
                'deskripsi' => 'Cara merawat bayi baru lahir mulai dari memandikan hingga perawatan tali pusat',
                'youtube_id' => 'Sagg08DrO5U',
                // 'thumbnail' => 'thumbnails/perawatan-bayi.jpg',
                'kategori' => 'perawatan_bayi',
                'durasi_detik' => 1020,
                'views' => 4200,
                'urutan' => 7,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'judul' => 'Senam Hamil untuk Persiapan Persalinan',
                'slug' => 'senam-hamil-persiapan-persalinan',
                'deskripsi' => 'Latihan khusus untuk memperkuat otot panggul dan mempersiapkan persalinan',
                'youtube_id' => 'M7lc1UVf-VE',
                // 'thumbnail' => 'thumbnails/senam-persalinan.jpg',
                'kategori' => 'senam_hamil',
                'durasi_detik' => 960,
                'views' => 2750,
                'urutan' => 8,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'judul' => 'Menu Makanan Sehat untuk Ibu Hamil',
                'slug' => 'menu-makanan-sehat-ibu-hamil',
                'deskripsi' => 'Ide menu harian yang bergizi dan lezat untuk ibu hamil',
                'youtube_id' => 'djV11Xbc914',
                // 'thumbnail' => 'thumbnails/menu-sehat.jpg',
                'kategori' => 'nutrisi',
                'durasi_detik' => 600,
                'views' => 1450,
                'urutan' => 9,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'judul' => 'Tips Mengatasi Morning Sickness',
                'slug' => 'tips-mengatasi-morning-sickness',
                'deskripsi' => 'Cara alami mengatasi mual dan muntah di awal kehamilan',
                'youtube_id' => 'YQHsXMglC9A',
                // 'thumbnail' => 'thumbnails/morning-sickness.jpg',
                'kategori' => 'lainnya',
                'durasi_detik' => 480,
                'views' => 980,
                'urutan' => 10,
                'status' => 'published',
                'published_at' => Carbon::now()->subDay(),
            ],
        ];

        foreach ($videos as $video) {
            DB::table('videos')->insert([
                'judul' => $video['judul'],
                'slug' => $video['slug'],
                'deskripsi' => $video['deskripsi'],
                'youtube_id' => $video['youtube_id'],
                // 'thumbnail' => $video['thumbnail'],
                'kategori' => $video['kategori'],
                'durasi_detik' => $video['durasi_detik'],
                'views' => $video['views'],
                'urutan' => $video['urutan'],
                'status' => $video['status'],
                'published_at' => $video['published_at'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
