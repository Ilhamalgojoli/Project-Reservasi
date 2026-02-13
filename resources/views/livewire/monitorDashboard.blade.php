<div class="flex flex-col gap-5">
    <div class="flex gap-6 mb-4 border-b border-gray-300">
        <button wire:click="setTab('akademik')" wire:navigate.scroll="false" class="
                pb-2 text-sm font-semibold
            {{ $tab === 'akademik'
    ? 'text-red-600 border-b-2 border-red-600'
    : 'text-gray-500 hover:text-gray-700'
            }}
        ">
            Akademik
        </button>

        <button wire:click="setTab('non-akademik')" wire:navigate.scroll="false" class="
                pb-2 text-sm font-semibold
            {{ $tab === 'non-akademik'
    ? 'text-red-600 border-b-2 border-red-600'
    : 'text-gray-500 hover:text-gray-700'
            }}
        ">
            Non Akademik
        </button>
    </div>
    @if ($tab === 'akademik')
    <div class="tableAkademik overflow-x-auto">
        <table class="table bordered-table text-sm sm-table mb-0 table-auto border-black p-1">
            <thead>
                <tr class="uppercase text-[12px]">
                    <th>No</th>
                    <th>Gedung</th>
                    <th>Ruangan</th>
                    <th>Tanggal</th>
                    <th>Shift</th>
                    <th>Kode Matkul</th>
                    <th>Mata Kuliah</th>
                    <th>Kapasitas</th>
                    <th>Penanggung Jawab</th>
                    <th>Kapasitas</th>
                    <th>Kontak</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($akademik as $data)
                <tr class="text-black">
                    <td>{{ ($akademik->currentPage() - 1) * $akademik->perPage() + $loop->iteration }}</td>
                    <td>
                        {{ $data->peminjaman->ruangan->lantai->gedung->nama_gedung ?? '-' }}
                    </td>
                    <td>
                        {{ $data->peminjaman->ruangan->kode_ruangan ?? '-' }}
                    </td>
                    <td>
                        {{ $data->peminjaman->tanggal_peminjaman ?? '-' }}
                    </td>
                    <td>
                        {{ $data->waktu_mulai }} - {{ $data->waktu_selesai }}
                    </td>
                    <td>
                        {{ $data->peminjaman->kode_matkul ?? '-' }}
                    </td>
                    <td>
                        {{ $data->peminjaman->prodi ?? '-' }}
                    </td>
                    <td>
                        {{ $data->peminjaman->muatan ?? '-' }}
                    </td>
                    <td>
                        {{ $data->peminjaman->penanggung_jawab ?? '-' }}
                    </td>
                    <td>
                        {{ $data->peminjaman->muatan ?? '-' }}
                    </td>
                    <td>
                        {{ $data->peminjaman->kontak_penanggung_jawab ?? '-' }}
                    </td>
                    <td>
                        @if ($data->peminjaman->status === "Approve")
                            <div class="flex items-center justify-center">
                                <span
                                    class="bg-success-100  text-success-600  px-6 py-1.5 rounded-full font-medium text-sm">{{ $data->peminjaman->status }}</span>
                            </div>
                        @elseif ($data->peminjaman->status === "Reject")
                            <div class="flex items-center justify-center">
                                <span
                                    class="bg-danger-100  text-danger-600  px-6 py-1.5 rounded-full font-medium text-sm">{{ $data->peminjaman->status }}</span>
                            </div>
                        @else
                            <div class="flex items-center justify-center">
                                <span
                                    class="bg-warning-100  text-warning-600  px-6 py-1.5 rounded-full font-medium text-sm">{{ $data->peminjaman->status }}</span>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 text-black">
            {{ $akademik->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
    @endif
    @if ($tab === 'non-akademik')
        <div class="tableNonAkademik kaoverflow-x-auto">
            <table id="non-akademik" class="table bordered-table text-sm sm-table mb-0 table-auto border-black p-1">
                <thead>
                    <tr class="uppercase text-[12px]">
                        <th>No</th>
                        <th>Gedung</th>
                        <th>Ruangan</th>
                        <th>Tanggal</th>
                        <th>Shift</th>
                        <th>Penanggung Jawab</th>
                        <th>Kapasitas</th>
                        <th>Kontak</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($non_akademik as $data)
                        <tr class="text-black">
                            <td>{{ ($non_akademik->currentPage() - 1) * $non_akademik->perPage() + $loop->iteration }}</td>
                            <td>
                                {{ $data->peminjaman->ruangan->lantai->gedung->nama_gedung ?? '-' }}
                            </td>
                            <td>
                                {{ $data->peminjaman->ruangan->kode_ruangan ?? '-' }}
                            </td>
                            <td>
                                {{ $data->peminjaman->tanggal_peminjaman }}
                            </td>
                            <td>
                                {{ $data->waktu_mulai }} - {{ $data->waktu_selesai }}
                            </td>
                            <td>
                                {{ $data->peminjaman->penanggung_jawab }}
                            </td>
                            <td>
                                {{ $data->peminjaman->muatan }}
                            </td>
                            <td>
                                {{ $data->peminjaman->kontak_penanggung_jawab }}
                            </td>
                            <td>
                                @if ($data->peminjaman->status === "Approve")
                                    <div class="flex items-center justify-center">
                                        <span
                                            class="bg-success-100  text-success-600  px-6 py-1.5 rounded-full font-medium text-sm">{{ $data->peminjaman->status }}</span>
                                    </div>
                                @elseif ($data->peminjaman->status === "Reject")
                                    <div class="flex items-center justify-center">
                                        <span
                                            class="bg-danger-100  text-danger-600  px-6 py-1.5 rounded-full font-medium text-sm">{{ $data->peminjaman->status }}</span>
                                    </div>
                                @else
                                    <div class="flex items-center justify-center">
                                        <span
                                            class="bg-warning-100  text-warning-600  px-6 py-1.5 rounded-full font-medium text-sm">{{ $data->peminjaman->status }}</span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 text-black">
                {{ $non_akademik->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    @endif
</div>
