<div class="bg-white p-5 rounded-[8px] shadow-md justify-center flex flex-col gap-5 sm:items-center">
    <h1 class="text-2xl font-bold flex justify-end">Ruangan Aktif / Tidak Aktif</h1>
    @if($data['ruanganAktif'] + $data['ruanganTidakAktif'] > 0)
        <div id="userOverviewDonutChart" class="apexcharts-tooltip-z-none w-fit"></div>
    @else
        <div class="flex flex-col items-center justify-center py-10 text-gray-400 gap-3">
            <iconify-icon icon="solar:home-bold-duotone" class="text-5xl opacity-20"></iconify-icon>
            <div class="text-center">
                <p class="text-base font-bold text-gray-500">Tidak ada data ruangan</p>
                <p class="text-xs italic">Belum ada data ruangan yang terdaftar</p>
            </div>
        </div>
    @endif
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
                dataLabels: {
                    enabled: false
                },
                legend: {
                    position: 'right'
                },
            };

            var chart = new ApexCharts(document.querySelector("#userOverviewDonutChart"), options);
            chart.render();
        });
    });
</script>
