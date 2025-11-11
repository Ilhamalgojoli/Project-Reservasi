<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        return view('dashboard/home');
    }

    public function index2()
    {
        return view('dashboard/reservasi-ruangan');
    }

    public function index3()
    {
        return view('dashboard/reservasi');
    }

    public function index4()
    {
        return view('dashboard/approve-reservasi');
    }

    public function index5()
    {
        return view('dashboard/index5');
    }

    public function index6()
    {
        return view('dashboard/kelola-ruang');
    }

    public function index7()
    {
        return view('dashboard/index7');
    }

    public function index8()
    {
        return view('dashboard/index8');
    }

    public function index9()
    {
        return view('dashboard/index9');
    }
}
