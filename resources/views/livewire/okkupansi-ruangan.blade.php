<div class="col-span-12">
    <div class="bg-white p-5 rounded-[8px] flex flex-col shadow-md gap-5 w-full">
        <div class="bg-[#e51411] p-2 rounded-lg w-fit">
            <p class="text-white font-bold">Okkupansi</p>
        </div>

        <div id="chart-okkupansi" class="w-full flex flex-nowrap gap-5 overflow-x-auto pb-5">
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('okkupansi', (item) => {
            let data = item[0];

            let container = document.getElementById('chart-okkupansi');
            container.innerHTML = "";

            data.forEach((item) => {
                let chartDiv = document.createElement('div');
                chartDiv.classList.add('min-w-[250px]', 'flex', 'justify-center');
                container.appendChild(chartDiv);

                var options = {
                    series: [item.terpakai, item.tidakTerpakai],
                    chart: {
                        height: 264,
                        type: 'pie',
                    },
                    title: {
                        text: item.nama_gedung,
                        align: 'center',
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold'
                        }
                    },
                    stroke: {
                        show: true,
                        width: 1,
                        colors: '#EDEDED'
                    },
                    labels: ['Terpakai', 'Tidak Terpakai'],
                    colors: ['#F07C3A', "#00529F"],
                    plotOptions: {
                        pie: {
                            dataLabels: {
                                dropShadow: {
                                    enabled: true,
                                },
                            },
                        }
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        markers: {
                            width: 14,
                            height: 14,
                            radius: 2
                        }
                    },
                    responsive: [{
                        breakpoint: 250,
                        options: {
                            chart: {
                                width: 480
                            },
                            legend: {
                                show: false,
                                position: 'bottom',
                                horizontalAlign: 'center',
                                offsetX: 0,
                                offsetY: 0
                            }
                        }
                    }]
                };

                let chart = new ApexCharts(chartDiv, options);
                chart.render();
            })
        });
    });
</script>
