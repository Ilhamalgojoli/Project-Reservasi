<?php

namespace App\Models;

use App\Models\DataPeminjaman;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Prodi;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'fakultas';

    protected $fillable = [
        'fakultas'
    ];

    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'fakultas_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(DataPeminjaman::class, 'fakultas_id');
    }
}
