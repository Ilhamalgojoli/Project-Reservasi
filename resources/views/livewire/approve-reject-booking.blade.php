<div class="flex flex-col gap-6">
    {{-- Search & Controls --}}
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-96 group">
            <iconify-icon icon="solar:magnifer-bold-duotone"
                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-xl"></iconify-icon>
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Cari penanggung jawab atau gedung..."
                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all outline-none">
        </div>
    </div>

    {{-- Modern Table --}}
    <div class="overflow-x-auto rounded-2xl border border-gray-100 shadow-sm bg-white">
        <table class="text-sm table bordered-table sm-table mb-0 table-auto border-black p-1 w-full text-black">
            <thead class="bg-gray-50 uppercase text-[12px] font-bold text-gray-700">
                <tr class="uppercase text-[11px] font-black text-gray-500 tracking-widest whitespace-nowrap">
                    <th class="px-6 py-5 text-center">No</th>
                    <th class="px-6 py-5 text-center">Gedung / Lantai</th>
                    <th class="px-6 py-5 text-center">Ruangan</th>
                    <th class="px-6 py-5 text-center">Jenis</th>
                    <th class="px-6 py-5 text-center">Kap.</th>
                    <th class="px-6 py-5 text-center">Fakultas</th>
                    <th class="px-6 py-5 text-center">Prodi</th>
                    <th class="px-6 py-5 text-center">Penanggung Jawab</th>
                    <th class="px-6 py-5 text-center">Shift & Tanggal</th>
                    <th class="px-6 py-5 text-center">Total</th>
                    <th class="px-6 py-5 text-center">Alasan</th>
                    <th class="px-6 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($peminjaman as $data)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-5 text-center font-bold text-gray-400">
                            {{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <iconify-icon icon="clarity:building-solid"
                                    class="text-gray-300 text-lg"></iconify-icon>
                                <span class="font-bold text-gray-700">{{ $data->nama_gedung ?? '-' }} / Lt.
                                    {{ $data->lantai ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <iconify-icon icon="mdi:office-building-marker"
                                    class="text-red-500 text-lg"></iconify-icon>
                                <span class="font-black text-gray-900">{{ $data->kode_ruangan }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span
                                class="uppercase text-[10px] font-black px-2.5 py-1 bg-gray-100 text-gray-500 rounded-lg tracking-tighter">
                                {{ $data->jenis_peminjaman }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <iconify-icon icon="mdi:account-group" class="text-blue-500 text-lg"></iconify-icon>
                                <span class="font-bold text-gray-800">{{ $data->muatan }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <iconify-icon icon="mdi:university" class="text-indigo-500 text-lg"></iconify-icon>
                                <span class="font-bold text-gray-800">{{ $data->fakultas }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <iconify-icon icon="mdi:school" class="text-amber-500 text-lg"></iconify-icon>
                                <span class="font-bold text-gray-800">{{ $data->prodi }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="font-bold text-gray-800">{{ $data->penanggung_jawab }}</span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex flex-col items-center gap-1">
                                <div class="flex items-center gap-1.5 font-bold text-gray-700">
                                    <iconify-icon icon="solar:calendar-bold"
                                        class="text-[#e51411] text-md"></iconify-icon>
                                    <span>{{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->translatedFormat('d M Y') }}</span>
                                </div>
                                <span
                                    class="text-[11px] text-gray-400 font-bold uppercase tracking-tight">{{ $data->jam_mulai }}
                                    – {{ $data->jam_selesai }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center font-bold text-gray-500">
                            {{ $data->total_menit }}m
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="max-w-[150px] mx-auto">
                                <p class="text-[11px] text-gray-500 italic font-medium truncate"
                                    title="{{ $data->keterangan_peminjaman }}">
                                    "{{ $data->keterangan_peminjaman }}"
                                </p>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Approve Button --}}
                                <button wire:click="$dispatch('confirmApprove', { id: {{ $data->id }} })"
                                    class="group flex items-center justify-center w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-500 hover:text-white transition-all duration-300 shadow-sm hover:shadow-emerald-200"
                                    title="Setujui">
                                    <iconify-icon icon="solar:check-read-linear"
                                        class="text-xl group-hover:scale-110 transition-transform"></iconify-icon>
                                </button>

                                {{-- Reject Button --}}
                                <button wire:click="$dispatch('confirmDelete', { id: {{ $data->id }}})"
                                    class="group flex items-center justify-center w-10 h-10 bg-red-50 text-red-600 rounded-xl hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm hover:shadow-red-200"
                                    title="Tolak">
                                    <iconify-icon icon="solar:close-circle-linear"
                                        class="text-xl group-hover:scale-110 transition-transform"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center opacity-20 grayscale">
                                <iconify-icon icon="solar:box-minimalistic-linear" class="text-7xl"></iconify-icon>
                                <p class="text-xs font-black uppercase mt-4 tracking-widest leading-none">Tidak ada
                                    antrean peminjaman</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center items-center px-4 mt-6">
        <div class="text-black w-full">
            {{ $peminjaman->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        const swalConfig = {
            buttonsStyling: false,
            reverseButtons: true,
            customClass: {
                confirmButton: 'inline-flex items-center px-6 py-2.5 bg-[#e51411] text-white font-bold rounded-xl shadow-lg hover:bg-red-700 transition-all ml-3',
                cancelButton: 'inline-flex items-center px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all'
            }
        };

        Livewire.on('confirmApprove', (e) => {
            Swal.fire({
                ...swalConfig,
                title: 'Setujui Peminjaman?',
                text: 'Reservasi ini akan segera dijadwalkan secara resmi.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.dispatch('approve', {
                        id: e.id
                    });
                }
            });
        });

        Livewire.on('confirmDelete', (e) => {
            Swal.fire({
                ...swalConfig,
                title: 'Tolak Peminjaman',
                text: 'Berikan alasan singkat penolakan reservasi ini:',
                input: 'text',
                inputPlaceholder: 'Contoh: Ruangan akan digunakan untuk pemeliharaan...',
                showCancelButton: true,
                confirmButtonText: 'Kirim Penolakan',
                cancelButtonText: 'Batal',
                preConfirm: (alasan) => {
                    if (!alasan) Swal.showValidationMessage('Alasan wajib diisi');
                    return alasan;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.dispatch('reject', {
                        id: e.id,
                        alasan: result.value
                    });
                }
            });
        });

        Livewire.on('successApprove', (e) => {
            Swal.fire({
                title: 'Berhasil!',
                text: e.text ?? 'Peminjaman telah disetujui.',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: swalConfig.customClass.confirmButton
                }
            });
        });

        Livewire.on('successReject', (e) => {
            Swal.fire({
                title: 'Berhasil!',
                text: e.text ?? 'Peminjaman telah ditolak.',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: swalConfig.customClass.confirmButton
                }
            });
        });
    });
</script>