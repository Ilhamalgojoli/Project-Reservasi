<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col gap-5">
    <div class="flex items-center gap-3 border-b border-gray-50 pb-4">
        <div class="p-2 bg-emerald-50 rounded-lg">
            <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="text-emerald-600 text-xl"></iconify-icon>
        </div>
        <h2 class="text-sm font-bold uppercase tracking-widest text-gray-800">Fasilitas Ruangan</h2>
    </div>

    @if (count($assets) > 0)
        <ul class="grid grid-cols-1 gap-3">
            @foreach ($assets as $data)
                <li class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 group hover:border-emerald-200 hover:bg-emerald-50/30 transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 flex items-center justify-center bg-white rounded-lg shadow-sm group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                             {{-- Dynamic icon based on asset name could be added here --}}
                             <iconify-icon icon="mdi:check-circle-outline" class="text-emerald-500 group-hover:text-white"></iconify-icon>
                        </div>
                        <span class="text-sm font-bold text-gray-700 capitalize">{{ $data->nama_asset }}</span>
                    </div>
                    <div class="px-3 py-1 bg-white rounded-lg shadow-sm border border-gray-100">
                        <span class="text-xs font-black text-gray-800">{{ $data->jumlah_asset }}</span>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="flex flex-col items-center justify-center py-10 opacity-40 grayscale">
            <iconify-icon icon="solar:box-minimalistic-linear" class="text-6xl"></iconify-icon>
            <p class="text-xs font-bold uppercase mt-2">Belum ada aset terdaftar</p>
        </div>
    @endif
</div>