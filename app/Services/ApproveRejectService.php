<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use App\Mail\NotifikasiMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ApproveRejectService
{
    public function approve($id)
    {
        $peminjaman = DataPeminjaman::with(['waktuPeminjaman', 'ruangan.lantai.gedung'])->findOrFail($id);
        $peminjaman->update(['status' => 'Approve']);

        $this->prepareEmailData($peminjaman);

        try {
            Mail::to($peminjaman->email)->send(new NotifikasiMail($peminjaman, 'approve'));
        } catch (\Exception $e) {
            throw new \Exception("Gagal menyetujui peminjaman karena email tidak terkirim.");
        }

        return true;
    }

    public function reject($id, $alasan)
    {
        $peminjaman = DataPeminjaman::with(['waktuPeminjaman', 'ruangan.lantai.gedung'])->findOrFail($id);
        $peminjaman->update([
            'status' => 'Reject',
            'alasan_penolakan' => $alasan,
        ]);

        $this->prepareEmailData($peminjaman);

        try {
            Mail::to($peminjaman->email)->send(new NotifikasiMail($peminjaman, 'reject'));
        } catch (\Exception $e) {
            throw new \Exception("Gagal menolak peminjaman karena email tidak terkirim.");
        }

        return true;
    }

    public function cancel($id, $userIdentifier = null, $reason = '-', $isAdmin = false)
    {
        $data = DataPeminjaman::with(['waktuPeminjaman', 'ruangan.lantai.gedung'])->find($id);

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
            'alasan_pembatalan' => $reason,
            'cancel_by' => $userIdentifier ?? 'Admin/BAA'
        ]);

        # Kirim email jika dibatalkan oleh Admin (userIdentifier null atau isAdmin true)
        if ($userIdentifier === null || $isAdmin) {
            $this->prepareEmailData($data);

            try {
                \Illuminate\Support\Facades\Mail::to($data->email)->send(new \App\Mail\NotifikasiMail($data, 'cancel'));
            } catch (\Exception $e) {
                // Email gagal tidak apa-apa, yang penting status terupdate
            }
        }

        return true;
    }

    private function prepareEmailData($peminjaman)
    {
        if ($peminjaman->waktuPeminjaman->isNotEmpty()) {
            $waktu = $peminjaman->waktuPeminjaman->sortBy('waktu_peminjaman')->values();
            $peminjaman->jam_mulai = Carbon::parse($waktu->first()->waktu_peminjaman)->format('H:i');
            $peminjaman->jam_selesai = Carbon::parse($waktu->last()->waktu_peminjaman)->format('H:i');
        } else {
            $peminjaman->jam_mulai = '-';
            $peminjaman->jam_selesai = '-';
        }
    }
}
