<div class="col-span-1 md:col-span-2 bg-white shadow-md p-5 rounded-[8px]">
    <div class="flex flex-col gap-2 pb-8 mb-8">
        <h1 class="font-bold text-2xl">Filter Ruangan</h1>
        <div class="w-50 border"></div>
        <p class="text-[#8B8B8B] text-md">Pastikan data yang dipilih telah sesuai
            untuk menampilkan data ruangan 😄</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10 mb-8">
        <div class="flex flex-row gap-10 sm:gap-4 sm:flex-col md:flex-col lg:flex-row">
            <select wire:model.live="lantai"
                class="rounded-md flex-1 text-[#000000] py-2 px-3 appearance-none
                    bg-transparent border border-[#808080] border-opacity-50">
                <option value="">Lantai</option>
                @foreach ($dataLantai as $data)
                    <option value="{{ $data->id }}">{{ $data->lantai }}</option>    
                @endforeach
            </select>
            <div>
                <button wire:click="filter" 
                    class="bg-[#ff0000ce] rounded-lg w-[150px] py-2 text-xl font-extrabold">
                    Filter
                </button>
            </div>
        </div>
    </div>
</div>
