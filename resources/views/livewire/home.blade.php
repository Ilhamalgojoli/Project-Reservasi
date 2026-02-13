<div class="lg:col-span-8 md:col-span-12 sm:col-span-12 bg-white p-2 rounded-[8px] space-y-10 shadow-md">
    <div class="grid lg:grid-cols-3 gap-5 md:grid-cols-2 sm:grid-cols-1">
        <div class="flex-1 bg-[#ffb800] p-4 rounded-[8px] flex flex-row items-center justify-center gap-3">
            <div class="bg-[#d19c00] rounded-full p-5 flex">
                <iconify-icon icon="clarity:building-solid" class="" style="font-size: 35px;"></iconify-icon>
            </div>
            <div class="text-center flex flex-col gap-2">
                <h1 class="text-4xl text-white">{{ $waiting }}</h1>
                <p class="text-white font-bold">Total Waiting</p>
            </div>
        </div>
        <div class="flex-1 bg-[#e51411] p-4 rounded-[8px] flex flex-row items-center justify-center gap-3">
            <div class="bg-[#c7110f] rounded-full p-5 flex justify-center">
                <iconify-icon icon="clarity:building-solid" class="" style="font-size: 35px;"></iconify-icon>
            </div>
            <div class="text-center flex flex-col gap-2">
                <h1 class="text-4xl text-white">{{ $approve }}</h1>
                <p class="text-white font-bold">Total Terpakai</p>
            </div>
        </div>
        <div class="flex-1 bg-[#3ea83f] p-5 rounded-[8px] flex flex-row items-center justify-center gap-3">
            <div class="bg-[#2f812f] rounded-full p-5 flex justify-center">
                <iconify-icon icon="clarity:building-solid" class="" style="font-size: 35px;"></iconify-icon>
            </div>
            <div class="text-center flex flex-col gap-2">
                <h1 class="text-4xl text-white">{{ $tersedia }}</h1>
                <p class="text-white font-bold">Total Tersedia</p>
            </div>
        </div>
    </div>
    <h1 class="text-2xl text-center">Penggunaan Ruang Gedung Telkom University</h1>
    <div class="overflow-x-auto text-black">
        <div id="columnChart" class="overflow-x-auto min-w-[800px]"></div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('dataGedung', (e) => {
            data = e[0]

            let categories = data.map(item => item.nama_gedung);
            let totalWaiting = data.map(item => item.totalWaiting);
            let totalTerpakai = data.map(item => item.totalTerpakai);
            let totalTersedia = data.map(item => item.totalTersedia);

            var options = {
                series: [
                    {
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
                labels: ['Total Waiting', 'Total Terpakai', 'Total Tersedia'],
                legend: {
                    show: false
                },
                chart: {
                    type: 'bar',
                    height: 520,
                    toolbar: {
                        show: false
                    },
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
                dataLabels: {
                    enabled: false
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    markers: {
                        width: 14,
                        height: 14,
                        radius: 2
                    },
                    itemMargin: {
                        horizontal: 15,
                        vertical: 25
                    }
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: categories
                },
                yaxis: {
                    categories: ['0', '1', '2', '3', '4', '5',]
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return value.toFixed(0);
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (value) {
                            return value.toFixed(1);
                        }
                    }
                },
                fill: {
                    opacity: 1,
                    width: 18,
                },
                responsive: [
                    {
                        breakpoint: 480,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 4,
                                    columnWidth: 10,
                                },
                            },
                        }
                    }
                ]
            };

            var chart = new ApexCharts(document.querySelector("#columnChart"), options);
            chart.render();
        });
    })
</script>