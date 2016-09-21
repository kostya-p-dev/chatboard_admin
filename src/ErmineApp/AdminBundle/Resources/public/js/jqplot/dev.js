

/* ROW 1-left */
$(document).ready(function () {
    var s1 = [[2002, 112000], [2003, 122000], [2004, 104000], [2005, 99000], [2006, 121000],
        [2007, 148000], [2008, 114000], [2009, 133000], [2010, 161000], [2011, 173000]];
    var s2 = [[2002, 10200], [2003, 10800], [2004, 11200], [2005, 11800], [2006, 12400],
        [2007, 12800], [2008, 13200], [2009, 12600], [2010, 13100]];

    plot1 = $.jqplot("chart1", [s2, s1], {
        // Turns on animatino for all series in this plot.
        animate: true,
        seriesColors:[ '#00ADD8'],
        seriesDefaults:{
            rendererOptions: {
                // Set varyBarColor to tru to use the custom colors on the bars.
                varyBarColor: true
            }
        },
        // Will animate plot on calls to plot1.replot({resetAxes:true})
        animateReplot: true,
        cursor: {
            show: true,
            zoom: true,
            looseZoom: true,
            showTooltip: false
        },
        series:[
            {
                pointLabels: {
                    show: true
                },
                renderer: $.jqplot.BarRenderer,
                showHighlight: false,
                yaxis: 'y2axis',
                rendererOptions: {
                    // Speed up the animation a little bit.
                    // This is a number of milliseconds.
                    // Default for bar series is 3000.
                    animation: {
                        speed: 2500
                    },
                    barWidth: 15,
                    barPadding: -15,
                    barMargin: 0,
                    highlightMouseOver: false
                }
            },
            {
                rendererOptions: {
                    // speed up the animation a little bit.
                    // This is a number of milliseconds.
                    // Default for a line series is 2500.
                    animation: {
                        speed: 2000
                    }
                }
            }
        ],
        axesDefaults: {
            pad: 0
        },
        axes: {
            // These options will set up the x axis like a category axis.
            xaxis: {
                tickInterval: 1,
                drawMajorGridlines: false,
                drawMinorGridlines: true,
                drawMajorTickMarks: false,
                rendererOptions: {
                    tickInset: 0.5,
                    minorTicks: 1
                }
            },
            yaxis: {
                tickOptions: {
                    formatString: "$%'d"
                },
                rendererOptions: {
                    forceTickAt0: true
                }
            },
            y2axis: {
                tickOptions: {
                    formatString: "$%'d"
                },
                rendererOptions: {
                    // align the ticks on the y2 axis with the y axis.
                    alignTicks: true,
                    forceTickAt0: true
                }
            }
        },
        highlighter: {
            show: true,
            showLabel: true,
            tooltipAxes: 'y',
            sizeAdjust: 7.5 , tooltipLocation : 'ne'
        }
    });

});

/*Row 1-right*/
$(document).ready(function(){


    /* USERS */

    $.jqplot.config.enablePlugins = true;
    var s1 = ['', 22, 6];
    var ticks = ['', 'Total', 'Online', ''];

    plot1 = $.jqplot('chart2', [s1], {
        // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
        animate: !$.jqplot.use_excanvas,
        seriesColors:['#DD4B39', '#C74433'],
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            pointLabels: { show: true },
            rendererOptions: {
                // Set varyBarColor to tru to use the custom colors on the bars.
                varyBarColor: true
            }
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            }
        },
        highlighter: { show: false }
    });


    /* ACTIVITIES */

    $.jqplot.config.enablePlugins = true;
    var s1 = ['', 800, 200];
    var ticks = ['', 'Total', 'Active', ''];

    plot1 = $.jqplot('chart3', [s1], {
        // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
        animate: !$.jqplot.use_excanvas,
        seriesColors:['#00A65A', '#009651'],
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            pointLabels: { show: true },
            rendererOptions: {
                // Set varyBarColor to tru to use the custom colors on the bars.
                varyBarColor: true
            }
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            }
        },
        highlighter: { show: false }
    });

    /* INTERESTS */

    $.jqplot.config.enablePlugins = true;
    var s1 = ['', 2700, 1600];
    var ticks = ['', 'Total', 'Public', ''];

    plot1 = $.jqplot('chart4', [s1], {
        // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
        animate: !$.jqplot.use_excanvas,
        seriesColors:['#F39C12', '#DB8D10'],
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            pointLabels: { show: true },
            rendererOptions: {
                // Set varyBarColor to tru to use the custom colors on the bars.
                varyBarColor: true
            }
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            }
        },
        highlighter: { show: false }
    });

});