<div class="flex flex-col gap-6">
    {{-- Style following History Peminjaman --}}
    <div class="bg-white p-5 rounded-xl shadow-sm mb-5 border border-gray-100 flex flex-col gap-5">
        {{-- Row 1: Pencarian (Full Width) --}}
        <div class="flex flex-col gap-1.5 w-full">
            <label class="text-xs font-bold text-gray-600 uppercase tracking-wider flex items-center gap-1">
                Pencarian Data
            </label>
            <div class="relative group">
                <iconify-icon icon="solar:magnifer-bold-duotone"
                    class="absolute left-3 top-1/2 -translate-y-1/2 text-lg text-gray-400 transition-colors group-focus-within:text-red-500"></iconify-icon>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari penanggung jawab, gedung, atau ruangan..."
                    class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full pl-10 pr-3 py-3 shadow-sm transition-colors hover:bg-gray-100 outline-none">
            </div>
        </div>

        {{-- Row 2: 3 Filters in a row --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            {{-- Fakultas --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider flex items-center gap-1">
                    Fakultas
                </label>
                <div class="relative group">
                    <iconify-icon icon="solar:buildings-bold-duotone" class="absolute left-3 top-1/2 -translate-y-1/2 text-lg text-gray-400 group-focus-within:text-red-500 transition-colors"></iconify-icon>
                    <select wire:model.live="filterFakultas"
                        class="bg-gray-50 border border-gray-200 text-gray-700 text-sm font-bold rounded-lg focus:ring-red-500 focus:border-red-500 block w-full pl-10 pr-10 py-2.5 shadow-sm transition-colors cursor-pointer hover:bg-gray-100 appearance-none outline-none">
                        <option value="">Semua Fakultas</option>
                        @foreach ($fakultas as $f)
                            <option value="{{ $f->id }}">{{ $f->fakultas }}</option>
                        @endforeach
                    </select>
                    <iconify-icon icon="mdi:chevron-down" class="absolute right-3 top-1/2 -translate-y-1/2 text-xl text-gray-400 pointer-events-none"></iconify-icon>
                </div>
            </div>

            {{-- Jenis --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider flex items-center gap-1">
                    Jenis Peminjaman
                </label>
                <div class="relative group">
                    <iconify-icon icon="solar:document-bold-duotone" class="absolute left-3 top-1/2 -translate-y-1/2 text-lg text-gray-400 group-focus-within:text-red-500 transition-colors"></iconify-icon>
                    <select wire:model.live="filterJenis"
                        class="bg-gray-50 border border-gray-200 text-gray-700 text-sm font-bold rounded-lg focus:ring-red-500 focus:border-red-500 block w-full pl-10 pr-10 py-2.5 shadow-sm transition-colors cursor-pointer hover:bg-gray-100 appearance-none outline-none">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenis_peminjaman as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <iconify-icon icon="mdi:chevron-down" class="absolute right-3 top-1/2 -translate-y-1/2 text-xl text-gray-400 pointer-events-none"></iconify-icon>
                </div>
            </div>

            {{-- Hari --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider flex items-center gap-1">
                    Hari
                </label>
                <div class="relative group">
                    <iconify-icon icon="solar:calendar-bold-duotone" class="absolute left-3 top-1/2 -translate-y-1/2 text-lg text-gray-400 group-focus-within:text-red-500 transition-colors"></iconify-icon>
                    <select wire:model.live="filterHari"
                        class="bg-gray-50 border border-gray-200 text-gray-700 text-sm font-bold rounded-lg focus:ring-red-500 focus:border-red-500 block w-full pl-10 pr-10 py-2.5 shadow-sm transition-colors cursor-pointer hover:bg-gray-100 appearance-none outline-none">
                        <option value="">Semua Hari</option>
                        @foreach ($hari_list as $h)
                            <option value="{{ $h }}">{{ $h }}</option>
                        @endforeach
                    </select>
                    <iconify-icon icon="mdi:chevron-down" class="absolute right-3 top-1/2 -translate-y-1/2 text-xl text-gray-400 pointer-events-none"></iconify-icon>
                </div>
            </div>
        </div>
    </div>

    {{-- Table style matched to History Peminjaman --}}
    <div class="overflow-x-auto rounded-xl">
        <table class="text-sm table bordered-table sm-table mb-0 table-auto border-black p-1 w-full text-black">
            <thead class="bg-gray-50 uppercase text-[12px] font-bold text-gray-700">
                <tr>
                    <th class="px-4 py-4 text-center border-black">No</th>
                    <th class="px-4 py-4 text-center border-black w-1/4">Ruangan & Lokasi</th>
                    <th class="px-4 py-4 text-center border-black">Penanggung Jawab</th>
                    <th class="px-4 py-4 text-center border-black">Hari & Tanggal</th>
                    <th class="px-4 py-4 text-center border-black">Waktu</th>
                    <th class="px-4 py-4 text-center border-black w-24">Aksi</th>
                </tr>
            </thead>
            <tbody class="border-black">
                @forelse ($peminjaman as $data)
                    <tr class="text-black hover:bg-gray-50/50 transition-colors border-black">
                        <td class="px-4 py-4 text-center border-black font-semibold text-gray-500">
                            {{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-4 border-black">
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
                        <td class="px-4 py-4 text-center border-black">
                            <div class="flex flex-col items-center gap-1">
                                <span class="font-bold text-gray-700">{{ $data->penanggung_jawab }}</span>
                                <span
                                    class="px-1.5 py-0.5 bg-gray-100 text-[9px] font-bold text-gray-400 rounded uppercase tracking-widest">{{ $data->prodi_name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-center border-black">
                            <div class="flex flex-col items-center gap-1">
                                <div class="flex items-center gap-1.5 font-bold text-gray-800">
                                    <iconify-icon icon="solar:calendar-bold"
                                        class="text-[#e51411] text-md"></iconify-icon>
                                    <span>{{ $data->hari }},
                                        {{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-center border-black">
                            <div
                                class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[11px] font-black border border-blue-100">
                                <iconify-icon icon="solar:clock-circle-bold" class="text-sm"></iconify-icon>
                                {{ $data->jam_mulai }} – {{ $data->jam_selesai }}
                            </div>
                        </td>
                        <td class="px-4 py-4 text-center border-black">
                            <button type="button"
                                wire:click="$dispatch('showApprovalDetail', { id: {{ $data->id }} })"
                                class="p-2.5 bg-gray-50 text-gray-400 border border-gray-100 rounded-xl hover:bg-red-50 hover:text-red-500 hover:border-red-100 transition-all duration-300 group shadow-sm flex items-center justify-center mx-auto"
                                title="Lihat Detail">
                                <iconify-icon icon="solar:eye-bold-duotone"
                                    class="text-xl group-hover:scale-110 transition-transform"></iconify-icon>
                            </button>
                        </td>
                    </tr>r>
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
