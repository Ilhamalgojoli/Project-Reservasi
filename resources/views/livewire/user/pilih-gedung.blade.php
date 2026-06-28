<div>
    <style>
        
        @media (min-width: 768px) {
            .custom-overlay {
                opacity: 0 !important;
                transition: opacity 0.3s ease-in-out !important;
            }
            .custom-overlay-btn {
                transform: translateY(1rem) !important;
                transition: transform 0.5s ease-in-out !important;
            }
            .group:hover .custom-overlay {
                opacity: 1 !important;
            }
            .group:hover .custom-overlay-btn {
                transform: translateY(0) !important;
            }
        }

        @media (max-width: 767px) {
            .custom-overlay {
                opacity: 1 !important;
            }
            .custom-overlay-btn {
                transform: translateY(0) !important;
            }
        }
    </style>
    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex flex-col gap-2">
            <h1 class="font-extrabold text-3xl text-gray-800 tracking-tight">Pilih Gedung</h1>
            <p class="text-gray-400 text-sm font-medium">Pilih gedung tujuan untuk melihat ketersediaan ruangan</p>
        </div>

        {{-- Search Bar Matched with Approve Style --}}
        <div class="relative w-full md:w-96 group">
            <iconify-icon icon="solar:magnifer-bold-duotone"
                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-xl"></iconify-icon>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama Gedung..."
                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none shadow-sm">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 mb-10">
        @forelse ($datas as $data)
            <div class="group relative bg-white rounded-[8px] shadow-xl shadow-gray-100/50 hover:shadow-2xl hover:shadow-gray-200/50 hover:-translate-y-2 hover:scale-[1.01] transition-all duration-500 overflow-hidden flex flex-col border border-gray-100 h-full"
                style="border-radius: 8px;">
                <div class="relative h-64 overflow-hidden"
                    style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <img src="{{ $data['gambar'] ? asset('storage/' . $data['gambar']) : asset('assets/basila_images/DefaultBuilding.png') }}"
                        alt="{{ $data['nama_gedung'] }}"
                        class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110" />

                    {{-- Overlay --}}
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/20 to-transparent flex items-center justify-center p-6 z-10 custom-overlay">
                        <a href="{{ route('pilih-ruang', ['id' => $data['id']]) }}"
                            class="flex items-center gap-3 bg-white text-gray-900 px-8 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#e51411] hover:text-white transition-all shadow-lg custom-overlay-btn">
                            <iconify-icon icon="solar:home-2-bold" class="text-xl"></iconify-icon>
                            <span>Pilih Gedung</span>
                        </a>
                    </div>

                    <div class="absolute top-4 right-4 z-20">
                        <span
                            class="bg-white text-emerald-600 text-[10px] font-extrabold px-3 py-1 rounded-full shadow-sm flex items-center gap-1 uppercase tracking-tighter border border-emerald-100">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            Tersedia
                        </span>
                    </div>
                </div>

                <div class="p-8 flex flex-col flex-1 gap-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-xl font-black text-gray-900 tracking-tight leading-tight uppercase relative inline-block transition-colors duration-300 group-hover:text-[#e51411]">
                                {{ $data['nama_gedung'] }}
                                <span
                                    class="absolute -bottom-1 left-0 w-0 h-[2px] bg-[#e51411] rounded-full transition-all duration-300 group-hover:w-1/2"></span>
                            </h2>
                            <div
                                class="flex items-center gap-1.5 text-gray-400 text-[10px] font-bold uppercase tracking-widest">
                                <iconify-icon icon="solar:map-point-bold-duotone"
                                    class="text-[#e51411] text-sm"></iconify-icon>
                                <span>Area Kampus Utama</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span
                                class="text-[10px] uppercase font-bold text-gray-300 tracking-widest leading-none mb-1">ID</span>
                            <span class="text-xs font-black text-gray-400">#GD-0{{ $data['id'] }}</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-50">
                        <p class="text-gray-500 text-xs font-medium leading-relaxed line-clamp-2 italic">
                            {{ $data['keterangan'] ?: 'Gedung ini merupakan fasilitas akademik yang mendukung kegiatan belajar mengajar.' }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="col-span-full flex flex-col items-center justify-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-100">
                <iconify-icon icon="solar:buildings-bold-duotone" class="text-6xl text-gray-200 mb-4"></iconify-icon>
                <p class="text-gray-400 font-bold uppercase tracking-widest">Gedung tidak ditemukan</p>
            </div>
        @endforelse
    </div>
</div>
