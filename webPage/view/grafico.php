<?php 
require_once '../controller/getTemperature.php';
?>
<!DOCTYPE html>
<html>
<head>
<script src="../js/Chart.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
#canvas-container {
   width: 100%;
   text-align:center;
}
</style>
</head>
<body>
<div align="center"><h2>My room temperature by Arduino<h2></div>
<div id="canvas-container">
<canvas id="myChart" height=110 align="center"></canvas>
</div>
<script>
function drawGraph() {
// Define the data to show in the graph
var data = { 
labels: [<?php echo '"'.$labels_x.'"'; ?>],
datasets: [{ 
			label: "Temperature", 
			fillColor: "rgba(99,240,220,0.2)", 
			strokeColor: "rgba(99,240,220,1)", 
			pointColor: "rgba(99,240,220,1)", 
			pointStrokeColor: "#fff", 
			pointHighlightFill: "#fff", 
			pointHighlightStroke: "rgba(220,220,220,1)", 
			data: [<?php echo $values_y; ?>]
		  }] 
}; 
// Get the Canvas 2D context in which to display the graph
var ctx = $("#myChart").get(0).getContext("2d");
// Create the graph and displays the data
var myLineChart = new Chart(ctx).Line(data, { animation: true,                    // Boolean - Whether to animate the chart
											  pointDot : false,					  // Boolean - Whether to show a dot for each point
											  responsive: true,					  // Boolean - whether or not the chart should be responsive and resize when the browser does.
											  scaleShowVerticalLines: false,	  // Boolean - Whether to show vertical lines (except Y axis)
											  scaleShowHorizontalLines: false,	  // Boolean - Whether to show horizontal lines (except X axis)
											  scaleIntegersOnly: true, 			  // Boolean - Whether the scale should stick to integers, not floats even if drawing space is there
											  showXLabels: 20, 					  // Number - n° label of the axis x to show on the graph
											  bezierCurve : true,				  // Boolean - Whether the line is curved between points
											  bezierCurveTension : 0.4,			  // Number - Tension of the bezier curve between points
											}); 
}
drawGraph();
// setInterval(drawGraph,5000);
</script>
</body>
</html>

