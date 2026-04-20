<section class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 transition-all duration-300">
    <div class="flex flex-col gap-10">

        {{-- Building Header Info --}}
        <div class="flex flex-col gap-3 relative border-b border-gray-50 pb-8">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-red-50 rounded-xl">
                    <iconify-icon icon="clarity:building-solid" class="text-[#e51411] text-2xl"></iconify-icon>
                </div>
                <div class="flex flex-col">
                    <h1 class="font-extrabold text-2xl text-gray-800 tracking-tight">{{ $buildingName }}</h1>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Gedung ID:
                        #GD-0{{ $routeId }}</p>
                </div>
            </div>
            <p class="text-gray-500 text-sm leading-relaxed italic max-w-2xl px-1">
                "{{ $buildingDesc ?: 'Pastikan data yang dipilih telah sesuai untuk menampilkan data ruangan yang tersedia di gedung ini.' }}"
            </p>
            <div class="absolute -bottom-[1px] left-0 w-24 h-1 bg-[#e51411] rounded-full"></div>
        </div>

        {{-- Step 1: Identitas & Jenis --}}
        <div class="space-y-6">
            <div class="flex items-center gap-3 px-1">
                <div
                    class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-xs font-black shadow-lg">
                    1</div>
                <h2 class="text-sm font-bold uppercase tracking-widest text-gray-800">Pemilihan Identitas & Jenis</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-1">
                {{-- Fakultas --}}
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Fakultas /
                        Direktorat</label>
                    <div class="relative group">
                        <iconify-icon icon="mdi:university-outline"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                        <select wire:model.live="fakultas" 
                        @if (session('faculty')) disabled @else selected @endif
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all outline-none appearance-none">
                            <option value="">Pilih Fakultas / Direktorat</option>
                            @foreach ($faculties as $data)
                                <option value="{{ $data->id }}">{{ $data->fakultas }}</option>
                            @endforeach
                        </select>
                        <iconify-icon icon="mdi:chevron-down"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></iconify-icon>
                    </div>
                    @if ($errorFakultas)
                        <p class="text-[10px] text-red-500 font-bold ml-1 italic">{{ $errorFakultas }}</p>
                    @endif
                </div>

                {{-- Prodi --}}
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Program
                        Studi</label>
                    <div class="relative group">
                        <iconify-icon icon="mdi:folder-account-outline"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                        <select wire:model.live="prodi" 
                        @if (session('studyProgram')) disabled @else selected @endif
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:bg-white focus:ring-2 focus:ring-[#e51411]/20 focus:border-[#e51411] transition-all outline-none appearance-none">
                            <option value="">Pilih Prodi</option>
                            @foreach ($prodies as $data)
                                <option value="{{ $data->id }}">
                                    {{ $data->prodi }}</option>
                            @endforeach
                        </select>
                        <iconify-icon icon="mdi:chevron-down"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></iconify-icon>
                    </div>
                    @if ($errorProdi)
                        <p class="text-[10px] text-red-500 font-bold ml-1 italic">{{ $errorProdi }}</p>
                    @endif
                </div>

                <div class="flex flex-col gap-2 md:col-span-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Tujuan
                        Peminjaman</label>
                    <div class="flex items-center gap-4 bg-gray-50 p-2 rounded-2xl border border-gray-100">
                        <button wire:click="$set('jenisPeminjaman', 'akademik')"
                            class="flex-1 flex items-center justify-center gap-2 py-2.5 
                            rounded-xl transition-all duration-300 font-bold text-sm
                            @if (session('role_name') !== 'DOSEN') hidden @endif
                            {{ $jenisPeminjaman === 'akademik' ? 'bg-white shadow-md text-[#e51411]' : 'text-gray-400 hover:text-gray-600' }}">
                            <iconify-icon icon="mdi:school-outline" class="text-xl"></iconify-icon>
                            <span>Akademik</span>
                        </button>
                        <button wire:click="$set('jenisPeminjaman', 'non-akademik')"
                            class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl transition-all duration-300 font-bold text-sm
                            {{ $jenisPeminjaman === 'non-akademik' ? 'bg-white shadow-md text-[#e51411]' : 'text-gray-400 hover:text-gray-600' }}">
                            <iconify-icon icon="mdi:account-star-outline" class="text-xl"></iconify-icon>
                            <span>Non-Akademik</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6 pt-4">
            <div class="flex items-center gap-3 px-1">
                <div
                    class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-xs font-black shadow-lg">
                    2</div>
                <h2 class="text-sm font-bold uppercase tracking-widest text-gray-800">Lengkapi Detail Reservasi</h2>
            </div>

            <div class="px-1 animate-in fade-in slide-in-from-bottom-5 duration-700">
                @if ($jenisPeminjaman === 'akademik')
                    <livewire:peminjaman-akademik :id="$routeId" :jenis-peminjaman="$jenisPeminjaman" :fakultas="$fakultas"
                        :prodi="$prodi" :key="'akademik-' . $jenisPeminjaman . '-' . $fakultas . '-' . $prodi" />
                @endif

                @if ($jenisPeminjaman === 'non-akademik')
                    <livewire:peminjaman-non-akademik :id="$routeId" :jenis-peminjaman="$jenisPeminjaman" :fakultas="$fakultas"
                        :prodi="$prodi" :key="'non-akademik-' . $jenisPeminjaman . '-' . $fakultas . '-' . $prodi" />
                @endif
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('livewire:init', () => {
        const swalConfig = {
            buttonsStyling: false,
            reverseButtons: true,
            customClass: {
                confirmButton: 'inline-flex items-center px-6 py-2.5 bg-[#e51411] text-white font-bold rounded-xl shadow-lg hover:bg-red-700 transition-all ml-3',
                cancelButton: 'inline-flex items-center px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all'
            }
        };

        Livewire.on('confirmAkademik', () => {
            Swal.fire({
                ...swalConfig,
                title: 'Konfirmasi Peminjaman?',
                text: 'Pastikan data jadwal dan ruangan sudah benar.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ajukan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('akademik');
                }
            });
        });

        Livewire.on('confirmNonAkademik', () => {
            Swal.fire({
                ...swalConfig,
                title: 'Konfirmasi Peminjaman?',
                text: 'Ajukan reservasi non-akademik ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ajukan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('non-akademik');
                }
            });
        });

        Livewire.on('successAkademik', () => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Permintaan peminjaman Anda telah dikirim.',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: swalConfig.customClass.confirmButton
                }
            }).then(() => {
                Livewire.dispatch('resetSelect');
            });
        });

        Livewire.on('successNonAkademik', () => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Permintaan peminjaman Non-Akademik Anda telah dikirim.',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: swalConfig.customClass.confirmButton
                }
            }).then(() => {
                Livewire.dispatch('resetSelect');
            });
        });

        Livewire.on('errorAkademik', (e) => {
            Swal.fire({
                title: 'Oops!',
                text: e,
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: swalConfig.customClass.confirmButton
                }
            });
        });
    });
</script>
