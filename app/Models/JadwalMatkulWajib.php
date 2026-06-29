<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMatkulWajib extends Model
{
    use HasFactory;

    protected $table = 'jadwal_matkul';

    protected $fillable = [
        'hari',
        'ruangan_id',
        'nama_matkul',
        'dosen',
        'shift_mulai',
        'shift_selesai',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
