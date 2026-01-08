<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ruangan;

class Gedung extends Model
{
    use HasFactory ;
    
    protected $table = 'gedungs';

    protected $fillable = [
        'nama_gedung',
        'kode_gedung',
        'status',
        'keterangan',
        'jumlah_lantai',
        'gambar'
    ];

    public function ruangan(){
        return $this->hasMany(Ruangan::class);
    }
}
