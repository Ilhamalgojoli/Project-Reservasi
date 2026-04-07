<div class="bg-white shadow-md p-5 rounded-l space-y-3">
    <div class="flex flex-col gap-4" wire:ignore>
        <div id="map" class="h-[300px] w-full border-2 border-gray-400 rounded-md"></div>
    </div>

    <div class="flex flex-row gap-2">
        <p class="text-black">lat : {{ $latitude }}</p>
        <p class="text-black">long : {{ $longitude }}</p>
    </div>

    <input type="hidden" id="lat-map" wire:model.live="latitude">
    <input type="hidden" id="lng-map" wire:model.live="longitude">
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('init-map', () => {
            setTimeout(() => {
                window.initMap();
            }, 100);
        });
    });
</script>
