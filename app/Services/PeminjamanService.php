<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Gedung;
use App\Models\Lantai;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\JadwalMatkulWajib;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
        return Ruangan::select('id', 'kode_ruangan', 'muatan_kapasitas')
            ->where('status', 'Aktif')
            ->where('lantai_id', $lantaiId)
            ->get()
            ->toArray();
    }

    public function getFakultas()
    {
        $fakultas = env('URL_FACULTY');
        $token = env('TOKEN');

        if ($token !== null && $token != '') {
            $response = Http::withToken($token)->get($fakultas);

            if ($response->successful()) {
                $data = $response->json();
                return collect($data)->map(function ($item) {
                    return [
                        'id' => $item['facultyid'],
                        'fakultas' => $item['facultyname'],
                    ];
                })->toArray();
            }
        }

        return Fakultas::select('id', 'fakultas')
            ->get()
            ->toArray();
    }

    public function getProdi($fakultasId)
    {
        $prodi = env('URL_PRODY');
        $token = env('TOKEN');

        if ($token !== null && $token !== '') {
            $response = Http::withToken($token)->get($prodi . $fakultasId);

            if ($response->successful()) {
                $data = $response->json();
                return collect($data)->map(function ($item) {
                    return [
                        'id' => $item['studyprogramid'],
                        'prodi' => $item['studyprogramname'],
                    ];
                })->toArray();
            }
        }

        return Prodi::select('id', 'prodi')
            ->where('fakultas_id', $fakultasId)
            ->get()
            ->toArray();
    }

    public function getMataKuliah($prodiId)
    {
        $data = MataKuliah::select('kode_matkul', 'nama_matkul')
            ->where(function ($query) use ($prodiId) {
                if ($prodiId) {
                    $query->where('prodi_id', $prodiId)
                        ->orWhereNull('prodi_id');
                } else {
                    $query->whereNull('prodi_id');
                }
            })
            ->get();

        return $data->toArray();
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
            'fakultas' => 'required',
            'prodi' => 'required',
            'tanggal' => 'required|date|after_or_equal:today',
            'lantaiID' => 'required|integer',
            'ruanganID' => 'required|integer',
            'pilihJam' => 'required|array|min:1',
            'muatanKapasitas' => 'required|integer|min:1',
            'jenisPeminjaman' => 'required|string',
            'penanggungJawab' => 'required|string|min:3',
            'kontakPenanggungJawab' => 'required|numeric|digits_between:10,15',
            'email' => 'required|email',
            'deskripsi' => 'required|string|max:500',
            'userIdentifier' => 'required|string',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'nama_dokumen' => 'nullable|string',
        ];

        if ($type === 'akademik') {
            $baseRules['kodeMatkul'] = 'required|string';
        }

        return $baseRules;
    }

    public function getMessages(): array
    {
        return [
            'fakultas.required' => 'Fakultas wajib diisi',
            'prodi.required' => 'Program studi wajib diisi',
            'kodeMatkul.required' => 'Kode mata kuliah wajib dipilih',
            'tanggal.required' => 'Tanggal wajib diisi',
            'lantaiID.required' => 'Lantai wajib dipilih',
            'ruanganID.required' => 'Ruangan wajib dipilih',
            'pilihJam.required' => 'Minimal pilih satu jam',
            'pilihJam.min' => 'Minimal pilih satu jam',
            'muatanKapasitas.required' => 'Kapasitas wajib diisi',
            'muatanKapasitas.integer' => 'Kapasitas harus berupa angka',
            'muatanKapasitas.min' => 'Kapasitas minimal 1',
            'penanggungJawab.required' => 'Penanggung jawab wajib diisi',
            'penanggungJawab.min' => 'Minimal 3 karakter',
            'kontakPenanggungJawab.required' => 'Kontak wajib diisi',
            'kontakPenanggungJawab.numeric' => 'Kontak tidak boleh mengandung huruf atau simbol',
            'kontakPenanggungJawab.digits_between' => 'Kontak minimal 10 dan maksimal 15 digit',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter',
            'deskripsi.required' => 'Keterangan kegiatan wajib di isi',
            'dokumen.file' => 'Dokumen harus berupa file valid',
            'dokumen.mimes' => 'Format dokumen harus berupa PDF, DOC, atau DOCX',
            'dokumen.max' => 'Ukuran dokumen maksimal 10MB',
        ];
    }

    # Generate jam otomatis
    public function generateJam($start, $end, $interval = 30)
    {
        $result = [];
        # Split string pakai explode
        [$h, $m] = explode(':', $start);
        [$endH, $endM] = explode(':', $end);
        $h = (int) $h;
        $m = (int) $m;
        $endH = (int) $endH;
        $endM = (int) $endM;

        # Loop jam awal sama jam akhir
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

    public function create(array $data, $role = null)
    {
        $this->cekWaktuTerlewat($data);
        $this->cekTabrakanJadwal($data);
        $this->cekTabrakanMatkulWajib($data);
        $this->cekMuatan($data['ruanganID'], $data['muatanKapasitas']);

        $jam = array_unique($data['pilihJam']);
        sort($jam);

        # Hitung waktu_mulai, waktu_selesai, dan total_waktu
        $range = $this->hitungWaktu($jam);
        $start = $range['waktu_mulai'];
        $end = $range['waktu_selesai'];
        $durationText = $range['total_waktu'];

        # Spesial case, jika Direktorat Khusus
        $isDirektorat = ($data['fakultas'] === 'DIREKTORAT KHUSUS');
        $namaFakultas = $isDirektorat ? 'DIREKTORAT KHUSUS' : (Fakultas::find($data['fakultas'])?->fakultas ?? $data['fakultas']);
        $namaProdi = $isDirektorat ? $data['prodi'] : (Prodi::find($data['prodi'])?->prodi ?? $data['prodi']);

        try {
            # Masuk transaction dikarenakan ada 1 proses query utama
            $peminjaman = DB::transaction(function () use ($data, $start, $end, $durationText, $role, $namaFakultas, $namaProdi) {
                $record = DataPeminjaman::create([
                    'fakultas' => $namaFakultas,
                    'prodi' => $namaProdi,
                    'jenis_peminjaman' => $data['jenisPeminjaman'],
                    'kode_matkul' => $data['kodeMatkul'] ?? null,
                    'user_identifier' => $data['userIdentifier'],
                    'lantai' => (int) $data['lantaiID'],
                    'ruangan_id' => (int) $data['ruanganID'],
                    'tanggal_peminjaman' => $data['tanggal'],
                    'hari' => Carbon::parse($data['tanggal'])->locale('id')->translatedFormat('l'),
                    'muatan' => $data['muatanKapasitas'],
                    'penanggung_jawab' => $data['penanggungJawab'],
                    'kontak_penanggung_jawab' => $data['kontakPenanggungJawab'],
                    'email' => $data['email'],
                    'keterangan_peminjaman' => $data['deskripsi'],
                    'dokumen' => $data['dokumen'] ?? null,
                    'nama_dokumen' => $data['nama_dokumen'] ?? null,
                    'status' => ($role === 'BAA') ? 'Approve' : 'Waiting',
                    'waktu_mulai' => $start,
                    'waktu_selesai' => $end,
                    'total_waktu' => $durationText,
                ]);

                # Mencatat log kegiatan setelah transaksi sukses
                $kodeRuangan = Ruangan::where('id', $data['ruanganID'])->value('kode_ruangan') ?? $data['ruanganID'];
                app(NotificationService::class)->pushKegiatanTerkini($data['penanggungJawab'], $kodeRuangan);

                return $record;
            });

            return $peminjaman;
        } catch (\Exception $e) {
            throw new \Exception('Gagal memproses peminjaman.');
        }
    }

    # Cek apakah jadwal yang dipinjam apakah sudah pernah dipinjam atau belum
    private function cekTabrakanJadwal(array $data)
    {
        sort($data['pilihJam']);
        \Log::info('jam yg di pilih: ' . json_encode($data['pilihJam']));
        $startBaru = $data['pilihJam'][0];
        # Cek apakah pilih jam hanya 1 atau lebih dari 1
        $endBaru = count($data['pilihJam']) > 1 ? end($data['pilihJam']) : Carbon::parse($startBaru)->addMinutes(30)->format('H:i');

        \Log::info('' . $startBaru . ' ' . $endBaru);

        $tabrakan = DataPeminjaman::where('ruangan_id', $data['ruanganID'])
            ->where('tanggal_peminjaman', $data['tanggal'])
            ->whereIn('status', ['Approve', 'Waiting'])
            ->where(function ($q) use ($startBaru, $endBaru) {
                $q->where('waktu_mulai', '<', $endBaru)
                    ->where('waktu_selesai', '>', $startBaru);
            })
            ->first();

        if ($tabrakan) {
            $formattedStart = Carbon::parse($tabrakan->waktu_mulai)->format('H:i');
            $formattedEnd = Carbon::parse($tabrakan->waktu_selesai)->format('H:i');
            throw new \Exception("Ruangan sudah dipakai pada jam {$formattedStart} sampai {$formattedEnd} oleh {$tabrakan->penanggung_jawab}");
        }
    }

    # Cek apakah jadwal yang dipilih user bentrok dengan jadwal matakuliah wajib
    private function cekTabrakanMatkulWajib(array $data)
    {
        # Ambil nama hari dari tanggal yang dipilih user
        $hari = Carbon::parse($data['tanggal'])->locale('id')->translatedFormat('l');

        # Ambil jadwal matkul wajib di ruangan dan hari yang sama
        $jadwals = JadwalMatkulWajib::where('ruangan_id', $data['ruanganID'])
            ->where('hari', $hari)
            ->get();

        # Jika tidak ada jadwal matakuliah pada hari tersebut, langsung return
        if ($jadwals->isEmpty()) {
            return;
        }

        # Urutkan jam pilihan user lalu tentukan jam mulai dan jam selesai
        sort($data['pilihJam']);
        $startBaru = $data['pilihJam'][0];

        # Memakai fungsi addMinute untuk mendapatkan nilai waktu dengan interval 30 menit dari waktu mulai sampai akhir
        $endBaru = count($data['pilihJam']) > 1 ? end($data['pilihJam']) :
            Carbon::parse($startBaru)->addMinutes(30)->format('H:i');

        # Cocokkan pilihan user dengan setiap jadwal wajib yang ada
        foreach ($jadwals as $jadwal) {
            # Ambil jam mulai dan jam selesai jadwal wajib
            $mulai = Carbon::parse($jadwal->shift_mulai)->format('H:i');
            $selesai = Carbon::parse($jadwal->shift_selesai)->format('H:i');

            # Cek apakah waktu pilihan user bertabrakan dengan jadwal wajib
            if ($startBaru < $selesai && $endBaru > $mulai) {
                throw new \Exception(
                    "Ruangan sudah dipakai untuk jadwal matakuliah '{$jadwal->nama_matkul}' "
                        . "pada hari {$hari}, pukul {$mulai}–{$selesai}"
                );
            }
        }
    }

    # Cek muatan dari peminjaman apakah melebihi kapasitas ruangan atau tidak
    private function cekMuatan(int $ruanganID, int $kapasitas)
    {
        $over_cap = Ruangan::where('id', $ruanganID)
            ->value('muatan_kapasitas');

        if ($kapasitas > $over_cap) {
            throw new \Exception('Muatan melebihi kapasitas');
        }
    }

    # Cek waktu peminjaman nya apakah sudah terlewat jam dihari user meminjam
    private function cekWaktuTerlewat(array $data)
    {
        $tanggalPeminjaman = Carbon::parse($data['tanggal'])->toDateString();

        $currentDay = Carbon::today()->toDateString();

        # Jika tanggal peminjaman hari ini 
        if ($tanggalPeminjaman === $currentDay) {
            sort($data['pilihJam']);

            # Jam mulai yang dipilih oleh user
            $jamMulai = $data['pilihJam'][0];
            $waktuPeminjaman = Carbon::parse($tanggalPeminjaman . ' ' . $jamMulai);

            # Jika jam yang dipilih sudah terlewat
            if ($waktuPeminjaman->isPast()) {
                throw new \Exception('Waktu peminjaman yang dipilih sudah terlewat.');
            }
        }
    }

    # Fungsi untuk menghitung total waktu meminjam dan 
    private function hitungWaktu(array $jam): array
    {
        $start = $jam[0];
        $end = count($jam) > 1 ? end($jam) : Carbon::parse($start)->addMinutes(30)->format('H:i');

        $startTime = Carbon::parse($start);
        $endTime = Carbon::parse($end);

        $diffMinutes = $startTime->diffInMinutes($endTime);
        $durationText = '';
        if ($diffMinutes >= 60) {
            $hours = floor($diffMinutes / 60);
            $mins = $diffMinutes % 60;
            $durationText = $hours . ' Jam' . ($mins > 0 ? " $mins Menit" : '');
        } else {
            $durationText = "$diffMinutes Menit";
        }

        return [
            'waktu_mulai' => $start,
            'waktu_selesai' => $end,
            'total_waktu' => $durationText
        ];
    }

    public function getDataWaktuPeminjaman($ruanganId)
    {
        if (!$ruanganId) {
            return [
                'dates' => [],
                'bookings' => [],
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
                'day' => $date->locale('id')->translatedFormat('l'),
                'date' => $date->locale('id')->translatedFormat('d M')
            ];
        }

        # 1. Mengambil peminjaman (Waiting & Approve)
        $grouped = $this->getBookings((int) $ruanganId, $dates);

        # 2. Menyisipkan jadwal mata kuliah wajib ke dalam kalender
        $grouped = $this->injectMatkulWajib($grouped, (int) $ruanganId, $dates);

        return [
            'dates' => $dates,
            'bookings' => $grouped,
            'timeSlots' => $this->generateJam('06:30', '22:30'),
            'kodeRuangan' => $ruangan->kode_ruangan ?? '-'
        ];
    }

    # Mengambil dan mengelompokkan peminjaman (Waiting & Approve). 
    private function getBookings(int $ruanganId, array $dates): array
    {
        $fullDates = array_column($dates, 'full');

        $bookings = DataPeminjaman::select('id', 'ruangan_id', 'status', 'tanggal_peminjaman', 'penanggung_jawab', 'waktu_mulai', 'waktu_selesai')
            ->where('ruangan_id', $ruanganId)
            ->whereIn('tanggal_peminjaman', $fullDates)
            ->whereIn('status', ['Waiting', 'Approve'])
            ->get();

        return $bookings->map(function ($booking) {
            $slots = [];
            if ($booking->waktu_mulai && $booking->waktu_selesai) {
                $slots = $this->expandRangeToSlots($booking->waktu_mulai, $booking->waktu_selesai);
            }

            return [
                'date' => Carbon::parse($booking->tanggal_peminjaman)->toDateString(),
                'status' => $booking->status,
                'user' => $booking->penanggung_jawab,
                'waktu' => $slots
            ];
            # Untuk group data waktu peminjaman yang sudah dimapping waktu per interval 30 menit nya berdasarkan tanggal peminjaman
        })->groupBy('date')->map(function ($dayBookings) {
            $slots = [];
            foreach ($dayBookings as $booking) {
                foreach ($booking['waktu'] as $jam) {
                    $slots[$jam] = [
                        'status' => $booking['status'],
                        'user' => $booking['user']
                    ];
                }
            }

            return $slots;
        })->toArray();
    }

    private function expandRangeToSlots($start, $end): array
    {
        $slots = [];
        $startTime = Carbon::parse($start);
        $endTime = Carbon::parse($end);

        # Selama waktu mulai kurang dari waktu selesai nya, maka lakukan loop secara terus menerut dengan rentang interval 30M.
        while ($startTime->lt($endTime)) {
            # Lalu simpan, waktu mulai ke dalam slot dengan format jam dan menit
            $slots[] = $startTime->format('H:i');
            # Lalu tambah kan waktu mulai 30m, Contoh misal startTime 08:00, maka tambah kan 30m, jadi 08:30,
            # Begitu seterus nya sampai while diluar kondisi dari waktu terakhir nya.
            $startTime->addMinutes(30);
        }

        return $slots;
    }

    # Menyisipkan jadwal mata kuliah wajib ke dalam slot waktu kalender yang sesuai.
    private function injectMatkulWajib(array $grouped, int $ruanganId, array $dates): array
    {
        $matkulWajibs = JadwalMatkulWajib::where('ruangan_id', $ruanganId)->get();

        $dayMapping = [
            'monday' => 'senin',
            'tuesday' => 'selasa',
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',
            'sunday' => 'minggu',
        ];

        foreach ($dates as $date) {
            $hariEng = strtolower($date['day']);
            $hariIndo = $dayMapping[$hariEng] ?? $hariEng;
            $fullDate = $date['full'];

            if (!isset($grouped[$fullDate])) {
                $grouped[$fullDate] = [];
            }

            foreach ($matkulWajibs as $mw) {
                if (strtolower($mw->hari) === $hariIndo) {
                    $jamMulai = Carbon::parse($mw->shift_mulai)->format('H:i');
                    $jamSelesai = Carbon::parse($mw->shift_selesai)->format('H:i');
                    $slotsMw = $this->generateJam($jamMulai, $jamSelesai);
                    array_pop($slotsMw);

                    foreach ($slotsMw as $slot) {
                        $grouped[$fullDate][$slot] = [
                            'status' => 'MatkulWajib',
                            'user' => $mw->nama_matkul
                        ];
                    }
                }
            }
        }

        return $grouped;
    }

    public function getRuanganByGedung(int $gedungId)
    {
        return Ruangan::select('ruangans.id', 'ruangans.kode_ruangan', 'ruangans.muatan_kapasitas', 'lantais.lantai')
            ->join('lantais', 'ruangans.lantai_id', '=', 'lantais.id')
            ->where('lantais.gedung_id', $gedungId)
            ->where('ruangans.status', 'Aktif')
            ->orderBy('lantais.id', 'asc')
            ->orderBy('ruangans.kode_ruangan', 'asc')
            ->get()
            ->toArray();
    }
}
