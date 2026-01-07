<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gedung;
use App\Models\Ruangan;

class Lantai extends Model
{
    use HasFactory;

    protected $table = 'lantais';

    protected $fillable = [
        'lantai',
        'gedung_id'
    ];

    public function gedung(){
        return $this->belongTo(Gedung::class);
    }

    public function ruangan(){
        return $this->hasMany(Ruangan::class);
    }
}
