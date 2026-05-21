<?php

namespace App\Services;

use App\Models\KegiatanTerkiniModel;
use App\Models\Notifikasi;
use App\Models\Ruangan;
use Carbon\Carbon;

class NotificationService
{
    public function pushNotification($peminjaman, $status)
    {
        $kodeRuangan = $peminjaman->ruangan ? $peminjaman->ruangan->kode_ruangan : 'ruangan';
        $userIdentifier = $peminjaman->user_identifier;

        switch ($status) {
            case 'Reject':
                Notifikasi::create([
                    'user_id' => $userIdentifier,
                    'pesan' => "Peminjaman anda pada ruangan {$kodeRuangan} ditolak dengan alasan: " . ($peminjaman->alasan_penolakan ?? '-')
                ]);
                break;
            case 'Approve':
                Notifikasi::create([
                    'user_id' => $userIdentifier,
                    'pesan' => "Peminjaman anda pada ruangan {$kodeRuangan} telah disetujui."
                ]);
                break;
            case 'Canceled':
                Notifikasi::create([
                    'user_id' => $userIdentifier,
                    'pesan' => "Peminjaman anda pada ruangan {$kodeRuangan} telah dibatalkan."
                ]);
                break;
            default:
                break;
        }
    }

    public function getNotifications($userId)
    {
        return Notifikasi::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function pushKegiatanTerkini($penanggungJawab, $ruanganID, $event = 'booking', $targetId = null, $alasan = '')
    {
        $ruangan = Ruangan::select('kode_ruangan')
            ->where('id', $ruanganID)
            ->first();

        if (!$ruangan) {
            return;
        }

        $pesan = '';
        switch ($event) {
            case 'booking':
                $pesan = "{$penanggungJawab} melakukan peminjaman pada ruangan {$ruangan->kode_ruangan}";
                break;
            case 'CancelRequest':
                $alasanText = $alasan ? " dengan alasan: {$alasan}" : '';
                $pesan = "{$penanggungJawab} mengajukan pembatalan peminjaman pada ruangan {$ruangan->kode_ruangan}{$alasanText}. Klik untuk lanjutkan pembatalan.";
                break;
        }

        if ($pesan) {
            KegiatanTerkiniModel::create([
                'pesan' => $pesan,
                'target_id' => $targetId,
            ]);
        }
    }

    public function getDataKegiatanTerkini(int $limit = 3): array
    {
        return $this->buildKegiatanTerkini($limit);
    }

    public function getDataKegiatanTerkiniAll(): array
    {
        return $this->buildKegiatanTerkini(50);
    }

    private function buildKegiatanTerkini(int $limit): array
    {
        return KegiatanTerkiniModel::select('pesan', 'target_id', 'created_at')
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                $pesan = $item->pesan;
                $pesan_clickable = null;
                
                if (strpos($pesan, 'Klik untuk lanjutkan pembatalan.') !== false) {
                    $parts = explode('. Klik untuk lanjutkan pembatalan.', $pesan);
                    $pesan = $parts[0] . '.';
                    $pesan_clickable = 'Klik untuk lanjutkan pembatalan.';
                }
                
                return [
                    'pesan'          => $pesan,
                    'pesan_clickable'=> $pesan_clickable,
                    'target_id'      => $item->target_id,
                    'waktu'          => Carbon::parse($item->created_at)->locale('id')->diffForHumans(),
                ];
            })
            ->toArray();
    }
}
