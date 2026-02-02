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
        $lantais = Lantai::where('gedung_id', $id)->get();

        return view('dashboard.peminjaman-ruangan', [
            'lantais' => $lantais,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * Ambil data ruangan jika salah satu dari opsi lantai dipilih,berdasarkan lantai id nya
     */
    public function ruangan($id)
    {
        $datas = Ruangan::select('id', 'kode_ruangan', 'muatan_kapasitas')
            ->whereHas('lantai', function ($q) use ($id) {
                $q->where('id', $id);
                $q->where('status', '=', 'Aktif');
            })->get();

        \Log::info('id nya : '.$id.'');
        // \Log::info('data ruangan : ', $datas->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data ruangan',
            'data' => $datas,
        ], 200);
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
            'kontak_penanggung_jawab' => 'required|string',
            'keterangan_peminjaman' => 'required|string',
        ]);

        // Cek apakah ada tabrakan jam di ruangan yang sama pada tanggal yang sama
        $tabrakan = WaktuPeminjaman::whereHas('peminjaman', function ($q) use ($validate) {
            $q->where('ruangan_id', $validate['ruangan'])
                ->where('tanggal_peminjaman', $validate['tanggal_peminjaman']);
        })
            ->whereIn('waktu_peminjaman', $validate['jam_peminjaman'])
            ->orderBy('waktu_peminjaman')
            ->get();

        if ($tabrakan->isNotEmpty()) {
            // Ambil range jadwal yang bertabrakan
            $rangeDb = WaktuPeminjaman::whereHas('peminjaman', function ($q) use ($validate) {
                $q->where('ruangan_id', $validate['ruangan'])->where('tanggal_peminjaman', $validate['tanggal_peminjaman']);
            })->orderBy('waktu_peminjaman')->get();

            $start = Carbon::parse($rangeDb->first()->waktu_peminjaman);
            $end = Carbon::parse($rangeDb->last()->waktu_peminjaman);

            return response()->json([
                'success' => false,
                'message' => "Ruangan sudah dipakai dari jam {$start->format('H:i')} sampai {$end->format('H:i')}",
            ], 409);
        }

        $over_cap = Ruangan::where('id', $validate['ruangan'])
            ->value('muatan_kapasitas');

        \Log::info('kapasitas: '.$over_cap);
        \Log::info('muatan: '.$validate['muatan']);

        if ($validate['muatan'] >= $over_cap) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan melebihi kapasitas yang ditampung',
            ], 409);
        }

        try {
            $data_peminjaman = DataPeminjaman::create([
                'fakultas' => $validate['fakultas'],
                'prodi' => $validate['prodi'],
                'jenis_peminjaman' => $validate['jenis_peminjaman'],
                'kode_matkul' => ! empty($validate['kode_matkul']) ? $validate['kode_matkul'] : null,
                'lantai' => (int) $validate['lantai'],
                'ruangan_id' => (int) $validate['ruangan'],
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
    public function show()
    {
        $data_peminjaman = DataPeminjaman::with([
            // Waktu peminjaman
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',

            // Ruangan lantai dan gedung
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
        ])->select('id', 'jenis_peminjaman', 'penanggung_jawab', 'fakultas', 'prodi', 'keterangan_peminjaman', 'ruangan_id', 'muatan', 'status', 'alasan_penolakan')
            ->where('status', 'Waiting')
            ->get();

        info('query : ', $data_peminjaman->toArray());

        foreach ($data_peminjaman as $r) {
            $r->kode_ruangan = $r->ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $r->ruangan?->lantai?->gedung?->nama_gedung ?? '-';

            if ($r->waktuPeminjaman->isNotEmpty()) {
                $waktu = $r->waktuPeminjaman->sortBy('waktu_peminjaman')->values();
                $start = Carbon::parse($waktu->first()->waktu_peminjaman);
                $end = Carbon::parse($waktu->last()->waktu_peminjaman);

                $r->jam_mulai = $start->format('H:i');
                $r->jam_selesai = $end->format('H:i');
                $r->total_menit = $waktu->count() * 30 - 30;
            } else {
                $r->jam_mulai = '-';
                $r->jam_selesai = '-';
                $r->total_menit = 0;
            }
        }

        return view('dashboard.history-peminjaman', [
            'peminjaman' => $data_peminjaman,
        ]);
    }

    public function cancelBooking($id)
    {
        $data_peminjaman = DataPeminjaman::findOrFail($id);

        if ($data_peminjaman->status === 'Waiting') {
            $data_peminjaman->delete();
        }
    }
}
