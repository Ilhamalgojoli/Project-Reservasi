<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col gap-5">
    <div class="flex items-center justify-between border-b border-gray-50 pb-4">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-red-50 rounded-lg">
                <iconify-icon icon="mdi:account-group-outline" class="text-[#e51411] text-xl"></iconify-icon>
            </div>
            <div>
                <h2 class="text-sm font-bold uppercase tracking-widest text-gray-800">Kapasitas Ruangan</h2>
                @if($buildingName)
                    <p class="text-[10px] font-bold text-gray-400 uppercase mt-0.5">{{ $buildingName }}</p>
                @endif
            </div>
        </div>
        @if (count($ruangan) > 0)
            <span class="px-2.5 py-1 bg-red-50 text-[#e51411] text-[10px] font-bold rounded-lg border border-red-100">{{ count($ruangan) }} Ruang</span>
        @endif
    </div>

    @if (count($ruangan) > 0)
        @php
            $groupedRuangan = collect($ruangan)->groupBy('lantai');
        @endphp
        <div class="overflow-y-auto max-h-[380px] pr-1 space-y-5 scrollbar-thin scrollbar-thumb-gray-200 scrollbar-track-transparent">
            @foreach ($groupedRuangan as $namaLantai => $rooms)
                <div class="space-y-2.5">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#e51411]">Lantai {{ $namaLantai }}</span>
                        <div class="h-[1px] flex-grow bg-gray-100"></div>
                    </div>

                    <div class="grid grid-cols-1 gap-2">
                        @foreach ($rooms as $room)
                            <div class="flex items-center justify-between p-3.5 bg-gray-50 rounded-xl border border-gray-100 hover:border-red-100 hover:bg-red-50/10 transition-all duration-300">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-wider">Ruang</span>
                                    <span class="text-sm font-black text-gray-800">{{ $room['kode_ruangan'] }}</span>
                                </div>
                                <div class="flex items-center gap-2 px-3 py-1.5 bg-white rounded-lg shadow-sm border border-gray-100">
                                    <iconify-icon icon="mdi:account-group-outline" class="text-gray-400 text-base"></iconify-icon>
                                    <span class="text-xs font-black text-gray-800">{{ $room['muatan_kapasitas'] }} Orang</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-12 text-center opacity-40 grayscale">
            <iconify-icon icon="solar:box-minimalistic-linear" class="text-6xl text-gray-400"></iconify-icon>
            <p class="text-xs font-bold uppercase mt-2">Tidak ada ruangan aktif</p>
        </div>
    @endif
</div>
