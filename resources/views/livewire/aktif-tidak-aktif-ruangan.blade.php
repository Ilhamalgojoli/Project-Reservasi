<div class="bg-white p-5 rounded-[8px] shadow-md justify-center flex flex-col gap-5 sm:items-center">
    <h1 class="text-2xl font-bold flex justify-end">Ruangan Aktif / Tidak Aktif</h1>
    <div id="userOverviewDonutChart" class="apexcharts-tooltip-z-none w-fit"></div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('totalRuangan', (item) => {
            data = item[0];

            let aktif = data.ruanganAktif;
            let tidakAktif = data.ruanganTidakAktif;

            var options = {
                series: [aktif, tidakAktif],
                labels: ['Aktif', 'Tidak Aktif'],
                colors: ['#e51411', '#6175C1'],
                chart: {
                    type: 'donut',
                    width: 450,
                    height: 270,
                    startAngle: 0,
                    endAngle: 360,
                },
                dataLabels: { enabled: false },
                legend: { position: 'right' },
            };

            var chart = new ApexCharts(document.querySelector("#userOverviewDonutChart"), options);
            chart.render();
        });
    });
</script>