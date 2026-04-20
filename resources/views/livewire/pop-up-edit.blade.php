<section class="popup fixed inset-0 bg-gray-900/80 flex items-center justify-center z-[100] p-4 transition-all duration-500">
    <div class="bg-white w-full max-w-2xl rounded-[40px] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.3)] overflow-hidden relative animate-slide-up">
        
        {{-- Modal Header --}}
        <div class="p-8 flex items-center justify-between bg-white border-b border-gray-100">
            <div class="flex items-center gap-4 text-gray-800">
                <div class="p-3 bg-red-50 rounded-[20px] shadow-sm italic text-[#e51411]">
                    <iconify-icon icon="solar:pen-new-square-bold-duotone" class="text-2xl"></iconify-icon>
                </div>
                <div>
                    <h2 class="text-2xl font-black tracking-tight leading-none">Modifier Data Gedung</h2>
                    <p class="text-[10px] font-medium text-gray-400 uppercase tracking-[0.2em] mt-2">Sinkronisasi & pembaruan aset gedung</p>
                </div>
            </div>
            <button type="button" wire:click="closeButton" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-gray-50 text-gray-400 border border-gray-100 hover:bg-red-50 hover:text-red-500 transition-all duration-300">
                <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>

        <form wire:submit.prevent="submit">
            <div class="p-8 flex flex-col gap-8 max-h-[65vh] overflow-y-auto custom-scrollbar">
                
                {{-- Section 1: Identitas Gedung --}}
                <div class="flex flex-col gap-6">
                    <div class="flex flex-col gap-1">
                        <h3 class="text-lg font-black text-gray-800 tracking-tight leading-none">Identitas Gedung</h3>
                        <div class="w-full border-b border-dashed border-gray-100 mt-2"></div>
                    </div>

                    <div class="flex flex-col gap-5">
                        <div class="relative group">
                            <label class="text-[11px] font-medium uppercase tracking-widest text-gray-400 ml-1 mb-2 block">Pembaruan Foto Gedung</label>
                            <div class="relative">
                                <iconify-icon icon="solar:gallery-edit-bold" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                <input id="edit-gambar" type="file" wire:model.live="gambar"
                                    class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none appearance-none cursor-pointer"
                                    accept="image/*" />
                            </div>
                        </div>

                        <div class="flex flex-row gap-5">
                            <div class="flex-1 space-y-2">
                                <label class="text-[11px] font-medium uppercase tracking-widest text-gray-400 ml-1">Nama Gedung</label>
                                <div class="relative group">
                                    <iconify-icon icon="solar:building-bold-duotone" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                    <input type="text" wire:model="nama" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none" placeholder="Nama Gedung" />
                                </div>
                                @error('nama') <span class="text-[10px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex-1 space-y-2">
                                <label class="text-[11px] font-medium uppercase tracking-widest text-gray-400 ml-1">Kode Gedung</label>
                                <div class="relative group">
                                    <iconify-icon icon="solar:tag-bold-duotone" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                    <input type="text" wire:model="kode" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none" placeholder="Kode Ruangan" />
                                </div>
                                @error('kode') <span class="text-[10px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex flex-row gap-5">
                            <div class="flex-1 space-y-2">
                                <label class="text-[11px] font-medium uppercase tracking-widest text-gray-400 ml-1">Jumlah Lantai</label>
                                <div class="relative group">
                                    <iconify-icon icon="solar:layers-bold-duotone" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                    <input type="number" wire:model="jumlahLantai" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none" placeholder="Jumlah Lantai" />
                                </div>
                                @error('jumlahLantai') <span class="text-[10px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex-1 space-y-2">
                                <label class="text-[11px] font-medium uppercase tracking-widest text-gray-400 ml-1">Status Operasional</label>
                                <div class="relative group">
                                    <iconify-icon icon="solar:shield-check-bold-duotone" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                    <select wire:model="status" class="w-full pl-11 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none appearance-none cursor-pointer">
                                        <option value="">Status</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                    <iconify-icon icon="mdi:chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></iconify-icon>
                                </div>
                                @error('status') <span class="text-[10px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-medium uppercase tracking-widest text-gray-400 ml-1">Deskripsi</label>
                            <div class="relative group">
                                <textarea wire:model="keterangan" id="edit-keterangan" class="w-full h-24 p-4 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none resize-none" placeholder="Deskripsi"></textarea>
                            </div>
                            @error('keterangan') <span class="text-[10px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 2: Lokasi Geografis --}}
                <div class="flex flex-col gap-6">
                    <div class="flex flex-col gap-1">
                        <h3 class="text-lg font-black text-gray-800 tracking-tight leading-none">Lokasi Geografis</h3>
                        <div class="w-full border-b border-dashed border-gray-100 mt-2"></div>
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm" wire:ignore>
                            <div id="map" class="h-[250px] w-full bg-gray-100"></div>
                        </div>
                        
                        <div class="flex items-center justify-between px-5 py-3 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="flex gap-6">
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Lat:</span>
                                    <span id="show-lat" class="text-xs font-bold text-gray-800 italic uppercase">{{ $latitude }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Lng:</span>
                                    <span id="show-lng" class="text-xs font-bold text-gray-800 italic uppercase">{{ $longitude }}</span>
                                </div>
                            </div>
                            <div class="px-3 py-1 bg-white rounded-lg shadow-sm border border-gray-100">
                                <span class="text-[8px] font-black text-[#e51411] uppercase tracking-[0.2em] italic">Geo-Updated</span>
                            </div>
                        </div>

                        <input type="hidden" id="lat" value="{{ $latitude }}" wire:model="latitude">
                        <input type="hidden" id="lng" value="{{ $longitude }}" wire:model="longitude">
                        @error('latitude') <span class="text-[10px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Action Footer --}}
            <div class="p-8 bg-gray-50/50 border-t border-gray-100">
                <div class="flex flex-row gap-4">
                    <button type="button" wire:click="$dispatch('confirmDeleteGedung', { id: {{ $id }}})" class="flex items-center justify-center gap-2 px-8 py-5 bg-gray-100 text-gray-400 rounded-[24px] font-black text-xs uppercase tracking-[0.2em] hover:bg-red-50 hover:text-red-500 transition-all border border-gray-200">
                        <iconify-icon icon="solar:trash-bin-trash-bold" class="text-xl"></iconify-icon>
                        Hapus
                    </button>
                    <button type="submit" class="flex-1 flex items-center justify-center gap-3 px-12 py-5 bg-[#e51411] text-white rounded-[24px] font-black text-xs uppercase tracking-[0.25em] hover:bg-red-700 hover:-translate-y-1 transition-all shadow-xl">
                        <iconify-icon icon="solar:diskette-bold" class="text-xl"></iconify-icon>
                        UPDATE DATA
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
