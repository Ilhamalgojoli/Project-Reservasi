<div class="bg-white shadow-md p-5 rounded-[8px] h-36">
    <h1 class="text-2xl font-bold mb-2">Asset Ruangan</h1>
    <ul class="flex flex-col gap-3 text-black">
        @foreach ($assets as $data)
        <li class="flex flex-row items-center gap-5 justify-center">
            <iconify-icon icon="icon-park-outline:dot" class="text-[#1BBA9A]" style="font-size: 20px;"></iconify-icon>
            <span>{{ ucfirst($data->nama_asset) }} : {{ ucfirst($data->jumlah_asset) }}</span>
        </li>
        @endforeach
    </ul>
</div>