<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GedungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gedung = Gedung::all();
        return view('dashboard.kelola-gedung', compact($gedung));
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
            'gambar' => 'nullable|file|image|mimes:jpeg,png,jpg|max:10240'
        ]);

        if (empty($validate['id_gedung']) || empty($validate['nama']) || empty($validate['keterangan'])
            || empty($validate['status']) || empty($validate['jumlah'])) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi form dengan benar',
            ], 403);
        }

        // Implement storage transfer untuk ke database dan localdisk

        $path = null ;

        // Cek ada atau tidak nya gambar/file yang akan di upload ke localdisk 

        if ($request->hasFile('gambar')){
            if(!Storage::disk('public')->exists('gambar_gedung')){
                Storage::disk('public')->makeDirectory('gambar_gedung');
            }

            // Path sekaligus store file ke folder gambar gedung di public storage

            $path = $request->file('gambar')->store('gambar_gedung', 'public');
        }

        \Log::info('payload : ' . $validate['status']);
        // Log::info($validate['jumlah']);
        $gedung = Gedung::create([
            'nama_gedung' => $validate['nama'],
            'kode_gedung' => $validate['id_gedung'],
            'jumlah_lantai' => $validate['jumlah'],
            'status' => $validate['status'],
            'keterangan' => $validate['keterangan'],
            'gambar' => $path
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gedung berhasil ditambahkan',
        ], 200);
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
