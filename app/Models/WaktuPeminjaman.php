<?php

namespace App\Models;

use App\Models\DataPeminjaman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaktuPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'waktu_peminjaman';
    protected $fillable = [
        'waktu_peminjaman',
        'peminjaman_id',
    ];

    public function peminjaman(){
        return $this->belongsTo(DataPeminjaman::class);
    }
}
