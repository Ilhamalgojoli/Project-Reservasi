<div class="flex flex-col gap-5">
    {{-- Tab Navigation --}}
    <div class="flex gap-6 mb-4 border-b border-gray-200 overflow-x-auto whitespace-nowrap pb-1 hide-scrollbar">
        <button wire:click="setTab('matkul-wajib')" wire:navigate.scroll="false"
            class="pb-2 text-sm font-semibold transition-colors
            {{ $tab === 'matkul-wajib' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-400 hover:text-gray-700' }}">
            Jadwal Matakuliah umum
        </button>
        <button wire:click="setTab('akademik')" wire:navigate.scroll="false"
            class="pb-2 text-sm font-semibold transition-colors
            {{ $tab === 'akademik' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-400 hover:text-gray-700' }}">
            Peminjaman Akademik
        </button>
        <button wire:click="setTab('non-akademik')" wire:navigate.scroll="false"
            class="pb-2 text-sm font-semibold transition-colors
            {{ $tab === 'non-akademik' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-400 hover:text-gray-700' }}">
            Peminjaman Non Akademik
        </button>
    </div>

    {{-- Filter Section (Global for all tabs) --}}
    <div class="flex flex-col gap-4 mb-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            {{-- Filter Lantai --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider flex items-center gap-1">
                    Filter Lantai
                </label>
                <div class="relative group">
                    <iconify-icon icon="solar:buildings-bold-duotone" class="absolute left-3 top-1/2 -translate-y-1/2 text-lg text-gray-400 group-focus-within:text-red-500 transition-colors"></iconify-icon>
                    <select wire:model.live="selectedLantai"
                        class="bg-gray-50 border border-gray-200 text-gray-700 text-sm font-bold rounded-lg focus:ring-red-500 focus:border-red-500 block w-full pl-10 pr-10 py-2.5 shadow-sm transition-colors cursor-pointer hover:bg-gray-100 outline-none">
                        <option value="">Semua Lantai</option>
                        @foreach($list_lantai as $l)
                            <option value="{{ $l->lantai }}">Lantai {{ $l->lantai }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Filter Status --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider flex items-center gap-1">
                    Status Jadwal
                </label>
                <div class="relative group">
                    <iconify-icon icon="solar:clock-circle-bold-duotone" class="absolute left-3 top-1/2 -translate-y-1/2 text-lg text-gray-400 group-focus-within:text-red-500 transition-colors"></iconify-icon>
                    <select wire:model.live="selectedStatus"
                        class="bg-gray-50 border border-gray-200 text-gray-700 text-sm font-bold rounded-lg focus:ring-red-500 focus:border-red-500 block w-full pl-10 pr-10 py-2.5 shadow-sm transition-colors cursor-pointer hover:bg-gray-100 outline-none">
                        <option value="">Semua Status</option>
                        <option value="Di Jadwalkan">Di Jadwalkan</option>
                        <option value="Sedang Berlangsung">Sedang Berlangsung</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
            </div>
            
            {{-- Reset Button (if active) --}}
            @if($selectedLantai || $selectedStatus)
                <div class="flex items-end pb-1.5">
                    <button wire:click="$set('selectedLantai', ''); $set('selectedStatus', '');" 
                        class="text-xs font-bold text-red-600 hover:text-red-700 transition-colors flex items-center gap-1.5 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-lg border border-red-100">
                        <iconify-icon icon="solar:close-circle-bold-duotone" class="text-lg"></iconify-icon>
                        Reset Filter
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- ====== TABEL MATKUL WAJIB ====== --}}
    @if ($tab === 'matkul-wajib')
        <div class="tableMatkulWajib overflow-x-auto rounded-xl">
            <div class="inline-block min-w-full align-middle">
                <table class="text-sm table bordered-table sm-table mb-0 table-auto border-black p-1 w-full text-black">
                    <thead class="bg-gray-50 uppercase text-[11px] text-gray-500 tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">No</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Ruangan & Lokasi</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Hari & Waktu</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Mata Kuliah</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Dosen</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 border-black">
                        @forelse ($matkul_wajib as $data)
                            <tr class="text-gray-700 hover:bg-gray-50 transition-colors border-black">
                                <td class="px-4 py-3 text-center text-gray-400 text-xs border-black">
                                    {{ ($matkul_wajib->currentPage() - 1) * $matkul_wajib->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 border-black">
                                    <div class="flex flex-col items-center">
                                        <span class="font-bold text-gray-900">{{ $data->kode_ruangan ?? '-' }}</span>
                                        <span class="text-[10px] text-gray-400 font-semibold">{{ $data->nama_gedung ?? '-' }} / Lt. {{ $data->lantai_display ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 border-black">
                                    <div class="flex flex-col items-center">
                                        <span class="font-bold text-gray-800 text-xs uppercase">{{ $data->hari }}</span>
                                        <span class="text-[10px] text-gray-400 font-black uppercase">{{ $data->waktu_mulai }} - {{ $data->waktu_selesai }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 border-black text-center">
                                    <span class="font-bold text-gray-700 text-xs">{{ $data->nama_matkul ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 border-black text-center">
                                    <span class="font-bold text-gray-800 text-xs">{{ $data->dosen ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 text-center border-black">
                                    @php
                                        $statusClass = match($data->status_display) {
                                            'Di Jadwalkan' => 'bg-blue-50 text-blue-600',
                                            'Sedang Berlangsung' => 'bg-red-50 text-red-600',
                                            default => 'bg-amber-50 text-amber-600',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-tight {{ $statusClass }}">
                                        {{ $data->status_display }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-400 text-sm border-black">
                                    Tidak ada jadwal mata kuliah wajib untuk hari ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Pagination Card --}}
        <div class="bg-white rounded-[8px] shadow-md border border-gray-100 px-5 py-3 mt-6">
            <div class="text-black">
                {{ $matkul_wajib->links('vendor.pagination.tailwind', data: ['scrollTo' => false]) }}
            </div>
        </div>
    @endif

    {{-- ====== TABEL AKADEMIK ====== --}}
    @if ($tab === 'akademik')
        <div class="tableAkademik overflow-x-auto rounded-xl">
            <div class="inline-block min-w-full align-middle">
                <table class="text-sm table bordered-table sm-table mb-0 table-auto border-black p-1 w-full text-black">
                    <thead class="bg-gray-50 uppercase text-[11px] text-gray-500 tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">No</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Ruangan & Lokasi</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Unit / Program Studi</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Jadwal & Waktu</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Mata Kuliah</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Kps</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Penanggung Jawab</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 border-black">
                        @forelse ($akademik as $data)
                            <tr class="text-gray-700 hover:bg-gray-50 transition-colors border-black">
                                <td class="px-4 py-3 text-center text-gray-400 text-xs border-black">
                                    {{ ($akademik->currentPage() - 1) * $akademik->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 border-black">
                                    <div class="flex flex-col items-center">
                                        <span class="font-bold text-gray-900">{{ $data->kode_ruangan ?? '-' }}</span>
                                        <span class="text-[10px] text-gray-400 font-semibold">{{ $data->nama_gedung ?? '-' }} / Lt. {{ $data->lantai ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 border-black">
                                    <div class="flex flex-col items-center text-center">
                                        <span class="font-bold text-gray-700 text-xs">{{ $data->prodi_name ?? '-' }}</span>
                                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $data->fakultas_name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 border-black">
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center gap-1 font-bold text-gray-800 text-xs">
                                            <span>{{ $data->hari }}, {{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->translatedFormat('d M Y') }}</span>
                                        </div>
                                        <span class="text-[10px] text-gray-400 font-black uppercase">{{ $data->waktu_mulai }} - {{ $data->waktu_selesai }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 border-black">
                                    <div class="flex flex-col items-center text-center">
                                        <span class="font-bold text-gray-700 text-xs">{{ $data->nama_matkul ?? '-' }}</span>
                                        <span class="text-[10px] text-gray-400 font-black tracking-widest">{{ $data->kode_matkul ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-gray-600 border-black">
                                    {{ $data->muatan ?? '-' }}
                                </td>
                                <td class="px-4 py-3 border-black">
                                    <div class="flex flex-col items-center">
                                        <span class="font-bold text-gray-800 text-xs">{{ $data->penanggung_jawab ?? '-' }}</span>
                                        <span class="text-[10px] text-blue-500 font-black">{{ $data->kontak_penanggung_jawab ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center border-black">
                                    @php
                                        $statusClass = match($data->status_display) {
                                            'Di Jadwalkan' => 'bg-blue-50 text-blue-600',
                                            'Sedang Berlangsung' => 'bg-red-50 text-red-600',
                                            default => 'bg-amber-50 text-amber-600',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-tight {{ $statusClass }}">
                                        {{ $data->status_display }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-gray-400 text-sm border-black">
                                    Tidak ada data peminjaman akademik
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Pagination Card --}}
        <div class="bg-white rounded-[8px] shadow-md border border-gray-100 px-5 py-3 mt-6 {{ $akademik->hasPages() ? 'block' : 'hidden' }}">
            <div class="text-black">
                {{ $akademik->links('vendor.pagination.tailwind', data: ['scrollTo' => false]) }}
            </div>
        </div>
    @endif


    {{-- ====== TABEL NON AKADEMIK ====== --}}
    @if ($tab === 'non-akademik')
        <div class="tableNonAkademik overflow-x-auto rounded-xl">
            <div class="inline-block min-w-full align-middle">
                <table class="text-sm table bordered-table sm-table mb-0 table-auto border-black p-1 w-full text-black">
                    <thead class="bg-gray-50 uppercase text-[11px] text-gray-500 tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">No</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Ruangan & Lokasi</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Unit / Program Studi</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Jadwal & Waktu</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Kps</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Penanggung Jawab</th>
                            <th class="px-4 py-3 text-center font-semibold whitespace-nowrap border-black">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 border-black">
                        @forelse ($non_akademik as $data)
                            <tr class="text-gray-700 hover:bg-gray-50 transition-colors border-black">
                                <td class="px-4 py-3 text-center text-gray-400 text-xs border-black">
                                    {{ ($non_akademik->currentPage() - 1) * $non_akademik->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 border-black">
                                    <div class="flex flex-col items-center">
                                        <span class="font-bold text-gray-900">{{ $data->kode_ruangan ?? '-' }}</span>
                                        <span class="text-[10px] text-gray-400 font-semibold">{{ $data->nama_gedung ?? '-' }} / Lt. {{ $data->lantai ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 border-black">
                                    <div class="flex flex-col items-center text-center">
                                        <span class="font-bold text-gray-700 text-xs">{{ $data->prodi_name ?? '-' }}</span>
                                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $data->fakultas_name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 border-black">
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center gap-1 font-bold text-gray-800 text-xs">
                                            <span>{{ $data->hari }}, {{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->translatedFormat('d M Y') }}</span>
                                        </div>
                                        <span class="text-[10px] text-gray-400 font-black uppercase">{{ $data->waktu_mulai }} - {{ $data->waktu_selesai }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-gray-600 border-black">
                                    {{ $data->muatan ?? '-' }}
                                </td>
                                <td class="px-4 py-3 border-black">
                                    <div class="flex flex-col items-center">
                                        <span class="font-bold text-gray-800 text-xs">{{ $data->penanggung_jawab ?? '-' }}</span>
                                        <span class="text-[10px] text-blue-500 font-black">{{ $data->kontak_penanggung_jawab ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center border-black">
                                    @php
                                        $statusClass = match($data->status_display) {
                                            'Di Jadwalkan' => 'bg-blue-50 text-blue-600',
                                            'Sedang Berlangsung' => 'bg-red-50 text-red-600',
                                            default => 'bg-amber-50 text-amber-600',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-tight {{ $statusClass }}">
                                        {{ $data->status_display }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-gray-400 text-sm border-black">
                                    Tidak ada data peminjaman non-akademik
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Pagination Card --}}
        <div class="bg-white rounded-[8px] shadow-md border border-gray-100 px-5 py-3 mt-6">
            <div class="text-black">
                {{ $non_akademik->links('vendor.pagination.tailwind', data: ['scrollTo' => false]) }}
            </div>
        </div>
    @endif
</div>
