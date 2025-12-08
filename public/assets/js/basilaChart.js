// ================================ Users Overview Donut chart Start ================================
var options = {
    series: [500, 500, 500],
    colors: ['#FF9F29', '#487FFF', '#E4F1FF'],
    labels: ['Active', 'New', 'Total'],
    legend: {
        show: false
    },
    chart: {
        type: 'donut',
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
        breakpoint: 250,
        options: {
            chart: {
                width: 200
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
    series: [70, 80, 90, 30],
    chart: {
        height: 264,
        type: 'pie',
    },
    stroke: {
        show: false // This will remove the white border
    },
    labels: ['Team A', 'Team B', 'Team C'],
    colors: ['#487FFF', "#FF9F29", '#45B369', '#EF4A00'],
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
        horizontalAlign: 'center' // Align the legend horizontally
    },
    responsive: [{
        breakpoint: 250,
        options: {
            chart: {
                width: 200
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
            name: 'Net Profit',
            data: [20000, 16000, 14000, 25000, 45000, 18000, 28000, 11000, 26000, 48000, 18000, 22000]
        }, {
            name: 'Revenue',
            data: [15000, 18000, 19000, 20000, 35000, 20000, 18000, 13000, 18000, 38000, 14000, 16000]
        }, {
            name: 'Total',
            data: [15000, 18000, 19000, 20000, 35000, 20000, 18000, 13000, 18000, 38000, 14000, 16000]
        }
    ],
    colors: ['#487FFF', '#FF9F29',],
    labels: ['Active', 'New', 'Total'],
    legend: {
        show: false
    },
    chart: {
        type: 'bar',
        height: 454,
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
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    },
    yaxis: {
        categories: ['0', '5000', '10,000', '20,000', '30,000', '50,000', '60,000', '60,000', '70,000', '80,000', '90,000', '100,000'],
    },
    yaxis: {
        labels: {
            formatter: function (value) {
                return (value / 1000).toFixed(0) + 'k';
            }
        }
    },
    tooltip: {
        y: {
            formatter: function (value) {
                return value / 1000 + 'k';
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
