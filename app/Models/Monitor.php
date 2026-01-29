<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    use HasFactory;

    protected $table = 'monitors';

    protected $fillable = [
        'waktu_mulai',
        'waktu_selesai',
        'peminjaman_id'
    ];

    public function peminjaman(){
        return $this->belongsTo(DataPeminjaman::class);
    }
}
