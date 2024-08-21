/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

/* global moment:false, Chart:false, Sparkline:false */

$(function() {
    'use strict'
    //gender chart
    var genderChartCanvas = $('#gender-chart-canvas').get(0).getContext('2d')
    var genderData = {
        labels: [
            'Male',
            'Female',
            'Other'
        ],
        datasets: [{
            data: [total_male, total_female, total_other],
            backgroundColor: ['#f56954', '#00a65a', '#f39c12']
        }]
    }
    var genderOptions = {
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
    var genderpieChart = new Chart(genderChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'pie',
        data: genderData,
        options: genderOptions
    })

      

    

})
