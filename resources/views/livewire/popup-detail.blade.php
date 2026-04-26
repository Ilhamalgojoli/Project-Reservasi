<div>
    {{-- Forced Centered Loading Overlay --}}
    <div wire:loading wire:target="cancelReservation"
        class="fixed inset-0 bg-black/40 z-[10000] flex flex-col items-center justify-center">
        <div class="flex flex-col items-center justify-center">
            <div class="relative w-12 h-12 mb-4">
                <div class="absolute inset-0 border-4 border-white/20 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-white rounded-full border-t-transparent animate-spin"></div>
            </div>
            <p class="text-[10px] font-black text-white uppercase tracking-[0.4em] animate-pulse text-center">
                Memproses...</p>
        </div>
    </div>

    @if ($isOpen && $peminjamanDetail)

        <section
            class="popup fixed inset-0 bg-gray-900/40 backdrop-blur-sm flex items-center justify-center z-[1000] p-4 transition-all duration-500">
            <div
                class="bg-white w-full max-w-2xl rounded-[40px] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.2)] overflow-hidden relative animate-slide-up border border-white/20">

                <div
                    class="absolute -top-24 -right-24 w-64 h-64 bg-red-50 rounded-full blur-3xl opacity-60 pointer-events-none">
                </div>
                <div
                    class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-60 pointer-events-none">
                </div>

                <div
                    class="p-8 relative flex items-center justify-between bg-white/80 backdrop-blur-md border-b border-gray-100">
                    <div class="flex items-center gap-4 text-gray-800">
                        <div class="p-3 bg-red-50 rounded-[20px] shadow-sm italic text-[#e51411]">
                            <iconify-icon icon="solar:clipboard-list-bold-duotone" class="text-3xl"></iconify-icon>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black tracking-tight leading-none text-gray-900">Detail Reservasi
                            </h2>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-2">ID Reservasi:
                                #{{ str_pad($peminjamanDetail->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                    <button type="button" wire:click="closeDetail"
                        class="w-12 h-12 flex items-center justify-center rounded-2xl bg-gray-50 text-gray-400 border border-gray-100 hover:bg-red-50 hover:text-red-500 transition-all duration-300 group">
                        <iconify-icon icon="solar:close-circle-bold"
                            class="text-2xl group-hover:rotate-90 transition-transform duration-300"></iconify-icon>
                    </button>
                </div>

                <div class="p-8 relative flex flex-col gap-8 max-h-[70vh] overflow-y-auto custom-scrollbar">

                    <div class="flex items-center justify-between p-5 bg-gray-50 rounded-3xl border border-gray-100">
                        <div class="flex flex-col gap-1">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Status Saat
                                Ini</span>
                            @php
                                $badgeColor = match ($peminjamanDetail->status) {
                                    'Approve' => 'text-emerald-600',
                                    'Reject' => 'text-red-600',
                                    'Waiting' => 'text-amber-600',
                                    'Canceled' => 'text-gray-500',
                                    'Finish' => 'text-blue-600',
                                    default => 'text-gray-400',
                                };
                                $statusIcon = match ($peminjamanDetail->status) {
                                    'Approve' => 'solar:check-circle-bold-duotone',
                                    'Reject' => 'solar:close-circle-bold-duotone',
                                    'Waiting' => 'solar:clock-circle-bold-duotone',
                                    'Canceled' => 'solar:forbidden-circle-bold-duotone',
                                    'Finish' => 'solar:check-read-bold-duotone',
                                    default => 'solar:help-circle-bold-duotone',
                                };
                            @endphp
                            <div class="flex items-center gap-2 {{ $badgeColor }}">
                                <iconify-icon icon="{{ $statusIcon }}" class="text-2xl"></iconify-icon>
                                <span
                                    class="font-black text-lg uppercase tracking-tight">{{ $peminjamanDetail->status }}</span>
                            </div>
                        </div>
                        @if ($peminjamanDetail->status === 'Reject' && $peminjamanDetail->alasan_penolakan)
                            <div class="max-w-[60%] text-right">
                                <span
                                    class="text-[10px] font-black text-red-400 uppercase tracking-widest block">Catatan
                                    Penolakan</span>
                                <p class="text-xs font-bold text-red-500 mt-1 italic leading-relaxed">
                                    "{{ $peminjamanDetail->alasan_penolakan }}"</p>
                            </div>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-8">
                            <div class="flex flex-col gap-4">
                                <h3
                                    class="text-sm font-black text-gray-900 flex items-center gap-2 uppercase tracking-widest">
                                    <span class="w-2 h-2 bg-[#e51411] rounded-full"></span>
                                    Informasi Peminjaman
                                </h3>
                                <div class="space-y-4 ml-4">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Nama Penanggung
                                            Jawab</span>
                                        <span
                                            class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->penanggung_jawab }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Email</span>
                                        <span
                                            class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->email ?? '-' }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Jenis
                                            Peminjaman</span>
                                        <span
                                            class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->jenis_peminjaman }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Fakultas /
                                            Unit</span>
                                        <span
                                            class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->fakultas_name }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Program Studi</span>
                                        <span
                                            class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->prodi_name }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-4">
                                <h3
                                    class="text-sm font-black text-gray-900 flex items-center gap-2 uppercase tracking-widest">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                    Waktu & Durasi
                                </h3>
                                <div class="flex flex-row gap-12">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:calendar-date-bold-duotone"
                                            class="text-2xl text-emerald-500"></iconify-icon>
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">Tanggal
                                                Peminjaman</span>
                                            <span
                                                class="text-sm font-bold text-gray-800 w-32">{{ \Carbon\Carbon::parse($peminjamanDetail->tanggal_peminjaman)->translatedFormat('d F Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:clock-circle-bold-duotone"
                                            class="text-2xl text-emerald-500"></iconify-icon>
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">Sesi
                                                Waktu</span>
                                            <span
                                                class="text-sm font-bold text-gray-800 w-64">{{ $peminjamanDetail->jam_mulai }}
                                                {{ $peminjamanDetail->jam_selesai }} <span
                                                    class="text-[10px] text-gray-400 ml-1">({{ $peminjamanDetail->total_menit }}
                                                    Menit)</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-8">
                            <div class="flex flex-col gap-4">
                                <h3
                                    class="text-sm font-black text-gray-900 flex items-center gap-2 uppercase tracking-widest">
                                    <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                                    Lokasi & Fasilitas
                                </h3>
                                <div class="space-y-4 ml-4">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:city-bold-duotone"
                                            class="text-2xl text-amber-500"></iconify-icon>
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">Gedung /
                                                Lantai</span>
                                            <span
                                                class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->nama_gedung }}
                                                / Lt. {{ $peminjamanDetail->lantai }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="mdi:office-building-marker"
                                            class="text-2xl text-amber-500"></iconify-icon>
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">Kode
                                                Ruangan</span>
                                            <span
                                                class="text-sm font-bold text-gray-800 tracking-wider">{{ $peminjamanDetail->kode_ruangan }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:users-group-rounded-bold-duotone"
                                            class="text-2xl text-amber-500"></iconify-icon>
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">Kapasitas
                                                Peserta</span>
                                            <span
                                                class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->muatan ?? $peminjamanDetail->ruangan?->kapasitas }}
                                                Orang</span>
                                        </div>
                                    </div>

                                    @if ($peminjamanDetail->ruangan && $peminjamanDetail->ruangan->fasilitas)
                                        <div class="flex flex-col gap-3 pt-2">
                                            <span
                                                class="text-[10px] font-bold text-gray-400 uppercase border-t border-gray-50 pt-3">Fasilitas
                                                Tersedia</span>
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach (explode(',', $peminjamanDetail->ruangan->fasilitas) as $item)
                                                    <span
                                                        class="px-2.5 py-1 bg-amber-50 border border-amber-100/50 rounded-lg text-[9px] font-bold text-amber-600 uppercase tracking-wider">{{ trim($item) }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <h3 class="text-sm font-black text-gray-900 flex items-center gap-2 uppercase tracking-widest">
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                            Keperluan Peminjaman
                        </h3>
                        <div class="p-6 bg-blue-50/30 rounded-[32px] border border-blue-100/50 ml-4">
                            <p class="text-sm font-medium text-gray-700 italic leading-relaxed">
                                "{{ $peminjamanDetail->keterangan_peminjaman }}"
                            </p>
                        </div>
                    </div>
                </div>
                <div
                    class="p-8 bg-gray-50/50 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <button type="button" wire:click="closeDetail"
                            class="px-8 py-4 bg-white border border-gray-200 text-gray-500 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-gray-50 transition-all shadow-sm">
                            Tutup Detail
                        </button>

                        @if (session('role_name') === 'BAA' &&
                                $peminjamanDetail->status !== 'Canceled' &&
                                $peminjamanDetail->status !== 'Finish')
                            <button type="button"
                                @click="
                                    Swal.fire({
                                        title: 'Batalkan Reservasi?',
                                        text: 'Apakah Anda yakin ingin membatalkan reservasi ini? Tindakan ini tidak dapat dibatalkan.',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Ya, Batalkan!',
                                        cancelButtonText: 'Batal',
                                        buttonsStyling: false,
                                        reverseButtons: true,
                                        customClass: {
                                            confirmButton: 'inline-flex items-center px-8 py-4 bg-[#e51411] text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl shadow-sm hover:bg-red-700 transition-all ml-3',
                                            cancelButton: 'inline-flex items-center px-8 py-4 bg-gray-100 text-gray-500 font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl hover:bg-gray-200 transition-all'
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $wire.cancelReservation()
                                        }
                                    });
                                "
                                class="px-8 py-4 bg-red-50 border border-red-100 text-red-500 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm flex items-center gap-2 group">
                                <iconify-icon icon="solar:trash-bin-trash-bold-duotone"
                                    class="text-lg group-hover:animate-bounce"></iconify-icon>
                                Batalkan Reservasi
                            </button>
                        @endif
                        @if ($peminjamanDetail->status === 'Waiting')
                            <div
                                class="flex items-center gap-2 px-6 py-4 bg-amber-50 border border-amber-100 rounded-2xl">
                                <iconify-icon icon="solar:info-circle-bold-duotone"
                                    class="text-amber-500 text-lg"></iconify-icon>
                                <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">Menunggu
                                    Persetujuan Admin</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('swal:success', (e) => {
            Swal.fire({
                title: 'Berhasil!',
                text: e.text || 'Aksi berhasil dilakukan.',
                icon: 'success',
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'inline-flex items-center px-8 py-4 bg-[#e51411] text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl shadow-sm hover:bg-red-700 transition-all'
                }
            });
        });
    });
</script>
