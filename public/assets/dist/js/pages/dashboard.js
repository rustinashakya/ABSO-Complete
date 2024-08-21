$(function() {
    'use strict'
    // World map by jvectormap
    $('#world-map').vectorMap({
        map: 'world_en',
        backgroundColor: 'transparent',
        regionStyle: {
            initial: {
                fill: 'rgba(255, 255, 255, 0.7)',
                'fill-opacity': 1,
                stroke: 'rgba(0,0,0,.2)',
                'stroke-width': 1,
                'stroke-opacity': 1
            }
        },
        selectedRegions: newMapData,
    })

    //weeekly line chart
    var weeklyChartCanvas = document.getElementById('weekly-chart-canvas').getContext('2d');

    var weeklyChartData = {
        labels: [labels_day_1, labels_day_2, labels_day_3, labels_day_4, labels_day_5, labels_day_6, labels_day_7],
        datasets: [{
            label: 'Grievance',
            backgroundColor: 'rgba(210, 214, 222, 1)',
            borderColor: 'rgba(210, 214, 222, 1)',
            pointBackgroundColor: '#999',
            data: [data_day_1, data_day_2, data_day_3, data_day_4, data_day_5, data_day_6, data_day_7]
        }]
    }
    var weeklyChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false
                }
            }],
            yAxes: [{
                gridLines: {
                    display: false
                }
            }]
        }
    }
    var weeklyChart = new Chart(weeklyChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'line',
        data: weeklyChartData,
        options: weeklyChartOptions
    })

    // yearly chart
    var yearlyChartCanvas = $('#yearly-chart-canvas').get(0).getContext('2d')
    var yearlyData = {
        labels: [labels_fiscalyear_month_1, labels_fiscalyear_month_2, labels_fiscalyear_month_3, labels_fiscalyear_month_4, labels_fiscalyear_month_5, labels_fiscalyear_month_6, labels_fiscalyear_month_7, labels_fiscalyear_month_8, labels_fiscalyear_month_9, labels_fiscalyear_month_10, labels_fiscalyear_month_11, labels_fiscalyear_month_12 ],
        datasets: [{
            data: [data_fiscalyear_month_1, data_fiscalyear_month_2, data_fiscalyear_month_3, data_fiscalyear_month_4, data_fiscalyear_month_5, data_fiscalyear_month_6, data_fiscalyear_month_7, data_fiscalyear_month_8, data_fiscalyear_month_9, data_fiscalyear_month_10, data_fiscalyear_month_11, data_fiscalyear_month_12],
            // backgroundColor: ['#f56954', '#00a65a', '#f39c12']
            pointBackgroundColor: '#999',
        }]
    }
    var yearlyOptions = {
        title: {
            display: false,
        },
        legend: {
            display: false,
        },
        maintainAspectRatio: false,
        responsive: true
    }
    var yearlyChart = new Chart(yearlyChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'line',
        data: yearlyData,
        options: yearlyOptions
    })

     //cases by condition 
     var caseConditionChartCanvas = $('#caseconditionpie').get(0).getContext('2d')
     var caseConditionData = {
         labels: [
             'Solved',
             'Unsolved'
         ],
         datasets: [{
             data: [total_sloved_cases, total_new_cases],
             backgroundColor: ['#00a65a', '#f56954']
         }]
     }

     var caseConditionOption = {
         legend: {
             display: true,
             labels: {
                 fontColor: '#000',
                 generateLabels: (chart) => {
                     const datasets = chart.data.datasets;
                     return datasets[0].data.map((data, i) => ({
                     text: `${chart.data.labels[i]} : ${data}`,
                     fillStyle: datasets[0].backgroundColor[i],
                     }))
                 }
             }
         },
         maintainAspectRatio: false,
         responsive: true,
         plugins: {
             labels: {
                 render: 'value',
                 fontColor: '#fff',
                 precision: 2
             }
         },
     }
   
     var caseConditionChart = new Chart(caseConditionChartCanvas, { // lgtm[js/unused-local-variable]
         type: 'pie',
         data: caseConditionData,
         options: caseConditionOption
     })





})
