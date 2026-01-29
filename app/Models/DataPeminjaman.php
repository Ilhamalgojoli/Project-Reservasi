<?php

namespace App\Models;

use App\Models\WaktuPeminjaman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'data_peminjaman';
    protected $fillable =[
        'fakultas',
        'prodi',
        'jenis_peminjaman',
        'kode_matkul',
        'lantai',
        'status',
        'ruangan',
        'tanggal_peminjaman',
        'jadwal_peminjaman',
        'muatan',
        'penanggung_jawab',
        'kontak_penanggung_jawab',
        'alasan_penolakan',
        'keterangan_peminjaman'
    ];

    public function waktuPeminjaman(){
        return $this->hasMany(WaktuPeminjaman::class, 'peminjaman_id');
    }

    public function monitors(){
        return $this->hasMany(Monitor::class);
    }
}
