<div class="lg:col-span-8 md:col-span-12 sm:col-span-12 bg-white p-4 rounded-[8px] space-y-6 shadow-md">
    <div class="grid lg:grid-cols-3 gap-4 md:grid-cols-2 sm:grid-cols-1">

        {{-- Waiting Card --}}
        <div
            class="group relative overflow-hidden rounded-xl p-5 flex flex-row items-center justify-center gap-4 cursor-default
            bg-gradient-to-br from-[#ffca28] to-[#ffb800]
            shadow-lg hover:shadow-xl
            transition-all duration-300 hover:-translate-y-0.5">
            <!-- Decorative circle -->
            <div class="absolute -right-4 -bottom-4 w-24 h-24 rounded-full bg-white/10"></div>
            <div class="bg-[#d19c00] rounded-full p-4 flex flex-shrink-0 shadow-inner">
                <iconify-icon icon="clarity:building-solid" style="font-size: 30px; color: white;"></iconify-icon>
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
                <iconify-icon icon="clarity:building-solid" style="font-size: 30px; color: white;"></iconify-icon>
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
                <iconify-icon icon="clarity:building-solid" style="font-size: 30px; color: white;"></iconify-icon>
            </div>
            <div class="text-center flex flex-col gap-1 relative z-10">
                <h1 class="text-4xl font-bold text-white drop-shadow-sm">{{ $tersedia }}</h1>
                <p class="text-white font-semibold text-sm tracking-wide">Total Tersedia</p>
            </div>
        </div>

    </div>

    <div class="border-t border-gray-100 pt-4"
         x-data="cardDashboardChart(@js($gedung))">
        <h2 class="text-lg font-bold text-gray-700 text-center mb-2">Penggunaan Ruang Gedung Telkom University</h2>
        <div class="overflow-x-auto text-black">
            @if(count($gedung) > 0)
                <div x-ref="chart" class="overflow-x-auto min-w-[800px]"></div>
            @else
                <div class="flex flex-col items-center justify-center py-20 text-gray-400 gap-3 bg-gray-50/50 rounded-xl">
                    <iconify-icon icon="solar:buildings-bold-duotone" class="text-6xl opacity-20"></iconify-icon>
                    <div class="text-center">
                        <p class="text-lg font-bold text-gray-500">Tidak ada data gedung</p>
                        <p class="text-sm italic">Data penggunaan ruang belum tersedia</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('cardDashboardChart', (data) => ({
                chart: null,
                init() {
                    if (!data || data.length === 0) return;

                    let categories = data.map(item => item.nama_gedung);
                    let totalWaiting = data.map(item => item.totalWaiting);
                    let totalTerpakai = data.map(item => item.totalTerpakai);
                    let totalTersedia = data.map(item => item.totalTersedia);

                    var options = {
                        series: [
                            { name: 'Total Waiting', data: totalWaiting },
                            { name: 'Total Terpakai', data: totalTerpakai },
                            { name: 'Total Tersedia', data: totalTersedia }
                        ],
                        colors: ['#ffb800', '#e51411', '#3ea83f'],
                        labels: ['Total Waiting', 'Total Terpakai', 'Total Tersedia'],
                        legend: { show: false },
                        chart: {
                            type: 'bar',
                            height: 520,
                            toolbar: { show: false },
                        },
                        grid: {
                            show: true,
                            borderColor: '#D1D5DB',
                            strokeDashArray: 4,
                            position: 'back',
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                columnWidth: 20,
                            },
                        },
                        dataLabels: { enabled: false },
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'center',
                            markers: { width: 14, height: 14, radius: 2 },
                            itemMargin: { horizontal: 15, vertical: 25 }
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: { categories: categories },
                        yaxis: {
                            labels: {
                                formatter: function(value) { return value.toFixed(0); }
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: function(value) { return value.toFixed(1); }
                            }
                        },
                        fill: {
                            opacity: 1,
                            width: 18,
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                plotOptions: {
                                    bar: { borderRadius: 4, columnWidth: 10 },
                                },
                            }
                        }]
                    };

                    let checkInterval = setInterval(() => {
                        if (typeof ApexCharts !== 'undefined' && this.$refs.chart) {
                            clearInterval(checkInterval);
                            this.chart = new ApexCharts(this.$refs.chart, options);
                            this.chart.render();
                        }
                    }, 50);
                },
                destroy() {
                    if (this.chart) {
                        this.chart.destroy();
                        this.chart = null;
                    }
                }
            }));
        });
    </script>
</div>
