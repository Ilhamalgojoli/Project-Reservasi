<div>
    <style>
        .apexcharts-tooltip {
            background: #ffffff !important;
            color: #000000 !important;
            box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1) !important;
        }

        .apexcharts-tooltip-title,
        .apexcharts-tooltip-text-y-label,
        .apexcharts-tooltip-text-y-value {
            color: #000000 !important;
        }

        .apexcharts-tooltip-series-group {
            background-color: #ffffff !important;
        }

        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <main class="w-full h-auto space-y-5 mb-5">
        {{-- Main Section --}}
        <section class="grid grid-cols-12 gap-5">
            {{-- Card Dashboard --}}
            <div class="col-span-12 xl:col-span-8 bg-white p-4 rounded-[8px] space-y-6 shadow-md">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    {{-- Waiting Card --}}
                    <div
                        class="group relative overflow-hidden rounded-xl p-5 flex flex-row items-center justify-center gap-4 cursor-default
                        bg-gradient-to-br from-[#ffca28] to-[#ffb800]
                        shadow-lg hover:shadow-xl
                        transition-all duration-300 hover:-translate-y-0.5">
                        <div class="bg-[#d19c00] rounded-full p-4 flex flex-shrink-0 shadow-inner">
                            <iconify-icon icon="clarity:building-solid"
                                style="font-size: 30px; color: white;"></iconify-icon>
                        </div>
                        <div class="text-center flex flex-col gap-1 relative z-10">
                            <h1 class="text-4xl font-bold text-white drop-shadow-sm">{{ $waiting }}</h1>
                            <p class="text-white font-semibold text-sm tracking-wide">Total Peminjaman Menunggu</p>
                        </div>
                    </div>

                    {{-- Total ruangan terpakai Card --}}
                    <div
                        class="group relative overflow-hidden rounded-xl p-5 flex flex-row items-center justify-center gap-4 cursor-default
                        bg-gradient-to-br from-[#ff3b38] to-[#e51411]
                        shadow-lg hover:shadow-xl
                        transition-all duration-300 hover:-translate-y-0.5">
                        <div class="bg-[#c7110f] rounded-full p-4 flex justify-center flex-shrink-0 shadow-inner">
                            <iconify-icon icon="clarity:building-solid"
                                style="font-size: 30px; color: white;"></iconify-icon>
                        </div>
                        <div class="text-center flex flex-col gap-1 relative z-10">
                            <h1 class="text-4xl font-bold text-white drop-shadow-sm">{{ $approve }}</h1>
                            <p class="text-white font-semibold text-sm tracking-wide">Total Ruangan Terpakai</p>
                        </div>
                    </div>

                    {{-- Total ruangan available Card --}}
                    <div
                        class="group relative overflow-hidden rounded-xl p-5 flex flex-row items-center justify-center gap-4 cursor-default
                        bg-gradient-to-br from-[#4fc451] to-[#3ea83f]
                        shadow-lg hover:shadow-xl
                        transition-all duration-300 hover:-translate-y-0.5">
                        <div class="bg-[#2f812f] rounded-full p-4 flex justify-center flex-shrink-0 shadow-inner">
                            <iconify-icon icon="clarity:building-solid"
                                style="font-size: 30px; color: white;"></iconify-icon>
                        </div>
                        <div class="text-center flex flex-col gap-1 relative z-10">
                            <h1 class="text-4xl font-bold text-white drop-shadow-sm">{{ $tersedia }}</h1>
                            <p class="text-white font-semibold text-sm tracking-wide">Total Ruangan Tersedia</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-16 mt-16" x-data="cardDashboardChart(@js($gedung))"
                    wire:key="chart-gedung-{{ $periode_semester }}-{{ md5(json_encode($gedung)) }}">
                    <h2 class="text-xl font-bold text-gray-800 text-center mb-8">Penggunaan Ruang Gedung Telkom
                        University</h2>
                    <div class="overflow-x-auto text-black">
                        <div x-ref="chart" wire:ignore
                            class="min-w-[800px] lg:min-w-0 {{ count($gedung) === 0 ? 'hidden' : '' }}"></div>
                        <div
                            class="flex flex-col items-center justify-center py-20 text-gray-400 gap-3 bg-gray-50/50 rounded-xl {{ count($gedung) > 0 ? 'hidden' : '' }}">
                            <iconify-icon icon="solar:buildings-bold-duotone"
                                class="text-6xl opacity-20"></iconify-icon>
                            <div class="text-center">
                                <p class="text-lg font-bold text-gray-500">Tidak ada data gedung</p>
                                <p class="text-sm italic">Data penggunaan ruang belum tersedia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-4 space-y-5">
                {{-- Filter Semester Section --}}
                <div class="bg-white p-5 rounded-[8px] shadow-md flex flex-col gap-3">
                    <label for="periodeFilter" class="text-sm font-semibold text-gray-600 flex items-center gap-1.5">
                        Filter Berdasarkan Semester
                    </label>
                    <div class="flex items-center gap-2 w-full">
                        <div class="relative w-full">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <iconify-icon icon="solar:calendar-bold-duotone"
                                    style="font-size: 16px; color: #6b7280;"></iconify-icon>
                            </div>
                            <select wire:model="periode_semester" id="periodeFilter"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-9 pr-3 py-2 cursor-pointer shadow-sm appearance-none">
                                @foreach ($periodeOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <iconify-icon icon="solar:alt-arrow-down-bold"
                                    style="font-size: 14px; color: #6b7280;"></iconify-icon>
                            </div>
                        </div>
                        <button wire:click="applyFilter"
                            class="bg-[#e51411] hover:bg-[#c7110f] text-white font-medium text-sm px-4 py-2 rounded-lg shadow-md transition-colors duration-200 flex items-center gap-2 whitespace-nowrap">
                            <iconify-icon icon="solar:filter-bold-duotone" class="text-lg"></iconify-icon>
                            Filter
                        </button>
                    </div>
                </div>

                {{-- Kegiatan Terkini Section --}}
                <div class="bg-white p-6 rounded-[12px] shadow-lg flex flex-col gap-6 border border-gray-100/50"
                    id="kegiatan-terkini-section" data-kegiatan-all="{{ json_encode($kegiatanTerkiniAll) }}">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <div class="flex items-center gap-2.5">
                            <h2 class="font-black text-xl text-gray-900 tracking-tight">Kegiatan Terkini</h2>
                        </div>
                        <div class="flex items-center gap-2">
                            @if (count($kegiatanTerkini) > 0)
                                <button wire:click="showDetail()"
                                    class="flex items-center gap-1.5 px-3 py-1.5 text-[11px] font-black uppercase tracking-wider text-[#e51411] bg-rose-50 hover:bg-rose-100 rounded-full transition-all duration-200 border border-rose-100/50 hover:border-rose-200">
                                    <iconify-icon icon="solar:list-bold" class="text-sm"></iconify-icon>
                                    Lihat Semua
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- Bagian Card kegiatan terkini --}}
                    <div class="relative pl-6 border-l-2 border-gray-100 flex flex-col gap-6 ml-2">
                        @forelse ($kegiatanTerkini as $data)
                            @php
                                $isBatal = isset($data['tautan']) && $data['tautan'];
                                $urlTujuan = isset($data['target_id'])
                                    ? route('pembatalan-reservasi', ['detailId' => $data['target_id']])
                                    : null;
                            @endphp
                            <div
                                class="relative flex flex-col gap-2 p-4 rounded-[8px] transition-all duration-300 border
                                {{ $isBatal ? 'bg-red-50/30 border-red-100/50 hover:bg-red-50/50 shadow-sm' : 'bg-gray-50/30 border-gray-100/50 hover:bg-gray-50/60' }}">
                                <div
                                    class="absolute -left-[35px] top-4 w-6 h-6 rounded-full flex items-center justify-center border border-white shadow-sm z-10
                                    {{ $isBatal ? 'bg-red-500 text-white' : 'bg-emerald-500 text-white' }}">
                                    <iconify-icon
                                        icon="{{ $isBatal ? 'solar:shield-warning-bold' : 'solar:calendar-add-bold' }}"
                                        class="text-xs"></iconify-icon>
                                </div>

                                <div class="flex items-center justify-between gap-2">
                                    <span
                                        class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest
                                        {{ $isBatal ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' }}">
                                        {{ $isBatal ? 'BATAL REQUEST' : 'PEMINJAMAN BARU' }}
                                    </span>
                                    @if (isset($data['waktu']))
                                        <span class="text-[10px] font-bold text-gray-400 flex items-center gap-1">
                                            <iconify-icon icon="solar:clock-circle-linear"
                                                class="text-xs"></iconify-icon>
                                            {{ $data['waktu'] }}
                                        </span>
                                    @endif
                                </div>

                                <div class="text-xs font-semibold text-gray-700 leading-relaxed">
                                    @if ($isBatal)
                                        <p class="inline">{{ $data['pesan'] }}</p>
                                        @if ($urlTujuan)
                                            <a href="{{ $urlTujuan }}"
                                                class="inline-flex items-center gap-0.5 text-blue-600 hover:text-blue-800 font-extrabold hover:underline ml-1 group/btn">
                                                {{ $data['tautan'] }}
                                                <iconify-icon icon="solar:alt-arrow-right-bold"
                                                    class="text-[10px] group-hover/btn:translate-x-0.5 transition-transform"></iconify-icon>
                                            </a>
                                        @else
                                            <span class="ml-1 text-gray-400">{{ $data['tautan'] }}</span>
                                        @endif
                                    @else
                                        @if ($urlTujuan)
                                            <a href="{{ $urlTujuan }}"
                                                class="hover:underline text-gray-700 font-bold">
                                                {{ $data['pesan'] }}
                                            </a>
                                        @else
                                            <span>{{ $data['pesan'] }}</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-12 text-gray-400 gap-3">
                                <iconify-icon icon="solar:notes-minimalistic-bold-duotone"
                                    class="text-5xl opacity-20"></iconify-icon>
                                <div class="text-center">
                                    <p class="text-sm font-bold text-gray-500">Tidak ada kegiatan terbaru</p>
                                    <p class="text-xs italic">Semua aktivitas akan tampil di sini secara real-time</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Bagian Pop Up data kegiatan terkini --}}
                    @if ($showDetailKegiatan)
                        @livewire('admin.popup-detail-kegiatan', ['data' => $kegiatanTerkiniAll])
                    @endif
                </div>

                {{-- Aktif/Tidak Aktif Ruangan Section --}}
                <div class="bg-white p-5 rounded-[8px] shadow-md justify-center flex flex-col gap-5 items-center sm:items-center"
                    x-data="aktifChart(@js($dataAktif))"
                    wire:key="chart-aktif-{{ $periode_semester }}-{{ $aktif_gedung_id }}-{{ md5(json_encode($dataAktif)) }}">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between w-full gap-3">
                        <h1 class="text-lg font-bold text-gray-800 text-left">Ruangan Aktif / Tidak Aktif</h1>
                        <select wire:model.live="aktif_gedung_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-1.5 cursor-pointer shadow-sm min-w-[140px] w-full sm:w-auto">
                            <option value="">Semua Gedung</option>
                            @foreach ($listGedung as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_gedung }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="userOverviewDonutChart" x-ref="chart" wire:ignore
                        class="apexcharts-tooltip-z-none w-full flex justify-center {{ $dataAktif['ruanganAktif'] + $dataAktif['ruanganTidakAktif'] == 0 ? 'hidden' : '' }}">
                    </div>

                    <div
                        class="flex flex-col items-center justify-center py-10 text-gray-400 gap-3 {{ $dataAktif['ruanganAktif'] + $dataAktif['ruanganTidakAktif'] > 0 ? 'hidden' : '' }}">
                        <iconify-icon icon="solar:home-bold-duotone" class="text-5xl opacity-20"></iconify-icon>
                        <div class="text-center">
                            <p class="text-base font-bold text-gray-500">Tidak ada data ruangan</p>
                            <p class="text-xs italic">Belum ada data ruangan yang terdaftar</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Peminjaman Per Fakultas Section --}}
        <section class="grid grid-cols-12">
            <div class="col-span-12" x-data="peminjamanChart(@js($peminjamanPerFakultas))"
                wire:key="chart-fakultas-{{ $periode_semester }}-{{ $fakultas_filter }}-{{ md5(json_encode($peminjamanPerFakultas)) }}">
                <div
                    class="bg-white p-5 rounded-[12px] flex flex-col shadow-lg gap-6 w-full border border-gray-50 transition-all duration-300 hover:shadow-xl">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="bg-red-600 p-3 rounded-xl shadow-inner flex items-center gap-3">
                            <p class="text-white font-bold tracking-wide">Data Penggunaan Ruang Gedung Berdasarkan Fakultas</p>
                        </div>
                        <div class="flex items-center gap-1.5 bg-gray-100 p-1 rounded-xl border border-gray-200/20">
                            <button wire:click="$set('fakultas_filter', 'semua')"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 {{ $fakultas_filter === 'semua' ? 'bg-white text-gray-800 shadow-sm border border-gray-200/50' : 'text-gray-500 hover:text-gray-800' }}">
                                Semua
                            </button>
                            <button wire:click="$set('fakultas_filter', 'peminjaman')"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 {{ $fakultas_filter === 'peminjaman' ? 'bg-white text-gray-800 shadow-sm border border-gray-200/50' : 'text-gray-500 hover:text-gray-800' }}">
                                Peminjaman
                            </button>
                            <button wire:click="$set('fakultas_filter', 'perkuliahan')"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 {{ $fakultas_filter === 'perkuliahan' ? 'bg-white text-gray-800 shadow-sm border border-gray-200/50' : 'text-gray-500 hover:text-gray-800' }}">
                                Perkuliahan
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto text-black bg-gray-50/50 rounded-2xl p-4">
                        @php
                            $hasFakultasData =
                                count($peminjamanPerFakultas) > 0 && collect($peminjamanPerFakultas)->sum('total') > 0;
                        @endphp
                        <div id="chart-peminjaman-fakultas" x-ref="chart" wire:ignore
                            class="overflow-x-auto min-w-[800px] {{ !$hasFakultasData ? 'hidden' : '' }}"></div>

                        <div
                            class="flex flex-col items-center justify-center py-20 text-gray-400 gap-3 {{ $hasFakultasData ? 'hidden' : '' }}">
                            <iconify-icon icon="solar:chart-square-bold-duotone"
                                class="text-6xl opacity-20"></iconify-icon>
                            <div class="text-center">
                                <p class="text-lg font-bold text-gray-500">Tidak ada data peminjaman</p>
                                <p class="text-sm italic">Belum ada aktivitas peminjaman antar fakultas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Okkupansi Ruangan Section --}}
        <section class="grid grid-cols-12">
            <div class="col-span-12" x-data="okkupansiChart(@js($okkupansi))"
                wire:key="chart-okkupansi-{{ $periode_semester }}-{{ $okkupansi_filter }}-{{ md5(json_encode($okkupansi)) }}">
                <div class="bg-white p-5 rounded-[8px] flex flex-col shadow-md gap-5 w-full">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="bg-[#e51411] p-2 rounded-lg w-fit">
                            <p class="text-white font-bold">Okupansi</p>
                        </div>
                        <div class="flex items-center gap-1.5 bg-gray-100 p-1 rounded-xl border border-gray-200/20">
                            <button wire:click="$set('okkupansi_filter', 'semua')"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 {{ $okkupansi_filter === 'semua' ? 'bg-white text-gray-800 shadow-sm border border-gray-200/50' : 'text-gray-500 hover:text-gray-800' }}">
                                Semua
                            </button>
                            <button wire:click="$set('okkupansi_filter', 'peminjaman')"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 {{ $okkupansi_filter === 'peminjaman' ? 'bg-white text-gray-800 shadow-sm border border-gray-200/50' : 'text-gray-500 hover:text-gray-800' }}">
                                Peminjaman
                            </button>
                            <button wire:click="$set('okkupansi_filter', 'perkuliahan')"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 {{ $okkupansi_filter === 'perkuliahan' ? 'bg-white text-gray-800 shadow-sm border border-gray-200/50' : 'text-gray-500 hover:text-gray-800' }}">
                                Perkuliahan
                            </button>
                        </div>
                    </div>
                    <div id="chart-okkupansi" x-ref="chart" wire:ignore
                        class="w-full flex flex-nowrap gap-5 overflow-x-auto pb-5 {{ count($okkupansi) === 0 ? 'hidden' : '' }}">
                    </div>

                    <div
                        class="flex flex-col items-center justify-center py-12 text-gray-400 gap-3 {{ count($okkupansi) > 0 ? 'hidden' : '' }}">
                        <iconify-icon icon="solar:globus-bold-duotone" class="text-5xl opacity-20"></iconify-icon>
                        <div class="text-center">
                            <p class="text-base font-bold text-gray-500">Tidak ada data gedung</p>
                            <p class="text-xs italic">Data okupansi belum tersedia untuk ditampilkan</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Monitor Dashboard Section (Keep as separate component for performance) --}}
        <section class="grid grid-cols-12">
            <div class="col-span-12">
                <div class="bg-white p-5 rounded-[8px] flex flex-col shadow-md gap-5">
                    @livewire('admin.monitor-dashboard')
                </div>
            </div>
        </section>
    </main>

    @push('extra_scripts')
        <script src="{{ asset('assets/js/lib/apexcharts.min.js') }}"></script>

        <script data-navigate-once>
            document.addEventListener('alpine:init', () => {
                Alpine.data('cardDashboardChart', (data) => ({
                    chart: null,
                    navListener: null,
                    init() {
                        if (!data || data.length === 0) return;

                        this.navListener = () => this.destroy();
                        document.addEventListener('livewire:navigating', this.navListener);

                        let categories = data.map(item => item.nama_gedung);
                        let totalWaiting = data.map(item => item.totalWaiting);
                        let totalTerpakai = data.map(item => item.totalTerpakai);
                        let totalTersedia = data.map(item => item.totalTersedia);

                        var options = {
                            series: [{
                                    name: 'Total Waiting',
                                    data: totalWaiting
                                },
                                {
                                    name: 'Total Terpakai',
                                    data: totalTerpakai
                                },
                                {
                                    name: 'Total Tersedia',
                                    data: totalTersedia
                                }
                            ],
                            colors: ['#ffb800', '#e51411', '#3ea83f'],
                            chart: {
                                type: 'bar',
                                height: 520,
                                fontFamily: 'Inter, sans-serif',
                                toolbar: {
                                    show: false
                                }
                            },
                            plotOptions: {
                                bar: {
                                    borderRadius: 4,
                                    columnWidth: 20
                                }
                            },
                            xaxis: {
                                categories: categories,
                                labels: {
                                    style: {
                                        colors: '#000',
                                        fontWeight: 500
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    style: {
                                        colors: '#000'
                                    }
                                }
                            },
                            legend: {
                                position: 'bottom',
                                labels: {
                                    colors: '#000'
                                }
                            },
                            tooltip: {
                                theme: 'light',
                                fillSeriesColor: false
                            }
                        };

                        if (this.checkInterval) clearInterval(this.checkInterval);
                        this.checkInterval = setInterval(() => {
                            if (typeof ApexCharts !== 'undefined' && this.$refs.chart) {
                                clearInterval(this.checkInterval);
                                this.$refs.chart.innerHTML = '';
                                this.chart = new ApexCharts(this.$refs.chart, options);
                                this.chart.render();
                            }
                        }, 50);
                    },
                    destroy() {
                        if (this.navListener) document.removeEventListener('livewire:navigating', this
                            .navListener);
                        if (this.checkInterval) clearInterval(this.checkInterval);
                        if (this.chart) {
                            this.chart.destroy();
                            this.chart = null;
                        }
                    }
                }));

                // Chart Aktif/Tidak Aktif
                Alpine.data('aktifChart', (data) => ({
                    chart: null,
                    navListener: null,
                    init() {
                        if (!data) return;

                        this.navListener = () => this.destroy();
                        document.addEventListener('livewire:navigating', this.navListener);
                        var options = {
                            series: [data.ruanganAktif, data.ruanganTidakAktif],
                            labels: ['Aktif', 'Tidak Aktif'],
                            colors: ['#e51411', '#6175C1'],
                            chart: {
                                type: 'donut',
                                width: 380,
                                height: 270,
                                fontFamily: 'Inter, sans-serif'
                            },
                            legend: {
                                position: 'right',
                                labels: {
                                    colors: '#000'
                                }
                            },
                            tooltip: {
                                theme: 'light',
                                fillSeriesColor: false
                            },
                            responsive: [{
                                breakpoint: 640,
                                options: {
                                    chart: {
                                        width: 280,
                                        height: 240
                                    },
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }]
                        };
                        if (this.checkInterval) clearInterval(this.checkInterval);
                        this.checkInterval = setInterval(() => {
                            if (typeof ApexCharts !== 'undefined' && this.$refs.chart) {
                                clearInterval(this.checkInterval);
                                this.$refs.chart.innerHTML = '';
                                this.chart = new ApexCharts(this.$refs.chart, options);
                                this.chart.render();
                            }
                        }, 50);
                    },
                    destroy() {
                        if (this.navListener) document.removeEventListener('livewire:navigating', this
                            .navListener);
                        if (this.checkInterval) clearInterval(this.checkInterval);
                        if (this.chart) {
                            this.chart.destroy();
                            this.chart = null;
                        }
                    }
                }));

                // Chart Peminjaman Fakultas
                Alpine.data('peminjamanChart', (data) => ({
                    chart: null,
                    navListener: null,
                    init() {
                        if (!data || data.length === 0) return;

                        this.navListener = () => this.destroy();
                        document.addEventListener('livewire:navigating', this.navListener);

                        let categories = data.map(item => item.fakultas);
                        let totals = data.map(item => item.total);

                        var options = {
                            series: [{
                                name: 'Total Peminjaman',
                                data: totals
                            }],
                            chart: {
                                type: 'bar',
                                height: 400,
                                fontFamily: 'Inter, sans-serif',
                                toolbar: {
                                    show: false
                                },
                                animations: {
                                    enabled: true,
                                    easing: 'easeinout',
                                    speed: 800
                                }
                            },
                            plotOptions: {
                                bar: {
                                    borderRadius: 6,
                                    horizontal: true,
                                    distributed: true,
                                    barHeight: '60%',
                                    dataLabels: {
                                        position: 'center'
                                    },
                                }
                            },
                            colors: [
                                '#00529F', '#F07C3A', '#3ea83f', '#ffb800', '#e51411',
                                '#7B68EE', '#FF69B4', '#20B2AA', '#F4A460', '#778899'
                            ],
                            dataLabels: {
                                enabled: true,
                                style: {
                                    colors: ['#ffffff'],
                                    fontWeight: 'bold'
                                },
                                formatter: function(val) {
                                    return val > 0 ? val : '';
                                }
                            },
                            grid: {
                                borderColor: '#f1f1f1',
                                xaxis: {
                                    lines: {
                                        show: true
                                    }
                                },
                                yaxis: {
                                    lines: {
                                        show: false
                                    }
                                }
                            },
                            xaxis: {
                                categories: categories,
                                labels: {
                                    style: {
                                        fontWeight: 500,
                                        colors: '#000'
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    style: {
                                        fontWeight: 600,
                                        colors: '#000'
                                    }
                                }
                            },
                            tooltip: {
                                theme: 'light',
                                fillSeriesColor: false,
                                y: {
                                    formatter: function(val) {
                                        return val + " Peminjaman"
                                    }
                                }
                            },
                            legend: {
                                show: false
                            }
                        };

                        if (this.checkInterval) clearInterval(this.checkInterval);
                        this.checkInterval = setInterval(() => {
                            if (typeof ApexCharts !== 'undefined' && this.$refs.chart) {
                                clearInterval(this.checkInterval);
                                this.$refs.chart.innerHTML = '';
                                this.chart = new ApexCharts(this.$refs.chart, options);
                                this.chart.render();
                            }
                        }, 50);
                    },
                    destroy() {
                        if (this.navListener) document.removeEventListener('livewire:navigating', this
                            .navListener);
                        if (this.checkInterval) clearInterval(this.checkInterval);
                        if (this.chart) {
                            this.chart.destroy();
                            this.chart = null;
                        }
                    }
                }));

                Alpine.data('okkupansiChart', (data) => ({
                    charts: [],
                    navListener: null,
                    init() {
                        if (!data) return;

                        this.navListener = () => this.destroy();
                        document.addEventListener('livewire:navigating', this.navListener);
                        if (this.checkInterval) clearInterval(this.checkInterval);
                        this.checkInterval = setInterval(() => {
                            if (typeof ApexCharts !== 'undefined' && this.$refs.chart) {
                                clearInterval(this.checkInterval);
                                this.$refs.chart.innerHTML = "";
                                data.forEach((item) => {
                                    let chartDiv = document.createElement('div');
                                    chartDiv.classList.add('min-w-[250px]', 'flex',
                                        'justify-center');
                                    this.$refs.chart.appendChild(chartDiv);
                                    var options = {
                                        series: [item.terpakai, item.tidakTerpakai],
                                        chart: {
                                            height: 264,
                                            type: 'pie',
                                            fontFamily: 'Inter, sans-serif'
                                        },
                                        title: {
                                            text: item.nama_gedung,
                                            align: 'center',
                                            style: {
                                                color: '#000'
                                            }
                                        },
                                        labels: ['Terpakai', 'Tidak Terpakai'],
                                        colors: ['#F07C3A', "#00529F"],
                                        legend: {
                                            position: 'bottom',
                                            labels: {
                                                colors: '#000'
                                            }
                                        },
                                        tooltip: {
                                            theme: 'light',
                                            fillSeriesColor: false
                                        }
                                    };
                                    let chart = new ApexCharts(chartDiv, options);
                                    chart.render();
                                    this.charts.push(chart);
                                });
                            }
                        }, 50);
                    },
                    destroy() {
                        if (this.navListener) document.removeEventListener('livewire:navigating', this
                            .navListener);
                        if (this.checkInterval) clearInterval(this.checkInterval);
                        if (this.charts && this.charts.length > 0) {
                            this.charts.forEach(chart => chart.destroy());
                            this.charts = [];
                        }
                    }
                }));
            });
        </script>
    @endpush
</div>
