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

            {{-- Filters & Reset Group --}}
            <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4 sm:w-full">
                {{-- Dropdown Jenis --}}
                <select wire:model.live="filterJenis"
                    class="appearance-none w-full pl-4 flex-1 pr-9 py-2.5 text-xs font-black uppercase tracking-wider text-gray-600 bg-white border border-gray-200 rounded-lg outline-none cursor-pointer hover:border-gray-300 transition-colors shadow-sm">
                    <option value="">SEMUA JENIS</option>
                    @foreach ($jenis_peminjaman as $value => $label)
                        <option value="{{ $value }}">{{ strtoupper($label) }}</option>
                    @endforeach
                </select>

                {{-- Dropdown Hari --}}
                <select wire:model.live="filterHari"
                    class="appearance-none w-full pl-4 pr-9 py-2.5 text-xs font-black uppercase tracking-wider text-gray-600 bg-white border border-gray-200 rounded-lg outline-none cursor-pointer hover:border-gray-300 transition-colors shadow-sm">
                    <option value="">SEMUA HARI</option>
                    @foreach ($hari_list as $h)
                        <option value="{{ $h }}">{{ strtoupper($h) }}</option>
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
                        <th class="px-4 py-2.5 text-center border-black w-1/4">Ruangan & Lokasi</th>
                        <th class="px-4 py-2.5 text-center border-black">Penanggung Jawab</th>
                        <th class="px-4 py-2.5 text-center border-black">Hari & Tanggal</th>
                        <th class="px-4 py-2.5 text-center border-black">Waktu</th>
                        <th class="px-4 py-2.5 text-center border-black w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-black">
                    @forelse ($peminjaman as $data)
                        <tr class="text-black hover:bg-gray-50/50 transition-colors border-black">
                            <td class="px-4 py-2.5 text-center border-black font-semibold text-gray-500">
                                {{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 py-2.5 border-black">
                                <div class="flex flex-col gap-0.5 w-max mx-auto">
                                    <div class="flex items-center gap-2">
                                        <iconify-icon icon="mdi:office-building-marker"
                                            class="text-red-500 text-lg"></iconify-icon>
                                        <span class="font-extrabold text-gray-900">{{ $data->kode_ruangan }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-400 font-semibold ml-1">
                                        <iconify-icon icon="clarity:building-line" class="text-lg"></iconify-icon>
                                        <span>{{ $data->nama_gedung ?? '-' }} / Lt. {{ $data->lantai ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2.5 text-center border-black">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="font-bold text-gray-700">{{ $data->penanggung_jawab }}</span>
                                    <span
                                        class="px-1.5 py-0.5 bg-gray-100 text-[9px] font-bold text-gray-400 rounded uppercase tracking-widest">{{ $data->prodi_name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-2.5 text-center border-black">
                                <div class="flex flex-col items-center gap-1">
                                    <div class="flex items-center gap-1.5 font-bold text-gray-800">
                                        <iconify-icon icon="solar:calendar-bold"
                                            class="text-[#e51411] text-md"></iconify-icon>
                                        <span>{{ $data->hari }},
                                            {{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->translatedFormat('d M Y') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2.5 text-center border-black">
                                <div
                                    class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[11px] font-black border border-blue-100">
                                    <iconify-icon icon="solar:clock-circle-bold" class="text-sm"></iconify-icon>
                                    {{ $data->jam_mulai }} – {{ $data->jam_selesai }}
                                </div>
                            </td>
                            <td class="px-4 py-2.5 text-center border-black">
                                <button type="button"
                                    wire:click="$dispatch('showApprovalDetail', { id: {{ $data->id }} })"
                                    class="p-2.5 bg-gray-50 text-gray-400 border border-gray-100 rounded-xl hover:bg-red-50 hover:text-red-500 hover:border-red-100 transition-all duration-300 group shadow-sm flex items-center justify-center mx-auto"
                                    title="Lihat Detail">
                                    <iconify-icon icon="solar:eye-bold-duotone"
                                        class="text-xl group-hover:scale-110 transition-transform"></iconify-icon>
                                </button>
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
    </div>

    {{-- Pagination Card --}}
    <div class="bg-white rounded-[8px] shadow-md border border-gray-100 px-5 py-3">
        <div class="text-black">
            {{ $peminjaman->links('vendor.pagination.tailwind', data: ['scrollTo' => false]) }}
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
