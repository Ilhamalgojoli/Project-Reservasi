<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\Ruangan;
use App\Models\Lantai;
use Illuminate\Support\Facades\DB;

class RuanganService
{
    public function getDataLantai($id)
    {
        return Lantai::select('id', 'lantai')->where('gedung_id', $id)
            ->get()
            ->toArray();
    }

    public function getData($id, $search, $filters = false, $idLantai = null)
    {
        return Ruangan::with([
            'lantai:id,lantai,gedung_id',
            'asset:ruangan_id,nama_asset,jumlah_asset',
        ])
            ->select('id', 'kode_ruangan', 'status', 'muatan_kapasitas', 'lantai_id')
            ->whereHas('lantai', function ($q) use ($id) {
                $q->where('gedung_id', $id);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('kode_ruangan', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->when($filters && $idLantai != null, function ($query) use ($idLantai) {
                $query->whereHas('lantai', function ($q) use ($idLantai) {
                    $q->where('id', $idLantai);
                });
            })
            ->paginate(10);
    }

    public function store(array $data)
    {
        $ruangan = Ruangan::create([
            'kode_ruangan' => $data['kode_ruangan'],
            'status' => $data['status'],
            'muatan_kapasitas' => $data['muatan_kapasitas'],
            'lantai_id' => $data['lantai'],
        ]);

        DB::transaction(function () use ($ruangan, $data) {
            $asset_map = array_map(null, $data['nama_asset'], $data['total_asset']);
            foreach ($asset_map as [$nama, $total]) {
                if (! $nama || ! $total) {
                    continue;
                }

                Asset::create([
                    'nama_asset' => $nama,
                    'jumlah_asset' => $total,
                    'ruangan_id' => $ruangan->id,
                ]);
            }
        });

        return [
            'success' => true,
            'message' => 'Ruangan berhasil ditambahkan!',
        ];
    }

    public function update(array $data)
    {
        $ruangan = Ruangan::find($data['id']);

        if (! $ruangan) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan tidak ditemukan.',
            ]);
        }

        try {
            $ruangan->update([
                'kode_ruangan' => $data['kode_ruangan'],
                'status' => $data['status'],
                'muatan_kapasitas' => $data['kapasitas'],
            ]);

            DB::transaction(function () use ($data) {
                $asset_id = $data['asset_id'] ?? [];
                $asset_map = array_map(null, $asset_id, $data['nama_asset'], $data['total_asset']);
                foreach ($asset_map as [$id, $nama, $jumlah]) {
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
                            'ruangan_id' => $data['id'],
                        ]);
                    }
                }
            });

            return [
                'success' => true,
                'message' => 'Ruangan berhasil diupdate!',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function deleteRuangan(int $id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return $ruangan->delete();
    }

    public function deleteAsset(int $id)
    {
        $asset = Asset::findOrFail($id);
        return $asset->delete();
    }

    public function destroyRuangan($id)
    {
        try {
            $ruangan = Ruangan::findOrFail($id);

            $ruangan->delete();

            return [
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan internal',
            ];
        }
    }
}
