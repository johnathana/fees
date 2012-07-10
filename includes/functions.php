<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connection.php');

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
			$query .= " and now() <= end_date ";
		else
			$query .= " and end_date < now() ";


		$result_set = mysql_query($query, $con);
		confirm_query($result_set);
		return $result_set;
	}


	function get_admin_workoffer_list($email, $pending, $current)
	{
		global $con;

		$query = "select * from work_offers where 1=1 ";

		if ($pending)
			$query .= " and published = false ";
		else
			$query .= " and published = true ";

		if ($current)
			$query .= " and now() <= end_date ";
		else
			$query .= " and end_date < now() ";


		$result_set = mysql_query($query, $con);
		confirm_query($result_set);
		return $result_set;
	}
?>
