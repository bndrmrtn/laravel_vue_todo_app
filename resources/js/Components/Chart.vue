<template>
    <div>
        <canvas id="timelog-chart"></canvas>
    </div>
</template>

<script>
import Chart from 'chart.js'

export default {
    name: 'Chart',
    data() {
        return {
            chartData: {
                type: "line",
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: "Hours",
                            data: [],
                            backgroundColor: "",
                            borderColor: "",
                            borderWidth: 3
                        },
                    ]
                },
                options: {
                    responsive: true,
                    lineTension: 1,
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true,
                                    padding: 25
                                }
                            }
                        ]
                    }
                }
            },
        }
    },
    props: {
      data:Object
    },
    mounted() {
        // chart colors
        const color = '#' + Math.floor(Math.random()*16777215).toString(16);
        this.chartData.data.datasets[0].borderColor = color;
        this.chartData.data.datasets[0].backgroundColor = color + '80';

        this.data.forEach(log => {
            this.chartData.data.labels.push(log.create_date)
            this.chartData.data.datasets[0].data.push(Math.round((log.seconds_on_day / 3600) * 100) / 100)
        })
        const ctx = document.getElementById('timelog-chart');
        new Chart(ctx, this.chartData);
    }
}
</script>
