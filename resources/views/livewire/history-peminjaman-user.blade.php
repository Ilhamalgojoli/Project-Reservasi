<div class="overflow-x-auto rounded-xl">
    <table class="text-sm table bordered-table sm-table mb-0 table-auto border-black p-1 w-full text-black">
        <thead class="bg-gray-50 uppercase text-[12px] font-bold text-gray-700">
            <tr>
                <th class="px-4 py-4 text-center border-black">No</th>
                <th class="px-4 py-4 text-center border-black">Gedung / Lantai</th>
                <th class="px-4 py-4 text-center border-black">Ruangan</th>
                <th class="px-4 py-4 text-center border-black">Jenis</th>
                <th class="px-4 py-4 text-center border-black">Kap.</th>
                <th class="px-4 py-4 text-center border-black">Penanggung Jawab</th>
                <th class="px-4 py-4 text-center border-black">Shift & Tanggal</th>
                <th class="px-4 py-4 text-center border-black">Durasi</th>
                <th class="px-4 py-4 text-center border-black">Keperluan</th>
                <th class="px-4 py-4 text-center border-black">Status</th>
            </tr>
        </thead>
        <tbody class="border-black">
            @forelse ($peminjaman as $data)
                <tr class="text-black hover:bg-gray-50/50 transition-colors border-black">
                    <td class="px-4 py-4 text-center border-black font-semibold text-gray-500">
                        {{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-4 py-4 text-center border-black">
                        <div class="flex items-center justify-center gap-2">
                             <iconify-icon icon="clarity:building-solid" class="text-gray-400 text-lg"></iconify-icon>
                             <span class="font-bold text-gray-800">{{ $data->nama_gedung ?? '-' }} / Lt. {{ $data->lantai ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4 text-center border-black">
                        <div class="flex items-center justify-center gap-2">
                             <iconify-icon icon="mdi:office-building-marker" class="text-red-500 text-lg"></iconify-icon>
                             <span class="font-extrabold text-gray-900">{{ $data->kode_ruangan }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4 text-center border-black">
                        <span class="uppercase text-[11px] font-bold text-gray-400 tracking-widest">{{ $data->jenis_peminjaman }}</span>
                    </td>
                    <td class="px-4 py-4 text-center border-black">
                        <div class="flex items-center justify-center gap-1.5">
                             <iconify-icon icon="mdi:account-group" class="text-blue-500 text-lg"></iconify-icon>
                             <span class="font-bold text-gray-800">{{ $data->muatan }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4 text-center border-black">
                        <span class="font-bold text-gray-700">{{ $data->penanggung_jawab }}</span>
                    </td>
                    <td class="px-4 py-4 text-center border-black">
                        <div class="flex flex-col items-center gap-1">
                            <div class="flex items-center gap-1.5 font-bold text-gray-800">
                                <iconify-icon icon="solar:calendar-bold" class="text-[#e51411] text-md"></iconify-icon>
                                <span>{{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->translatedFormat('d M Y') }}</span>
                            </div>
                            <span class="text-xs text-gray-400 font-semibold">{{ $data->jam_mulai }} – {{ $data->jam_selesai }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4 text-center border-black font-medium text-gray-600">
                        {{ $data->total_menit }}m
                    </td>
                    <td class="px-4 py-4 text-center border-black">
                        <div class="max-w-[200px] mx-auto">
                            <p class="text-xs text-gray-500 italic font-medium truncate" title="{{ $data->keterangan_peminjaman }}">
                                "{{ $data->keterangan_peminjaman }}"
                            </p>
                            @if ($data->status === 'Reject' && $data->alasan_penolakan)
                                <p class="text-[10px] text-red-500 font-extrabold mt-1.5">
                                    Ket: {{ $data->alasan_penolakan }}
                                </p>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-4 text-center border-black">
                        @php
                            $badgeColor = match($data->status) {
                                'Approve' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'Reject' => 'bg-red-50 text-red-600 border-red-100',
                                'Waiting' => 'bg-amber-50 text-amber-600 border-amber-100',
                                'Canceled' => 'bg-gray-100 text-gray-500 border-gray-200',
                                default => 'bg-gray-100 text-gray-400 border-gray-200',
                            };
                            $statusIcon = match($data->status) {
                                'Approve' => 'mdi:check-circle',
                                'Reject' => 'mdi:close-circle',
                                'Waiting' => 'mdi:clock-outline',
                                'Canceled' => 'mdi:cancel',
                                default => 'mdi:help-circle',
                            };
                        @endphp
                        <div class="flex items-center justify-center">
                             <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-extrabold border {{ $badgeColor }}">
                                <iconify-icon icon="{{ $statusIcon }}" class="text-sm"></iconify-icon>
                                {{ strtoupper($data->status) }}
                            </span>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="px-4 py-16 text-center text-gray-300 italic text-sm border-black">
                        Belum ada data peminjaman
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-6 flex justify-center items-center px-4">
        <div class="w-full">
            {{ $peminjaman->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>
