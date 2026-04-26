<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col gap-5">
    <div class="flex items-center justify-between border-b border-gray-50 pb-4">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-50 rounded-lg">
                <iconify-icon icon="solar:map-point-bold-duotone" class="text-blue-600 text-xl"></iconify-icon>
            </div>
            <h2 class="text-sm font-bold uppercase tracking-widest text-gray-800">Lokasi Presisi</h2>
        </div>

        <div class="flex items-center gap-2">
            <div class="flex items-center gap-1 px-2.5 py-1 bg-gray-50 border border-gray-100 rounded-lg shadow-inner">
                <span class="text-[9px] font-black text-gray-400 uppercase">Lat</span>
                <span class="text-[10px] font-bold text-blue-600">{{ number_format((float) $latitude, 6) }}</span>
            </div>
            <div class="flex items-center gap-1 px-2.5 py-1 bg-gray-50 border border-gray-100 rounded-lg shadow-inner">
                <span class="text-[9px] font-black text-gray-400 uppercase">Lng</span>
                <span class="text-[10px] font-bold text-blue-600">{{ number_format((float) $longitude, 6) }}</span>
            </div>
        </div>
    </div>

    <div class="relative overflow-hidden group" wire:ignore>
        <div id="map"
            class="h-[300px] w-full bg-gray-100 rounded-xl border border-gray-200 shadow-inner group-hover:border-blue-200 transition-colors duration-500">
        </div>

        {{-- Map Overlay Decorations --}}
        <div
            class="absolute bottom-4 left-4 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
            <div
                class="px-3 py-1.5 bg-white/90 backdrop-blur-sm rounded-lg shadow-xl border border-white/50 text-[10px] font-bold text-gray-500 flex items-center gap-2">
                <iconify-icon icon="mdi:navigation-variant" class="text-blue-500 animate-bounce"></iconify-icon>
                Marker Lokasi Aktif
            </div>
        </div>
    </div>

    <input type="hidden" id="lat-map" wire:model.live="latitude">
    <input type="hidden" id="lng-map" wire:model.live="longitude">
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('init-map', (payload) => {
            const data = Array.isArray(payload) ? payload[0] : payload;
            const lat = data?.lat ?? null;
            const lng = data?.lng ?? null;
            setTimeout(() => {
                if (window.initMap) {
                    window.initMap(lat, lng);
                }
            }, 150);
        });
    });
</script>
