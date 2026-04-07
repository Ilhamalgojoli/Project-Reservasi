<?php

namespace App\Services;

use App\Models\Ruangan;
use App\Models\Lantai;

class RuanganService
{
    public function getDataLantai($id)
    {
        return Lantai::select('id', 'lantai')->where('gedung_id', $id)
            ->get();
    }

    public function getData($id, $search, $filters = false, $idLantai = null)
    {
        return Ruangan::with([
            'lantai:id,lantai,gedung_id',
            'asset:ruangan_id,nama_asset,jumlah_asset',
        ])
            ->select('id', 'kode_ruangan', 'status', 'muatan_kapasitas', 'lantai_id')
            ->whereHas('lantai', function ($q)use($id) {
                $q->where('gedung_id', $id);
            })
            ->when($search, function($query) use($search) {
                $query->where('kode_ruangan', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "{$search}");
            })
            ->when($filters && $idLantai != null, function($query) use($idLantai){
                $query->whereHas('lantai', function($q) use($idLantai) {
                    $q->where('id', 'like', $idLantai);
                });
            })
            ->paginate(5);
    }
}
