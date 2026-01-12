<?php

namespace App\Models;

use App\Models\Ruangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';
    protected $fillable = [
        'nama_asset',
        'jumlah_asset',
        'ruangan_id'
    ];

    public function ruangan(){
        return $this->belongsTo(Ruangan::class);
    }
}
