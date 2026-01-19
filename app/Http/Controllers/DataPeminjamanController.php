<?php

namespace App\Http\Controllers;

use App\Models\DataPeminjaman;
use App\Models\Lantai;
use App\Models\Ruangan;
use App\Models\WaktuPeminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataPeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $datas = Ruangan::whereHas('lantai', function ($q) use ($id) {
            $q->where('gedung_id', $id);
        })->get();

        \Log::info('data ruangan : ', $datas->toArray());
        $lantais = Lantai::where('gedung_id', $id)->get();

        return view('dashboard.peminjaman-ruangan', [
            'datas' => $datas,
            'lantais' => $lantais,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'fakultas' => 'required|string',
            'prodi' => 'required|string',
            'jenis_peminjaman' => 'required|string',
            'kode_matkul' => 'nullable|required_if:jenis_peminjaman,Akademik|string',
            'lantai' => 'required|integer',
            'ruangan' => 'required|integer',
            'tanggal_peminjaman' => 'required|string',
            'jam_peminjaman' => 'required|array',
            'muatan' => 'required|integer',
            'penanggung_jawab' => 'required|string',
            'kontak_penanggung_jawab' => 'required|integer',
            'keterangan_peminjaman' => 'required|string',
        ]);

        // Cek apakah ada tabrakan jam di ruangan yang sama pada tanggal yang sama
        $tabrakan = WaktuPeminjaman::whereHas('peminjaman', function ($q) use ($validate) {
            $q->where('ruangan', $validate['ruangan'])
                ->where('tanggal_peminjaman', $validate['tanggal_peminjaman']);
        })
            ->whereIn('waktu_peminjaman', $validate['jam_peminjaman'])
            ->orderBy('waktu_peminjaman')
            ->get();

        if ($tabrakan->isNotEmpty()) {
            // Ambil range jadwal yang bertabrakan
            $rangeDb = WaktuPeminjaman::whereHas('peminjaman', function ($q) use ($validate) {
                $q->where('ruangan', $validate['ruangan'])->where('tanggal_peminjaman', $validate['tanggal_peminjaman']);
            })->orderBy('waktu_peminjaman')->get();

            $start = Carbon::parse($rangeDb->first()->waktu_peminjaman);
            $end = Carbon::parse($rangeDb->last()->waktu_peminjaman);

            return response()->json([
                'success' => false,
                'message' => "Ruangan sudah dipakai dari jam {$start->format('H:i')} sampai {$end->format('H:i')}"
            ], 420);
        }

        try {
            $data_peminjaman = DataPeminjaman::create([
                'fakultas' => $validate['fakultas'],
                'prodi' => $validate['prodi'],
                'jenis_peminjaman' => $validate['jenis_peminjaman'],
                'kode_matkul' => ! empty($validate['kode_matkul']) ? $validate['kode_matkul'] : null,
                'lantai' => (int) $validate['lantai'],
                'ruangan' => (int) $validate['ruangan'],
                'tanggal_peminjaman' => $validate['tanggal_peminjaman'],
                'muatan' => $validate['muatan'],
                'penanggung_jawab' => $validate['penanggung_jawab'],
                'kontak_penanggung_jawab' => $validate['kontak_penanggung_jawab'],
                'keterangan_peminjaman' => $validate['keterangan_peminjaman'],
            ]);

            DB::transaction(function () use ($validate, $data_peminjaman) {
                foreach ($validate['jam_peminjaman'] as $waktu) {
                    WaktuPeminjaman::create([
                        'waktu_peminjaman' => $waktu,
                        'jenis_peminjaman' => $validate['jenis_peminjaman'],
                        'peminjaman_id' => $data_peminjaman->id,
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Gedung berhasil ditambahkan',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DataPeminjman $dataPeminjman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataPeminjman $dataPeminjman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataPeminjman $dataPeminjman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataPeminjman $dataPeminjman)
    {
        //
    }
}
