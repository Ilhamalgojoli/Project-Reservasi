<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use App\Mail\NotifikasiMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Exception;

class ApproveRejectService
{
    private $notif;
    
    public function __construct()
    {
        $this->notif = app(NotificationService::class);
    }

    public function approve($id)
    {
        $peminjaman = DataPeminjaman::with(['ruangan.lantai.gedung'])->findOrFail($id);
        $peminjaman->update(['status' => 'Approve']);

        # Pemicu Notifikasi dan Kegiatan Terkini
        $this->notif->pushNotification($peminjaman, 'Approve');
        $this->notif->pushKegiatanTerkini($peminjaman->penanggung_jawab, $peminjaman->ruangan_id, 'approve');

        $this->prepareEmailData($peminjaman);

        try {
            Mail::to($peminjaman->email)->send(new NotifikasiMail($peminjaman, 'approve'));
        } catch (\Exception $e) {
            throw new \Exception("Peminjaman berhasil disetujui,tetapi email tidak terkirim.");
        }

        return true;
    }

    public function reject($id, $alasan)
    {
        $peminjaman = DataPeminjaman::with(['ruangan.lantai.gedung'])->findOrFail($id);
        $peminjaman->update([
            'status' => 'Reject',
            'alasan_penolakan' => $alasan,
        ]);

        # Pemicu Notifikasi dan Kegiatan Terkini
        $this->notif->pushNotification($peminjaman, 'Reject');
        $this->notif->pushKegiatanTerkini($peminjaman->penanggung_jawab, $peminjaman->ruangan_id, 'reject');

        $this->prepareEmailData($peminjaman);

        try {
            Mail::to($peminjaman->email)->send(new NotifikasiMail($peminjaman, 'reject'));
        } catch (\Exception $e) {
            throw new \Exception("Peminjaman berhasil ditolak,tetapi email tidak terkirim.");
        }

        return true;
    }

    public function cancel($id, $userIdentifier = null, $reason = '-', $isAdmin = false)
    {
        $data = DataPeminjaman::with(['ruangan.lantai.gedung'])->find($id);

        if (!$data) {
            throw new \Exception("Data peminjaman tidak ditemukan.");
        }

        # Jika bukan admin dan pembatalan dari sisi User, cek hak akses
        if (!$isAdmin && $userIdentifier && $data->user_identifier !== $userIdentifier) {
            throw new \Exception("Anda tidak berhak membatalkan peminjaman ini.");
        }

        # Cek status sebelum cancel
        if ($data->status === 'Canceled') {
            throw new \Exception("Peminjaman sudah dibatalkan sebelumnya.");
        }

        $data->update([
            'status' => 'Canceled',
        ]);
        $cancelBy = $userIdentifier ?? 'Admin/BAA';
        if (!$isAdmin && $userIdentifier === session('user_identifier') && session('username')) {
            $cancelBy = session('username') . ' (' . session('user_identifier') . ')';
        }

        $data->pembatalan()->updateOrCreate(
            ['data_peminjaman_id' => $data->id],
            [
                'alasan_pembatalan' => $reason,
                'cancel_by' => $cancelBy,
                'cancel_requested' => false,
                'cancel_request_reason' => null
            ]
        );

        # Pemicu Notifikasi dan Kegiatan Terkini
        $this->notif->pushNotification($data, 'Canceled');
        $this->notif->pushKegiatanTerkini($data->penanggung_jawab, $data->ruangan_id, 'cancel');

        # Kirim email jika dibatalkan oleh Admin (userIdentifier null atau isAdmin true)
        if ($userIdentifier === null || $isAdmin) {
            $this->prepareEmailData($data);

            try {
                Mail::to($data->email)->send(new NotifikasiMail($data, 'cancel'));
            } catch (\Exception $e) {
                throw new Exception('Peminjaman berhasil dibatalkan,tetapi email tidak terkirim');
            }
        }

        return true;
    }

    public function autoRejectExpire(?string $userIdentifier = null)
    {
        $now = Carbon::now();
        $today = $now->toDateString();
        $nowTime = $now->toTimeString();

        # Ambil ID peminjaman yang expired sebelum hari ini
        $queryPast = DataPeminjaman::select('id')
            ->where('status', 'Waiting')
            ->where('tanggal_peminjaman', '<', $today);

        # Ambil ID peminjaman yang expired hari ini (waktu_selesai sudah lewat)
        $queryToday = DataPeminjaman::select('id')
            ->where('status', 'Waiting')
            ->where('tanggal_peminjaman', $today)
            ->where('waktu_selesai', '<', $nowTime);

        if ($userIdentifier) {
            $queryPast->where('user_identifier', $userIdentifier);
            $queryToday->where('user_identifier', $userIdentifier);
        }

        $peminjamanExpirePast = $queryPast->pluck('id');
        $peminjamanExpireToday = $queryToday->pluck('id');

        $allIds = $peminjamanExpirePast->merge($peminjamanExpireToday);

        if ($allIds->isEmpty()) {
            return;
        }

        foreach ($allIds as $id) {
            try {
                $this->reject($id, "Data Peminjaman ini telah expired, dan otomatis tertolak, silahkan mengajukan ulang peminjaman");
            } catch (\Exception $e) {
                continue;
            }
        }
    }

    private function prepareEmailData($peminjaman)
    {
        if ($peminjaman->ruangan && $peminjaman->ruangan->lantai && $peminjaman->ruangan->lantai->gedung) {
            $peminjaman->nama_gedung = $peminjaman->ruangan->lantai->gedung->nama_gedung;
            $peminjaman->lantas = $peminjaman->ruangan->lantai->nama_lantai;
            $peminjaman->nama_ruangan = $peminjaman->ruangan->nama_ruangan;
        } else {
            $peminjaman->nama_gedung = '-';
            $peminjaman->lantas = '-';
            $peminjaman->nama_ruangan = '-';
        }
    }
}
