<div class="flex flex-col gap-6">
    {{-- Search Area --}}
    <div class="relative w-full max-w-md group">
        <iconify-icon icon="solar:magnifer-bold-duotone"
            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-xl"></iconify-icon>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kode ruangan atau status..."
            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-sm font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all outline-none shadow-sm">
    </div>

    {{-- Modern Table --}}
    <div class="overflow-hidden rounded-[24px] border border-gray-100 bg-white shadow-sm">
        <table class="text-sm table bordered-table sm-table mb-0 table-auto border-black p-1 w-full text-black">
            <thead class="bg-gray-50 uppercase text-[12px] font-bold text-gray-700"></thead>
            <tr
                class="bg-gray-50/80 border-b border-gray-100 uppercase text-[10px] font-black text-gray-500 tracking-[0.15em] text-center">
                <th class="px-6 py-5">No</th>
                <th class="px-6 py-5">Lantai</th>
                <th class="px-6 py-5">Ruangan</th>
                <th class="px-6 py-5">Deskripsi Fasilitas</th>
                <th class="px-6 py-5">Status</th>
                <th class="px-6 py-5">Kapasitas</th>
                <th class="px-6 py-5">Aksi</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($datas as $data)
                    <tr class="hover:bg-gray-50/50 transition-colors animate-in fade-in slide-in-from-bottom-2 duration-500 fill-mode-both"
                        style="animation-delay: {{ $loop->iteration * 50 }}ms">
                        <td class="px-6 py-5 text-center font-medium text-gray-400">
                            {{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-6 py-5 text-center">
                            <span
                                class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-[11px] font-medium uppercase tracking-tight">
                                Lantai {{ $data->lantai->lantai ?? '-' }}
                            </span>
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <iconify-icon icon="mdi:office-building-marker"
                                    class="text-[#e51411] text-lg"></iconify-icon>
                                <span
                                    class="font-black text-gray-900 tracking-tight text-base">{{ $data->kode_ruangan }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-5">
                            <div class="max-w-[240px] mx-auto flex flex-wrap justify-center gap-2">
                                @forelse ($data->asset as $asset)
                                    <div
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-100 rounded-lg shadow-[0_2px_4px_rgba(0,0,0,0.02)] text-xs font-medium text-gray-700 group hover:border-red-100 transition-colors">
                                        <iconify-icon icon="solar:box-minimalistic-bold-duotone"
                                            class="text-gray-400 group-hover:text-red-400 transition-colors text-sm"></iconify-icon>
                                        {{ ucfirst($asset->nama_asset) }} <span class="text-gray-300 mx-0.5">/</span>
                                        {{ $asset->jumlah_asset }}
                                    </div>
                                @empty
                                    <span class="text-gray-300 italic text-[11px] font-medium tracking-wide">Fasilitas
                                        belum diatur</span>
                                @endforelse
                            </div>
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center">
                                @if ($data->status === 'Aktif')
                                    <div class="flex flex-col items-center gap-1">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full font-black text-[10px] uppercase tracking-wider border border-emerald-100">
                                            <span
                                                class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.4)]"></span>
                                            {{ $data->status }}
                                        </span>
                                    </div>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-red-50 text-red-600 rounded-full font-black text-[10px] uppercase tracking-wider border border-red-100">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                        {{ $data->status }}
                                    </span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-1.5">
                                <iconify-icon icon="mdi:account-group" class="text-blue-500 text-lg"></iconify-icon>
                                <span class="font-black text-gray-800 text-base">{{ $data->muatan_kapasitas }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center">
                                <button data-id="{{ $data->id }}" type="button"
                                    class="edit-btn group flex items-center justify-center w-10 h-10 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-500 hover:text-white transition-all duration-300 shadow-sm hover:shadow-amber-200">
                                    <iconify-icon icon="solar:pen-new-square-bold-duotone"
                                        class="text-xl group-hover:scale-110 transition-transform"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-24 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="relative">
                                    <iconify-icon icon="solar:folder-error-bold-duotone"
                                        class="text-8xl text-gray-100"></iconify-icon>
                                    <iconify-icon icon="solar:magnifer-zoom-out-bold-duotone"
                                        class="absolute bottom-0 right-0 text-gray-300 text-4xl animate-bounce"></iconify-icon>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <p class="text-sm font-black uppercase text-gray-400 tracking-widest mt-4">Ruangan
                                        tidak ditemukan</p>
                                    <p class="text-xs font-bold text-gray-300 italic">Coba sesuaikan kata kunci atau
                                        filter lantai Anda</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Improved Pagination --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 px-2 mt-4">
        <div class="text-[10px] font-medium uppercase tracking-widest text-gray-400">
            Halaman {{ $datas->currentPage() }} dari {{ $datas->lastPage() }}
        </div>
        <div class="w-full md:w-auto text-black">
            {{ $datas->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>
