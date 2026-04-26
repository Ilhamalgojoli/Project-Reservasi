<div class="flex flex-col gap-5">

    {{-- Tab Navigation --}}
    <div class="flex gap-6 mb-4 border-b border-gray-200">
        <button wire:click="setTab('akademik')" wire:navigate.scroll="false"
            class="pb-3 text-sm font-semibold transition-colors
            {{ $tab === 'akademik' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-400 hover:text-gray-700' }}">
            Akademik
        </button>
        <button wire:click="setTab('non-akademik')" wire:navigate.scroll="false"
            class="pb-3 text-sm font-semibold transition-colors
            {{ $tab === 'non-akademik' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-400 hover:text-gray-700' }}">
            Non Akademik
        </button>
    </div>

    {{-- ====== TABEL AKADEMIK ====== --}}
    @if ($tab === 'akademik')
        <div class="tableAkademik overflow-x-auto rounded-xl">
            <div class="inline-block min-w-full align-middle">
                <table class="text-sm table bordered-table sm-table mb-0 table-auto border-black p-1 w-full text-black">
                    <thead class="bg-gray-50 uppercase text-[11px] text-gray-500 tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">No</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Gedung</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Ruangan</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Fakultas</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Prodi</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Tanggal</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Shift</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Kode Matkul</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Mata Kuliah</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Kapasitas</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Penanggung Jawab</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Kontak</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($akademik as $data)
                            <tr class="text-gray-700 hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-400 text-xs">
                                    {{ ($akademik->currentPage() - 1) * $akademik->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 font-medium whitespace-nowrap">
                                    {{ $data->ruangan->lantai->gedung->nama_gedung ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->ruangan->kode_ruangan ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->fakultas_name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->prodi_name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-gray-500">
                                    {{ $data->tanggal_peminjaman ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->waktu_mulai }} - {{ $data->waktu_selesai }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->kode_matkul ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->prodi_name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $data->muatan ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->penanggung_jawab ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->kontak_penanggung_jawab ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($data->status_display === 'Di Jadwalkan')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600">
                                            {{ $data->status_display }}
                                        </span>
                                    @elseif ($data->status_display === 'Sedang Berlangsung')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600">
                                            {{ $data->status_display }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-600">
                                            {{ $data->status_display }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="px-4 py-10 text-center text-gray-400 text-sm">
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
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">No</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Gedung</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Ruangan</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Fakultas</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Prodi</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Tanggal</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Shift</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Penanggung Jawab</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Kapasitas</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Kontak</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($non_akademik as $data)
                            <tr class="text-gray-700 hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-400 text-xs">
                                    {{ ($non_akademik->currentPage() - 1) * $non_akademik->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 font-medium whitespace-nowrap">
                                    {{ $data->ruangan->lantai->gedung->nama_gedung ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->ruangan->kode_ruangan ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->fakultas_name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->prodi_name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-gray-500">
                                    {{ $data->tanggal_peminjaman }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->waktu_mulai }} - {{ $data->waktu_selesai }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->penanggung_jawab }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $data->muatan }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $data->kontak_penanggung_jawab }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($data->status_display === 'Di Jadwalkan')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600">
                                            {{ $data->status_display }}
                                        </span>
                                    @elseif ($data->status_display === 'Sedang Berlangsung')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600">
                                            {{ $data->status_display }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-600">
                                            {{ $data->status_display }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="px-4 py-10 text-center text-gray-400 text-sm">
                                    Tidak ada data peminjaman akademik
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
