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
        $datas = Gedung::withCount('ruangan')->get();

        return view(
            'dashboard.kelola-gedung', [
                'datas' => $datas,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Implement storage transfer untuk ke database dan localdisk
        $path = null;

        try {
            $validate = $request->validate([
                'id_gedung' => 'required|string',
                'nama' => 'required|string',
                'jumlah' => 'required|integer',
                'status' => 'required|string',
                'keterangan' => 'required|string',
                'gambar' => 'nullable|file|image|mimes:jpeg,png,jpg|max:10240',
            ]);

            // Filter form jumlah harus menggunakan validasi number
            if (! filter_var($request->jumlah, FILTER_VALIDATE_INT)) {
                return response->json([
                    'success' => false,
                    'message' => 'Isi form jumlah dengan sebuah angka!',
                ], 422);
            }

            // Cek ada atau tidak nya gambar/file yang akan di upload ke localdisk pada request js
            if ($request->hasFile('gambar')) {
                if (! Storage::disk('public')->exists('gambar_gedung')) {
                    Storage::disk('public')->makeDirectory('gambar_gedung');
                }

                // Path sekaligus store file ke folder gambar gedung di public storage
                $path = $request->file('gambar')->store('gambar_gedung', 'public');
            }

            // \Log::info('payload : '.$validate['status']);
            // Log::info($validate['jumlah']);
            $gedung = Gedung::create([
                'nama_gedung' => $validate['nama'],
                'kode_gedung' => $validate['id_gedung'],
                'status' => $validate['status'],
                'keterangan' => $validate['keterangan'],
                'jumlah_lantai' => $validate['jumlah'],
                'gambar' => $path ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Gedung berhasil ditambahkan',
            ], 200);
        } catch (\Exception $e) {
            // Cek gambar pada storage laravel jika ada maka hapus
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            \Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan gedung!',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gedung = Gedung::find($id);

        if (! $gedung) {
            return response()->json([
                'success' => false,
                'message' => 'Gedung tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $gedung,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|integer',
            'nama' => 'required|string',
            'jumlah' => 'required|integer',
            'status' => 'required|string',
            'keterangan' => 'required|string',
            'gambar' => 'nullable|file|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        if (! filter_var($request->jumlah, FILTER_VALIDATE_INT)) {
            return response->json([
                'success' => false,
                'message' => 'Isi form jumlah dengan sebuah angka!',
            ], 422);
        }

        $gedung = Gedung::find($request->id);

        $gedung = Gedung::update([
            'nama_gedung' => $validate['nama'],
            'kode_gedung' => $validate['id_gedung'],
            'jumlah_lantai' => $validate['jumlah'],
            'status' => $validate['status'],
            'keterangan' => $validate['keterangan'],
            'gambar' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil di update.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gedung $gedung)
    {
        //
    }
}
