/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

/* global moment:false, Chart:false, Sparkline:false */

$(function() {
    'use strict'
    var newMapData = ['us', 'ru', 'fr', 'br', 'au', 'np', 'in']
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

    var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d');
    var salesChartData = {
        labels: [labels_day_1, labels_day_2, labels_day_3, labels_day_4, labels_day_5, labels_day_6, labels_day_7],
        datasets: [{
            label: 'Grievance',
            backgroundColor: 'rgba(210, 214, 222, 1)',
            borderColor: 'rgba(210, 214, 222, 1)',
            pointBackgroundColor: '#999',
            data: [data_day_1, data_day_2, data_day_3, data_day_4, data_day_5, data_day_6, data_day_7]
        }]
    }

    var salesChartOptions = {
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

    // This will get the first returned node in the jQuery collection.
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart(salesChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'line',
        data: salesChartData,
        options: salesChartOptions
    })
})