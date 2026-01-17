<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artikels = [
            [
                'penulis_id' => 1,
                'judul' => 'Pentingnya Asam Folat untuk Ibu Hamil',
                'slug' => 'pentingnya-asam-folat-untuk-ibu-hamil',
                'excerpt' => 'Asam folat merupakan nutrisi penting yang harus dikonsumsi oleh ibu hamil untuk mencegah cacat tabung saraf pada janin.',
                'konten' => '<p>Asam folat adalah vitamin B yang sangat penting untuk perkembangan janin, terutama pada trimester pertama kehamilan.</p><p>Kekurangan asam folat dapat menyebabkan cacat tabung saraf seperti spina bifida. Ibu hamil disarankan mengonsumsi 400-800 mcg asam folat per hari.</p><p>Sumber asam folat alami termasuk sayuran hijau, kacang-kacangan, jeruk, dan biji-bijian yang diperkaya.</p>',
                'gambar_utama' => 'images/asam-folat.jpg',
                'kategori' => 'nutrisi',
                'tags' => 'asam folat,vitamin,nutrisi kehamilan,trimester pertama',
                'views' => 2450,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(40),
            ],
            [
                'penulis_id' => 1,
                'judul' => 'Olahraga Aman untuk Ibu Hamil Trimester 1',
                'slug' => 'olahraga-aman-ibu-hamil-trimester-1',
                'excerpt' => 'Panduan olahraga yang aman dan bermanfaat untuk ibu hamil di trimester pertama.',
                'konten' => '<p>Olahraga ringan sangat dianjurkan selama kehamilan untuk menjaga kesehatan ibu dan janin.</p><p>Beberapa olahraga yang aman di trimester pertama meliputi jalan santai, yoga prenatal, dan berenang.</p><p>Hindari olahraga dengan risiko jatuh atau benturan. Konsultasikan dengan dokter sebelum memulai program olahraga baru.</p>',
                'gambar_utama' => 'images/olahraga-hamil.jpg',
                'kategori' => 'olahraga',
                'tags' => 'olahraga,trimester 1,aktivitas fisik,yoga',
                'views' => 1890,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(35),
            ],
            [
                'penulis_id' => 2,
                'judul' => 'Perkembangan Janin Minggu ke-12',
                'slug' => 'perkembangan-janin-minggu-12',
                'excerpt' => 'Mengenal tahap perkembangan janin pada akhir trimester pertama kehamilan.',
                'konten' => '<p>Pada minggu ke-12, janin sudah berukuran sekitar 5-6 cm dengan berat 14 gram.</p><p>Semua organ utama sudah terbentuk dan mulai berfungsi. Jari tangan dan kaki sudah terpisah sempurna, dan kuku mulai tumbuh.</p><p>Detak jantung janin dapat terdeteksi dengan Doppler, dan janin sudah mulai dapat membuat gerakan kecil.</p>',
                'gambar_utama' => 'images/janin-12-minggu.jpg',
                'kategori' => 'perkembangan_janin',
                'tags' => 'perkembangan janin,minggu 12,trimester 1,USG',
                'views' => 3200,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(30),
            ],
            [
                'penulis_id' => 1,
                'judul' => 'Tanda Bahaya Kehamilan yang Harus Diwaspadai',
                'slug' => 'tanda-bahaya-kehamilan',
                'excerpt' => 'Kenali tanda-tanda bahaya selama kehamilan yang memerlukan penanganan medis segera.',
                'konten' => '<p>Setiap ibu hamil perlu mengenali tanda bahaya yang memerlukan perhatian medis segera.</p><p>Tanda bahaya meliputi: perdarahan hebat, nyeri perut yang parah, demam tinggi, sakit kepala berat yang tidak hilang, pandangan kabur, dan berkurangnya gerakan janin.</p><p>Jika mengalami salah satu tanda ini, segera hubungi dokter atau pergi ke rumah sakit terdekat.</p>',
                'gambar_utama' => 'images/tanda-bahaya.jpg',
                'kategori' => 'tanda_bahaya',
                'tags' => 'tanda bahaya,komplikasi,emergency,kesehatan ibu',
                'views' => 4100,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(25),
            ],
            [
                'penulis_id' => 2,
                'judul' => 'Persiapan Tas Persalinan: Checklist Lengkap',
                'slug' => 'persiapan-tas-persalinan',
                'excerpt' => 'Daftar lengkap barang-barang yang perlu disiapkan dalam tas persalinan untuk ibu dan bayi.',
                'konten' => '<p>Persiapan tas persalinan sebaiknya dilakukan sejak trimester ketiga untuk mengantisipasi persalinan yang datang lebih cepat.</p><p>Untuk ibu: baju ganti, perlengkapan mandi, pembalut khusus nifas, nursing bra, dokumen penting.</p><p>Untuk bayi: popok, baju bayi, bedong, topi, sarung tangan kaki, dan selimut.</p><p>Jangan lupa bawa buku KIA, hasil USG terakhir, dan kartu BPJS/asuransi.</p>',
                'gambar_utama' => 'images/tas-persalinan.jpg',
                'kategori' => 'persiapan_persalinan',
                'tags' => 'persiapan persalinan,tas persalinan,checklist,perlengkapan bayi',
                'views' => 2890,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(20),
            ],
            [
                'penulis_id' => 1,
                'judul' => 'Tips Mengatasi Nyeri Punggung Saat Hamil',
                'slug' => 'mengatasi-nyeri-punggung-hamil',
                'excerpt' => 'Cara alami dan aman untuk mengurangi nyeri punggung yang sering dialami ibu hamil.',
                'konten' => '<p>Nyeri punggung adalah keluhan umum selama kehamilan akibat perubahan postur dan berat badan.</p><p>Tips mengatasi: gunakan bantal penyangga saat tidur, hindari sepatu hak tinggi, jaga postur tubuh yang baik, lakukan peregangan ringan, dan kompres hangat pada area yang nyeri.</p><p>Jika nyeri sangat mengganggu atau disertai gejala lain, konsultasikan dengan dokter.</p>',
                'gambar_utama' => 'images/nyeri-punggung.jpg',
                'kategori' => 'tips_kehamilan',
                'tags' => 'nyeri punggung,tips hamil,kenyamanan,keluhan kehamilan',
                'views' => 1750,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(15),
            ],
            [
                'penulis_id' => 2,
                'judul' => 'Menjaga Kesehatan Mental Ibu Hamil',
                'slug' => 'kesehatan-mental-ibu-hamil',
                'excerpt' => 'Pentingnya menjaga kesehatan mental dan emosional selama masa kehamilan.',
                'konten' => '<p>Kesehatan mental sama pentingnya dengan kesehatan fisik selama kehamilan.</p><p>Perubahan hormon dapat mempengaruhi mood dan emosi. Penting untuk: berkomunikasi dengan pasangan dan keluarga, istirahat cukup, lakukan aktivitas yang menyenangkan, dan bergabung dengan komunitas ibu hamil.</p><p>Jika merasa cemas berlebihan atau depresi, jangan ragu untuk berkonsultasi dengan profesional kesehatan mental.</p>',
                'gambar_utama' => 'images/mental-health.jpg',
                'kategori' => 'kesehatan_ibu',
                'tags' => 'kesehatan mental,depresi,kecemasan,wellbeing',
                'views' => 2100,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(12),
            ],
            [
                'penulis_id' => 1,
                'judul' => 'Makanan yang Harus Dihindari Saat Hamil',
                'slug' => 'makanan-dihindari-saat-hamil',
                'excerpt' => 'Daftar makanan dan minuman yang sebaiknya dihindari selama kehamilan untuk keselamatan ibu dan janin.',
                'konten' => '<p>Beberapa makanan dapat membahayakan kehamilan dan harus dihindari.</p><p>Hindari: ikan tinggi merkuri (tuna, hiu), daging dan telur mentah atau setengah matang, produk susu yang tidak dipasteurisasi, alkohol, dan kafein berlebihan.</p><p>Cuci bersih buah dan sayuran sebelum dikonsumsi untuk menghindari kontaminasi bakteri.</p>',
                'gambar_utama' => 'images/makanan-hindari.jpg',
                'kategori' => 'nutrisi',
                'tags' => 'pantangan,makanan,nutrisi,keamanan pangan',
                'views' => 3450,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(8),
            ],
            [
                'penulis_id' => 2,
                'judul' => 'Perbedaan Kontraksi Palsu dan Asli',
                'slug' => 'perbedaan-kontraksi-palsu-asli',
                'excerpt' => 'Cara membedakan kontraksi Braxton Hicks dengan kontraksi persalinan yang sesungguhnya.',
                'konten' => '<p>Kontraksi Braxton Hicks adalah kontraksi palsu yang biasa terjadi di trimester ketiga.</p><p>Kontraksi palsu: tidak teratur, tidak bertambah kuat, hilang saat posisi berubah atau istirahat. Kontraksi asli: teratur dan semakin sering, bertambah kuat, tidak hilang saat istirahat, disertai keluar lendir atau air ketuban.</p><p>Jika ragu, segera hubungi bidan atau dokter.</p>',
                'gambar_utama' => 'images/kontraksi.jpg',
                'kategori' => 'persiapan_persalinan',
                'tags' => 'kontraksi,persalinan,braxton hicks,tanda persalinan',
                'views' => 2650,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'penulis_id' => 1,
                'judul' => 'Perawatan Payudara untuk Persiapan Menyusui',
                'slug' => 'perawatan-payudara-persiapan-menyusui',
                'excerpt' => 'Panduan merawat payudara selama kehamilan untuk mempersiapkan proses menyusui yang lancar.',
                'konten' => '<p>Perawatan payudara sejak kehamilan membantu mempersiapkan proses menyusui setelah melahirkan.</p><p>Tips perawatan: gunakan bra yang nyaman dan mendukung, bersihkan puting dengan air hangat (tanpa sabun), pijat lembut untuk melancarkan aliran ASI, dan konsumsi makanan bergizi.</p><p>Pada trimester ketiga, kolostrum mungkin mulai keluar. Ini normal dan pertanda produksi ASI sudah dimulai.</p>',
                'gambar_utama' => 'images/perawatan-payudara.jpg',
                'kategori' => 'tips_kehamilan',
                'tags' => 'menyusui,ASI,perawatan payudara,laktasi',
                'views' => 1980,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'penulis_id' => 2,
                'judul' => 'Manfaat Skin to Skin dengan Bayi Baru Lahir',
                'slug' => 'manfaat-skin-to-skin-bayi',
                'excerpt' => 'Mengapa kontak kulit langsung dengan bayi sangat penting di jam-jam pertama kelahiran.',
                'konten' => '<p>Skin to skin contact atau IMD (Inisiasi Menyusu Dini) sangat penting untuk bonding ibu dan bayi.</p><p>Manfaat: menstabilkan suhu tubuh bayi, membantu bayi menemukan puting untuk menyusu pertama, meningkatkan ikatan emosional, mengurangi stres bayi, dan membantu kontraksi rahim ibu.</p><p>WHO merekomendasikan skin to skin minimal 1 jam setelah lahir, atau lebih lama jika memungkinkan.</p>',
                'gambar_utama' => 'images/skin-to-skin.jpg',
                'kategori' => 'lainnya',
                'tags' => 'IMD,bonding,bayi baru lahir,skin to skin',
                'views' => 1560,
                'status' => 'published',
                'published_at' => Carbon::now()->subDay(),
            ],
        ];

        foreach ($artikels as $artikel) {
            DB::table('artikels')->insert([
                'penulis_id' => $artikel['penulis_id'],
                'judul' => $artikel['judul'],
                'slug' => $artikel['slug'],
                'excerpt' => $artikel['excerpt'],
                'konten' => $artikel['konten'],
                'gambar_utama' => $artikel['gambar_utama'],
                'kategori' => $artikel['kategori'],
                'tags' => $artikel['tags'],
                'views' => $artikel['views'],
                'status' => $artikel['status'],
                'published_at' => $artikel['published_at'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
