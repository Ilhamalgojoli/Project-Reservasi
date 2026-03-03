<?php

namespace App\Http\Controllers;

use App\Models\Gedung;

class GedungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Gedung::withCount('ruangan')->withCount('lantai')->get();

        return view(
            'dashboard.kelola-gedung', [
                'datas' => $datas,
            ]);
    }

    // Untuk ditampilkan ke client side
    public function show()
    {
        $datas = Gedung::select('id', 'nama_gedung', 'keterangan', 'gambar')
            ->where('status', '=', 'Aktif')->get();

        return view(
            'dashboard.pemilihan-gedung', [
                'datas' => $datas,
            ]);
    }
}
