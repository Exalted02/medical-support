// bebgin line chart display
var lineChart = document.getElementById("line-chart").getContext('2d')

// line chart options
var options = {
    borderWidth: 3,
    cubicInterpolationMode: 'monotone', // make the line curvy over zigzag
    pointRadius: 0,
    pointHoverRadius: 5,
    pointHoverBackgroundColor: '#fff',
    pointHoverBorderWidth: 4
}

// create linear gradients for line chart
var gradientOne = lineChart.createLinearGradient(0,0,0,lineChart.canvas.clientHeight)
gradientOne.addColorStop(0, 'rgba(51, 169, 247, 0.3)')
gradientOne.addColorStop(1, 'rgba(0, 0, 0, 0)')

var gradientTwo = lineChart.createLinearGradient(0,0,0,lineChart.canvas.clientHeight)
gradientTwo.addColorStop(0, 'rgba(195, 113, 239, 0.15)')
gradientTwo.addColorStop(1, 'rgba(0, 0, 0, 0)')


new Chart(
    lineChart,
    {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                
                {
                    label: 'Spending',
                    data: [12,48,35,38,40,60,35,20,15,32,22,10],
                    ...options,
                    borderColor: '#191970',
                    fill: 'start',
                    backgroundColor: 'transparent'
                },
                {
                    label: 'Emergency',
                    data: [7,22,60,35,16,24,48,36,55,22,32,38],
                    ...options,
                    borderstyle: 'Dashed',
                    borderColor: '#4CAF5026',
                    fill: 'start',
                    backgroundColor: 'transparent'
                }
            ]
        },
        options: {
            plugins: {
                legend: {
                    display: false, // hide display data about the dataset
                },
                tooltip: { // modify graph tooltip
                    backgroundColor: 'rgba(53, 27, 92, 0.8)',
                    caretPadding: 5,
                    boxWidth: 5,
                    usePointStyle: 'triangle',
                    boxPadding: 1
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false // set display to false to hide the x-axis grid
                    },
                    beginAtZero: true
                },
                y: {
                    ticks: {
                        callback: function(value, index, values) {
                            return '' + value // prefix '$' to the dataset values
                        },
                        stepSize: 10
                    }
                }
            }
        }
    }
)







// bebgin line chart display
var lineChart = document.getElementById("line-chart-2").getContext('2d')

// line chart options
var options = {
    borderWidth: 3,
    cubicInterpolationMode: 'monotone', // make the line curvy over zigzag
    pointRadius: 0,
    pointHoverRadius: 5,
    pointHoverBackgroundColor: '#fff',
    pointHoverBorderWidth: 4
}

// create linear gradients for line chart
var gradientOne = lineChart.createLinearGradient(0,0,0,lineChart.canvas.clientHeight)
gradientOne.addColorStop(0, 'rgba(51, 169, 247, 0.3)')
gradientOne.addColorStop(1, 'rgba(0, 0, 0, 0)')

var gradientTwo = lineChart.createLinearGradient(0,0,0,lineChart.canvas.clientHeight)
gradientTwo.addColorStop(0, 'rgba(195, 113, 239, 0.15)')
gradientTwo.addColorStop(1, 'rgba(0, 0, 0, 0)')


new Chart(
    lineChart,
    {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [
                
                {
                    label: 'Spending',
                    data: [13,31,68,23,43,51,41,100],
                    ...options,
                    borderColor: '#4CC2B0',
                    fill: 'start',
                    backgroundColor: '#4cc2b02e'
                },
                {
                    label: 'Emergency',
                    data: [21,40,26,53,21,63,80],
                    ...options,
                    borderColor: '#808080',
                    fill: 'start',
                    backgroundColor: '#8080801a'
                }
            ]
        },
        options: {
            plugins: {
                legend: {
                    display: false, // hide display data about the dataset
                },
                tooltip: { // modify graph tooltip
                    backgroundColor: 'rgba(53, 27, 92, 0.8)',
                    caretPadding: 5,
                    boxWidth: 5,
                    usePointStyle: 'triangle',
                    boxPadding: 1
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false // set display to false to hide the x-axis grid
                    },
                    beginAtZero: true
                },
                y: {
                    ticks: {
                        callback: function(value, index, values) {
                            return '' + value // prefix '$' to the dataset values
                        },
                        stepSize: 20
                    }
                }
            }
        }
    }
)



