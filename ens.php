<?php
//Author: johnathana Copyrights@2012

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', false);
date_default_timezone_set('UTC');

?>

<html>
<head>
	<title>JohNick GFS</title>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<!--    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script> -->

	<script type="text/javascript" src="./js/highcharts.js"></script>

	<script type="text/javascript">

		function loadGFS() {
			var chart;

			var avg_data = [];
			var c00_data = [];

			var members = ["avg", "c00", "spr", "p01", "p02", "p03", "p04", "p05", "p06", "p07", "p08", "p09", "p10", "p11", "p12", "p13", "p14", "p15", "p16", "p17", "p18", "p19", "p20"];

			$.ajax({
				type: "GET",
				url: "/ens2xml.php?latlon=38,24",
				dataType: "xml",
				success: function(xml) {

				for(var i in members) {

					$(xml).find(members[i]).each(function() {
						var datetime = $(this).find('DateTime').text();
						var timestamp = parseInt($(this).find('Timestamp').text());
						var temperature850 = parseFloat($(this).find('TMP_850').text(), 10);

						//avg_data.push([timestamp, temperature850]);
						c00_data.push([timestamp, temperature850]);

					});

					var temperature_options = {
						chart: {
							renderTo: 'temp',
							type: 'spline'
						},
						credits: {
							enabled: false
						},
						title: {
							text: 'Temperature'
						},
						subtitle: {
							text: 'Time in UTC'
						},
						xAxis: {
							type: 'datetime',
							dateTimeLabelFormats: {
								hour: '%H:%M<br>%e %b %y'
							}
						},
						yAxis: {
							tickInterval: 2,
							title: {
								text: "(℃)"
							}
						},
						tooltip: {
							formatter: function() {
								return Highcharts.dateFormat('%e %b %Y, %H:%M UTC', this.x) + '<br/>' + this.series.name + ':<b>'+ this.y + '℃</b>';
							}
						},
						series: [{
							name: 'avg',
							},{
							name: 'c00'
							}]
					};


					temperature_options.series[i].data = avg_data;
					chart = new Highcharts.Chart(temperature_options);
				}
				}
			});
		}
	</script>


</head>

<body onload="loadGFS()">
	<div id="temp" style="width: 700px; height: 250px; margin: 0 auto"></div>
</body>

</html>
