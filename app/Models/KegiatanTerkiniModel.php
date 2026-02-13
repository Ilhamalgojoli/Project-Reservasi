<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanTerkiniModel extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_terkinis';
    protected $fillable = [
        'pesan',
    ];
}
