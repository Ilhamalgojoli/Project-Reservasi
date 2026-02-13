<?php

namespace App\Http\Controllers;

use App\Models\Lantai;

class DataPeminjamanController extends Controller
{
    public function index($id)
    {
        $lantais = Lantai::where('gedung_id', $id)->get();

        return view('dashboard.peminjaman-ruangan', [
            'lantais' => $lantais,
        ]);
    }

    public function show()
    {
        return view('dashboard.history-peminjaman');
    }
}
