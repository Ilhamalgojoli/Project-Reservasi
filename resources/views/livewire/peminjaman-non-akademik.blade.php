<div>
    <form id="non-akademik">
        <div class="space-y-5" id="Non-Akademik">
            <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                    <div class="flex flex-col flex-1 gap-5">
                        <!-- Lantai -->
                        <select wire:model.live="lantaiID" class="lantai rounded-md md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                            bg-transparent border border-[#808080] border-opacity-50 font-bold">
                            <option selected>Lantai</option>
                            @foreach ($lantai as $data)
                                <option value="{{ $data->id }}">{{ $data->lantai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col flex-1 gap-5">
                        <!-- Ruangan -->
                        <select wire:model.live="ruanganID" class="ruangan rounded-md md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                            bg-transparent border border-[#808080] border-opacity-50 font-bold">
                            <option selected>Ruangan</option>
                            @foreach ($ruangan as $data)
                                <option value="{{ $data->id }}">{{ $data->kode_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-5">
                <div class="flex flex-row gap-5 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                    <div class="flex flex-col flex-1 relative">
                        <input type="date" wire:model="tanggal" class="tanggal-peminjaman rounded-lg py-2 px-3 border border-[#808080] text-[#808080]
                                border-opacity-50 font-bold appearance-none" style="appearance:none;
                                -webkit-appearance:none;
                                -moz-appearance:none;" placeholder="Tanggal" />
                        <iconify-icon icon="solar:calendar-linear" onclick="this.previousElementSibling.showPicker()"
                            class="text-black absolute right-2 top-2.5 text-2xl cursor-pointer"></iconify-icon>
                    </div>
                    <div class="flex flex-col flex-1 relative">
                        <input type="text" value="{{ implode(', ', $pilihJam ?? []) }}" readonly
                            placeholder="Pilih Jam Peminjaman"
                            class="w-full border text-black border-gray-400 rounded-md py-2 px-3 cursor-pointer"
                            wire:click="toggleDropdown" />
                        <!-- Dropdown -->
                        @if ($dropdownOpen)
                            <div
                                class="absolute w-full border border-gray-400 text-black rounded-md mt-11 bg-white max-h-48 overflow-y-auto z-10">
                                @foreach ($jamList as $jam)
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                        <input type="checkbox" value="{{ $jam }}" class="mr-2" wire:model.live="pilihJam" />
                                        {{ $jam }}
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1">
                <div class="flex flex-row gap-10 sm:flex-col md:flex-col lg:flex-row">
                    <div class="flex flex-col flex-1 relative">
                        <!-- Muatan/Kapasitas -->
                        <input type="number" inputmode="numeric" wire:model="muatanKapasitas" class="rounded-lg py-2 px-3 border border-[#808080] text-black appearance-none
                                border-opacity-50 font-bold" placeholder="Kapasitas" />
                        <p class="muatan text-black text-md absolute right-10 font-bold top-2.5 cursor-pointer">
                            Max {{ $maxKapasitas }}
                        </p>
                        <iconify-icon icon="mdi:people-outline"
                            class="text-black absolute right-2 top-2.5 text-2xl cursor-pointer"></iconify-icon>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                    <div class="flex flex-col flex-1 relative">
                        <input type="text" wire:model="penanggungJawab" class="rounded-lg py-2 px-3 border border-[#808080] text-black
                            border-opacity-50 font-bold" placeholder="Penanggung Jawab" />
                    </div>
                    <div class="flex flex-col flex-1 relative">
                        <input type="number" name="kontak_penanggung_jawab" wire:model="kontakPenanggungJawab" class="rounded-lg py-2 px-3 border border-[#808080] text-black
                            border-opacity-50 font-bold" placeholder="Kontak Penanggung Jawab" />
                    </div>
                </div>
            </div>

            <div class="flex lg:flex-row sm:flex-col md:flex-col gap-5">
                <div class="flex flex-col flex-1 gap-5">
                    <textarea name="keterangan_peminjaman" wire:model="deskripsi" class="rounded-lg py-2 px-3 h-24 border border-[#808080] text-[#808080] font-bold
                        border-opacity-50" placeholder="Deskripsi"></textarea>
                </div>
            </div>
        </div>

        <div class="w-auto flex justify-center mt-5">
            <button wire:click="$dispatch('confirmNonAkademik')" type="button"
                class="bg-[#FF0101] w-[150px] font-bold py-2 rounded-md">
                Submit
            </button>
        </div>
    </form>
</div>
