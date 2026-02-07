<div>
    <div class="flex flex-col flex-1 gap-5">
        <select name="lantai" id="lantai-id" wire:model="lantaiID"
            class="lantai rounded-md md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                bg-transparent border border-[#808080] border-opacity-50 font-bold">
            <option disabled selected>Lantai</option>
            @foreach ($lantai as $data)
                <option value="{{ $data['id'] }}">{{ $data['lantai'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex flex-col flex-1 gap-5">
        <select name="ruangan"
            class="ruangan rounded-md md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                bg-transparent border border-[#808080] border-opacity-50 font-bold">
            <option disabled selected>Ruangan</option>
        </select>
    </div>
</div>
