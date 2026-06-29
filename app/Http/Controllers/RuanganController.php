<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Lantai;
use App\Models\Ruangan;
use App\Services\RuanganService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RuanganController extends Controller
{
    protected function service()
    {
        return new RuanganService();
    }

    public function index($id)
    {
        $lantais = Lantai::where('gedung_id', $id)->get();

        return view('dashboard.kelola-ruang', [
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
                'nama_asset' => 'nullable|array',
                'total_asset' => 'nullable|array',
            ], [
                'kode_ruangan.required' => 'Kode Ruangan wajib diisi.',
                'kode_ruangan.unique' => 'Kode Ruangan sudah terdaftar.',
                'status.required' => 'Status wajib dipilih.',
                'muatan_kapasitas.required' => 'Kapasitas wajib diisi.',
                'muatan_kapasitas.integer' => 'Kapasitas harus berupa angka.',
                'lantai.required' => 'Lantai wajib dipilih.',
                'nama_asset.required' => 'Nama asset wajib diisi.',
                'total_asset.required' => 'Total asset wajib diisi.',
            ]);

            $service = $this->service()->store($validate);

            return response()->json([
                'success' => true,
                'message' => $service['message'],
            ], 200);
            
        } catch (\Exception $e) {
            if ($e instanceof ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terdapat kesalahan pada isian form!',
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menyimpan data.',
            ], 500);
        }
    }

    public function edit($id)
    {
        $data = Ruangan::with(['asset:id,jumlah_asset,nama_asset,ruangan_id'])
            ->select('id', 'kode_ruangan', 'status', 'muatan_kapasitas', 'lantai_id')
            ->find($id);

        if (! $data) {
            return response()->json(['success' => false, 'message' => 'Ruangan tidak ditemukan!']);
        }

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function update(Request $request)
    {
        try {
            $validate = $request->validate([
                'id' => 'required|integer',
                'kode_ruangan' => 'required|string|max:12',
                'status' => 'required|string',
                'kapasitas' => 'required|integer',
                'asset_id' => 'nullable|array',
                'nama_asset' => 'nullable|array',
                'total_asset' => 'nullable|array',
            ], [
                'kode_ruangan.required' => 'Kode Ruangan wajib diisi.',
                'status.required' => 'Status wajib dipilih.',
                'kapasitas.required' => 'Kapasitas wajib diisi.',
                'kapasitas.integer' => 'Kapasitas harus berupa angka.',
                'nama_asset.required' => 'Nama asset wajib diisi.',
                'total_asset.required' => 'Total asset wajib diisi.',
            ]);

            $this->service()->update($validate);

            return response()->json([
                'success' => true,
                'message' => 'Ruangan berhasil diupdate!',
            ], 200);
        } catch (\Exception $e) {
            if ($e instanceof ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terdapat kesalahan pada isian form!',
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menyimpan pembaruan.',
            ], 500);
        }
    }

    public function destroyAsset($id)
    {
        try {
            $this->service()->deleteAsset($id);
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan internal'], 500);
        }
    }

    public function destroyRuangan($id)
    {
        try {
            $this->service()->destroyRuangan($id);
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan internal'], 500);
        }
    }

    public function getAssetByRuangan($id)
    {
        $asset = Asset::select('nama_asset', 'jumlah_asset')
            ->where('ruangan_id', $id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil',
            'data' => $asset,
        ]);
    }
}
