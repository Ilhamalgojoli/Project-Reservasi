<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use App\Models\Lantai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'id_gedung' => 'required|string|unique:gedungs,kode_gedung|max:16',
            'nama' => 'required|string',
            'jumlah' => 'required|integer',
            'status' => 'required|string',
            'keterangan' => 'required|string',
            'gambar' => 'nullable|file|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        // Implement storage transfer untuk ke database dan localdisk
        $path = null;

        // Cek ada atau tidak nya gambar/file yang akan di upload ke localdisk pada request js
        if ($request->hasFile('gambar')) {
            if (! Storage::disk('public')->exists('gambar_gedung')) {
                Storage::disk('public')->makeDirectory('gambar_gedung');
            }

            // Path sekaligus store file ke folder gambar gedung di public storage
            $path = $request->file('gambar')->store('gambar_gedung', 'public');
        }

        try {
            $gedung = Gedung::create([
                'nama_gedung' => $validate['nama'],
                'kode_gedung' => $validate['id_gedung'],
                'status' => $validate['status'],
                'keterangan' => $validate['keterangan'],
                'gambar' => $path ?? null,
            ]);

            DB::transaction(function () use ($request, $gedung) {
                // \Log::info('payload : '.$validate['status']);
                // Log::info($validate['jumlah']);

                for ($i = 1; $i <= $request->jumlah; $i++) {
                    $lantai = Lantai::create([
                        'lantai' => $i,
                        'gedung_id' => $gedung->id,
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Gedung berhasil ditambahkan',
            ], 200);
        } catch (\Exception $e) {
            // Cek gambar pada storage laravel jika ada maka hapus
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            if ($e instanceof ValidationException) {
                $errors = $e->errors();
                if (isset($errors['id_gedung'])) {
                    $msg = 'Id sudah dipakai,silahkan pakai id lain!';
                } elseif (isset($errors['jumlah'])) {
                    $msg = 'Isi jumlah lantai dengan sebuah angka!';
                } else {
                    $msg = 'Lengkapi form!';
                }

                return response()->json([
                    'success' => false,
                    'message' => $msg,
                ], 422);
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
        $gedung = Gedung::withCount('lantai')->find($id);

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
            'id_gedung' => 'required|string|max:16',
            'jumlah' => 'required|integer',
            'status' => 'required|string',
            'keterangan' => 'required|string',
            'gambar' => 'nullable|file|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        // Implement storage transfer untuk ke database dan localdisk
        $path = null;

        // Cek ada atau tidak nya gambar/file yang akan di upload ke localdisk pada request js
        if ($request->hasFile('gambar')) {
            if (! Storage::disk('public')->exists('gambar_gedung')) {
                Storage::disk('public')->makeDirectory('gambar_gedung');
            }

            // Path sekaligus store file ke folder gambar gedung di public storage
            $path = $request->file('gambar')->store('gambar_gedung', 'public');
        }

        $gedung = Gedung::with('lantai')->find($request->id);
        if (! $gedung) {
            return response->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 422);
        }

        try {
            DB::transaction(function () use ($validate, $path, $gedung) {
                $gedungUpdate = [
                    'nama_gedung' => $validate['nama'],
                    'kode_gedung' => $validate['id_gedung'],
                    'jumlah_lantai' => $validate['jumlah'],
                    'status' => $validate['status'],
                    'keterangan' => $validate['keterangan'],

                ];

                if ($path) {
                    $gedungUpdate['gambar'] = $path;
                }
                $gedung->update($gedungUpdate);

                // Proses Update jumlah lantai
                $jumlah_baru = $validate['jumlah'];
                $jumlah_lama = $gedung->lantai()->count();

                if ($jumlah_lama < $jumlah_baru) {
                    for ($i = $jumlah_lama + 1; $i <= $jumlah_baru; $i++) {
                        $gedung->lantai()->create([
                            'lantai' => $i,
                        ]);
                    }
                }

                if ($jumlah_lama > $jumlah_baru) {
                    $gedung->lantai()
                        ->where('lantai', '>', $jumlah_baru)
                        ->delete();
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di update.',
            ], 200);
        } catch (\Exception $e) {
            // Cek gambar pada storage laravel jika ada maka hapus
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            if ($e instanceof ValidationException) {
                $errors = $e->errors();
                if (isset($errors['jumlah'])) {
                    $msg = 'Isi jumlah lantai dengan sebuah angka!';
                } else {
                    $msg = 'Lengkapi form!';
                }

                return response()->json([
                    'success' => false,
                    'message' => $msg,
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan gedung!',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gedung = Gedung::find($id);

        \Log::info('id'.$id);

        if (! $gedung) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        }

        try {
            $gedung->delete();

            if ($gedung->gambar) {
                Storage::disk('public')->delete($gedung->gambar);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan gedung!',
            ], 500);
        }
    }

    // Untuk ditampilkan ke client side
    public function show()
    {
        $datas = Gedung::select('id', 'nama_gedung', 'keterangan', 'gambar')
            ->where('status', '=', 'Aktif')->get();

        \Log::info($datas->toArray());

        return view(
            'dashboard.pemilihan-gedung', [
                'datas' => $datas,
            ]);
    }
}
