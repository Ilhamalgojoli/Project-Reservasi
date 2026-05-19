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
    </style>
    <main class="w-full h-auto space-y-5 mb-5">
        <section class="grid lg:grid-cols-12 sm:grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Card Dashboard Section --}}
            <div class="lg:col-span-8 md:col-span-12 sm:col-span-12 bg-white p-4 rounded-[8px] space-y-6 shadow-md">
                <div class="grid lg:grid-cols-3 gap-4 md:grid-cols-2 sm:grid-cols-1">
                    {{-- Waiting Card --}}
                    <div
                        class="group relative overflow-hidden rounded-xl p-5 flex flex-row items-center justify-center gap-4 cursor-default
                        bg-gradient-to-br from-[#ffca28] to-[#ffb800]
                        shadow-lg hover:shadow-xl
                        transition-all duration-300 hover:-translate-y-0.5">
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 rounded-full bg-white/10"></div>
                        <div class="bg-[#d19c00] rounded-full p-4 flex flex-shrink-0 shadow-inner">
                            <iconify-icon icon="clarity:building-solid"
                                style="font-size: 30px; color: white;"></iconify-icon>
                        </div>
                        <div class="text-center flex flex-col gap-1 relative z-10">
                            <h1 class="text-4xl font-bold text-white drop-shadow-sm">{{ $waiting }}</h1>
                            <p class="text-white font-semibold text-sm tracking-wide">Total Waiting</p>
                        </div>
                    </div>

                    {{-- Terpakai Card --}}
                    <div
                        class="group relative overflow-hidden rounded-xl p-5 flex flex-row items-center justify-center gap-4 cursor-default
                        bg-gradient-to-br from-[#ff3b38] to-[#e51411]
                        shadow-lg hover:shadow-xl
                        transition-all duration-300 hover:-translate-y-0.5">
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 rounded-full bg-white/10"></div>
                        <div class="bg-[#c7110f] rounded-full p-4 flex justify-center flex-shrink-0 shadow-inner">
                            <iconify-icon icon="clarity:building-solid"
                                style="font-size: 30px; color: white;"></iconify-icon>
                        </div>
                        <div class="text-center flex flex-col gap-1 relative z-10">
                            <h1 class="text-4xl font-bold text-white drop-shadow-sm">{{ $approve }}</h1>
                            <p class="text-white font-semibold text-sm tracking-wide">Total Terpakai</p>
                        </div>
                    </div>

                    {{-- Tersedia Card --}}
                    <div
                        class="group relative overflow-hidden rounded-xl p-5 flex flex-row items-center justify-center gap-4 cursor-default
                        bg-gradient-to-br from-[#4fc451] to-[#3ea83f]
                        shadow-lg hover:shadow-xl
                        transition-all duration-300 hover:-translate-y-0.5">
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 rounded-full bg-white/10"></div>
                        <div class="bg-[#2f812f] rounded-full p-4 flex justify-center flex-shrink-0 shadow-inner">
                            <iconify-icon icon="clarity:building-solid"
                                style="font-size: 30px; color: white;"></iconify-icon>
                        </div>
                        <div class="text-center flex flex-col gap-1 relative z-10">
                            <h1 class="text-4xl font-bold text-white drop-shadow-sm">{{ $tersedia }}</h1>
                            <p class="text-white font-semibold text-sm tracking-wide">Total Tersedia</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4" x-data="cardDashboardChart(@js($gedung))"
                    wire:key="chart-gedung-{{ $periode_semester }}-{{ md5(json_encode($gedung)) }}">
                    <h2 class="text-lg font-bold text-gray-700 text-center mb-2">Penggunaan Ruang Gedung Telkom
                        University</h2>
                    <div class="overflow-x-auto text-black">
                        <div x-ref="chart" wire:ignore class="overflow-x-auto min-w-[800px] {{ count($gedung) === 0 ? 'hidden' : '' }}"></div>
                        
                        <div class="flex flex-col items-center justify-center py-20 text-gray-400 gap-3 bg-gray-50/50 rounded-xl {{ count($gedung) > 0 ? 'hidden' : '' }}">
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

            <div class="lg:col-span-4 md:col-span-12 sm:col-span-12 space-y-5">
                {{-- Filter Semester Section --}}
                <div class="bg-white p-5 rounded-[8px] shadow-md flex flex-col gap-3">
                    <label for="periodeFilter" class="text-sm font-semibold text-gray-600">
                        <iconify-icon icon="solar:calendar-bold-duotone"
                            class="inline text-lg align-text-bottom mr-1"></iconify-icon>
                        Filter Berdasarkan Semester
                    </label>
                    <div class="flex items-center gap-2 w-full">
                        <select wire:model="periode_semester" id="periodeFilter"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-pointer shadow-sm">
                            @foreach ($periodeOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <button wire:click="applyFilter"
                            class="bg-[#e51411] hover:bg-[#c7110f] text-white font-medium text-sm px-4 py-2 rounded-lg shadow-md transition-colors duration-200 flex items-center gap-2 whitespace-nowrap">
                            <iconify-icon icon="solar:filter-bold-duotone" class="text-lg"></iconify-icon>
                            Filter
                        </button>
                    </div>
                </div>

                {{-- Kegiatan Terkini Section --}}
                <div class="bg-white p-5 rounded-[8px] shadow-md flex flex-col justify-between space-y-5">
                    <h1 class="font-bold text-2xl">Kegiatan Terkini</h1>
                    <ul class="flex flex-col gap-3 text-black w-full">
                        @forelse ($kegiatanTerkini as $data)
                            <li class="flex flex-row items-start gap-3">
                                <iconify-icon icon="icon-park-outline:dot" class="text-[#1BBA9A] mt-0.5 flex-shrink-0"
                                    style="font-size: 20px;"></iconify-icon>
                                <span class="text-sm text-gray-700 leading-snug">{{ $data['pesan'] }}</span>
                            </li>
                        @empty
                            <li class="flex flex-col items-center justify-center py-8 text-gray-400 gap-2">
                                <iconify-icon icon="solar:notes-minimalistic-bold-duotone"
                                    class="text-4xl opacity-20"></iconify-icon>
                                <span class="text-sm font-medium italic">Tidak ada kegiatan terbaru</span>
                            </li>
                        @endforelse
                    </ul>
                </div>

                {{-- Aktif/Tidak Aktif Ruangan Section --}}
                <div class="bg-white p-5 rounded-[8px] shadow-md justify-center flex flex-col gap-5 sm:items-center"
                    x-data="aktifChart(@js($dataAktif))" wire:key="chart-aktif-{{ $periode_semester }}-{{ md5(json_encode($dataAktif)) }}">
                    <h1 class="text-2xl font-bold flex justify-end">Ruangan Aktif / Tidak Aktif</h1>
                    <div id="userOverviewDonutChart" wire:ignore class="apexcharts-tooltip-z-none w-fit {{ ($dataAktif['ruanganAktif'] + $dataAktif['ruanganTidakAktif']) == 0 ? 'hidden' : '' }}"></div>
                    
                    <div class="flex flex-col items-center justify-center py-10 text-gray-400 gap-3 {{ ($dataAktif['ruanganAktif'] + $dataAktif['ruanganTidakAktif']) > 0 ? 'hidden' : '' }}">
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
                wire:key="chart-fakultas-{{ $periode_semester }}-{{ md5(json_encode($peminjamanPerFakultas)) }}">
                <div
                    class="bg-white p-5 rounded-[12px] flex flex-col shadow-lg gap-6 w-full border border-gray-50 transition-all duration-300 hover:shadow-xl">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="bg-red-600 p-3 rounded-xl shadow-inner flex items-center gap-3">
                            <iconify-icon icon="solar:ranking-bold-duotone"
                                style="font-size: 24px; color: white;"></iconify-icon>
                            <p class="text-white font-bold tracking-wide">Data Peminjaman Berdasarkan Fakultas</p>
                        </div>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Global Statistics
                        </div>
                    </div>
                    <div class="w-full bg-gray-50/50 rounded-2xl p-4">
                        @php
                            $hasFakultasData = count($peminjamanPerFakultas) > 0 && collect($peminjamanPerFakultas)->sum('total') > 0;
                        @endphp
                        <div id="chart-peminjaman-fakultas" wire:ignore class="w-full {{ !$hasFakultasData ? 'hidden' : '' }}"></div>
                        
                        <div class="flex flex-col items-center justify-center py-20 text-gray-400 gap-3 {{ $hasFakultasData ? 'hidden' : '' }}">
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
                wire:key="chart-okkupansi-{{ $periode_semester }}-{{ md5(json_encode($okkupansi)) }}">
                <div class="bg-white p-5 rounded-[8px] flex flex-col shadow-md gap-5 w-full">
                    <div class="bg-[#e51411] p-2 rounded-lg w-fit">
                        <p class="text-white font-bold">Okkupansi</p>
                    </div>
                    <div id="chart-okkupansi" wire:ignore class="w-full flex flex-nowrap gap-5 overflow-x-auto pb-5 {{ count($okkupansi) === 0 ? 'hidden' : '' }}"></div>
                    
                    <div class="flex flex-col items-center justify-center py-12 text-gray-400 gap-3 {{ count($okkupansi) > 0 ? 'hidden' : '' }}">
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
                // Chart Gedung
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

                        this.checkInterval = setInterval(() => {
                            if (typeof ApexCharts !== 'undefined' && this.$refs.chart) {
                                clearInterval(this.checkInterval);
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
                                width: 450,
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
                            }
                        };
                        this.checkInterval = setInterval(() => {
                            const chartEl = document.querySelector("#userOverviewDonutChart");
                            if (typeof ApexCharts !== 'undefined' && chartEl) {
                                clearInterval(this.checkInterval);
                                this.chart = new ApexCharts(chartEl, options);
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
                                    colors: ['#ffffff'], // Kembali ke putih sesuai request
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

                        this.checkInterval = setInterval(() => {
                            const chartEl = document.querySelector("#chart-peminjaman-fakultas");
                            if (typeof ApexCharts !== 'undefined' && chartEl) {
                                clearInterval(this.checkInterval);
                                this.chart = new ApexCharts(chartEl, options);
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
                        let container = document.getElementById('chart-okkupansi');
                        if (!container) return;
                        container.innerHTML = "";
                        this.checkInterval = setInterval(() => {
                            if (typeof ApexCharts !== 'undefined') {
                                clearInterval(this.checkInterval);
                                data.forEach((item) => {
                                    let chartDiv = document.createElement('div');
                                    chartDiv.classList.add('min-w-[250px]', 'flex',
                                        'justify-center');
                                    container.appendChild(chartDiv);
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
