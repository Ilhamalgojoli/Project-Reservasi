<div>
    {{-- Modern Loading Overlay --}}
    <div wire:loading wire:target="cancelReservation"
        class="fixed inset-0 bg-gray-900/80 z-[10000] flex flex-col items-center justify-center transition-all duration-500">
        <div class="relative">
            <div class="w-20 h-20 border-4 border-white/10 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-red-500 rounded-full border-t-transparent animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <iconify-icon icon="solar:history-bold-duotone" class="text-3xl text-white animate-pulse"></iconify-icon>
            </div>
        </div>
        <p class="mt-6 text-[10px] font-black text-white uppercase tracking-[0.4em] animate-pulse">Memproses Permintaan</p>
    </div>

    @if ($isOpen && $peminjamanDetail)
        <section class="fixed inset-0 z-[1000] flex items-center justify-center p-4 sm:p-6">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-gray-900/80 transition-opacity duration-500" wire:click="closeDetail"></div>

            {{-- Main Container --}}
            <div class="bg-white w-full max-w-2xl rounded-[8px] shadow-[0_40px_80px_-16px_rgba(0,0,0,0.3)] overflow-hidden relative animate-slide-up border border-white/40 flex flex-col max-h-[90vh]">
                
                {{-- Decoration --}}
                <div class="absolute -top-32 -right-32 w-80 h-80 bg-red-500/5 rounded-full blur-[100px] pointer-events-none"></div>
                <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-blue-500/5 rounded-full blur-[100px] pointer-events-none"></div>

                {{-- Header --}}
                <div class="p-8 pb-6 relative flex items-center justify-between border-b border-gray-50 bg-white/50 backdrop-blur-xl">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-50 to-red-100 rounded-[8px] flex items-center justify-center shadow-inner group overflow-hidden">
                            <iconify-icon icon="solar:clipboard-list-bold-duotone" class="text-3xl text-red-600 group-hover:scale-110 transition-transform duration-500"></iconify-icon>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black tracking-tight text-gray-900">Detail Reservasi</h2>
                            <div class="flex items-center gap-2 mt-1.5">
                                <span class="px-2.5 py-0.5 bg-gray-900 text-white text-[8px] font-black rounded-full uppercase tracking-widest shadow-sm">
                                    #{{ str_pad($peminjamanDetail->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider italic">ID Digital Token</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" wire:click="closeDetail"
                        class="w-12 h-12 flex items-center justify-center rounded-[8px] bg-gray-50 text-gray-400 border border-gray-100 hover:bg-red-50 hover:text-red-500 transition-all duration-300 group">
                        <iconify-icon icon="solar:close-circle-bold" class="text-2xl group-hover:rotate-90 transition-transform duration-500"></iconify-icon>
                    </button>
                </div>

                {{-- Body --}}
                <div class="p-8 pt-6 overflow-y-auto custom-scrollbar flex-1 flex flex-col gap-8">
                    
                    {{-- Status Banner --}}
                    @php
                        $statusStyles = match ($peminjamanDetail->status) {
                            'Approve' => ['bg' => 'bg-emerald-50/50', 'border' => 'border-emerald-100', 'text' => 'text-emerald-600', 'icon' => 'solar:check-circle-bold-duotone'],
                            'Reject' => ['bg' => 'bg-red-50/50', 'border' => 'border-red-100', 'text' => 'text-red-600', 'icon' => 'solar:close-circle-bold-duotone'],
                            'Waiting' => ['bg' => 'bg-amber-50/50', 'border' => 'border-amber-100', 'text' => 'text-amber-600', 'icon' => 'solar:clock-circle-bold-duotone'],
                            'Canceled' => ['bg' => 'bg-gray-50/50', 'border' => 'border-gray-100', 'text' => 'text-gray-500', 'icon' => 'solar:forbidden-circle-bold-duotone'],
                            'Finish' => ['bg' => 'bg-blue-50/50', 'border' => 'border-blue-100', 'text' => 'text-blue-600', 'icon' => 'solar:check-read-bold-duotone'],
                            default => ['bg' => 'bg-gray-50/50', 'border' => 'border-gray-100', 'text' => 'text-gray-400', 'icon' => 'solar:help-circle-bold-duotone'],
                        };
                    @endphp
                    <div class="p-6 {{ $statusStyles['bg'] }} {{ $statusStyles['border'] }} border-2 rounded-[8px] flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 {{ $statusStyles['bg'] }} rounded-[8px] flex items-center justify-center border {{ $statusStyles['border'] }}">
                                <iconify-icon icon="{{ $statusStyles['icon'] }}" class="text-3xl {{ $statusStyles['text'] }}"></iconify-icon>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black {{ $statusStyles['text'] }} uppercase tracking-[0.2em] opacity-70">Status Reservasi</span>
                                <span class="text-xl font-black {{ $statusStyles['text'] }} uppercase tracking-tighter">{{ $peminjamanDetail->status }}</span>
                            </div>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        {{-- Left Column --}}
                        <div class="space-y-10">
                            {{-- Info Section --}}
                            <div class="flex flex-col gap-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-6 bg-red-500 rounded-full"></div>
                                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em]">Data Peminjam</h3>
                                </div>
                                <div class="grid grid-cols-1 gap-5 ml-4">
                                    <div class="group">
                                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-1 group-hover:text-red-400 transition-colors">Penanggung Jawab</label>
                                        <p class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->penanggung_jawab }}</p>
                                    </div>
                                    <div class="group">
                                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-1 group-hover:text-red-400 transition-colors">Unit / Fakultas</label>
                                        <p class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->fakultas_name }}</p>
                                        <p class="text-[10px] font-semibold text-gray-400 mt-0.5">{{ $peminjamanDetail->fakultas_name === 'DIREKTORAT KHUSUS' ? 'Direktorat' : 'Prodi' }}: {{ $peminjamanDetail->prodi_name }}</p>
                                    </div>
                                    <div class="group">
                                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-1 group-hover:text-red-400 transition-colors">Jenis Keperluan</label>
                                        <div class="inline-flex items-center px-2.5 py-1 bg-gray-50 border border-gray-100 rounded-lg mt-1">
                                            <span class="text-[10px] font-black text-gray-700 uppercase tracking-wider">{{ $peminjamanDetail->jenis_peminjaman }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Waktu Section --}}
                            <div class="flex flex-col gap-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-6 bg-emerald-500 rounded-full"></div>
                                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em]">Jadwal & Waktu</h3>
                                </div>
                                <div class="flex flex-col gap-4 ml-4">
                                    <div class="flex items-center gap-4 p-4 bg-emerald-50/30 border border-emerald-100/50 rounded-[8px] group hover:bg-emerald-50 transition-all">
                                        <div class="p-3 bg-white rounded-xl shadow-sm text-emerald-500">
                                            <iconify-icon icon="solar:calendar-bold-duotone" class="text-2xl"></iconify-icon>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Tanggal</span>
                                            <span class="text-sm font-black text-gray-800">{{ $peminjamanDetail->hari }}, {{ \Carbon\Carbon::parse($peminjamanDetail->tanggal_peminjaman)->translatedFormat('d F Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4 p-4 bg-emerald-50/30 border border-emerald-100/50 rounded-[8px] group hover:bg-emerald-50 transition-all">
                                        <div class="p-3 bg-white rounded-xl shadow-sm text-emerald-500">
                                            <iconify-icon icon="solar:clock-circle-bold-duotone" class="text-2xl"></iconify-icon>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Sesi Waktu</span>
                                            <span class="text-sm font-black text-gray-800 tracking-tight">{{ $peminjamanDetail->jam_mulai }} – {{ $peminjamanDetail->jam_selesai }}</span>
                                            <span class="text-[9px] font-bold text-emerald-500 mt-0.5">{{ $peminjamanDetail->total_menit }} Menit Durasi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right Column --}}
                        <div class="space-y-10">
                            {{-- Lokasi Section --}}
                            <div class="flex flex-col gap-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-6 bg-amber-500 rounded-full"></div>
                                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em]">Lokasi & Ruangan</h3>
                                </div>
                                <div class="flex flex-col gap-4 ml-4">
                                    <div class="flex items-center gap-4 p-4 bg-amber-50/30 border border-amber-100/50 rounded-[8px] group hover:bg-amber-50 transition-all">
                                        <div class="p-3 bg-white rounded-xl shadow-sm text-amber-500">
                                            <iconify-icon icon="solar:buildings-bold-duotone" class="text-2xl"></iconify-icon>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-amber-400 uppercase tracking-widest">Gedung / Lantai</span>
                                            <span class="text-sm font-black text-gray-800">{{ $peminjamanDetail->nama_gedung }} / Lt. {{ $peminjamanDetail->lantai }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4 p-4 bg-amber-50/30 border border-amber-100/50 rounded-[8px] group hover:bg-amber-50 transition-all">
                                        <div class="p-3 bg-white rounded-xl shadow-sm text-amber-500">
                                            <iconify-icon icon="mdi:office-building-marker" class="text-2xl"></iconify-icon>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-amber-400 uppercase tracking-widest">Kode Ruangan</span>
                                            <span class="text-sm font-black text-gray-800 tracking-wider">{{ $peminjamanDetail->kode_ruangan }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4 p-4 bg-amber-50/30 border border-amber-100/50 rounded-[8px] group hover:bg-amber-50 transition-all">
                                        <div class="p-3 bg-white rounded-xl shadow-sm text-amber-500">
                                            <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="text-2xl"></iconify-icon>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-amber-400 uppercase tracking-widest">Estimasi Muatan</span>
                                            <span class="text-sm font-black text-gray-800">{{ $peminjamanDetail->muatan ?? $peminjamanDetail->ruangan?->kapasitas }} Orang</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Fasilitas Section --}}
                            @if ($peminjamanDetail->ruangan && $peminjamanDetail->ruangan->fasilitas)
                                <div class="flex flex-col gap-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-6 bg-blue-500 rounded-full"></div>
                                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em]">Fasilitas Ruangan</h3>
                                    </div>
                                    <div class="flex flex-wrap gap-2 ml-4">
                                        @foreach (explode(',', $peminjamanDetail->ruangan->fasilitas) as $item)
                                            <span class="px-3 py-1.5 bg-blue-50 border border-blue-100 rounded-[8px] text-[9px] font-black text-blue-600 uppercase tracking-widest shadow-sm hover:scale-105 transition-transform cursor-default">{{ trim($item) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Keperluan Section --}}
                    <div class="flex flex-col gap-4 mt-4">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-6 bg-gray-900 rounded-full"></div>
                            <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em]">Catatan / Keperluan</h3>
                        </div>
                        <div class="p-6 bg-gray-50 rounded-[8px] border border-gray-100 ml-4 relative overflow-hidden group">
                            <iconify-icon icon="solar:chat-line-bold-duotone" class="absolute -bottom-4 -right-4 text-7xl text-gray-200/50 group-hover:scale-110 transition-transform duration-700"></iconify-icon>
                            <p class="text-sm font-medium text-gray-600 italic leading-relaxed relative z-10">
                                "{{ $peminjamanDetail->keterangan_peminjaman }}"
                            </p>
                        </div>
                    </div>

                    @if ($peminjamanDetail->status === 'Reject' && $peminjamanDetail->alasan_penolakan)
                        <div class="flex flex-col gap-4 mt-2">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-6 bg-red-500 rounded-full"></div>
                                <h3 class="text-xs font-black text-red-500 uppercase tracking-[0.2em]">Catatan Penolakan</h3>
                            </div>
                            <div class="p-6 bg-red-50/50 rounded-[8px] border border-red-100 ml-4 relative overflow-hidden group">
                                <iconify-icon icon="solar:shield-warning-bold-duotone" class="absolute -bottom-4 -right-4 text-7xl text-red-500/10 group-hover:scale-110 transition-transform duration-700"></iconify-icon>
                                <p class="text-sm font-bold text-red-500 italic leading-relaxed relative z-10">
                                    "{{ $peminjamanDetail->alasan_penolakan }}"
                                </p>
                            </div>
                        </div>
                    @elseif ($peminjamanDetail->status === 'Canceled')
                        <div class="flex flex-col gap-4 mt-2">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-6 bg-red-500 rounded-full"></div>
                                <h3 class="text-xs font-black text-gray-600 uppercase tracking-[0.2em]">Catatan Pembatalan</h3>
                            </div>
                            <div class="p-6 bg-red-50/30 rounded-[8px] border border-red-100/50 ml-4 relative overflow-hidden group space-y-3">
                                <iconify-icon icon="solar:forbidden-circle-bold-duotone" class="absolute -bottom-4 -right-4 text-7xl text-red-500/5 group-hover:scale-110 transition-transform duration-700"></iconify-icon>
                                <div class="flex flex-col relative z-10">
                                    <span class="text-[9px] font-black text-red-400 uppercase tracking-widest block mb-0.5">Dibatalkan Oleh</span>
                                    <span class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->cancel_by ?? '-' }}</span>
                                </div>
                                <div class="flex flex-col relative z-10">
                                    <span class="text-[9px] font-black text-red-400 uppercase tracking-widest block mb-0.5">Alasan Pembatalan</span>
                                    <p class="text-sm font-medium text-gray-600 italic leading-relaxed">
                                        "{{ $peminjamanDetail->alasan_pembatalan ?? '-' }}"
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="p-8 bg-gray-50/80 border-t border-gray-100 flex items-center justify-between gap-4 backdrop-blur-md">
                    <button type="button" wire:click="closeDetail"
                        class="px-8 py-4 bg-white border border-gray-200 text-gray-500 rounded-[8px] font-black text-[10px] uppercase tracking-[0.2em] hover:bg-gray-100 transition-all shadow-sm">
                        Tutup Panel
                    </button>

                    <div class="flex items-center gap-3">
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
                                        cancelButtonText: 'Kembali',
                                        buttonsStyling: false,
                                        reverseButtons: true,
                                        customClass: {
                                            confirmButton: 'inline-flex items-center px-8 py-4 bg-red-600 text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-[8px] shadow-[0_8px_20px_rgba(220,38,38,0.2)] hover:bg-red-700 transition-all ml-3',
                                            cancelButton: 'inline-flex items-center px-8 py-4 bg-gray-100 text-gray-500 font-black text-[10px] uppercase tracking-[0.2em] rounded-[8px] hover:bg-gray-200 transition-all'
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $wire.cancelReservation()
                                        }
                                    });
                                "
                                class="px-8 py-4 bg-red-50 border border-red-100 text-red-500 rounded-[8px] font-black text-[10px] uppercase tracking-[0.2em] hover:bg-red-600 hover:text-white transition-all duration-500 shadow-sm flex items-center gap-2 group">
                                <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="text-lg group-hover:animate-bounce"></iconify-icon>
                                Batalkan Reservasi
                            </button>
                        @endif

                        @if ($peminjamanDetail->status === 'Waiting')
                            <div class="flex items-center gap-2 px-6 py-4 bg-amber-50 border border-amber-100 rounded-[8px] shadow-sm">
                                <iconify-icon icon="solar:info-circle-bold-duotone" class="text-amber-500 text-lg"></iconify-icon>
                                <span class="text-[9px] font-black text-amber-600 uppercase tracking-widest">Pending Review</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>

<style>
    @keyframes slide-up {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-up { animation: slide-up 0.5s cubic-bezier(0.16, 1, 0.3, 1); }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #e5141120;
    }
</style>

<script data-navigate-once>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('swal:success', (e) => {
            Swal.fire({
                title: 'Berhasil!',
                text: e.text || 'Aksi berhasil dilakukan.',
                icon: 'success',
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'inline-flex items-center px-8 py-4 bg-gray-900 text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-[8px] shadow-lg hover:bg-black transition-all'
                }
            });
        });
    });
</script>
