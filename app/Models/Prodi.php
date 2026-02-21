<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fakultas;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';

    protected $fillable = [
        'prodi',
        'fakultas_id'
    ];

    public function prodi()
    {
        return $this->belongsTo(Fakultas::class);
    }
}
