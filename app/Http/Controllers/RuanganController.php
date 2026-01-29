<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Lantai;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuanganController extends Controller
{
    public function index($id)
    {
        $datas = Ruangan::with('asset')
            ->whereHas('lantai', function ($q) use ($id) {
                $q->where('gedung_id', $id);
            })
            ->get();

        \Log::info($datas->toArray());
        $lantais = Lantai::where('gedung_id', $id)->get();

        return view('dashboard.kelola-ruang', [
            'datas' => $datas,
            'lantais' => $lantais,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'kode_ruangan' => 'required|string|max:12|unique:ruangans,kode_ruangan',
                'status' => 'required|string',
                'muatan_kapasitas' => 'required|integer',
                'lantai' => 'required|integer',
                'nama_asset' => 'required|array',
                'total_asset' => 'required|array',
            ]);

            $ruangan = Ruangan::create([
                'kode_ruangan' => $validate['kode_ruangan'],
                'status' => $validate['status'],
                'muatan_kapasitas' => $validate['muatan_kapasitas'],
                'lantai_id' => $validate['lantai'],
            ]);
            DB::transaction(function () use ($ruangan, $request) {
                $asset_map = array_map(null, $request->nama_asset, $request->total_asset);
                foreach ($asset_map as [$nama, $total]) {
                    if (! $nama || ! $total) {
                        continue;
                    }

                    $asset = Asset::create([
                        'nama_asset' => $nama,
                        'jumlah_asset' => $total,
                        'ruangan_id' => $ruangan->id,
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Ruangan berhasil ditambahkan!',
            ], 200);
        } catch (\Exception $e) {
            if ($e instanceof ValidationException) {
                $errors = $e->errors();
                if (isset($errors['muatan_kapasitas'])) {
                    $msg = 'Isi jumlah kapasitas dengan sebuah angka!';
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
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $data = Ruangan::with(['asset:id,jumlah_asset,nama_asset,ruangan_id'])
            ->select('id', 'kode_ruangan', 'status', 'muatan_kapasitas', 'lantai_id')
            ->find($id);

        // $data = Ruangan::with('asset')->find($id);
        // \Log::info($data->toArray());

        if (! $data) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan tidak ditemukan!',
            ]);
        }

        \Log::info('id : '.$id);

        return response()->json([
            'success' => false,
            'data' => $data,
        ]);
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|integer',
            'kode_ruangan' => 'required|string|max:12',
            'status' => 'required|string',
            'kapasitas' => 'required|integer',
            'asset_id' => 'nullable|array',
            'nama_asset' => 'required|array',
            'total_asset' => 'required|array',
        ]);

        \Log::info('id : '.$request->id);

        $ruangan = Ruangan::find($request->id);

        if (! $ruangan) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan tidak ditemukan.',
            ]);
        }

        try {
            $ruangan->update([
                'kode_ruangan' => $validate['kode_ruangan'],
                'status' => $validate['status'],
                'muatan_kapasitas' => $validate['kapasitas'],
            ]);

            DB::transaction(function () use ($request) {
                $asset_id = $request->asset_id ?? [];
                $asset_map = array_map(null, $asset_id, $request->nama_asset, $request->total_asset);
                foreach ($asset_map as [$id ,$nama, $jumlah]) {
                    if (! $nama || ! $jumlah) {
                        continue;
                    }

                    if ($id) {
                        $asset = Asset::find($id);

                        $asset->update([
                            'nama_asset' => $nama,
                            'jumlah_asset' => $jumlah,
                        ]);
                    } else {
                        Asset::create([
                            'nama_asset' => $nama,
                            'jumlah_asset' => $jumlah,
                            'ruangan_id' => $request->id,
                        ]);
                    }
                }
            });

            return response()->json([
                'success' => false,
                'message' => 'Ruangan berhasil diupdate!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroyAsset($id)
    {
        try {
            $asset = Asset::findOrFail($id);

            $asset->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal',
            ], 500);
        }
    }

    public function destroyRuangan($id)
    {
        try {
            $ruangan = Ruangan::findOrFail($id);

            $ruangan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal',
            ], 500);
        }
    }

    public function getAssetByRuangan($id)
    {
        $asset = Asset::select('nama_asset', 'jumlah_asset')
            ->where('ruangan_id', $id)->get();

        return response()->json([
            'success'=> true,
            'message'=> 'Data berhasil',
            'data' => $asset
        ]);
    }
}
