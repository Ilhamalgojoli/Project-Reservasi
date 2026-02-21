<?php

namespace App\Services;

use App\Models\Gedung;
use App\Models\Lantai;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TambahEditGedungService
{
    public function getEdit($gedungID)
    {
        return Gedung::withCount('lantai')->find($gedungID);
    }

    public function getDataGedung()
    {
        return Gedung::withCount('ruangan')->withCount('lantai')->get();
    }

    public function deleteGedung($id)
    {
        try{
            $gedung = Gedung::findOrFail($id);
            return $gedung->delete();
        } catch(\Exception $e){
            return false;
        }
    }

    public function createData(array $data)
    {
        $path = null;
        if (! empty($data['gambar'])) {
            $gambar = $data['gambar'];
            $path = $gambar->store('gambar_gedung', 'public');
        }

        $gedung = DB::transaction(function () use ($data, $path) {
            $gedung = Gedung::create([
                'nama_gedung' => $data['nama'],
                'kode_gedung' => $data['kode'],
                'status' => $data['status'],
                'keterangan' => $data['keterangan'],
                'latitude' => (float) $data['latitude'],
                'longitude' => (float) $data['longitude'],
                'gambar' => $path,
            ]);

            $jumlah = (int) $data['jumlahLantai'];
            for ($i = 1; $i <= $jumlah; $i++) {
                Lantai::create([
                    'lantai' => $i,
                    'gedung_id' => $gedung->id,
                ]);
            }

            return $gedung;
        });

        return $gedung;
    }

    public function update(array $data)
    {
        info('data : ', $data);
        $path = null;

        if (! empty($data['gambar'])) {
            $gambar = $data['gambar'];

            if (! Storage::disk('public')->exists('gambar_gedung')) {
                Storage::disk('public')->makeDirectory('gambar_gedung');
            }

            $path = $gambar->store('gambar_gedung', 'public');
        }

        $gedung = Gedung::with('lantai')->find($data['id']);
        if (! $gedung) {
            throw new \DomainException('Data tidak ditemukan');
        }

        DB::transaction(function () use ($data, $path, $gedung) {
            $gedungUpdate = [
                'nama_gedung' => $data['nama'],
                'kode_gedung' => $data['kode'],
                'status' => $data['status'],
                'keterangan' => $data['keterangan'],
                'latitude' => (float) $data['latitude'],
                'longitude' => (float) $data['longitude'],
            ];

            if ($path) {
                $gedungUpdate['gambar'] = $path;
            }

            $gedung->update($gedungUpdate);

            $jumlah_baru = (int) $data['jumlahLantai'];
            $jumlah_lama = $gedung->lantai()->count();

            if ($jumlah_lama < $jumlah_baru) {
                for ($i = $jumlah_lama + 1; $i <= $jumlah_baru; $i++) {
                    $gedung->lantai()->create(['lantai' => $i]);
                }
            } elseif ($jumlah_lama > $jumlah_baru) {
                $gedung->lantai()->where('lantai', '>', $jumlah_baru)->delete();
            }
        });

        return $gedung;
    }
}
