$(document).ready(function () {

    $.ajax({
        url: '/',
        method: 'GET',
        dataType: 'json',
        success: function (response) {

            const months = response.months
            const totalSales = response.totalSales

            const options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Total Sales',
                    data: totalSales
                }],
                xaxis: {
                    categories: months,
                    title: {
                        text: 'Months',
                        style: {
                            color: '#FFF',
                            fontSize: '12px',
                            fontWeight: 'normal',
                        }
                    },

                },
                yaxis: {
                    title: {
                        text: 'Sales',
                        style: {
                            color: '#FFF',
                            fontSize: '12px',
                            fontWeight: 'normal',
                        }
                    },

                },
                // title: {
                //     text: 'Total Sales Per Month',
                //     align: 'center',
                //     style: {
                //         color: '#FFF'
                //     }
                // },
                colors: ['#435ebe'],
                dataLabels: {
                    enabled: false,
                    style: {
                        fontSize: '12px',
                        fontWeight: 'normal',
                        colors: ['#FFF']
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (value) {
                            return value.toLocaleString()
                        }
                    },
                    theme: 'dark',
                    marker: {
                        show: true
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%',
                        // borderRadius: 10
                    }
                },
                fill: {
                    opacity: 1,
                },
            }


            // Render chart
            const chart = new ApexCharts(document.querySelector("#chart-zxc"), options)
            chart.render()
        },
        error: function () {
            console.log('error')
        }
    })

})