<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lantai;
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
        'gambar'
    ];

    public function lantai(){
        return $this->hasMany(Lantai::class);
    }

    public function ruangan(){
        return $this->hasOneThrough(
            Ruangan::class,
            Lantai::class,
            'gedung_id',
            'lantai_id',
            'id',
            'id'
        );
    }
}
