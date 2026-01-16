<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Data dummy artikel
        $artikels = [
            [
                'id' => 1,
                'judul' => 'Tips Nutrisi untuk Ibu Hamil',
                'excerpt' => 'Panduan lengkap asupan nutrisi yang dibutuhkan selama kehamilan untuk kesehatan ibu dan janin...',
                'icon' => 'fas fa-apple-alt'
            ],
            [
                'id' => 2,
                'judul' => 'Perkembangan Janin Trimester Pertama',
                'excerpt' => 'Ketahui tahap-tahap perkembangan bayi Anda di trimester awal kehamilan dan apa yang perlu diperhatikan...',
                'icon' => 'fas fa-baby'
            ],
            [
                'id' => 3,
                'judul' => 'Olahraga Aman untuk Ibu Hamil',
                'excerpt' => 'Jenis-jenis olahraga yang aman dan bermanfaat untuk menjaga kebugaran selama masa kehamilan...',
                'icon' => 'fas fa-running'
            ],
            [
                'id' => 4,
                'judul' => 'Mengatasi Mual dan Muntah',
                'excerpt' => 'Cara efektif mengurangi morning sickness dan mual di masa kehamilan dengan tips praktis...',
                'icon' => 'fas fa-moon'
            ],
        ];

        return view('pages.home', compact('artikels'));
    }
}
