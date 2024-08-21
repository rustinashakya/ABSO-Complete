/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

/* global moment:false, Chart:false, Sparkline:false */

$(function() {
    'use strict'

    var pieChartCanvas2 = $('#complaint-chart-canvas').get(0).getContext('2d')
    var pieData = {
            // labels: [
            //     'Migrant Worker',
            //     'Non-governmental organization',
            //     'Government Agency',
            //     'Family member or friend',
            //     'Trade Union',
            //     'Local Community Leader',
            //     'Other'
            // ],

            // labels: [
            //     'अरू,उल्लेख गर्नुहोस्',
            //     'श्रमिक',
            //     'परिवारको सदस्य वा साथि',
            //     'गैर-सरकारी संस्था',
            //     'श्रमिक संगठन',
            //     'सरकारी निकाय',
            //     'स्थानीय समुदायका प्रतिनिधि'
            // ],

            labels: [
                source_complaints
            ],
            datasets: [{
                data: [20, 40, 2, 20, 40, 2, 4],
                backgroundColor: ['#f56954', '#00a600', '#f39c12', '#886954', '#44a65a', '#999', '#000']
            }]
        }
        // Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        // eslint-disable-next-line no-unused-vars
    var pieChart = new Chart(pieChartCanvas2, { // lgtm[js/unused-local-variable]
        type: 'pie',
        data: pieData,
        options: pieOptions
    })

    Highcharts.chart('container', {
        accessibility: {
            point: {
                descriptionFormatter: function(point) {
                    var intersection = point.sets.join(', '),
                        name = point.name,
                        ix = point.index + 1,
                        val = point.value;
                    return ix + '. Intersection: ' + intersection + '. ' +
                        (point.sets.length > 1 ? name + '. ' : '') + 'Value ' + val + '.';
                }
            }
        },
        credits: {
            enabled: false,
        },
        series: [{
            type: 'venn',
            name: 'SUBJECT OF THE COMPLAINT',
            data: [{
                sets: ['Wages withheld'],
                value: 2
            }, {
                sets: ['Physical Abuse or Violence'],
                value: 2
            }, {
                sets: ['Underpayment of wages'],
                value: 2
            }, {
                sets: ['Wages withheld', 'Physical Abuse or Violence'],
                value: 1,
                // name: 'More expensive'
            }, {
                sets: ['Wages withheld', 'Underpayment of wages'],
                value: 1,
                // name: 'Will take time to deliver'
            }, {
                sets: ['Physical Abuse or Violence', 'Underpayment of wages'],
                value: 1,
                // name: 'Not the best quality'
            }, {
                sets: ['Physical Abuse or Violence', 'Underpayment of wages', 'Wages withheld'],
                value: 1,
                // name: 'They\'re dreaming'
            }]
        }],
        title: {
            text: ''
        }
    });

})
