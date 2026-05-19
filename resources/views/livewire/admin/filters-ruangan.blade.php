<div class="bg-white border border-gray-100 shadow-sm p-6 rounded-[8px] h-full flex flex-col gap-6">
    {{-- Filter Header --}}
    <div class="flex items-center gap-3 pb-4 border-b border-gray-50">
        <div class="flex flex-col">
            <h3 class="text-sm font-black uppercase tracking-widest text-gray-700">Filter Ruangan</h3>
            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-widest mt-0.5">Saring data berdasarkan lokasi</p>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row gap-4">
        {{-- Lantai Selector --}}
        <div class="flex-1 relative group">
            <iconify-icon icon="mdi:stairs" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
            <select wire:model.live="lantai"
                class="w-full pl-10 pr-10 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all outline-none cursor-pointer">
                <option value="">Semua Lantai</option>
                @foreach ($dataLantai as $data)
                    <option value="{{ $data['id'] }}">Lantai {{ $data['lantai'] }}</option>    
                @endforeach
            </select>
            </div>

        {{-- Filter Button --}}
        <button wire:click="filter" 
            class="group flex items-center justify-center gap-2 px-8 py-3 bg-[#e51411] text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-red-700 hover:-translate-y-0.5 active:scale-95 transition-all shadow-lg shadow-red-100/50">
            <iconify-icon icon="solar:funnel-bold" class="text-lg group-hover:rotate-12 transition-transform"></iconify-icon>
            <span>Terapkan Filter</span>
        </button>
    </div>

    {{-- Info Note --}}
    <div class="mt-auto flex items-start gap-3 opacity-60">
        <iconify-icon icon="solar:info-circle-linear" class="text-gray-400 text-md"></iconify-icon>
        <p class="text-[10px] font-medium text-gray-500 leading-normal">
            Pilih lantai yang spesifik untuk mempersempit pencarian ruangan di gedung ini.
        </p>
    </div>
</div>
