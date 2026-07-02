<?php

namespace App\Models;

use App\Models\Ruangan;
use App\Models\Monitor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'data_peminjaman';
    protected $fillable = [
        'fakultas',
        'prodi',
        'jenis_peminjaman',
        'kode_matkul',
        'lantai',
        'status',
        'ruangan_id',
        'user_identifier',
        'tanggal_peminjaman',
        'hari',
        'muatan',
        'penanggung_jawab',
        'kontak_penanggung_jawab',
        'email',
        'alasan_penolakan',
        'keterangan_peminjaman',
        'dokumen',
        'nama_dokumen',
        'waktu_mulai',
        'waktu_selesai',
        'total_waktu'
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_matkul', 'kode_matkul');
    }

    public function pembatalan()
    {
        return $this->hasOne(PembatalanPeminjaman::class, 'data_peminjaman_id');
    }

    public function getAlasanPembatalanAttribute()
    {
        return $this->pembatalan?->alasan_pembatalan;
    }

    public function getCancelByAttribute()
    {
        return $this->pembatalan?->cancel_by;
    }

    public function getCancelRequestedAttribute()
    {
        return (bool) ($this->pembatalan?->cancel_requested ?? false);
    }

    public function getCancelRequestReasonAttribute()
    {
        return $this->pembatalan?->cancel_request_reason;
    }
}
