<div class="col-span-12">
    <div class="bg-white p-5 rounded-[12px] flex flex-col shadow-lg gap-6 w-full border border-gray-50 transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center justify-between">
            <div class="bg-red-600 p-3 rounded-xl shadow-inner flex items-center gap-3">
                <iconify-icon icon="solar:ranking-bold-duotone" style="font-size: 24px; color: white;"></iconify-icon>
                <p class="text-white font-bold tracking-wide">Data Peminjaman Berdasarkan Fakultas</p>
            </div>
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Global Statistics</div>
        </div>

        <div class="w-full bg-gray-50/50 rounded-2xl p-4">
            @if(count($peminjamanPerFakultas) > 0 && collect($peminjamanPerFakultas)->sum('total') > 0)
                <div id="chart-peminjaman-fakultas" class="w-full"></div>
            @else
                <div class="flex flex-col items-center justify-center py-20 text-gray-400 gap-3">
                    <iconify-icon icon="solar:chart-square-bold-duotone" class="text-6xl opacity-20"></iconify-icon>
                    <div class="text-center">
                        <p class="text-lg font-bold text-gray-500">Tidak ada data peminjaman</p>
                        <p class="text-sm italic">Belum ada aktivitas peminjaman antar fakultas</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        let chart;
        Livewire.on('peminjamanPerFakultas', (item) => {
            let data = item[0];

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
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
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
                    textAnchor: 'middle',
                    style: {
                        colors: ['#fff'],
                        fontWeight: 'bold'
                    },
                    formatter: function(val) {
                        return val > 0 ? val : '';
                    },
                    offsetX: 0,
                    dropShadow: {
                        enabled: true
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
                            colors: '#64748b'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontWeight: 600,
                            colors: '#1e293b'
                        }
                    }
                },
                tooltip: {
                    theme: 'dark',
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

            if (chart) {
                chart.updateOptions(options);
            } else {
                chart = new ApexCharts(document.querySelector("#chart-peminjaman-fakultas"), options);
                chart.render();
            }
        });
    });
</script>
