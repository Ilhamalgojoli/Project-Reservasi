<div class="col-span-12" x-data="okkupansiChart(@js($okkupansi))">
    <div class="bg-white p-5 rounded-[8px] flex flex-col shadow-md gap-5 w-full">
        <div class="bg-[#e51411] p-2 rounded-lg w-fit">
            <p class="text-white font-bold">Okkupansi</p>
        </div>

        @if(count($okkupansi) > 0)
        <div id="chart-okkupansi" class="w-full flex flex-nowrap gap-5 overflow-x-auto pb-5">
        </div>
        @else
        <div class="flex flex-col items-center justify-center py-12 text-gray-400 gap-3">
            <iconify-icon icon="solar:globus-bold-duotone" class="text-5xl opacity-20"></iconify-icon>
            <div class="text-center">
                <p class="text-base font-bold text-gray-500">Tidak ada data gedung</p>
                <p class="text-xs italic">Data okupansi belum tersedia untuk ditampilkan</p>
            </div>
        </div>
        @endif
    </div>
</div>

<script data-navigate-once>
    document.addEventListener('alpine:init', () => {
        Alpine.data('okkupansiChart', (data) => ({
            charts: [],
            init() {
                if (!data) return;

                let container = document.getElementById('chart-okkupansi');
                if (!container) return;

                container.innerHTML = "";

                this.checkInterval = setInterval(() => {
                    if (typeof ApexCharts !== 'undefined') {
                        clearInterval(this.checkInterval);
                        
                        data.forEach((item) => {
                            let chartDiv = document.createElement('div');
                            chartDiv.classList.add('min-w-[250px]', 'flex', 'justify-center');
                            container.appendChild(chartDiv);

                            var options = {
                                series: [item.terpakai, item.tidakTerpakai],
                                chart: { height: 264, type: 'pie' },
                                title: {
                                    text: item.nama_gedung,
                                    align: 'center',
                                    style: { fontSize: '14px', fontWeight: 'bold' }
                                },
                                stroke: { show: true, width: 1, colors: '#EDEDED' },
                                labels: ['Terpakai', 'Tidak Terpakai'],
                                colors: ['#F07C3A', "#00529F"],
                                plotOptions: {
                                    pie: { dataLabels: { dropShadow: { enabled: true } } }
                                },
                                legend: {
                                    position: 'bottom',
                                    horizontalAlign: 'center',
                                    markers: { width: 14, height: 14, radius: 2 }
                                },
                                responsive: [{
                                    breakpoint: 250,
                                    options: {
                                        chart: { width: 480 },
                                        legend: { show: false, position: 'bottom', horizontalAlign: 'center', offsetX: 0, offsetY: 0 }
                                    }
                                }]
                            };

                            let chart = new ApexCharts(chartDiv, options);
                            chart.render();
                            this.charts.push(chart);
                        });
                    }
                }, 50);
            },
            destroy() {
                if (this.checkInterval) clearInterval(this.checkInterval);
                this.charts.forEach(chart => chart.destroy());
                this.charts = [];
            }
        }));
    });
</script>