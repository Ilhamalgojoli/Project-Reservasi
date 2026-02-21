<section class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
    <div
        class="bg-white p-6 rounded-xl shadow-lg
                overflow-y-auto relative flex-col w-[900px] sm:w-[80%] md:w-[600px] lg:w-[700px]">
        <form id="tambah-gedung" wire:submit.prevent="submit">
            <div class="flex flex-row justify-between mb-10">
                <h1 class="text-2xl font-bold">Tambah Gedung</h1>
                <button type="button" wire:click="closeButton()">
                    <img src="{{ asset('assets/icon/cross.svg') }}" />
                </button>
            </div>

            <div class="flex sm:flex-col md:flex-col lg:flex-col gap-5 w-full">
                <input wire:model="gambar" type="file"
                    class="rounded-lg py-2 px-3 border border-[#808080] border-opacity-50 text-[#808080] cursor-pointer"
                    accept="image/*" />
                @error('kode')
                    {{ $message }}
                @enderror

                <div class="flex sm:flex-col md:flex-col lg:flex-row gap-5 mb-5">
                    <div class="flex flex-col gap-5 flex-1">
                        <input type="text" wire:model="nama"
                            class="rounded-lg py-2 px-3 border text-black
                                border-[#808080] border-opacity-50"
                            placeholder="Nama Gedung" />
                        @error('kode')
                            {{ $message }}
                        @enderror
                        <input type="text" wire:model="kode"
                            class="rounded-lg py-2 px-3 border text-black
                                border-[#808080] border-opacity-50"
                            placeholder="Kode Gedung" />
                        @error('kode')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="flex flex-col gap-5 flex-1">
                        <input type="text" wire:model="jumlahLantai"
                            class="rounded-lg py-2 px-3 border border-[#808080] text-black
                                border-opacity-50"
                            placeholder="Jumlah Lantai " />
                        @error('kode')
                            {{ $message }}
                        @enderror
                        <select wire:model="status"
                            class="rounded-xl sm:w-auto text-black py-2 px-3 appearance-none
                                bg-transparent border border-[#808080] border-opacity-50">
                            <option value="">Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                        @error('kode')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex mb-5">
                <textarea wire:model="keterangan"
                    class="rounded-lg py-2 px-3 h-24 border border-[#808080] flex-1
                        border-opacity-50 text-black"
                    placeholder="Deskripsi"></textarea>
                @error('kode')
                    {{ $message }}
                @enderror
            </div>

            <div class="flex flex-col gap-4" wire:ignore>
                <div id="map" class="h-[300px] w-full border-[2px] border-gray-200 rounded-md"></div>
            </div>

            <input type="hidden" id="lat" wire:model="latitude">
            <input type="hidden" id="lng" wire:model="longitude">

            @error('kode')
                {{ $message }}
            @enderror

            <div class="flex flex-col gap-5 mt-5">
                <button type="submit" class="w-auto text-white bg-[red] py-2 rounded-xl font-extrabold">
                    Submit
                </button>
            </div>
        </form>
    </div>
</section>
