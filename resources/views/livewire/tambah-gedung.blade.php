<div>
    <div class="flex flex-row mb-5 justify-between sm:gap-5">
        <h1 class="font-bold text-2xl">Kelola Gedung</h1>
        <button wire:click="openPopUpTambah()"
            class="
                bg-[#FF0101] rounded-lg px-5 py-2 sm:px-1 sm:py-1 font-extrabold transition-all
                duration-300 hover:scale-105 flex justify-center items-center gap-2">
            <iconify-icon icon="mingcute:plus-fill" class="text-2xl sm:text-sm"></iconify-icon>
            <span class="font-extrabold mt-1 sm:text-sm">Tambah Gedung</span>
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-5">
        @foreach ($datas as $data)
            <div
                class="bg-[#ffffff] text-black rounded-[8px] py-1 px-1
                    shadow-md space-x-4 flex flex-col">
                <div class="flex flex-col justify-center items-center gap-5 mb-2">
                    <div class="flex flex-col gap-2 w-full ">
                        <div class="relative w-auto h-64 card-container">
                            <img src="{{ $data['gambar'] ? asset('storage/' . $data['gambar']) : asset('assets/basila_images/DefaultBuilding.png') }}"
                                class="w-full h-full object-cover rounded-lg" />
                            <div
                                class="overlay absolute inset-0 bg-gradient-to-t from-black/70 to-transparent rounded-lg z-20 lg:hidden">
                            </div>
                            <!-- icon menu -->
                            <div class="absolute top-3 right-3 z-30">

                            </div>
                            <!-- button -->
                            <div class="button-kelola absolute top-[110px] left-1/2 -translate-x-1/2 z-30 lg:hidden">
                                <a id="btn-gedung" href="{{ route('kelola-ruang', ['id' => $data['id']]) }}"
                                    class="bg-[#FF0101] rounded-[8px] px-5 py-2 font-extrabold transition-all
                                        duration-300 hover:scale-105 flex justify-center items-center gap-2 text-white">
                                    <iconify-icon icon="mingcute:plus-fill" class="text-2xl"></iconify-icon>
                                    <span class="font-extrabold mt-1">Kelola Ruangan</span>
                                </a>
                            </div>
                        </div>
                        <div class="flex flex-col px-5 gap-3">
                            <div class="flex flex-row justify-between items-center">
                                <h2 class="text-black font-bold leading-tight md:text-xl sm:text-md lg:text-2xl">
                                    {{ $data['nama_gedung'] }}
                                </h2>
                                <button wire:click="openPopUpEdit({{ $data->id }})">
                                    <iconify-icon icon="basil:edit-outline" class="text-4xl opacity-50"></iconify-icon>
                                </button>
                            </div>
                            <p class="text-[#8B8B8B] text-md">
                                {{ $data['keterangan'] }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-row gap-4">
                        <div
                            class="bg-[#FF0101] w-[120px] h-[100px] rounded-[8px]
                                flex flex-col justify-center items-center">
                            <h1 class="text-white text-2xl">{{ $data['ruangan_count'] ?? '0' }}</h1>
                            <p class="text-white font-bold text-sm">Jumlah</p>
                            <p class="text-white font-bold text-sm">Ruangan</p>
                        </div>
                        <div
                            class="bg-[#FF0101] w-[120px] h-[100px] rounded-[8px]
                                flex flex-col justify-center items-center">
                            <h1 class="text-white text-2xl">{{ $data['lantai_count'] }}</h1>
                            <p class="text-white font-bold text-sm">Jumlah</p>
                            <p class="text-white font-bold text-sm">Lantai</p>
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
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('init-map-tambah', () => {
            setTimeout(() => {
                window.initMapCreateUpdate();
            }, 100);
        });

        Livewire.on('init-map-edit', () => {
            setTimeout(() => {
                window.initMapCreateUpdate();
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
    });
</script>
