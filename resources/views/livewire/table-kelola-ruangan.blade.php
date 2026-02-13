<div class="tableKelola overflow-x-auto">
    <table class="table bordered-table text-sm sm-table mb-0 table-auto border-black p-1">
        <thead>
            <tr class="uppercase text-[12px]">
                <th>No</th>
                <th>Lantai</th>
                <th>Ruangan</th>
                <th>Fasilitas</th>
                <th>Status</th>
                <th>Kapasitas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($datas as $data)
                <tr class="text-black">
                    <td>
                        {{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}
                    </td>

                    <td>{{ $data->lantai->lantai ?? '-' }}</td>

                    <td>{{ $data->kode_ruangan }}</td>

                    <td>
                        @forelse ($data->asset as $asset)
                            {{ ucfirst($asset->nama_asset) }} : {{ $asset->jumlah_asset }} <br>
                        @empty
                            -
                        @endforelse
                    </td>
                    <td>
                        <div class="flex items-center justify-center">
                            @if ($data->status === "Aktif")
                                <span class="bg-success-100 text-success-600 px-6 py-1.5 rounded-full font-medium text-sm">
                                    {{ $data->status }}
                                </span>
                            @else
                                <span class="bg-danger-100 text-danger-600 px-6 py-1.5 rounded-full font-medium text-sm">
                                    {{ $data->status }}
                                </span>
                            @endif
                        </div>
                    </td>

                    <td>{{ $data->muatan_kapasitas }}</td>

                    <td>
                        <div class="flex items-center justify-center">
                            <button data-id="{{ $data->id }}" type="button"
                                class="edit-btn rounded-full bg-[#ff9d007e] px-4 py-3">
                                <iconify-icon icon="mingcute:edit-2-line" class="text-white"></iconify-icon>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-black">
                        Data tidak tersedia
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4 text-black">
        {{ $datas->links(data: ['scrollTo' => false]) }}
    </div>
</div>