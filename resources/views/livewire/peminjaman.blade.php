<section class="bg-white col-span-7 p-10 rounded-[8px] shadow-md">
    <div class="flex flex-col gap-8">
        <div class="flex flex-col gap-2 pb-8 mb-8">
            <h1 class="font-bold text-2xl">Gedung Gku</h1>
            <div class="w-50 border"></div>
            <p class="text-[#8B8B8B] text-md">Pastikan data yang dipilih telah sesuai
                untuk menampilkan data ruangan 😄</p>
        </div>

        <div class="flex flex-row gap-5 md:flex-row sm:flex-col">
            <!-- Fakultas -->
            <select wire:model.live="fakultas" class="rounded-md flex-1 md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                bg-transparent border border-[#808080] border-opacity-50 font-bold">
                <option value="">Pilih Fakultas / Direktorat</option>
                <option value="fakultas_teknik">Fakultas Teknik</option>
                <option value="fakultas_ekonomi">Fakultas Ekonomi</option>
                <option value="fakultas_sastra">Fakultas Sastra</option>
                <!-- bisa ditambah sesuai data asli -->
            </select>

            <!-- Prodi -->
            <select wire:model.live="prodi" class="rounded-md flex-1 md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                bg-transparent border border-[#808080] border-opacity-50 font-bold">
                <option value="">Pilih Prodi</option>
                <option value="prodi_informatika">Informatika</option>
                <option value="prodi_akuntansi">Akuntansi</option>
                <option value="prodi_bahasa">Bahasa Inggris</option>
                <!-- bisa ditambah sesuai data asli -->
            </select>
        </div>

        <div class="flex flex-col flex-1 gap-5">
            <select id="opsi-peminjaman" wire:model.live="jenisPeminjaman" class="rounded-md md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                bg-transparent border border-[#808080] border-opacity-50 font-bold">
                <option value="">Pilih Jenis Peminjaman</option>
                <option value="akademik">Akademik</option>
                <option value="non-akademik">Non Akademik</option>
            </select>
        </div>

        <div>
            <p class="text-xl font-bold" id="value">{{ ucfirst($jenisPeminjaman) }}</p>
            <div class="border border-black border-opacity-50"></div>
        </div>

        @if ($jenisPeminjaman === 'akademik')
            <livewire:peminjaman-akademik :id="$routeId" :jenis-peminjaman="$jenisPeminjaman" :fakultas="$fakultas"
                :prodi="$prodi" :key="'akademik-' . $jenisPeminjaman . '-' . $fakultas . '-' . $prodi" />
        @endif

        @if ($jenisPeminjaman === 'non-akademik')
            <livewire:peminjaman-non-akademik :id="$routeId" :jenis-peminjaman="$jenisPeminjaman" :fakultas="$fakultas"
                :prodi="$prodi" :key="'akademik-' . $jenisPeminjaman . '-' . $fakultas . '-' . $prodi" />
        @endif
    </div>
</section>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('confirmAkademik', () => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Apakah Anda yakin ingin menyimpan data ini?',
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
                    console.log('click');
                    Livewire.dispatch('akademik');
                }
            });
        });

        Livewire.on('successAkademik', () => {
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

        Livewire.on('errorAkademik', (e) => {
            Swal.fire({
                title: 'Failed!',
                text: e,
                icon: 'error',
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn-ok'
                }
            });
        });

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('confirmNonAkademik', () => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Apakah Anda yakin ingin menyimpan data ini?',
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
                        Livewire.dispatch('non-akademik');
                    }
                });
            });
        });
    });
</script>