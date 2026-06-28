<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fakultas;
use App\Models\Matakuliah;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';

    protected $fillable = [
        'prodi',
        'fakultas_id'
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function matakuliah()
    {
        return $this->hasMany(Matakuliah::class, 'prodi_id', 'id');
    }
}
