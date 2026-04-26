<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Gedung;
use App\Models\KegiatanTerkiniModel;
use App\Models\Lantai;
use App\Models\Ruangan;
use App\Models\WaktuPeminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PeminjamanService
{
    public function getBuilding(int $id)
    {
        return Gedung::select('id', 'nama_gedung')
            ->find($id);
    }
    public function getLantai($gedungId)
    {
        return Lantai::select('id', 'lantai')
            ->where('gedung_id', $gedungId)
            ->get()
            ->toArray();
    }

    public function getRuangan($lantaiId)
    {
        return Ruangan::select('id', 'kode_ruangan')
            ->where('status', 'Aktif')
            ->where('lantai_id', $lantaiId)
            ->get()
            ->toArray();
    }

    public function getFakultas()
    {
        return Fakultas::select('id', 'fakultas')
            ->get()
            ->toArray();
    }

    public function getProdi($fakultasId)
    {
        return Prodi::select('id', 'prodi')
            ->where('fakultas_id', $fakultasId)
            ->get()
            ->toArray();
    }

    public function getMaxKapasitas($ruanganId)
    {
        return Ruangan::where('id', $ruanganId)
            ->value('muatan_kapasitas');
    }

    public function getDataMap($gedungID)
    {
        return Gedung::select('latitude', 'longitude')
            ->where('id', $gedungID)
            ->first();
    }

    public function getRules(string $type): array
    {
        $baseRules = [
            'fakultas'              => 'required|integer',
            'prodi'                 => 'required|integer',
            'tanggal'               => 'required|date|after_or_equal:today',
            'lantaiID'              => 'required|integer',
            'ruanganID'             => 'required|integer',
            'pilihJam'              => 'required|array|min:1',
            'muatanKapasitas'       => 'required|integer|min:1',
            'jenisPeminjaman'       => 'required|string',
            'penanggungJawab'       => 'required|string|min:3',
            'kontakPenanggungJawab' => 'required|numeric|digits_between:10,15',
            'email'                 => 'required|email',
            'deskripsi'             => 'nullable|string|max:500',
            'userIdentifier'        => 'required|string',
        ];

        if ($type === 'akademik') {
            $baseRules['kodeMatkul'] = 'required|string';
        }

        return $baseRules;
    }

    public function getMessages(): array
    {
        return [
            'fakultas.required'              => 'Fakultas wajib diisi',
            'prodi.required'                 => 'Program studi wajib diisi',
            'kodeMatkul.required'            => 'Kode mata kuliah wajib dipilih',
            'tanggal.required'               => 'Tanggal wajib diisi',
            'lantaiID.required'              => 'Lantai wajib dipilih',
            'ruanganID.required'             => 'Ruangan wajib dipilih',
            'pilihJam.required'              => 'Minimal pilih satu jam',
            'pilihJam.min'                   => 'Minimal pilih satu jam',
            'muatanKapasitas.required'       => 'Kapasitas wajib diisi',
            'muatanKapasitas.integer'        => 'Kapasitas harus angka',
            'muatanKapasitas.min'            => 'Kapasitas minimal 1',
            'penanggungJawab.required'       => 'Penanggung jawab wajib diisi',
            'penanggungJawab.min'            => 'Minimal 3 karakter',
            'kontakPenanggungJawab.required' => 'Kontak wajib diisi',
            'kontakPenanggungJawab.numeric'  => 'Kontak harus angka',
            'kontakPenanggungJawab.digits_between' => 'Kontak harus 10-15 digit',
            'email.required'                 => 'Email wajib diisi',
            'email.email'                    => 'Format email tidak valid',
            'deskripsi.max'                  => 'Deskripsi maksimal 500 karakter',
        ];
    }

    # Generate jam otomatis
    public function generateJam($start, $end, $interval = 30)
    {
        $result = [];
        [$h, $m] = explode(':', $start);
        [$endH, $endM] = explode(':', $end);
        $h = (int) $h;
        $m = (int) $m;
        $endH = (int) $endH;
        $endM = (int) $endM;

        while ($h < $endH || ($h === $endH && $m <= $endM)) {
            $result[] = sprintf('%02d:%02d', $h, $m);
            $m += $interval;
            if ($m >= 60) {
                $h++;
                $m -= 60;
            }
        }

        return $result;
    }

    public function create(array $data)
    {
        $this->cekTabrakanJadwal($data);
        $this->cekMuatan($data['ruanganID'], $data['muatanKapasitas']);

        $jam = array_unique($data['pilihJam']);
        # Urutkan waktu peminjaman dari user supaya ketika masuk db data tidak berantakan
        sort($jam);
        # Panggil fungsi 
        $this->cekIntervalJadwal($jam);

        # Masuk transaction dikarenakan ada 2 proses query,menjaga data agar tetap konsisten
        $peminjaman = DB::transaction(function () use ($data, $jam) {
            $peminjaman = DataPeminjaman::create([
                'fakultas_id' => $data['fakultas'],
                'prodi_id' => $data['prodi'],
                'jenis_peminjaman' => $data['jenisPeminjaman'],
                'kode_matkul' => $data['kodeMatkul'] ?? null,
                'user_identifier' => $data['userIdentifier'],
                'lantai' => (int) $data['lantaiID'],
                'ruangan_id' => (int) $data['ruanganID'],
                'tanggal_peminjaman' => $data['tanggal'],
                'muatan' => $data['muatanKapasitas'],
                'penanggung_jawab' => $data['penanggungJawab'],
                'kontak_penanggung_jawab' => $data['kontakPenanggungJawab'],
                'email' => $data['email'],
                'keterangan_peminjaman' => $data['deskripsi'],
            ]);

            foreach ($jam as $waktu) {
                WaktuPeminjaman::create([
                    'waktu_peminjaman' => $waktu,
                    'peminjaman_id' => $peminjaman->id,
                ]);
            }

            return $peminjaman;
        });

        # Refresh Cache Riwayat (Mahasiswa & Admin)
        // $nim = $data['userIdentifier'];
        // for ($i = 1; $i <= 5; $i++) {
        //     Cache::forget("history-users-{$nim}-page-{$i}");
        //     Cache::forget("history-admin-page-{$i}");
        // }

        return $peminjaman;
    }

    # Cek interval waktu yang di pinjam,apakah format peminjaman sudah benar atau belum
    private function cekIntervalJadwal(array $listJam, $interval = 30)
    {
        sort($listJam);

        $expected = $interval * 60;

        for ($i = 0; $i < count($listJam) - 1; $i++) {
            $currentJam = strtotime($listJam[$i]);
            $nextJam = strtotime($listJam[$i + 1]);

            if (($nextJam - $currentJam) !== $expected) {
                throw new \Exception("Jam harus berurutan tiap {$interval} menit");
            }
        }
    }

    # Cek apakah jadwal yang dipinjam apakah sudah pernah dipinjam atau belum
    private function cekTabrakanJadwal(array $data)
    {
        # Ambil semua waktu yang sudah terisi di ruangan dan tanggal tersebut
        $rangeDb = WaktuPeminjaman::whereHas('peminjaman', function ($q) use ($data) {
                $q->where('ruangan_id', $data['ruanganID'])
                    ->where('tanggal_peminjaman', $data['tanggal'])
                    ->whereIn('status', ['Approve', 'Waiting']);
            })
            ->orderBy('waktu_peminjaman')
            ->get();

        if ($rangeDb->isNotEmpty()) {
            # Ambil hanya jam nya saja
            $takenHours = $rangeDb->pluck('waktu_peminjaman')->toArray();

            # Cek apakah ada jam yang dipilih user yang sudah terisi di DB
            $overlap = array_intersect($takenHours, $data['pilihJam']);

            if (!empty($overlap)) {
                $start = Carbon::parse($rangeDb->first()->waktu_peminjaman)->format('H:i');
                $end   = Carbon::parse($rangeDb->last()->waktu_peminjaman)->format('H:i');

                throw new \Exception("Ruangan pada jam $start sudah dipakai sampai jam $end");
            }
        }
    }

    # Cek muatan dari peminjaman apakah melebihi kapasitas ruangan atau tidak
    private function cekMuatan(int $ruanganID, int $kapasitas)
    {
        $over_cap = Ruangan::where('id', $ruanganID)
            ->value('muatan_kapasitas');

        if ($kapasitas > $over_cap) {
            throw new \Exception('Ruangan melebihi kapasitas');
        }
    }

    # Membuat log request peminjaman dari user
    public function createKegiatan($penanggungJawab, $ruanganID)
    {
        if (!$ruanganID) {
            throw new \Exception('Ruangan tidak ditemukan');
        }

        $ruangan = Ruangan::select('kode_ruangan')
            ->where('id', $ruanganID)
            ->first();

        KegiatanTerkiniModel::create([
            'pesan' => "$penanggungJawab melakukan peminjaman pada ruangan $ruangan->kode_ruangan",
        ]);
    }

    public function getDataWaktuPeminjaman($ruanganId)
    {
        if (!$ruanganId) {
            return [
                'dates' => [],
                'bookings' => collect([]),
                'timeSlots' => $this->generateJam('06:30', '22:30'),
                'kodeRuangan' => null
            ];
        }

        $ruangan = Ruangan::find($ruanganId);
        $daysToShow = 7;
        $dates = [];
        for ($i = 0; $i < $daysToShow; $i++) {
            $date = now()->addDays($i);
            $dates[] = [
                'full' => $date->toDateString(),
                'day' => $date->translatedFormat('l'),
                'date' => $date->translatedFormat('d M')
            ];
        }

        $fullDates = array_column($dates, 'full');

        $bookings = DataPeminjaman::with('waktuPeminjaman:peminjaman_id,waktu_peminjaman')
            ->where('ruangan_id', (int) $ruanganId)
            ->whereIn('tanggal_peminjaman', $fullDates)
            ->whereIn('status', ['Waiting', 'Approve'])
            ->get(['id', 'tanggal_peminjaman', 'status', 'penanggung_jawab']);

        $grouped = $bookings->map(function ($booking) {
            return [
                'date' => Carbon::parse($booking->tanggal_peminjaman)->toDateString(),
                'status' => $booking->status,
                'user' => $booking->penanggung_jawab,
                'waktu' => $booking->waktuPeminjaman
            ];
        })->groupBy('date')->map(function ($dayBookings) {
            $slots = [];
            foreach ($dayBookings as $booking) {
                foreach ($booking['waktu'] as $w) {
                    $jam = Carbon::parse($w->waktu_peminjaman)->format('H:i');
                    $slots[$jam] = [
                        'status' => $booking['status'],
                        'user' => $booking['user']
                    ];
                }
            }
            return $slots;
        });

        return [
            'dates' => $dates,
            'bookings' => $grouped,
            'timeSlots' => $this->generateJam('06:30', '22:30'),
            'kodeRuangan' => $ruangan->kode_ruangan ?? '-'
        ];
    }
}
