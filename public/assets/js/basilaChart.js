// ================================ Users Overview Donut chart Start ================================
var options = {
    series: [500, 500, 500],
    colors: ['#e51411', '#6175C1', '#ffb800'],
    labels: ['Perbaikan', 'Sedang Perbaikan', 'Selesai'],
    legend: {
        show: true,
        position: 'right',
        horizontalAlign: 'center',
        markers: {
            width: 14,
            height: 14,
            radius: 2
        }
    },
    chart: {
        type: 'donut',
        width: 450,
        height: 270,
        sparkline: {
            enabled: true // Remove whitespace
        },
        margin: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        },
        padding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        }
    },
    stroke: {
        width: 0,
    },
    dataLabels: {
        enabled: false
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 500
            },
            legend: {
                position: 'bottom'
            }
        }
    }],
};

var chart = new ApexCharts(document.querySelector("#userOverviewDonutChart"), options);
chart.render();

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

// ================================ Column Charts Chart Start ================================
var options = {
    series: [
        {
            name: 'Total Waiting',
            data: [2, 4, 3, 5]
        },
        {
            name: 'Total Terpakai',
            data: [3.5, 2.5, 4, 1]
        },
        {
            name: 'Total Tersedia',
            data: [4, 5, 3, 2]
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
        horizontalAlign: 'center', // Align the legend horizontally
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
        categories: ['Gedung 1', 'Gedung 2', 'Gedung 3', 'Gedung 4',],
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
