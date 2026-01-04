<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GedungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'id_gedung' => 'required|string',
            'nama' => 'required|string',
            'jumlah' => 'required|integer',
            'status' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        if (empty($validate['id_gedung']) || empty($validate['nama']) || empty($validate['keterangan'])) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi form dengan benar',
            ], 403);
        }

        Log::info('payload : ' . $validate['status']);
        // Log::info($validate['jumlah']);
        $gedung = Gedung::create([
            'nama_gedung' => $validate['nama'],
            'kode_gedung' => $validate['id_gedung'],
            'jumlah_lantai' => $validate['jumlah'],
            'status' => $validate['status'],
            'keterangan' => $validate['keterangan'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gedung berhasil ditambahkan',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gedung $gedung)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gedung $gedung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gedung $gedung)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gedung $gedung)
    {
        //
    }
}
