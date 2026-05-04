<div>
    <div class="bg-white p-4 rounded-xl shadow-sm mb-5 border border-gray-100 flex flex-col sm:flex-row gap-4 items-center justify-between">
        <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
            <div class="flex flex-col gap-1.5 w-full sm:w-64">
                <label for="fakultasFilter" class="text-xs font-bold text-gray-600 uppercase tracking-wider flex items-center gap-1">
                    <iconify-icon icon="solar:buildings-bold-duotone" class="text-lg text-gray-400"></iconify-icon>
                    Fakultas
                </label>
                <select wire:model.live="fakultas_id" id="fakultasFilter" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 shadow-sm transition-colors cursor-pointer hover:bg-gray-100">
                    <option value="">Semua Fakultas</option>
                    @foreach ($this->fakultasList as $fakultas)
                        <option value="{{ $fakultas->id }}">{{ $fakultas->fakultas }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex flex-col gap-1.5 w-full sm:w-56">
                <label for="jenisFilter" class="text-xs font-bold text-gray-600 uppercase tracking-wider flex items-center gap-1">
                    <iconify-icon icon="solar:document-bold-duotone" class="text-lg text-gray-400"></iconify-icon>
                    Jenis Peminjaman
                </label>
                <select wire:model.live="jenis_peminjaman" id="jenisFilter" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 shadow-sm transition-colors cursor-pointer hover:bg-gray-100">
                    <option value="">Semua Jenis</option>
                    <option value="akademik">Akademik</option>
                    <option value="non_akademik">Non Akademik</option>
                </select>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto rounded-xl">
        <table class="text-sm table bordered-table sm-table mb-0 table-auto border-black p-1 w-full text-black">
        <thead class="bg-gray-50 uppercase text-[12px] font-bold text-gray-700">
            <tr>
                <th class="px-4 py-4 text-center border-black">No</th>
                <th class="px-4 py-4 text-center border-black">Ruangan & Lokasi</th>
                <th class="px-4 py-4 text-center border-black">Penanggung Jawab</th>
                <th class="px-4 py-4 text-center border-black">Jadwal Peminjaman</th>
                <th class="px-4 py-4 text-center border-black">Status</th>
                <th class="px-4 py-4 text-center border-black">Aksi</th>
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
                                <iconify-icon icon="mdi:office-building-marker" class="text-red-500 text-lg"></iconify-icon>
                                <span class="font-extrabold text-gray-900">{{ $data->kode_ruangan }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-400 font-semibold ml-1">
                                <iconify-icon icon="clarity:building-line" class="text-lg"></iconify-icon>
                                <span>{{ $data->nama_gedung ?? '-' }} / Lt. {{ $data->lantai ?? '-' }}</span>
                            </div>
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
                            <span class="text-[11px] text-gray-400 font-semibold uppercase tracking-tight">{{ $data->jam_mulai }} – {{ $data->jam_selesai }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4 text-center border-black">
                        @php
                            $badgeColor = match($data->status) {
                                'Approve' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'Reject' => 'bg-red-50 text-red-600 border-red-100',
                                'Waiting' => 'bg-amber-50 text-amber-600 border-amber-100',
                                'Canceled' => 'bg-gray-100 text-gray-500 border-gray-200',
                                'Finish' => 'bg-blue-50 text-blue-600 border-blue-100',
                                default => 'bg-gray-100 text-gray-400 border-gray-200',
                            };
                            $statusIcon = match($data->status) {
                                'Approve' => 'mdi:check-circle',
                                'Reject' => 'mdi:close-circle',
                                'Waiting' => 'mdi:clock-outline',
                                'Canceled' => 'mdi:cancel',
                                'Finish' => 'mdi:check-all',
                                default => 'mdi:help-circle',
                            };
                        @endphp
                        <div class="flex items-center justify-center">
                             <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-extrabold border {{ $badgeColor }}">
                                <iconify-icon icon="{{ $statusIcon }}" class="text-sm"></iconify-icon>
                                {{ strtoupper($data->status) }}
                            </span>
                        </div>
                    </td>
                    <td class="px-4 py-4 text-center border-black">
                        <button type="button" 
                            wire:click="$dispatch('showHistoryDetail', { id: {{ $data->id }} })"
                            class="p-2.5 bg-gray-50 text-gray-400 border border-gray-100 rounded-xl hover:bg-red-50 hover:text-red-500 hover:border-red-100 transition-all duration-300 group shadow-sm flex items-center justify-center mx-auto"
                            title="Lihat Detail">
                            <iconify-icon icon="solar:eye-bold-duotone" class="text-xl group-hover:scale-110 transition-transform"></iconify-icon>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-16 text-center text-gray-300 italic text-sm border-black">
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
    
    @livewire('popup-detail')
</div>
