<div class="bg-white p-5 rounded-[8px] shadow-md flex flex-col justify-between space-y-5">
    <!-- Judul di atas container -->
    <h1 class="font-bold text-2xl">Kegiatan Terkini</h1>

    <!-- List kegiatan -->
    <ul class="flex flex-col gap-3 text-black w-full">
        @foreach ($datas as $data)
            <li class="flex flex-row items-center gap-5">
                <iconify-icon icon="icon-park-outline:dot" class="text-[#1BBA9A]" style="font-size: 20px;"></iconify-icon>
                <span>{{ $data->pesan }}</span>
            </li>
        @endforeach
    </ul>

    <button class="flex justify-center items-center mt-3" wire:click="getKegiatanTerkini">
        <iconify-icon icon="material-symbols:refresh-rounded" class="text-black text-2xl"></iconify-icon>
    </button>
</div>