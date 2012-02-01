<?php
    
	
		/*Βρίσκει τα emails όλων των χρηστών*/
		function select_all_users_mail()
	{	
		global $con;
		$query_all_mail = "SELECT DISTINCT email FROM users";
		$result_all_mail = mysql_query($query_all_mail,$con);
		confirm_query($result_all_mail);
		$all_mail = Array();
		while ($row = mysql_fetch_array($result_all_mail, MYSQL_ASSOC)) {
        $all_mail[] =  $row['email'];  
        }
        //$all_mail = mysql_fetch_row($result_all_mail);  
		return $all_mail;
	
	}
	
	/*Βρίσκει τα emails όλων των καθηγητών*/
		function select_all_professors_mail()
	{	
		global $con;
		$query_all_prof_mail = "SELECT DISTINCT email FROM users where is_admin='2'";
		$result_all_prof_mail = mysql_query($query_all_prof_mail,$con);
		confirm_query($result_all_prof_mail);
		$all_prof_mail = Array();
		while ($row = mysql_fetch_array($result_all_prof_mail, MYSQL_ASSOC)) {
        $all_prof_mail[] =  $row['email'];  
        }
        //$all_mail = mysql_fetch_row($result_all_mail);  
		return $all_prof_mail;
	
	}
	
	/*Βρίσκει τα emails όλων των φοιτητών*/
		function select_all_students_mail()
	{	
		global $con;
		$query_all_stud_mail = "SELECT DISTINCT email FROM users where is_admin='0'";
		$result_all_stud_mail = mysql_query($query_all_stud_mail,$con);
		confirm_query($result_all_stud_mail);
		$all_stud_mail = Array();
		while ($row = mysql_fetch_array($result_all_stud_mail, MYSQL_ASSOC)) {
        $all_stud_mail[] =  $row['email'];  
        }
        //$all_mail = mysql_fetch_row($result_all_mail);  
		return $all_stud_mail;
	
	}
	
	/*Βρίσκει τα emails όλων των διαχειριστών*/
		function select_all_admins_mail()
	{	
		global $con;
		$query_all_admins_mail = "SELECT DISTINCT email FROM users where is_admin='1'";
		$result_all_admins_mail = mysql_query($query_all_admins_mail,$con);
		confirm_query($result_all_admins_mail);
		$all_admins_mail = Array();
		while ($row = mysql_fetch_array($result_all_admins_mail, MYSQL_ASSOC)) {
        $all_admins_mail[] =  $row['email'];  
        }
        //$all_mail = mysql_fetch_row($result_all_mail);  
		return $all_admins_mail;
	
	}
	
	function get_user_mail($user_mail)
	{
		global $con;
		$query = "SELECT * FROM users WHERE email = '$user_mail'";
		$result = mysql_query($query, $con);
		confirm_query($result);
		$user_info = mysql_fetch_assoc($result);
		return $user_mail;
	}
	
	
?>