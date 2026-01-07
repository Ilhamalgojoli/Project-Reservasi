<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Lantai;
use App\Models\Gedung;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangans';

    protected $fillable = [
        'kode_ruangan',
        'status',
        'muatan_kapasitas',
        'lantai_id'
    ];

    public function lantai(){
        return $this->belongTo(Lantai::class);
    }
}
