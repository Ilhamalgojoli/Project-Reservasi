<div class="flex flex-col gap-5">

    {{-- Tab Navigation --}}
    <div class="flex gap-6 mb-4 border-b border-gray-200">
        <button wire:click="setTab('matkul-wajib')" wire:navigate.scroll="false"
            class="pb-3 text-sm font-semibold transition-colors
            {{ $tab === 'matkul-wajib' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-400 hover:text-gray-700' }}">
            Matkul Wajib
        </button>
        <button wire:click="setTab('akademik')" wire:navigate.scroll="false"
            class="pb-3 text-sm font-semibold transition-colors
            {{ $tab === 'akademik' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-400 hover:text-gray-700' }}">
            Peminjaman Akademik
        </button>
        <button wire:click="setTab('non-akademik')" wire:navigate.scroll="false"
            class="pb-3 text-sm font-semibold transition-colors
            {{ $tab === 'non-akademik' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-400 hover:text-gray-700' }}">
            Peminjaman Non Akademik
        </button>
    </div>

    {{-- ====== TABEL MATKUL WAJIB ====== --}}
    @if ($tab === 'matkul-wajib')
        <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
            <div class="flex flex-wrap items-center gap-3">
                {{-- Filter Lantai --}}
                <div class="flex items-center gap-3 bg-white p-2 px-4 rounded-2xl shadow-sm border border-gray-100">
                    <div class="p-2 bg-red-50 rounded-lg text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Filter Lantai</span>
                        <select wire:model.live="selectedLantai" 
                            class="text-xs font-black text-gray-700 bg-transparent border-none p-0 focus:ring-0 cursor-pointer hover:text-red-600 transition-colors">
                            <option value="">SEMUA LANTAI</option>
                            @foreach($list_lantai as $l)
                                <option value="{{ $l->lantai }}">LANTAI {{ $l->lantai }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Filter Status --}}
                <div class="flex items-center gap-3 bg-white p-2 px-4 rounded-2xl shadow-sm border border-gray-100">
                    <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status Jadwal</span>
                        <select wire:model.live="selectedStatus" 
                            class="text-xs font-black text-gray-700 bg-transparent border-none p-0 focus:ring-0 cursor-pointer hover:text-blue-600 transition-colors">
                            <option value="">SEMUA STATUS</option>
                            <option value="Di Jadwalkan">DI JADWALKAN</option>
                            <option value="Sedang Berlangsung">SEDANG BERLANGSUNG</option>
                            <option value="Selesai">SELESAI</option>
                        </select>
                    </div>
                </div>
            </div>

            @if($selectedLantai || $selectedStatus)
                <button wire:click="$set('selectedLantai', ''); $set('selectedStatus', '');" 
                    class="text-[10px] font-black text-red-600 uppercase tracking-widest hover:text-red-700 transition-colors flex items-center gap-1 bg-red-50 px-3 py-1.5 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Reset Filter
                </button>
            @endif
        </div>

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
                <div class="flex justify-center items-center px-4 mt-6">
                    <div class="text-black w-full">
                        {{ $matkul_wajib->links(data: ['scrollTo' => false]) }}
                    </div>
                </div>
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
                <div class="flex justify-center items-center px-4 mt-6">
                    <div class="text-black w-full">
                        {{ $akademik->links(data: ['scrollTo' => false]) }}
                    </div>
                </div>
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
                <div class="flex justify-center items-center px-4 mt-6">
                    <div class="text-black w-full">
                        {{ $non_akademik->links(data: ['scrollTo' => false]) }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
