<?php  
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	 ?>
<?php

	if(isset($_POST['id']))
	{
		$workapp_id = $_POST['id'];
		$query = "UPDATE work_applications SET accepted = '0' WHERE id='$workapp_id'";
		$result_set = mysql_query($query,$con);
		confirm_query($result_set);
		if(mysql_affected_rows() > 0)
		{
			$query1 = "SELECT work_id FROM work_applications WHERE id='$workapp_id'";
			$result_set1 = mysql_query($query1,$con);
			confirm_query($result_set1);
			$row1 = mysql_fetch_assoc($result_set1);
			$work_id = $row1['work_id'];
			$query2 = "SELECT candidates FROM work_offers WHERE id='$work_id'";
			$result_set2 = mysql_query($query2,$con);
			confirm_query($result_set2);
			$row2 = mysql_fetch_assoc($result_set2);
			$max_candidates = $row2['candidates'];
			$query3 = "SELECT * FROM work_applications WHERE work_id = '$work_id' AND accepted = '1'";
			$workapps = mysql_query($query3,$con);
			confirm_query($workapps);
			if (mysql_num_rows($workapps) < $max_candidates)
			{
				$que = "UPDATE work_offers SET is_available = '1' WHERE id='$work_id'";
				$result_set4 = mysql_query($que,$con);
				confirm_query($result_set4);
			}
			echo "Ακυρώθηκε η ανάθεση \n";
			echo "O πίνακας αιτήσεων θα ανανεωθεί.";
		}
		else
		{
			echo "Δεν μπήκε στο mysql_affected_rows.";
		}
	}
?>