<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connection.php');
    //This file is the place to store all basic functions
	function confirm_query($result_set)
	{
		if (!$result_set)
		{
			die("Database query failed: ". mysql_error());
		}
	}


	function get_workoffer_list($email, $personal, $current)
	{
		global $con;

		$query = "select * from work_offers where 1=1 ";

		if ($personal)
			$query .= " and professor_email = '$email' ";

		if ($current)
			$query .= " and now() between start_date and end_date ";
		else
			$query .= " and end_date < now() ";


		$result_set = mysql_query($query, $con);
		confirm_query($result_set);
		return $result_set;
	}


	function get_admin_data($choice)
	{
	//To 111 simainei egkekrimenes-trexon etos-energes
	//To 212 simainei oloi oi pros egkrisi-trexon etos-anenerges
		global $con;
		$row = get_current_year();//pernei to id tou current year
		$current_year = $row['id'];

		switch ($choice) {
			case"211":
				$query1 = "SELECT * FROM work_offers WHERE published = false AND academic_year_id = '$current_year' AND has_expired = false";
				$result_set1 = mysql_query($query1,$con);
				confirm_query($result_set1);
				return $result_set1;
			break;
			case"221":
				$query1 = "SELECT * FROM work_offers WHERE published = false AND academic_year_id <> '$current_year' AND has_expired = false";
				$result_set1 = mysql_query($query1,$con);
				confirm_query($result_set1);
				return $result_set1;
			break;
			case"212":
				$query1 = "SELECT * FROM work_offers WHERE published = false AND academic_year_id = '$current_year' AND has_expired = true";
				$result_set1 = mysql_query($query1,$con);
				confirm_query($result_set1);
				return $result_set1;
			break;
			case"222":
				$query1 = "SELECT * FROM work_offers WHERE published = false AND academic_year_id <> '$current_year' AND has_expired = true";
				$result_set1 = mysql_query($query1,$con);
				confirm_query($result_set1);
				return $result_set1;
			break;
			case"112":
				$query1 = "SELECT * FROM work_offers WHERE published = true AND academic_year_id = '$current_year' AND has_expired = true";
				$result_set1 = mysql_query($query1,$con);
				confirm_query($result_set1);
				return $result_set1;
			break;
			case"121":
				$query1 = "SELECT * FROM work_offers WHERE published = true AND academic_year_id <> '$current_year' AND has_expired = false";
				$result_set1 = mysql_query($query1,$con);
				confirm_query($result_set1);
				return $result_set1;
			break;
			case"122":
				$query1 = "SELECT * FROM work_offers WHERE published = true AND academic_year_id <> '$current_year' AND has_expired = true";
				$result_set1 = mysql_query($query1,$con);
				confirm_query($result_set1);
				return $result_set1;
			break;
			default:
				$query1 = "SELECT * FROM work_offers WHERE published = true AND academic_year_id = '$current_year' AND has_expired = false";
				$result_set1 = mysql_query($query1,$con);
				confirm_query($result_set1);
				return $result_set1;
		}
	}

?>
