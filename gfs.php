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
			var temperature_chart;
			var relhum_chart;
			var pressure_chart;
			var cloud_chart;

			var temperature_data = [];
			var temperature850_data = [];
			var relhum_data = [];
			var accprecip_data = [];
			var pressure_data = [];
			var cloud_low_data = [];
			var cloud_med_data = [];
			var cloud_high_data = [];

			$.ajax({
				type: "GET",
				url: "/gfs2xml.php?latlon=38,24",
				dataType: "xml",
				success: function(xml) {
					$(xml).find('line').each(function() {
						var datetime = $(this).find('DateTime').text();
						var timestamp = parseInt($(this).find('Timestamp').text());
						var temperature = parseInt($(this).find('TMP_2').text());
						var temperature850 = parseInt($(this).find('TMP_850').text());
						var relhum = parseInt($(this).find('RH_2').text());
						var accprecip = parseFloat($(this).find('APCP_0').text(), 10);
						var pressure = parseInt($(this).find('PRMSL_0').text());

						var cloud_low = parseInt($(this).find('TCDC_925').text());
						var cloud_med = parseInt($(this).find('TCDC_700').text());
						var cloud_high = parseInt($(this).find('TCDC_500').text());


						temperature_data.push([timestamp, temperature]);
						temperature850_data.push([timestamp, temperature850]);
						relhum_data.push([timestamp, relhum]);
						accprecip_data.push([timestamp, accprecip]);
						pressure_data.push([timestamp, pressure]);

						cloud_low_data.push([timestamp, cloud_low]);
						cloud_med_data.push([timestamp, cloud_med]);
						cloud_high_data.push([timestamp, cloud_high]);
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
							name: 'Air Temperature at 2m',
							color: '#ED561B'
							},{
							name: 'Air Temperature at 850mb'
							}]
					};

					var relhum_options = {
						chart: {
							renderTo: 'relhum',
							type: 'spline'
						},
						credits: {
							enabled: false
						},
						title: {
							text: ''
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
							min: 0,
							max: 100,
							tickInterval: 10,
							title: {
								text: "(%)"
							}
						},
						tooltip: {
							formatter: function() {
								return Highcharts.dateFormat('%e %b %Y, %H:%M UTC', this.x) + '<br/>' + this.series.name + ':<b>'+ this.y + '%</b>';
							}
						},
						series: [{
							name: 'Relative Humidity'
							}]
					};

					var accprecip_options = {
						chart: {
							renderTo: 'accprecip',
							defaultSeriesType: 'column'
						},
						credits: {
							enabled: false
						},
						title: {
							text: ''
						},
						subtitle: {
							text: 'Time in UTC'
						},
						xAxis: {
							maxPadding: 0,
							type: 'datetime',
							dateTimeLabelFormats: {
								hour: '%H:%M<br>%e %b %y'
							}
						},
						yAxis: {
							min: 0,
							max: 1,
							title: {
								text: "(mm)"
							},
							dataLabels: {
								enabled: true,
								rotation: -90,
							color: '#FFFFFF',
							align: 'right',
							x: -3,
							y: 10,
							formatter: function() {
									return this.y;
								},
								style: {
									font: 'normal 13px Verdana, sans-serif'
								}
							}         
						},
						tooltip: {
							formatter: function() {
								return Highcharts.dateFormat('%e %b %Y, %H:%M UTC', this.x) + '<br/>' + this.series.name + ':<b>'+ this.y + 'mm</b>';
							}
						},
						series: [{
							name: 'Accumulative Precipitation'
							}]
					};

					var cloud_options = {
						chart: {
							renderTo: 'cloud',
							defaultSeriesType: 'column'
						},
						credits: {
							enabled: false
						},
						title: {
							text: ''
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
							min: 0,
							max: 100,
							tickInterval: 10,
							title: {
								text: "(%)"
							}
						},
						tooltip: {
							formatter: function() {
								return Highcharts.dateFormat('%e %b %Y, %H:%M UTC', this.x) + '<br/>' + this.series.name + ':<b>'+ this.y + '%</b>';
							}
						},
						series: [{
							name: 'Low clouds',
							},{
							name: 'Med clouds'
							},{
							name: 'High clouds'
							}]
					};

					var pressure_options = {
						chart: {
							renderTo: 'pressure',
							type: 'spline'
						},
						credits: {
							enabled: false
						},
						title: {
							text: ' '
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
								text: '(hPa)'
							}
						},
						tooltip: {
							formatter: function() {
								return Highcharts.dateFormat('%e %b %Y, %H:%M UTC', this.x) + '<br/>' + this.series.name + ':<b>'+ this.y + ' hPa</b>';
							}
						},
						series: [{
							name: 'Sea Level Pressure',
							color: '#50B432'
							}] 
					};

					temperature_options.series[0].data = temperature_data;
					temperature_options.series[1].data = temperature850_data;
					temperature_chart = new Highcharts.Chart(temperature_options);

					relhum_options.series[0].data = relhum_data;
					relhum_chart = new Highcharts.Chart(relhum_options);

					accprecip_options.series[0].data = accprecip_data;
					accprecip_chart = new Highcharts.Chart(accprecip_options);

					pressure_options.series[0].data = pressure_data;
					pressure_chart = new Highcharts.Chart(pressure_options);

					cloud_options.series[0].data = cloud_low_data;
					cloud_options.series[1].data = cloud_med_data;
					cloud_options.series[2].data = cloud_high_data;
					cloud_chart = new Highcharts.Chart(cloud_options);
				}
			});
		}
	</script>


</head>

<body onload="loadGFS()">
	<div id="temp" style="width: 700px; height: 250px; margin: 0 auto"></div>
	<div id="relhum" style="width: 700px; height: 250px; margin: 0 auto"></div>
	<div id="accprecip" style="width: 700px; height: 250px; margin: 0 auto"></div>
	<div id="cloud" style="width: 1000px; height: 250px; margin: 0 auto"></div>
	<div id="pressure" style="width: 700px; height: 250px; margin: 0 auto"></div>
</body>

</html>
