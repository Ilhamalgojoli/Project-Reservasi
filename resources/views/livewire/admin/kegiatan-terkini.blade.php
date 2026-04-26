<div class="bg-white p-5 rounded-[8px] shadow-md flex flex-col justify-between space-y-5">
    <h1 class="font-bold text-2xl">Kegiatan Terkini</h1>

    <ul class="flex flex-col gap-3 text-black w-full">
        @forelse ($datas as $data)
            <li class="flex flex-row items-center gap-5">
                <iconify-icon icon="icon-park-outline:dot" class="text-[#1BBA9A]" style="font-size: 20px;"></iconify-icon>
                <span>{{ $data->pesan }}</span>
            </li>
        @empty
            <li class="flex flex-col items-center justify-center py-8 text-gray-400 gap-2">
                <iconify-icon icon="solar:notes-minimalistic-bold-duotone" class="text-4xl opacity-20"></iconify-icon>
                <span class="text-sm font-medium italic">Tidak ada kegiatan terbaru</span>
            </li>
        @endforelse
    </ul>

    <button class="flex justify-center items-center mt-3" wire:click="refreshKegiatanTerkini">
        <iconify-icon icon="material-symbols:refresh-rounded" class="text-black text-2xl"></iconify-icon>
    </button>
</div>
