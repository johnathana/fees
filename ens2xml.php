<?php
//Author: johnathana Copyrights@2012

date_default_timezone_set('UTC');
header("Content-Type: text/xml;");

/*
* Function to turn a mysql datetime (YYYY-MM-DD HH:MM:SS) into a unix timestamp
* @param str
* The string to be formatted
*/
function convert_datetime($str, $hours)
{
        list($date, $time) = explode(' ', $str);
        list($year, $month, $day) = explode('-', $date);
        list($hour, $minute, $second) = explode(':', $time);

        $timestamp = mktime($hour + $hours, $minute, $second, $month, $day, $year) * 1000;
        //return 'Date.UTC('.$year.', '.($month - 1).', '.$day.', '.$hour.', '.$minute.')';
        return $timestamp;
}



$latlon = explode(",", $_GET['latlon']);

$lat = $latlon[0];
$lon = $latlon[1];



$link = mysql_connect('localhost', 'johnathana', '');
if (!$link) {
	die('Could not connect: ' . mysql_error());
}

if (!mysql_select_db('test', $link)) {
	echo 'Could not select database';
	exit;
}

$members = array(avg, c00, spr, p01, p02, p03, p04, p05, p06, p07, p08, p09, p10, p11, p12, p13, p14, p15, p16, p17, p18, p19, p20);

echo "<GFS>\n";
//echo "<lines>\n";

foreach ($members as &$member) {

	$sql = 'select * from ens2012012006'.$member.' where lat = '.$lat.' and lon = '.$lon;

	$result = mysql_query($sql, $link);

	if ( !$result ) {
		echo "DB Error, could not query the database\n";
		echo 'MySQL Error: ' . mysql_error();
		exit;
	}

	while ($row = mysql_fetch_assoc($result)) {
		echo "<".$member.">\n";
		echo "\t<DateTime>".$row['vt']."</DateTime>\n";
		echo "\t<Timestamp>".convert_datetime($row['vt'])."</Timestamp>\n";
		echo "\t<TMP_500>".$row['TMP_500']."</TMP_500>\n";
		echo "\t<TMP_850>".$row['TMP_850']."</TMP_850>\n";
		echo "\t<APCP_0> ".$row['APCP_0']."</APCP_0>\n";
		echo "</".$member.">\n";
	}
}

//echo "</lines>";
echo "</GFS>\n";
?>
