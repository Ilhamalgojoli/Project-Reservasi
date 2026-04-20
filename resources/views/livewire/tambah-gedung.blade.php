<div>
    <div class="flex flex-col md:flex-row mb-10 justify-between items-start md:items-end gap-6">
        <div class="space-y-1">
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Kelola Gedung</h1>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-[0.2em]">Manajemen infrastruktur & pemetaan unit gedung</p>
        </div>
        
        <button wire:click="openPopUpTambah()"
            class="flex items-center gap-3 bg-white text-gray-900 border border-gray-100 px-8 py-4 rounded-[20px] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-gray-100/50 hover:bg-[#e51411] hover:text-white hover:border-[#e51411] hover:-translate-y-1 transition-all duration-300 group">
            <iconify-icon icon="solar:add-circle-bold" class="text-xl group-hover:rotate-90 transition-transform duration-500"></iconify-icon>
            <span>Tambah Gedung Baru</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach ($datas as $data)
            <div class="group bg-white rounded-[32px] overflow-hidden shadow-xl shadow-gray-100 border border-gray-100 flex flex-col hover:shadow-2xl hover:border-gray-200 hover:-translate-y-2 transition-all duration-500">
                {{-- Image Container --}}
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ $data['gambar'] ? asset('storage/' . $data['gambar']) : asset('assets/basila_images/DefaultBuilding.png') }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                    
                    {{-- Overlay Actions --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center p-6">
                        <a href="{{ route('kelola-ruang', ['id' => $data['id']]) }}"
                            class="flex items-center gap-3 bg-white text-gray-900 px-6 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#e51411] hover:text-white transition-all transform translate-y-4 group-hover:translate-y-0 duration-500 shadow-lg">
                            <iconify-icon icon="solar:home-2-bold" class="text-xl"></iconify-icon>
                            Kelola Ruangan
                        </a>
                    </div>

                    {{-- Floating Badge --}}
                    <div class="absolute top-5 left-5 px-4 py-2 bg-white rounded-xl shadow-sm">
                        <span class="text-[10px] font-black text-gray-900 uppercase tracking-widest">{{ $data['kode_gedung'] ?? 'B-'.($loop->index + 1) }}</span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-8 flex-1 flex flex-col gap-6">
                    <div class="flex justify-between items-start">
                        <div class="space-y-3">
                            <h2 class="text-xl font-black text-gray-900 tracking-tight leading-tight uppercase relative inline-block transition-colors duration-300 group-hover:text-[#e51411]">
                                {{ $data['nama_gedung'] }}
                                <span class="absolute -bottom-1 left-0 w-0 h-[2px] bg-[#e51411] rounded-full transition-all duration-300 group-hover:w-1/2"></span>
                            </h2>
                            <p class="text-xs font-medium text-gray-400 line-clamp-2 leading-relaxed">
                                {{ $data['keterangan'] ?: 'Aset gedung strategis untuk operasional unit.' }}
                            </p>
                        </div>
                        <button wire:click="openPopUpEdit({{ $data->id }})" class="p-3 bg-amber-50 text-amber-500 rounded-2xl hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                            <iconify-icon icon="solar:pen-new-square-bold-duotone" class="text-2xl"></iconify-icon>
                        </button>
                    </div>

                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-50">
                        <div class="flex items-center gap-4 p-4 bg-gray-50/50 rounded-2xl border border-gray-100/50">
                            <div class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm text-[#e51411]">
                                <iconify-icon icon="solar:home-2-bold-duotone" class="text-xl"></iconify-icon>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-gray-900">{{ $data['ruangan_count'] ?? '0' }}</span>
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Unit Ruang</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-4 bg-gray-50/50 rounded-2xl border border-gray-100/50">
                            <div class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm text-[#e51411]">
                                <iconify-icon icon="solar:layers-bold-duotone" class="text-xl"></iconify-icon>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-gray-900">{{ $data['lantai_count'] }}</span>
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Lantai</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pop Up Tambah-->
    @if ($popUpTambah)
        <livewire:pop-up-tambah />
    @endif

    <!-- Pop Up Edit -->
    @if ($popUpEdit)
        <livewire:pop-up-edit :id="$gedungId" />
    @endif

    
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('init-map-tambah', () => {
                setTimeout(() => {
                    window.initMapCreate();
                }, 100);
            });

            Livewire.on('init-map-edit', () => {
                setTimeout(() => {
                    window.initMapUpdate();
                }, 100);
            });

            Livewire.on('successCreated', () => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Sukses',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn-ok'
                    }
                }).then((result) => {
                    if(result.isConfirmed){
                        Livewire.dispatch('successClosePopUp')
                    }
                });
            });

            Livewire.on('successUpdated', () => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Sukses',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn-ok'
                    }
                });
            });

            Livewire.on('confirmDeleteGedung', (e) => {
                console.log('click');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Apakah Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Konfirmasi',
                    cancelButtonText: 'Batal',
                    buttonsStyling: false,
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn-confirm',
                        cancelButton: 'btn-cancel',
                        actions: 'flex justify-center gap-4'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteGedung', {
                            id: e.id
                        });
                    }
                });
            });

            Livewire.on('successDeleteGedung', () => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Sukses',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn-ok'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('closeAfterConfirm');
                    }
                });
            });

            Livewire.on('failDelete', () => {
                Swal.fire({
                    title: 'Failed!',
                    text: 'Gagal menghapus data',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn-ok'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('closeAfterConfirm');
                    }
                });
            });

            Livewire.on('errorCreated', (e) => {
                Swal.fire({
                    title: 'Failed!',
                    text: e,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn-ok'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('closeAfterConfirm');
                    }
                });
            });
        });
    </script>
</div>
