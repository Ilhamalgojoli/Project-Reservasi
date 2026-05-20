<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembatalanPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'pembatalan_peminjaman';

    protected $fillable = [
        'data_peminjaman_id',
        'alasan_pembatalan',
        'cancel_by',
        'cancel_requested',
        'cancel_request_reason'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(DataPeminjaman::class, 'data_peminjaman_id');
    }
}
