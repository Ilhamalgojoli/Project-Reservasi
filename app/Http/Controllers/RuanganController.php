<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    public function index($id){
        $datas = Ruangan::find($id);

        return view(
            'dashboard.kelola-ruang',[
                'datas' => $datas
            ]);
    }
}
