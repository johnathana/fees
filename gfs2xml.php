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

$sql = 'select * from gfs2012011406 where lat = '.$lat.' and lon = '.$lon;

$result = mysql_query($sql, $link);

if ( !$result ) {
	echo "DB Error, could not query the database\n";
	echo 'MySQL Error: ' . mysql_error();
	exit;
}

echo "<GFS>\n";
echo "<lines>";

while ($row = mysql_fetch_assoc($result)) {

// +----------+-------------+------+-----+---------+-------+
// | Field    | Type        | Null | Key | Default | Extra |
// +----------+-------------+------+-----+---------+-------+
// | rt       | datetime    | NO   |     | NULL    |       |
// | vt       | datetime    | NO   |     | NULL    |       |
// | lat      | double      | NO   | MUL | NULL    |       |
// | lon      | double      | NO   |     | NULL    |       |
// | TMP_2    | double(6,2) | YES  |     | NULL    |       |
// | TMP_925  | double(6,2) | YES  |     | NULL    |       |
// | TMP_850  | double(6,2) | YES  |     | NULL    |       |
// | TMP_700  | double(6,2) | YES  |     | NULL    |       |
// | TMP_500  | double(6,2) | YES  |     | NULL    |       |
// | HGT_0    | double(7,1) | YES  |     | NULL    |       |
// | HGT_925  | double(7,1) | YES  |     | NULL    |       |
// | HGT_850  | double(7,1) | YES  |     | NULL    |       |
// | HGT_700  | double(7,1) | YES  |     | NULL    |       |
// | HGT_500  | double(7,1) | YES  |     | NULL    |       |
// | TCDC_925 | double(5,2) | YES  |     | NULL    |       |
// | TCDC_700 | double(5,2) | YES  |     | NULL    |       |
// | TCDC_500 | double(5,2) | YES  |     | NULL    |       |
// | TCDC_0   | double(5,2) | YES  |     | NULL    |       |
// | UGRD_0   | double(6,2) | YES  |     | NULL    |       |
// | VGRD_0   | double(6,2) | YES  |     | NULL    |       |
// | RH_2     | double(6,2) | YES  |     | NULL    |       |
// | APCP_0   | double(6,2) | YES  |     | NULL    |       |
// | PRMSL_0  | double(6,1) | YES  |     | NULL    |       |
// +----------+-------------+------+-----+---------+-------+


	echo "<line>\n";
	echo "\t<DateTime>".$row['vt']."</DateTime>\n";
	echo "\t<Timestamp>".convert_datetime($row['vt'])."</Timestamp>\n";
	echo "\t<TMP_2>".$row['TMP_2']."</TMP_2>\n";
	echo "\t<TMP_850>".$row['TMP_850']."</TMP_850>\n";
	echo "\t<RH_2>".$row['RH_2']."</RH_2>\n";
	echo "\t<APCP_0> ".$row['APCP_0']."</APCP_0>\n";
	echo "\t<PRMSL_0> ".$row['PRMSL_0']."</PRMSL_0>\n";
	echo "\t<TCDC_925> ".$row['TCDC_925']."</TCDC_925>\n";
	echo "\t<TCDC_700> ".$row['TCDC_700']."</TCDC_700>\n";
	echo "\t<TCDC_500> ".$row['TCDC_500']."</TCDC_500>\n";
	echo "</line>\n";
}

echo "</lines>";
echo "</GFS>\n";
?>
