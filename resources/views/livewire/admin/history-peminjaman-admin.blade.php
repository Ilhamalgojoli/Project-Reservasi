<div class="flex flex-col gap-6">
    {{-- Filter Card --}}
    <div class="bg-white rounded-[8px] shadow-md border border-gray-100 p-4">
        <div class="flex flex-row sm:flex-col items-center sm:items-stretch justify-between gap-3 w-full">

            {{-- Search Input --}}
            <div class="relative flex-grow max-w-md sm:max-w-none w-full">
                <iconify-icon icon="solar:magnifer-bold-duotone"
                    class="absolute left-3.5 top-1/2 -translate-y-1/2 text-base text-gray-400 pointer-events-none"></iconify-icon>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari penanggung jawab, gedung, atau ruangan..."
                    class="w-full pl-10 pr-4 py-2.5 text-sm text-gray-600 bg-gray-50 border border-gray-200 rounded-lg outline-none placeholder:text-gray-400 font-medium focus:border-gray-300 focus:bg-white transition-colors shadow-sm">
            </div>

            {{-- Filter & Reset --}}
            <div class="grid lg:grid-cols-3 sm:grid-cols-1 lg:gap-4 sm:gap-2 sm:w-full">
                {{-- Dropdown Jenis --}}
                <select wire:model.live="jenis_peminjaman"
                    class="appearance-none w-full pl-4 flex-1 pr-9 py-2.5 text-xs font-black uppercase tracking-wider text-gray-600 bg-white border border-gray-200 rounded-lg outline-none cursor-pointer hover:border-gray-300 transition-colors shadow-sm">
                    <option value="">JENIS PEMINJAMAN</option>
                    @foreach ($jenisPeminjaman as $jp => $l)
                        <option value="{{ $jp }}">{{ strtoupper($l) }}</option>
                    @endforeach
                </select>

                {{-- Dropdown Status --}}
                <select wire:model.live="filterStatus"
                    class="appearance-none w-full pl-4 pr-9 py-2.5 text-xs font-black uppercase tracking-wider text-gray-600 bg-white border border-gray-200 rounded-lg outline-none cursor-pointer hover:border-gray-300 transition-colors shadow-sm">
                    <option value="">STATUS PEMINJAMAN</option>
                    @foreach ($status as $s => $l)
                        <option value="{{ $s }}">{{ strtoupper($l) }}</option>
                    @endforeach
                </select>

                {{-- Reset Button --}}
                <button wire:click="resetFilter"
                    class="inline-flex items-center justify-center w-auto sm:w-12 px-5 py-2.5 rounded-lg text-[11px] font-black uppercase tracking-widest bg-[#e51411] text-white hover:bg-red-700 transition-colors shadow-sm sm:self-start">
                    RESET
                </button>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[8px] shadow-md border border-gray-100 overflow-hidden p-4">
        <div class="overflow-x-auto">
            <table class="text-sm table bordered-table sm-table mb-0 table-auto border-black p-1 w-full text-black">
                <thead class="bg-gray-50 uppercase text-[12px] font-bold text-gray-700">
                    <tr>
                        <th class="px-4 py-2.5 text-center border-black">No</th>
                        <th class="px-4 py-2.5 text-center border-black">Ruangan & Lokasi</th>
                        <th class="px-4 py-2.5 text-center border-black">Penanggung Jawab</th>
                        <th class="px-4 py-2.5 text-center border-black">Jadwal Peminjaman</th>
                        <th class="px-4 py-2.5 text-center border-black">Status</th>
                        <th class="px-4 py-2.5 text-center border-black">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-black">
                    @forelse ($peminjaman as $data)
                        <tr class="text-black hover:bg-gray-50/50 transition-colors border-black">
                            <td class="px-4 py-2.5 text-center border-black font-semibold text-gray-500">
                                {{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 py-2.5 border-black flex-1">
                                <div class="flex flex-col gap-0.5 items-center">
                                    <div class="flex flex-start gap-2">
                                        <span class="font-extrabold text-gray-900">{{ $data->kode_ruangan }}</span>
                                    </div>
                                    <div class="flex flex-start gap-2 text-xs text-gray-400 font-semibold ml-1">
                                        <span>{{ $data->nama_gedung ?? '-' }} / Lt. {{ $data->lantai ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2.5 text-center border-black">
                                <span class="font-bold text-gray-700">{{ $data->penanggung_jawab }}</span>
                            </td>
                            <td class="px-4 py-2.5 text-center border-black">
                                <div class="flex flex-col items-center gap-1">
                                    <div class="flex items-center gap-1.5 font-bold text-gray-800">
                                        <span>{{ $data->hari }},
                                            {{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->translatedFormat('d M Y') }}</span>
                                    </div>
                                    <span
                                        class="text-[11px] text-gray-400 font-semibold uppercase tracking-tight">{{ $data->jam_mulai }}
                                        – {{ $data->jam_selesai }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-2.5 text-center border-black">
                                @php
                                    $badgeColor = match ($data->status) {
                                        'Reject' => 'bg-red-50 text-red-600 border-red-100',
                                        'Canceled' => 'bg-gray-100 text-gray-500 border-gray-200',
                                        'Finish' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        default => 'bg-gray-100 text-gray-400 border-gray-200',
                                    };
                                    $statusIcon = match ($data->status) {
                                        'Reject' => 'mdi:close-circle',
                                        'Canceled' => 'mdi:cancel',
                                        'Finish' => 'mdi:check-all',
                                        default => 'mdi:help-circle',
                                    };
                                    $statusLabel = match ($data->status) {
                                        'Reject' => 'Ditolak',
                                        'Canceled' => 'Dibatalkan',
                                        'Finish' => 'Selesai',
                                        default => $data->status,
                                    };
                                 @endphp
                                <div class="flex items-center justify-center">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-extrabold border {{ $badgeColor }}">
                                        <iconify-icon icon="{{ $statusIcon }}" class="text-sm"></iconify-icon>
                                        {{ strtoupper($statusLabel) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-2.5 text-center border-black">
                                <button type="button" wire:click="$dispatch('showHistoryDetail', { id: {{ $data->id }} })"
                                    class="p-2.5 bg-gray-50 text-gray-400 border border-gray-100 rounded-xl hover:bg-red-50 hover:text-red-500 hover:border-red-100 transition-all duration-300 group shadow-sm flex items-center justify-center mx-auto"
                                    title="Lihat Detail">
                                    <iconify-icon icon="solar:eye-bold-duotone"
                                        class="text-xl group-hover:scale-110 transition-transform"></iconify-icon>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center opacity-20 grayscale">
                                    <iconify-icon icon="solar:box-minimalistic-linear" class="text-7xl"></iconify-icon>
                                    <p class="text-xs font-black uppercase mt-4 tracking-widest leading-none">Belum ada data
                                        peminjaman</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination Card --}}
    <div
        class="{{ !$peminjaman->hasPages() ? 'hidden' : 'block' }} bg-white rounded-[8px] shadow-md border border-gray-100 px-5 py-3">
        <div class="text-black">
            {{ $peminjaman->links('vendor.pagination.tailwind', data: ['scrollTo' => false]) }}
        </div>
    </div>

    @livewire('popup-detail')
</div>