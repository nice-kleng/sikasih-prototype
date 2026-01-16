<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function create()
    {
        $hideBottomNav = true;
        return view('pages.pendaftaran', compact('hideBottomNav'));
    }

    public function store(Request $request)
    {
        // Validasi dan simpan data
        return redirect()->route('home')->with('success', 'Pendaftaran berhasil!');
    }
}
