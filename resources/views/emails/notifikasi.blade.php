<x-mail::message>
# Notifikasi Peminjaman

Halo **{{ $peminjaman->penanggung_jawab }}**,

Status peminjaman Anda telah diperbarui. Berikut adalah rincian peminjaman Anda:

<x-mail::panel>
**Status:** {{ strtoupper($type) }} <br>
**Ruangan:** {{ $peminjaman->ruangan->kode_ruangan }} ({{ $peminjaman->ruangan->lantai->gedung->nama_gedung }}) <br>
**Tanggal:** {{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->translatedFormat('d F Y') }} c
**Waktu:** {{ $peminjaman->jam_mulai }} - {{ $peminjaman->jam_selesai }} <br>
</x-mail::panel>

@if($type === 'approve')
Peminjaman Anda telah **Disetujui**. Silakan gunakan ruangan sesuai dengan jadwal yang telah ditentukan.
@elseif($type === 'reject')
Peminjaman Anda **Ditolak**.
**Alasan:** {{ $peminjaman->alasan_penolakan ?? 'Tidak ada alasan spesifik' }}
@elseif($type === 'cancel')
Peminjaman Anda telah **Dibatalkan**.
@endif

Silakan lihat status peminjaman di website.

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
