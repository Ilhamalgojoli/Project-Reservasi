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
                    <th class="px-6 py-5 text-center text-left">Ruangan & Lokasi</th>
                    <th class="px-6 py-5 text-center">Penanggung Jawab</th>
                    <th class="px-6 py-5 text-center">Jadwal Sesi</th>
                    <th class="px-6 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($peminjaman as $data)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-5 text-center font-bold text-gray-400">
                            {{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col gap-0.5">
                                <div class="flex items-center gap-2">
                                    <iconify-icon icon="mdi:office-building-marker"
                                        class="text-red-500 text-lg"></iconify-icon>
                                    <span
                                        class="font-black text-gray-900 tracking-wide">{{ $data->kode_ruangan }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] text-gray-400 font-bold ml-1">
                                    <iconify-icon icon="clarity:building-line" class="text-md"></iconify-icon>
                                    <span>{{ $data->nama_gedung ?? '-' }} / Lt. {{ $data->lantai ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex flex-col items-center">
                                <span class="font-bold text-gray-800">{{ $data->penanggung_jawab }}</span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase">{{ $data->prodi }}</span>
                            </div>
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
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button"
                                    wire:click="$dispatch('showApprovalDetail', { id: {{ $data->id }} })"
                                    class="p-2.5 bg-gray-50 text-gray-400 border border-gray-100 rounded-xl hover:bg-red-50 hover:text-red-500 hover:border-red-100 transition-all duration-300 group shadow-sm flex items-center justify-center"
                                    title="Lihat Detail">
                                    <iconify-icon icon="solar:eye-bold-duotone"
                                        class="text-xl group-hover:scale-110 transition-transform"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
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

    <div class="flex justify-center items-center px-4 mt-6">
        <div class="text-black w-full">
            {{ $peminjaman->links(data: ['scrollTo' => false]) }}
        </div>
    </div>

    @livewire('admin.popup-detail-approval')
</div>

<script data-navigate-once>
    document.addEventListener('livewire:init', () => {
        Livewire.on('successApprove', (event) => {
            Swal.fire({
                title: 'Berhasil!',
                text: event.text,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });

        Livewire.on('successReject', (event) => {
            Swal.fire({
                title: 'Berhasil!',
                text: event.text,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });

        Livewire.on('errorApproval', (event) => {
            Swal.fire({
                title: 'Gagal!',
                text: event.text,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
</script>
