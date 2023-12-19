<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
<script>
    window.onload = function () {
    
    var options = {
        animationEnabled: true,
        theme: "light2",
        title:{
            text: "Actual vs Projected Sales"
        },
        axisX:{
            valueFormatString: "DD MMM"
        },
        axisY: {
            title: "Number of Sales",
            suffix: "K",
            minimum: 30
        },
        toolTip:{
            shared:true
        },  
        legend:{
            cursor:"pointer",
            verticalAlign: "bottom",
            horizontalAlign: "left",
            dockInsidePlotArea: true,
            itemclick: toogleDataSeries
        },
        data: [{
            type: "line",
            showInLegend: true,
            name: "Projected Sales",
            markerType: "square",
            xValueFormatString: "DD MMM, YYYY",
            color: "#F08080",
            yValueFormatString: "#,##0K",
            dataPoints: [
                { x: new Date(2017, 10, 1), y: 63, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 2), y: 69, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 3), y: 65, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 4), y: 70, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 5), y: 71, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 6), y: 65, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 7), y: 73, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 8), y: 96, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 9), y: 84, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 10), y: 85, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 11), y: 86, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 12), y: 94, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 13), y: 97, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 14), y: 86, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 15), y: 89, indexLabel: "61", indexLabelFontSize:"20"}
            ]
        },
        {
            type: "line",
            showInLegend: true,
            name: "Actual Sales",
            lineDashType: "dash",
            yValueFormatString: "#,##0K",
            dataPoints: [
                { x: new Date(2017, 10, 1), y: 60, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 2), y: 57, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 3), y: 51, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 4), y: 56, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 5), y: 54, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 8), y: 69, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 9), y: 65, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 10), y: 66, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 11), y: 63, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 12), y: 67, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 13), y: 66, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 14), y: 56, indexLabel: "61", indexLabelFontSize:"20"},
                { x: new Date(2017, 10, 15), y: 64, indexLabel: "61", indexLabelFontSize:"20"}
            ]
        }]
    };
    $("#chartContainer").CanvasJSChart(options);
    
    function toogleDataSeries(e){
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else{
            e.dataSeries.visible = true;
        }
        e.chart.render();
    }
    
    
    //Better to construct options first and then pass it as a parameter
    var options2 = {
        title: {
            text: "Column Chart in jQuery CanvasJS"              
        },
        data: [              
        {
            // Change type to "doughnut", "line", "splineArea", etc.
            type: "column",
            dataPoints: [
                { label: "apple",  y: 10  },
                { label: "orange", y: 15  },
                { label: "banana", y: 25  },
                { label: "mango",  y: 30  },
                { label: "grape",  y: 28  }
            ]
        }
        ]
    };
    
    $("#chartContainer2").CanvasJSChart(options2);
    
    }
    </script>
</body>
</html>