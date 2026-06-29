<div>
    <section
        class="popup fixed inset-0 bg-gray-900/80 flex items-center justify-center z-[1000] p-4 transition-all duration-500">
        <div
            class="bg-white w-full max-w-3xl rounded-[12px] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.2)] overflow-hidden relative animate-slide-up border border-white/20 flex flex-col max-h-[85vh]">

            {{-- Background blur dekoratif --}}
            <div
                class="absolute -top-24 -right-24 w-64 h-64 bg-rose-50 rounded-full blur-3xl opacity-60 pointer-events-none">
            </div>
            <div
                class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-60 pointer-events-none">
            </div>

            {{-- Bagian Header --}}
            <div
                class="p-6 sm:p-8 relative flex items-center justify-between bg-white/80 backdrop-blur-md border-b border-gray-100 shrink-0">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-rose-50 rounded-[8px] shadow-sm italic text-[#e51411]">
                        <iconify-icon icon="solar:history-bold-duotone" class="text-3xl"></iconify-icon>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black tracking-tight leading-tight text-gray-900">
                            Semua Kegiatan Terkini
                        </h2>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1.5">
                            Daftar Lengkap Aktivitas Peminjaman dan Pembatalan
                        </p>
                    </div>
                </div>
                <button type="button" wire:click="closePopUp"
                    class="w-12 h-12 shrink-0 flex items-center justify-center rounded-[8px] bg-gray-50 text-gray-400 border border-gray-100 hover:bg-red-50 hover:text-red-500 transition-all duration-300 group">
                    <iconify-icon icon="solar:close-circle-bold"
                        class="text-2xl group-hover:rotate-90 transition-transform duration-300"></iconify-icon>
                </button>
            </div>

            {{-- Bagian Konten / Timeline --}}
            <div class="p-6 sm:p-8 relative flex flex-col gap-6 flex-1 overflow-y-auto custom-scrollbar bg-gray-50/30">
                <div class="relative pl-6 border-l-2 border-gray-100 flex flex-col gap-6 ml-2">
                    @forelse ($data as $item)
                        @php
                            $isBatalRequest = isset($item['tautan']) && $item['tautan'];
                            $isDibatalkan = strpos($item['pesan'], 'telah dibatalkan') !== false;
                            
                            $badgeText = 'PEMINJAMAN BARU';
                            $badgeColor = 'bg-emerald-100 text-emerald-600';
                            $iconBgColor = 'bg-emerald-500 text-white';
                            $iconName = 'solar:calendar-add-bold';
                            $cardBgColor = 'border-gray-100 hover:bg-gray-50/10';
                            
                            if ($isBatalRequest) {
                                $badgeText = 'BATAL REQUEST';
                                $badgeColor = 'bg-red-100 text-red-600';
                                $iconBgColor = 'bg-red-500 text-white';
                                $iconName = 'solar:shield-warning-bold';
                                $cardBgColor = 'border-red-100/70 hover:bg-red-50/10';
                            } elseif ($isDibatalkan) {
                                $badgeText = 'DIBATALKAN';
                                $badgeColor = 'bg-red-100 text-red-600';
                                $iconBgColor = 'bg-red-500 text-white';
                                $iconName = 'solar:close-circle-bold';
                                $cardBgColor = 'border-red-100/70 hover:bg-red-50/10';
                            }

                            $urlTujuan = isset($item['target_id'])
                                ? route('pembatalan-reservasi', ['detailId' => $item['target_id']])
                                : null;
                        @endphp
                        <div class="relative flex flex-col gap-2.5 p-4 rounded-[8px] transition-all duration-300 border bg-white shadow-sm hover:shadow-md {{ $cardBgColor }}">
                            <div class="absolute -left-[35px] top-4 w-6 h-6 rounded-full flex items-center justify-center border border-white shadow-sm z-10 {{ $iconBgColor }}">
                                <iconify-icon icon="{{ $iconName }}" class="text-xs"></iconify-icon>
                            </div>

                            <div class="flex items-center justify-between gap-2">
                                <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest {{ $badgeColor }}">
                                    {{ $badgeText }}
                                </span>
                                @if (isset($item['waktu']))
                                    <span class="text-[10px] font-bold text-gray-400 flex items-center gap-1">
                                        <iconify-icon icon="solar:clock-circle-linear" class="text-xs"></iconify-icon>
                                        {{ $item['waktu'] }}
                                    </span>
                                @endif
                            </div>

                            <div class="text-xs sm:text-sm font-semibold text-gray-700 leading-relaxed">
                                @if ($isBatalRequest)
                                    <p class="inline">{{ $item['pesan'] }}</p>
                                    @if ($urlTujuan)
                                        <a href="{{ $urlTujuan }}"
                                            class="inline-flex items-center gap-0.5 text-blue-600 hover:text-blue-800 font-extrabold hover:underline ml-1 group/btn">
                                            {{ $item['tautan'] }}
                                            <iconify-icon icon="solar:alt-arrow-right-bold"
                                                class="text-[10px] group-hover/btn:translate-x-0.5 transition-transform"></iconify-icon>
                                        </a>
                                    @else
                                        <span class="ml-1 text-gray-400">{{ $item['tautan'] }}</span>
                                    @endif
                                @else
                                    @if ($urlTujuan && !$isDibatalkan)
                                        <a href="{{ $urlTujuan }}" class="hover:underline text-gray-700 font-bold">
                                            {{ $item['pesan'] }}
                                        </a>
                                    @else
                                        <span>{{ $item['pesan'] }}</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-16 text-gray-400 gap-3">
                            <iconify-icon icon="solar:notes-minimalistic-bold-duotone"
                                class="text-6xl opacity-20"></iconify-icon>
                            <div class="text-center">
                                <p class="text-base font-bold text-gray-500">Tidak ada kegiatan terbaru</p>
                                <p class="text-xs italic">Semua aktivitas kegiatan akan tampil di sini secara real-time
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Bagian Footer --}}
            <div class="p-6 bg-gray-50/50 border-t border-gray-100 flex justify-end shrink-0">
                <button type="button" wire:click="closePopUp"
                    class="px-6 py-3 bg-white border border-gray-200 text-gray-500 rounded-[8px] font-black text-[10px] uppercase tracking-[0.2em] hover:bg-gray-50 transition-all shadow-sm">
                    Tutup
                </button>
            </div>
        </div>
    </section>
</div>
