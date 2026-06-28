<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col gap-5">
    <div class="flex items-center justify-between border-b border-gray-50 pb-4">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-red-50 rounded-lg">
                <iconify-icon icon="solar:calendar-date-bold-duotone" class="text-[#e51411] text-xl"></iconify-icon>
            </div>
            <div class="flex flex-col">
                <h2 class="text-xs font-black uppercase tracking-widest text-gray-800">Kalender Jadwal</h2>
                <p class="text-[12px] font-bold text-[#e51411] uppercase tracking-tighter mt-0.5">
                    {{ $kodeRuangan ?: 'Pilih Ruangan' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded-full bg-amber-400"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase">Menunggu Persetujuan</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded-full bg-[#e51411]"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase">Sudah Disetujui</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded-full bg-blue-500"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase">Jadwal Perkuliahan</span>
            </div>
        </div>
    </div>

    @if ($ruanganID)
        <div class="relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="overflow-x-auto custom-scrollbar">
                <div class="min-w-[450px]">
                    <div class="grid grid-cols-8 border-b border-gray-50 bg-gray-50/30">
                        <div class="p-2 border-r border-gray-50 flex items-center justify-center">
                            <iconify-icon icon="solar:clock-circle-bold" class="text-gray-300 text-xs"></iconify-icon>
                        </div>
                        @foreach ($dates as $date)
                            {{-- Bagian tanggal --}}
                            <div class="p-2 text-center border-r last:border-0 border-gray-50">
                                <p class="text-[8px] font-black text-gray-400 uppercase leading-none">
                                    {{ substr($date['day'], 0, 3) }}</p>
                                <p class="text-[10px] font-black text-gray-800 mt-0.5">
                                    {{ explode(' ', $date['date'])[0] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="max-h-[350px] overflow-y-auto relative custom-scrollbar">
                        @foreach ($timeSlots as $slot)
                            <div
                                class="grid grid-cols-8 border-b last:border-0 border-gray-50 group hover:bg-gray-50/50 transition-colors">
                                <div
                                    class="px-1 py-2 text-center bg-gray-50/10 border-r border-gray-50 flex items-center justify-center">
                                    <span
                                        class="text-[9px] font-black text-gray-400 tracking-tighter">{{ $slot }}
                                    </span>
                                </div>
                                @foreach ($dates as $date)
                                    @php
                                        $booking = $bookings[$date['full']][$slot] ?? null;
                                        $statusClass = '';
                                        $statusDisplay = '';
                                        if ($booking) {
                                            if ($booking['status'] === 'Approve') {
                                                $statusClass = 'bg-[#e51411]';
                                                $statusDisplay = 'Disetujui';
                                            } elseif ($booking['status'] === 'Waiting') {
                                                $statusClass = 'bg-amber-400';
                                                $statusDisplay = 'Menunggu Persetujuan';
                                            } elseif ($booking['status'] === 'MatkulWajib') {
                                                $statusClass = 'bg-blue-500';
                                                $statusDisplay = 'Jadwal Perkuliahan';
                                            }
                                        }
                                    @endphp
                                    <div class="p-0.5 border-r last:border-0 border-gray-50 min-h-[30px]">
                                        @if ($booking)
                                            <div class="w-full h-full rounded-md {{ $statusClass }} shadow-sm cursor-help relative group/box transition-transform hover:scale-105"
                                                title="{{ $booking['user'] }} ({{ $statusDisplay }})">
                                                <div
                                                    class="absolute inset-0 bg-white/10 opacity-0 group-hover/box:opacity-100 transition-opacity">
                                                </div>
                                            </div>
                                        @else
                                            <div
                                                class="w-full h-full rounded-md border border-emerald-100 bg-emerald-50/10 hover:bg-emerald-50/50 transition-all duration-300 flex items-center justify-center">
                                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-400"></div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="p-4 bg-emerald-50/30 border-t border-gray-500 text-center">
                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em]">
                    Keterangan: <span class="text-gray-400 ml-1 italic">(Hijau Titik = Tersedia)</span>
                </p>
            </div>
        </div>
    @else
        <div
            class="flex flex-col items-center justify-center py-16 bg-gray-50/50 rounded-2xl border-2 border-dashed border-gray-100 animate-pulse">
            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-4">
                <iconify-icon icon="solar:map-point-wave-bold-duotone" class="text-gray-300 text-2xl"></iconify-icon>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Silakan pilih ruangan
                untuk memuat kalender</p>
        </div>
    @endif

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 3px;
            height: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #f1f5f9;
            border-radius: 10px;
        }
    </style>
</div>
