<section class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
    <div
        class="bg-white p-6 rounded-xl shadow-lg
            overflow-y-auto relative flex-col w-[900px] sm:w-[80%] md:w-[600px] lg:w-[700px]">
        <form wire:submit.prevent="submit">
            <div class="flex flex-row justify-between mb-10">
                <h1 class="text-2xl font-bold">Edit Gedung</h1>
                <button wire:click="closeButton">
                    <img src="{{ asset('assets/icon/cross.svg') }}" class="" />
                </button>
            </div>

            <div class="flex sm:flex-col md:flex-col lg:flex-col gap-5 w-full">
                <input id="edit-gambar" type="file" wire:model.live="gambar"
                    class="rounded-lg py-2 px-3 border border-[#808080] border-opacity-50 text-[#808080] cursor-pointer"
                    accept="image/*" />
                @error('gambar')
                    {{ $message }}
                @enderror
                <div class="flex sm:flex-col md:flex-col lg:flex-row gap-5 mb-5">
                    <div class="flex flex-col gap-5 flex-1">
                        <input type="text" wire:model="nama"
                            class="rounded-lg py-2 px-3 border text-black
                            border-[#808080] border-opacity-50"
                            placeholder="Nama Gedung" />
                        @error('nama')
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
                        @error('jumlahLantai')
                            {{ $message }}
                        @enderror
                        <select wire:model="status"
                            class="rounded-xl sm:w-auto py-2 px-3 appearance-none
                            bg-transparent border border-[#808080] border-opacity-50 text-black">
                            <option value="">Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                        @error('status')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex mb-5">
                <textarea wire:model="keterangan"
                    class="rounded-lg py-2 px-3 h-24 border border-[#808080] flex-1
                    border-opacity-50 text-black"
                    id="edit-keterangan" placeholder="Deskripsi"></textarea>
                @error('keterangan')
                    {{ $message }}
                @enderror
            </div>

            <div class="flex flex-col gap-4 mb-3" wire:ignore>
                <div id="map" class="h-[300px] w-full border-[2px] border-gray-200 rounded-md"></div>
            </div>

            @error('latitude' || 'longitude')
                {{ $message }}
            @enderror

            <input type="hidden" id="lat" wire:model="latitude">
            <input type="hidden" id="lng" wire:model="longitude">

            <div class="flex flex-col gap-5">
                <div class="flex flex-row justify-center gap-5">
                    <button type="button" wire:click="$dispatch('confirmDeleteGedung', { id: {{ $id }}})"
                        class="btn-delete w-auto px-2 text-white bg-[red] py-2 rounded-xl font-extrabold flex flex-row items-center">
                        <iconify-icon icon="mdi:garbage-can-outline" class="text-xl"></iconify-icon>
                        Hapus
                    </button>
                    <button type="submit" class="w-auto px-2 text-white bg-[red] py-2 rounded-xl font-extrabold">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
