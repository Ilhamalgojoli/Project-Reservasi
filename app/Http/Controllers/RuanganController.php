<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index($id)
    {
        $datas = Ruangan::where('gedung_id', $id)->get();

        return view(
            'dashboard.kelola-ruang', [
                'datas' => $datas,
            ]);
    }

    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'kode_ruangan' => 'required|string|max:8',
                'status' => 'required|string',
                'muatan_kapasitas' => 'required|integer',
                'gedung_id' => 'required|integer'
            ]);

            if (! filter_var($request->muatan_kapasitas, FILTER_VALIDATE_INT)) {
                return response->json([
                    'success' => false,
                    'message' => 'Isi muatan kapasitas dengan angka',
                ], 422);
            }

            // Log::info('id gedung', $request->gedung_id);
            $validate = Ruangan::create([
                'kode_ruangan' => $validate['kode_ruangan'],
                'status' => $validate['status'],
                'muatan_kapasitas' => $validate['muatan_kapasitas'],
                'gedung_id' => $validate['gedung_id']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ruangan berhasil ditambahkan!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error.'
            ], 500);
        }
    }

    public function lantai($id) {}
}
