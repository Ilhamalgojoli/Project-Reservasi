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
                    <th class="px-6 py-5 text-center">Ruangan & Lokasi</th>
                    <th class="px-6 py-5 text-center">Penanggung Jawab</th>
                    <th class="px-6 py-5 text-center">Jadwal Sesi</th>
                    <th class="px-6 py-5 text-center">Status</th>
                    <th class="px-6 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($datas as $data)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-5 text-center font-bold text-gray-400">
                            {{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col gap-0.5 w-max mx-auto">
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
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-full font-bold text-[10px] uppercase tracking-widest border border-emerald-100">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                Approve
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Detail Button --}}
                                <button type="button"
                                    wire:click="$dispatch('showApprovalDetail', { id: {{ $data->id }} })"
                                    class="p-2.5 bg-gray-50 text-gray-400 border border-gray-100 rounded-xl hover:bg-red-50 hover:text-red-500 hover:border-red-100 transition-all duration-300 group shadow-sm flex items-center justify-center"
                                    title="Lihat Detail">
                                    <iconify-icon icon="solar:eye-bold-duotone"
                                        class="text-xl group-hover:scale-110 transition-transform"></iconify-icon>
                                </button>

                                {{-- Cancel Button --}}
                                <button type="button"
                                    wire:click="confirmCancel({{ $data->id }})"
                                    class="p-2.5 bg-red-50 text-red-600 border border-red-100 rounded-xl hover:bg-red-600 hover:text-white hover:border-red-600 transition-all duration-300 group shadow-sm flex items-center justify-center"
                                    title="Batalkan Reservasi">
                                    <iconify-icon icon="solar:trash-bin-trash-bold-duotone"
                                        class="text-xl group-hover:scale-110 transition-transform"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center opacity-20 grayscale">
                                <iconify-icon icon="solar:box-minimalistic-linear" class="text-7xl"></iconify-icon>
                                <p class="text-xs font-black uppercase mt-4 tracking-widest leading-none">Tidak ada peminjaman aktif</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-center items-center px-4 mt-6">
        <div class="text-black w-full">
            {{ $datas->links(data: ['scrollTo' => false]) }}
        </div>
    </div>

    @livewire('admin.popup-detail-approval')

    {{-- Modal Cancel --}}
    @if($showCancelModal)
        <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="closeCancelModal"></div>
            
            <div class="relative bg-white w-full max-w-md rounded-[32px] shadow-2xl overflow-hidden animate-in zoom-in duration-300">
                <div class="p-8">
                    <div class="flex flex-col items-center text-center mb-8">
                        <div class="w-20 h-20 bg-red-50 rounded-3xl flex items-center justify-center text-red-500 mb-6">
                            <iconify-icon icon="solar:danger-bold-duotone" class="text-5xl"></iconify-icon>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight mb-2">Batalkan Reservasi?</h3>
                        <p class="text-sm font-medium text-gray-400">Tindakan ini tidak dapat dibatalkan. Berikan alasan pembatalan di bawah ini.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Alasan Pembatalan</label>
                            <textarea wire:model="cancelReason" 
                                class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-700 focus:bg-white focus:ring-4 focus:ring-red-500/5 focus:border-red-500 transition-all outline-none min-h-[120px] resize-none"
                                placeholder="Tuliskan alasan pembatalan..."></textarea>
                            @error('cancelReason') <span class="text-[10px] font-bold text-red-500 ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-10">
                        <button wire:click="closeCancelModal"
                            class="px-6 py-4 bg-gray-50 text-gray-400 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-100 transition-all">
                            Batal
                        </button>
                        <button wire:click="processCancel"
                            class="px-6 py-4 bg-red-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-700 shadow-lg shadow-red-500/30 transition-all">
                            Ya, Batalkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script data-navigate-once>
    document.addEventListener('livewire:init', () => {
        Livewire.on('success', (event) => {
            Swal.fire({
                title: 'Berhasil!',
                text: event.message,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });

        Livewire.on('error', (event) => {
            Swal.fire({
                title: 'Gagal!',
                text: event.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
</script>
