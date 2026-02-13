// ============================ Pie Chart Start ==========================
var options = {
    series: [180, 58],
    chart: {
        height: 264,
        type: 'pie',
    },
    stroke: {
        show: true, // This will remove the white border
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
        horizontalAlign: 'center', // Align the legend horizontally
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
                position: 'bottom', // Ensure the legend is at the bottom
                horizontalAlign: 'center', // Align the legend horizontally
                offsetX: -10,
                offsetY: 0
            }
        }
    }]
};

document.querySelectorAll(".pieChart").forEach((element) => {
    var chart = new ApexCharts(element, options);
    chart.render();
});

