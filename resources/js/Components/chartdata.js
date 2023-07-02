export const planetChartData = {
    type: "line",
    data: {
        labels: [1,2,3,4,5,6,7,8],
        datasets: [
            {
                label: "Hours",
                data: [1,1.2,5,1.4,2,5,4,6],
                backgroundColor: "rgba(54,73,93,.5)",
                borderColor: "#36495d",
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
};

export default planetChartData;
