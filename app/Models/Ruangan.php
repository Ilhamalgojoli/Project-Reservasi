<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangans';

    protected $fillable = [
        'kode_ruangan',
        'status',
        'muatan_kapasitas',
        'lantai_id',
    ];

    public function lantai()
    {
        return $this->belongsTo(Lantai::class);
    }

    public function asset()
    {
        return $this->hasMany(Asset::class);
    }

    public function gedung()
    {
        return $this->hasOneThrough(
            Gedung::class,   
            Lantai::class,   
            'id',         
            'id',            
            'lantai_id',     
            'gedung_id'      
        );
    }
}
