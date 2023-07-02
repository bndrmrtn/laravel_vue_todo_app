<template>
    <div>
        <canvas id="group-chart"></canvas>
    </div>
</template>

<script>
import Chart from 'chart.js'

export default {
    name: 'DoughnutChart',
    data() {
        return {
            chartData: {
                type: "doughnut",
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: "Groups",
                            data: [],
                            backgroundColor: [],
                            hoverOffset: 4,
                            borderColor:'#557',
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
    methods: {
        getLightColor() {
            let letters = 'BCDEF'.split('');
            let color = '#';
            for (let i = 0; i < 6; i++ ) {
                color += letters[Math.floor(Math.random() * letters.length)];
            }
            return color;
        },
        getDarkColor() {
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += Math.floor(Math.random() * 10);
            }
            return color;
        }

    },
    mounted() {
        Object.keys(this.data).forEach(key => {
            this.chartData.data.labels.push(key)
            this.chartData.data.datasets[0].data.push(this.data[key])
            this.chartData.data.datasets[0].backgroundColor.push(this.getLightColor())
        })
        const ctx = document.getElementById('group-chart');
        new Chart(ctx, this.chartData);
    }
}
</script>
