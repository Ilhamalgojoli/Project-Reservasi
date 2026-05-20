<?php

namespace App\Http\Controllers;

use App\Models\DataPeminjaman;
use App\Models\Monitor;
use App\Models\Ruangan;
use Carbon\Carbon;

class ApproveController extends Controller
{
    public function index()
    {
        return view('dashboard.approve-reservasi');
    }

    public function pembatalan()
    {
        return view('dashboard.peminjaman-aktif', [
            'detailId' => request()->query('detailId'),
        ]);
    }
}
