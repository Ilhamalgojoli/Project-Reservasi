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
        return view('dashboard.kelola-gedung');
    }

    // Untuk ditampilkan ke client side
    public function show()
    {
        return view('dashboard.pemilihan-gedung');
    }
}
