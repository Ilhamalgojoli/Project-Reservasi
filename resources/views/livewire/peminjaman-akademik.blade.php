<div class="w-full mx-auto bg-white p-2">
    <form id="akademik" class="space-y-8">

        {{-- Section 1: Detail Mata Kuliah & Jadwal --}}
        <div class="space-y-6">
            <div class="flex items-center gap-2 pb-2 border-b border-gray-100">
                <iconify-icon icon="solar:folder-2-bold-duotone" class="text-[#e51411] text-xl"></iconify-icon>
                <h2 class="text-sm font-bold uppercase tracking-wider text-gray-700">Detail Sesi & Jadwal</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Kode Mata Kuliah --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">Mata Kuliah</label>
                    <div class="relative group">
                        <iconify-icon icon="mdi:book-open-page-variant"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-xl"></iconify-icon>
                        <select wire:model="kodeMatkul"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all appearance-none outline-none">
                            <option value="" selected>Pilih Kode Mata Kuliah</option>
                            <option value="FTE123">FTE123 - Teknik Elektro</option>
                            <option value="FIA456">FIA456 - Akuntansi</option>
                            <option value="FBA789">FBA789 - Bahasa Inggris</option>
                        </select>
                        <iconify-icon icon="mdi:chevron-down"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></iconify-icon>
                    </div>
                    @error('kodeMatkul')
                        <p class="text-[10px] text-red-500 font-bold ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Lantai --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">Lantai</label>
                    <div class="relative group">
                        <iconify-icon icon="mdi:stairs"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-xl"></iconify-icon>
                        <select wire:model.live="lantaiID"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all appearance-none outline-none">
                            <option selected>Pilih Lantai</option>
                            @foreach ($lantai as $data)
                                <option value="{{ $data->id }}">{{ $data->lantai }}</option>
                            @endforeach
                        </select>
                        <iconify-icon icon="mdi:chevron-down"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></iconify-icon>
                    </div>
                    @error('lantaiID')
                        <p class="text-[10px] text-red-500 font-bold ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ruangan --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">Ruangan</label>
                    <div class="relative group">
                        <iconify-icon icon="mdi:office-building-marker"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-xl"></iconify-icon>
                        <select id="ruangan" wire:model.live="ruanganID"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all appearance-none outline-none">
                            <option selected>Pilih Ruangan</option>
                            @foreach ($ruangan as $data)
                                <option value="{{ $data->id }}">{{ $data->kode_ruangan }}</option>
                            @endforeach
                        </select>
                        <iconify-icon icon="mdi:chevron-down"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></iconify-icon>
                    </div>
                    @error('ruanganID')
                        <p class="text-[10px] text-red-500 font-bold ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Section 2: Lokasi & Kapasitas --}}
        <div class="space-y-6">
            <div class="flex items-center gap-2 pb-2 border-b border-gray-100">
                <iconify-icon icon="solar:map-point-bold-duotone" class="text-[#e51411] text-xl"></iconify-icon>
                <h2 class="text-sm font-bold uppercase tracking-wider text-gray-700">Lokasi & Kapasitas</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Tanggal --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">Tanggal Peminjaman</label>
                    <div class="relative group">
                        <iconify-icon icon="solar:calendar-bold"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-xl cursor-pointer"
                            onclick="this.nextElementSibling.showPicker()"></iconify-icon>
                        <input type="date" wire:model="tanggal" min="{{ date('Y-m-d') }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all outline-none" />
                    </div>
                    @error('tanggal')
                        <p class="text-[10px] text-red-500 font-bold ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jam Peminjaman --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">Jam / Shift</label>
                    <div class="relative group">
                        <iconify-icon icon="mdi:clock-time-four"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-xl"></iconify-icon>
                        <input type="text" value="{{ implode(', ', $pilihJam ?? []) }}" readonly
                            placeholder="Pilih Jam ..."
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all outline-none cursor-pointer"
                            wire:click="toggleDropdown" />

                        @if ($dropdownOpen)
                            <div
                                class="absolute w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl max-h-48 overflow-y-auto z-20 p-2 space-y-1 animate-in fade-in slide-in-from-top-2 duration-200">
                                @foreach ($jamList as $jam)
                                    <label
                                        class="flex items-center px-3 py-2 hover:bg-red-50 rounded-lg cursor-pointer transition-colors group/item">
                                        <input type="checkbox" value="{{ $jam }}"
                                            class="w-4 h-4 text-[#e51411] border-gray-300 rounded focus:ring-[#e51411]"
                                            wire:model.live="pilihJam" />
                                        <span
                                            class="ml-3 text-sm font-bold text-gray-600 group-hover/item:text-[#e51411]">{{ $jam }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @error('pilihJam')
                        <p class="text-[10px] text-red-500 font-bold ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Kapasitas --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">Jumlah Muatan</label>
                    <div class="relative group">
                        <iconify-icon icon="mdi:account-group"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-xl"></iconify-icon>
                        <input type="number" wire:model="muatanKapasitas" inputmode="numeric"
                            class="w-full pl-10 pr-20 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all outline-none"
                            placeholder="Contoh: 30" />
                        <div
                            class="absolute right-3 top-1/2 -translate-y-1/2 px-2 py-0.5 bg-red-50 text-[#e51411] text-[10px] font-bold rounded-lg border border-red-100">
                            Max {{ $maxKapasitas }}
                        </div>
                    </div>
                    @error('muatanKapasitas')
                        <p class="text-[10px] text-red-500 font-bold ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Section 3: Informasi Penanggung Jawab --}}
        <div class="space-y-6">
            <div class="flex items-center gap-2 pb-2 border-b border-gray-100">
                <iconify-icon icon="solar:user-bold-duotone" class="text-[#e51411] text-xl"></iconify-icon>
                <h2 class="text-sm font-bold uppercase tracking-wider text-gray-700">Informasi Penanggung Jawab</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Penanggung Jawab --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">Nama Lengkap</label>
                    <div class="relative group">
                        <iconify-icon icon="mdi:account-outline"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-xl"></iconify-icon>
                        <input wire:model="penanggungJawab" type="text"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all outline-none"
                            placeholder="Nama Penanggung Jawab" />
                    </div>
                    @error('penanggungJawab')
                        <p class="text-[10px] text-red-500 font-bold ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kontak --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">Nomor WhatsApp / HP</label>
                    <div class="relative group">
                        <iconify-icon icon="mdi:phone-outline"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-xl"></iconify-icon>
                        <input wire:model="kontakPenanggungJawab" type="number"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all outline-none"
                            placeholder="08123xxx" />
                    </div>
                    @error('kontakPenanggungJawab')
                        <p class="text-[10px] text-red-500 font-bold ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="flex flex-col gap-2 md:col-span-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">Keperluan / Deskripsi Kegiatan</label>
                    <div class="relative group">
                        <iconify-icon icon="mdi:text-box-outline"
                            class="absolute left-3 top-3 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-xl"></iconify-icon>
                        <textarea wire:model="deskripsi"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all outline-none min-h-[100px]"
                            placeholder="Tuliskan detail kegiatan di sini..."></textarea>
                    </div>
                    @error('deskripsi')
                        <p class="text-[10px] text-red-500 font-bold ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-center pt-4">
            <button type="button" wire:click="$dispatch('confirmAkademik')"
                class="group flex items-center gap-3 px-10 py-3.5 bg-gradient-to-r from-[#e51411] to-[#ff3b38] text-white rounded-xl font-bold shadow-lg shadow-red-200 hover:shadow-red-300 hover:-translate-y-0.5 transition-all duration-300">
                <iconify-icon icon="mdi:send-variant" class="text-xl"></iconify-icon>
                <span>Ajukan Peminjaman</span>
            </button>
        </div>
    </form>
</div>
