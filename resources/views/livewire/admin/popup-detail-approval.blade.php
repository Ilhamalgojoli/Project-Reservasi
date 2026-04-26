<div>
    <div wire:loading wire:target="approve, reject" class="fixed inset-0 z-[999999] bg-black/40">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
            <div class="flex flex-col items-center">
                <div class="relative w-12 h-12 mb-4">
                    <div class="absolute inset-0 border-4 border-white/20 rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-white rounded-full border-t-transparent animate-spin">
                    </div>
                </div>
                <p class="text-[10px] font-black text-white uppercase tracking-[0.4em] animate-pulse text-center">
                    Memproses...
                </p>
            </div>
        </div>
    </div>

    @if ($isOpen && $peminjamanDetail)
        <section
            class="popup fixed inset-0 bg-gray-900/40 backdrop-blur-sm flex items-center justify-center z-[1000] p-4 transition-all duration-500">
            <div
                class="bg-white w-full max-w-2xl rounded-[40px] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.2)] overflow-hidden relative animate-slide-up border border-white/20">

                <div
                    class="absolute -top-24 -right-24 w-64 h-64 bg-emerald-50 rounded-full blur-3xl opacity-60 pointer-events-none">
                </div>
                <div
                    class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-60 pointer-events-none">
                </div>

                <div
                    class="p-8 relative flex items-center justify-between bg-white/80 backdrop-blur-md border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-emerald-50 rounded-[20px] shadow-sm italic text-emerald-600">
                            <iconify-icon icon="solar:shield-check-bold-duotone" class="text-3xl"></iconify-icon>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black tracking-tight leading-none text-gray-900">Konfirmasi
                                Peminjaman</h2>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div class="flex flex-col gap-4">
                                <h3
                                    class="text-sm font-black text-gray-900 flex items-center gap-2 uppercase tracking-widest">
                                    <span class="w-2 h-2 bg-[#e51411] rounded-full"></span>
                                    Pemohon
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
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Unit /
                                            Fakultas</span>
                                        <span
                                            class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->fakultas }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Program Studi</span>
                                        <span
                                            class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->prodi }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="flex flex-col gap-4">
                                <h3
                                    class="text-sm font-black text-gray-900 flex items-center gap-2 uppercase tracking-widest">
                                    <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                                    Lokasi & Waktu
                                </h3>
                                <div class="space-y-4 ml-4">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="mdi:office-building-marker"
                                            class="text-2xl text-amber-500"></iconify-icon>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-black text-gray-900 tracking-wider">{{ $peminjamanDetail->kode_ruangan }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">Kode
                                                Ruangan</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="clarity:building-solid"
                                            class="text-2xl text-amber-500"></iconify-icon>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->nama_gedung }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">Lt.
                                                {{ $peminjamanDetail->lantai }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:users-group-rounded-bold-duotone"
                                            class="text-2xl text-amber-500"></iconify-icon>
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">Kapasitas
                                                Peserta</span>
                                            <span
                                                class="text-sm font-bold text-gray-800">{{ $peminjamanDetail->muatan ?? '-' }}
                                                Orang</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:calendar-date-bold-duotone"
                                            class="text-xl text-amber-500"></iconify-icon>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($peminjamanDetail->tanggal_peminjaman)->translatedFormat('d F Y') }}</span>
                                            <span
                                                class="text-[10px] font-bold text-gray-400 uppercase">{{ $peminjamanDetail->jam_mulai }}
                                                – {{ $peminjamanDetail->jam_selesai }} <span
                                                    class="text-gray-400 ml-1">({{ $peminjamanDetail->total_menit }}
                                                    Menit)</span></span>
                                        </div>
                                    </div>
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

                <div class="p-8 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between gap-4">
                    <button type="button" wire:click="closeDetail"
                        class="px-8 py-4 bg-white border border-gray-200 text-gray-500 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-gray-50 transition-all shadow-sm">
                        Batal
                    </button>

                    <div class="flex items-center gap-3">
                        <button type="button"
                            @click="
                                Swal.fire({
                                    title: 'Tolak Peminjaman?',
                                    text: 'Berikan alasan singkat penolakan reservasi ini:',
                                    icon: 'warning',
                                    input: 'text',
                                    inputPlaceholder: 'Contoh: Ruangan akan digunakan untuk pemeliharaan...',
                                    showCancelButton: true,
                                    confirmButtonText: 'Tolak Sekarang',
                                    cancelButtonText: 'Batal',
                                    buttonsStyling: false,
                                    reverseButtons: true,
                                    customClass: {
                                        confirmButton: 'inline-flex items-center px-8 py-4 bg-red-500 text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl shadow-sm hover:bg-red-600 transition-all ml-3',
                                        cancelButton: 'inline-flex items-center px-8 py-4 bg-gray-100 text-gray-500 font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl hover:bg-gray-200 transition-all'
                                    },
                                    preConfirm: (alasan) => {
                                        if (!alasan) Swal.showValidationMessage('Alasan wajib diisi');
                                        return alasan;
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $wire.reject(result.value)
                                    }
                                });
                            "
                            class="px-8 py-4 bg-white border border-red-100 text-red-500 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-red-50 hover:text-red-600 transition-all duration-300 shadow-sm flex items-center gap-2 group">
                            <iconify-icon icon="solar:close-circle-bold-duotone"
                                class="text-lg group-hover:rotate-90 transition-transform duration-300"></iconify-icon>
                            Tolak
                        </button>

                        <button type="button"
                            @click="
                                Swal.fire({
                                    title: 'Setujui Peminjaman?',
                                    text: 'Reservasi ini akan segera dijadwalkan secara resmi.',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'Ya, Setujui',
                                    cancelButtonText: 'Batal',
                                    buttonsStyling: false,
                                    reverseButtons: true,
                                    customClass: {
                                        confirmButton: 'inline-flex items-center px-8 py-4 bg-emerald-500 text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl shadow-sm hover:bg-emerald-600 transition-all ml-3',
                                        cancelButton: 'inline-flex items-center px-8 py-4 bg-gray-100 text-gray-500 font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl hover:bg-gray-200 transition-all'
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $wire.approve()
                                    }
                                });
                            "
                            class="px-8 py-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-emerald-500 hover:text-white transition-all duration-300 shadow-sm flex items-center gap-2 group">
                            <iconify-icon icon="solar:check-circle-bold-duotone"
                                class="text-lg group-hover:scale-110 transition-transform"></iconify-icon>
                            Setujui
                        </button>
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>
