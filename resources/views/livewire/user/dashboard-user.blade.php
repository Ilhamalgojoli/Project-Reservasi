<div class="w-full space-y-6 sm:pb-4">
    <style>
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <div
        class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#e51411] via-[#c7110f] to-[#8b0c0a] p-6 shadow-lg">
        <div class="relative z-10 flex flex-col gap-5">
            <div class="space-y-2">
                <p class="text-white/70 text-xs font-bold tracking-[0.2em] uppercase mb-1">Selamat datang kembali 👋</p>
                <div>
                    <h1 class="text-white text-3xl font-black tracking-tight">
                        {{ session('name') ?? session('username') }}
                    </h1>
                    <h4 class="text-white text-lg font-black tracking-tight">
                        {{ session('name') ?? session('user_identifier') }}</h4>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2 border-t border-white/10">
                <div class="flex items-center gap-3">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/20 rounded-xl border border-white/10 transition-all hover:bg-white/30">
                        <iconify-icon icon="solar:user-id-bold-duotone" class="text-white/80 text-lg"></iconify-icon>
                        <p class="text-white/90 text-xs font-bold">
                            {{ session('role_name') ?? 'User' }}
                        </p>
                    </div>
                </div>

                <a href="{{ route('index2') }}"
                    class="group inline-flex items-center gap-2 bg-white text-[#e51411] font-bold text-xs px-6 py-3 rounded-xl shadow-xl hover:shadow-white/10 hover:-translate-y-0.5 active:scale-95 transition-all duration-300 whitespace-nowrap">
                    <iconify-icon icon="solar:add-circle-bold-duotone"
                        class="text-xl group-hover:rotate-90 transition-transform duration-500"></iconify-icon>
                    <span>Buat Peminjaman Baru</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-2 gap-4">
        <div
            class="group relative overflow-hidden rounded-xl p-4 sm:p-8 flex flex-col lg:flex-row items-center lg:justify-center gap-3 sm:gap-6 cursor-default
            bg-gradient-to-br from-[#6c63ff] to-[#4f46e5]
            shadow-lg hover:shadow-xl
            transition-all duration-300 hover:-translate-y-0.5">
            <div class="bg-[#3730a3] rounded-full p-2.5 sm:p-5 flex flex-shrink-0 shadow-inner">
                <iconify-icon icon="mdi:calendar-multiple" class="text-2xl sm:text-[40px]"
                    style="color:white;"></iconify-icon>
            </div>
            <div class="text-center lg:text-left flex flex-col gap-0.5 sm:gap-1 relative z-10">
                <h1 class="text-3xl sm:text-6xl font-bold text-white drop-shadow-sm leading-none">{{ $total }}
                </h1>
                <p class="text-white/90 font-semibold text-xs sm:text-base tracking-wide leading-tight">Total Peminjaman
                </p>
            </div>
        </div>

        <div
            class="group relative overflow-hidden rounded-xl p-4 sm:p-8 flex flex-col lg:flex-row items-center lg:justify-center gap-3 sm:gap-6 cursor-default
            bg-gradient-to-br from-[#ffca28] to-[#ffb800]
            shadow-lg hover:shadow-xl
            transition-all duration-300 hover:-translate-y-0.5">
            <div class="bg-[#d19c00] rounded-full p-2.5 sm:p-5 flex flex-shrink-0 shadow-inner">
                <iconify-icon icon="mdi:clock-outline" class="text-2xl sm:text-[40px]"
                    style="color:white;"></iconify-icon>
            </div>
            <div class="text-center lg:text-left flex flex-col gap-0.5 sm:gap-1 relative z-10">
                <h1 class="text-3xl sm:text-6xl font-bold text-white drop-shadow-sm leading-none">{{ $waiting }}
                </h1>
                <p class="text-white/90 font-semibold text-xs sm:text-base tracking-wide leading-tight">Menunggu
                    Persetujuan</p>
            </div>
        </div>

        <div
            class="group relative overflow-hidden rounded-xl p-4 sm:p-8 flex flex-col lg:flex-row items-center lg:justify-center gap-3 sm:gap-6 cursor-default
            bg-gradient-to-br from-[#4fc451] to-[#3ea83f]
            shadow-lg hover:shadow-xl
            transition-all duration-300 hover:-translate-y-0.5">
            <div class="bg-[#2f812f] rounded-full p-2.5 sm:p-5 flex flex-shrink-0 shadow-inner">
                <iconify-icon icon="mdi:check-circle-outline" class="text-2xl sm:text-[40px]"
                    style="color:white;"></iconify-icon>
            </div>
            <div class="text-center lg:text-left flex flex-col gap-0.5 sm:gap-1 relative z-10">
                <h1 class="text-3xl sm:text-6xl font-bold text-white drop-shadow-sm leading-none">{{ $approve }}
                </h1>
                <p class="text-white/90 font-semibold text-xs sm:text-base tracking-wide leading-tight">Disetujui</p>
            </div>
        </div>

        <div
            class="group relative overflow-hidden rounded-xl p-4 sm:p-8 flex flex-col lg:flex-row items-center lg:justify-center gap-3 sm:gap-6 cursor-default
            bg-gradient-to-br from-[#ff3b38] to-[#e51411]
            shadow-lg hover:shadow-xl
            transition-all duration-300 hover:-translate-y-0.5">
            <div class="bg-[#c7110f] rounded-full p-2.5 sm:p-5 flex flex-shrink-0 shadow-inner">
                <iconify-icon icon="mdi:close-circle-outline" class="text-2xl sm:text-[40px]"
                    style="color:white;"></iconify-icon>
            </div>
            <div class="text-center lg:text-left flex flex-col gap-0.5 sm:gap-1 relative z-10">
                <h1 class="text-3xl sm:text-6xl font-bold text-white drop-shadow-sm leading-none">{{ $reject }}
                </h1>
                <p class="text-white/90 font-semibold text-xs sm:text-base tracking-wide leading-tight">Ditolak</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-5">

        <div class="col-span-12 xl:col-span-3 flex flex-col gap-4">

            <div class="bg-white rounded-xl p-5 shadow-md space-y-3">
                <h2 class="font-bold text-gray-700 text-sm">Ringkasan Status Ruangan</h2>
                @foreach ($roomInfo as $item => $val)
                    @php
                        if ($item === 'total') {
                            continue;
                        }

                        $info = match ($item) {
                            'used' => [
                                'color' => 'bg-red-500',
                                'label' => 'Ruangan Terpakai',
                            ],
                            'available' => [
                                'color' => 'bg-emerald-500',
                                'label' => 'Ruangan Tersedia',
                            ],
                        };
                    @endphp

                    <div>
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>{{ $info['label'] }}</span>
                            <span class="font-medium">{{ $val }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="h-2 rounded-full {{ $info['color'] }} transition-all duration-500"
                                style="width: {{ round($val == 0 ? 0 : ($val / $roomInfo['total']) * 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="bg-white rounded-xl p-4 shadow-md space-y-3">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold text-gray-700 text-sm">Proses Peminjaman</h2>
                    <a href="{{ route('history-peminjaman') }}" class="text-xs text-[#e51411] hover:underline">Semua
                        →</a>
                </div>

                @if ($recent->isEmpty())
                    <div class="flex flex-col items-center justify-center py-6 text-gray-300">
                        <iconify-icon icon="mdi:calendar-blank-outline" style="font-size:36px;"></iconify-icon>
                        <p class="text-xs mt-2 text-gray-400">Belum ada peminjaran</p>
                    </div>
                @else
                    <div class="flex flex-col divide-y divide-gray-100">
                        @foreach ($recent as $item)
                            @php
                                $status = $item->status;
                                $isMenunggu = in_array($status, ['Waiting', 'Approve', 'Reject']);
                                $isDisetujui = $status === 'Approve';
                                $isDitolak = $status === 'Reject';
                            @endphp
                            <div class="py-2.5 first:pt-0 last:pb-0">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-gray-700 truncate leading-tight">
                                            {{ $item->kode_ruangan }}
                                            <span class="font-normal text-gray-400">• {{ $item->nama_gedung }}</span>
                                        </p>
                                        <p class="text-[10px] text-gray-400 leading-tight mt-0.5">
                                            {{ ucfirst($item->jenis_peminjaman) }}
                                            @if ($item->jam_mulai !== '-')
                                                · {{ $item->jam_mulai }}–{{ $item->jam_selesai }}
                                            @endif
                                        </p>
                                    </div>
                                    @if ($isDitolak)
                                        <span
                                            class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-red-100 text-red-600 flex-shrink-0 ml-1">Ditolak</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-0">

                                    <div class="flex flex-col items-center w-12 shrink-0">
                                        <div
                                            class="w-5 h-5 rounded-full flex items-center justify-center bg-emerald-500">
                                            <iconify-icon icon="mdi:check"
                                                style="font-size:11px; color:white;"></iconify-icon>
                                        </div>
                                        <p
                                            class="text-[9px] text-emerald-600 font-semibold mt-0.5 text-center leading-none">
                                            Diajukan</p>
                                    </div>

                                    <div class="flex-1 h-0.5 mb-3 mx-0.5 {{ $isMenunggu ? 'bg-amber-400' : 'bg-gray-200' }}">
                                    </div>

                                    <div class="flex flex-col items-center w-12 shrink-0">
                                        <div
                                            class="w-5 h-5 rounded-full flex items-center justify-center
                                            {{ $isMenunggu ? ($isDisetujui || $isDitolak ? ($isDitolak ? 'bg-red-400' : 'bg-amber-400') : 'bg-amber-400 ring-2 ring-amber-200') : 'bg-gray-200' }}">
                                            @if ($isDitolak)
                                                <iconify-icon icon="mdi:close"
                                                    style="font-size:11px; color:white;"></iconify-icon>
                                            @elseif($isMenunggu)
                                                <iconify-icon icon="{{ $isDisetujui ? 'mdi:check' : 'mdi:clock-outline' }}"
                                                    style="font-size:11px; color:white;"></iconify-icon>
                                            @else
                                                <iconify-icon icon="mdi:clock-outline"
                                                    style="font-size:10px; color:#d1d5db;"></iconify-icon>
                                            @endif
                                        </div>
                                        <p
                                            class="text-[9px] font-semibold mt-0.5 text-center leading-none {{ $isMenunggu ? 'text-amber-600' : 'text-gray-300' }}">
                                            Menunggu</p>
                                    </div>

                                    <div class="flex-1 h-0.5 mb-3 mx-0.5 {{ $isDisetujui ? 'bg-emerald-400' : 'bg-gray-200' }}">
                                    </div>

                                    <div class="flex flex-col items-center w-12 shrink-0">
                                        <div
                                            class="w-5 h-5 rounded-full flex items-center justify-center {{ $isDisetujui ? 'bg-emerald-500' : 'bg-gray-200' }}">
                                            <iconify-icon
                                                icon="{{ $isDisetujui ? 'mdi:check-circle' : 'mdi:check-circle-outline' }}"
                                                style="font-size:11px; color:{{ $isDisetujui ? 'white' : '#d1d5db' }};"></iconify-icon>
                                        </div>
                                        <p
                                            class="text-[9px] font-semibold mt-0.5 text-center leading-none {{ $isDisetujui ? 'text-emerald-600' : 'text-gray-300' }}">
                                            Disetujui</p>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="col-span-12 xl:col-span-9 bg-white rounded-xl p-5 shadow-md flex flex-col gap-4">
            <div>
                <h2 class="font-bold text-gray-700 text-xl">Peminjaman Terbaru</h2>
                <p class="text-xs text-gray-400 mt-0.5">5 aktivitas peminjaman terakhirmu</p>
            </div>

            @if ($recent->isEmpty())
                <div class="flex flex-col items-center justify-center py-14 text-gray-300">
                    <iconify-icon icon="mdi:calendar-blank-outline" style="font-size:60px;"
                        class="mb-3"></iconify-icon>
                    <p class="text-sm font-medium text-gray-400">Belum ada peminjaman</p>
                    <p class="text-xs text-gray-300 mt-1">Mulai buat peminjaman ruangan pertamamu!</p>
                    <a href="{{ route('index2') }}"
                        class="mt-4 inline-flex items-center gap-2 bg-[#e51411] text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-[#c7110f] transition-colors duration-150">
                        <iconify-icon icon="mdi:plus" style="font-size:16px;"></iconify-icon>
                        Buat Peminjaman
                    </a>
                </div>
            @else
                <div class="flex flex-col gap-3">
                    @foreach ($recent as $item)
                        @php
                            $statusConfig = match ($item->status) {
                                'Approve' => [
                                    'border' => 'border-emerald-400',
                                    'bg' => 'bg-emerald-50',
                                    'icon_bg' => 'bg-emerald-500',
                                    'badge_bg' => 'bg-emerald-100',
                                    'badge_text' => 'text-emerald-700',
                                    'icon' => 'mdi:check-circle',
                                    'label' => 'Approved',
                                ],
                                'Waiting' => [
                                    'border' => 'border-amber-400',
                                    'bg' => 'bg-amber-50',
                                    'icon_bg' => 'bg-amber-400',
                                    'badge_bg' => 'bg-amber-100',
                                    'badge_text' => 'text-amber-700',
                                    'icon' => 'mdi:clock-outline',
                                    'label' => 'Waiting',
                                ],
                                'Reject' => [
                                    'border' => 'border-red-400',
                                    'bg' => 'bg-red-50',
                                    'icon_bg' => 'bg-red-500',
                                    'badge_bg' => 'bg-red-100',
                                    'badge_text' => 'text-red-700',
                                    'icon' => 'mdi:close-circle',
                                    'label' => 'Rejected',
                                ],
                                default => [
                                    'border' => 'border-gray-300',
                                    'bg' => 'bg-gray-50',
                                    'icon_bg' => 'bg-gray-400',
                                    'badge_bg' => 'bg-gray-100',
                                    'badge_text' => 'text-gray-500',
                                    'icon' => 'mdi:cancel',
                                    'label' => 'Canceled',
                                ],
                            };
                        @endphp
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-xl border-l-4 {{ $statusConfig['border'] }} {{ $statusConfig['bg'] }} hover:brightness-95 transition-all duration-150">
                            <div class="flex items-start gap-4 min-w-0">
                                <div
                                    class="w-10 h-10 rounded-xl {{ $statusConfig['icon_bg'] }} flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <iconify-icon icon="mdi:door-open"
                                        style="font-size:20px; color:white;"></iconify-icon>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <p class="font-bold text-gray-800 text-sm">{{ $item->kode_ruangan }}</p>
                                        <span class="text-gray-300">•</span>
                                        <p class="text-sm text-gray-600 truncate">{{ $item->nama_gedung }}, Lantai
                                            {{ $item->lantai }}</p>
                                    </div>
                                    <div class="flex items-center gap-3 mt-1 flex-wrap">
                                        <span
                                            class="inline-flex items-center gap-1 text-xs font-medium px-2 py-0.5 rounded-full
                                            {{ $item->jenis_peminjaman === 'akademik' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }}">
                                            <iconify-icon
                                                icon="{{ $item->jenis_peminjaman === 'akademik' ? 'mdi:school' : 'mdi:account-group' }}"
                                                style="font-size:11px;"></iconify-icon>
                                            {{ ucfirst($item->jenis_peminjaman) }}
                                        </span>
                                        @if ($item->jam_mulai !== '-')
                                            <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                                <iconify-icon icon="mdi:clock-time-four-outline"
                                                    style="font-size:12px;"></iconify-icon>
                                                {{ $item->jam_mulai }} – {{ $item->jam_selesai }}
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                                            <iconify-icon icon="mdi:account-outline"
                                                style="font-size:12px;"></iconify-icon>
                                            {{ $item->penanggung_jawab ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 sm:justify-end mt-2 sm:mt-0 pl-14 sm:pl-0">
                                @if ($item->status === 'Waiting')
                                    <button wire:click="confirmCancel({{ $item->id }})"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-600 transition-colors duration-150">
                                        <iconify-icon icon="mdi:cancel" style="font-size:13px;"></iconify-icon>
                                        Batalkan
                                    </button>
                                @elseif ($item->status === 'Approve')
                                    @if ($item->cancel_requested)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-extrabold bg-amber-50 text-amber-600 border border-amber-200 shadow-sm">
                                            <iconify-icon icon="solar:clock-circle-bold"
                                                class="text-sm"></iconify-icon>
                                            Menunggu Pembatalan
                                        </span>
                                    @else
                                        <button wire:click="confirmRequestCancel({{ $item->id }})"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-600 transition-colors duration-150">
                                            <iconify-icon icon="mdi:cancel" style="font-size:13px;"></iconify-icon>
                                            Ajukan Pembatalan Peminjaman
                                        </button>
                                    @endif
                                @endif
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold
                                    {{ $statusConfig['badge_bg'] }} {{ $statusConfig['badge_text'] }}">
                                    <iconify-icon icon="{{ $statusConfig['icon'] }}"
                                        style="font-size:13px;"></iconify-icon>
                                    {{ $statusConfig['label'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@script
    <script data-navigate-once>
        Livewire.on('open-cancel-modal', (event) => {
            Swal.fire({
                title: 'Batalkan Peminjaman?',
                text: 'Silakan tuliskan alasan singkat pembatalan peminjaman Anda.',
                input: 'text',
                inputPlaceholder: 'Contoh: Salah pilih ruangan / jam...',
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Kembali',
                confirmButtonColor: '#e51411',
                cancelButtonColor: '#6b7280',
                preConfirm: (value) => {
                    if (!value || value.trim().length < 5) {
                        Swal.showValidationMessage('Alasan pembatalan minimal 5 karakter!');
                    }
                    return value;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.cancelBooking(event.id, result.value);
                }
            });
        });

        Livewire.on('confirmRequestCancel', (event) => {
            Swal.fire({
                title: 'Ajukan Pembatalan?',
                text: 'Silakan tulis alasan Anda membatalkan peminjaman ini. Permintaan akan dikirimkan ke Admin/BAA untuk diverifikasi.',
                input: 'text',
                inputPlaceholder: 'Contoh: Kegiatan dipindahkan ke hari lain...',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ajukan',
                cancelButtonText: 'Kembali',
                confirmButtonColor: '#e51411',
                cancelButtonColor: '#6b7280',
                preConfirm: (value) => {
                    if (!value || value.trim().length < 5) {
                        Swal.showValidationMessage('Alasan pembatalan minimal 5 karakter!');
                    }
                    return value;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.requestCancelBooking(event.id, result.value);
                }
            });
        });

        Livewire.on('successCancel', (event) => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: event.text || 'Peminjaman berhasil dibatalkan.',
                timer: 2000,
                showConfirmButton: false
            });
        });

        Livewire.on('failedCancel', (event) => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: event.text || 'Terjadi kesalahan.'
            });
        });
    </script>
@endscript
