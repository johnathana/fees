<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	 ?>	 
	 <style type="text/css" title="currentStyle">
		@import "dataTables/css/demo_page.css";
		@import "dataTables/css/demo_table_jui.css";
		@import "jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css";
		@import "media/css/TableTools.css";
	</style>
	<script type="text/javascript" language="javascript" src="dataTables/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="media/js/ZeroClipboard.js"></script>
	<script type="text/javascript" language="javascript" src="media/js/TableTools.min.js"></script>
	<script type="text/javascript" charset="utf-8"></script>
	
	<title>Πίνακας καθηγητών</title>
	<link type="text/css" href="jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css" rel="Stylesheet" />
	<script>
		$(function() {
		$( "#deadline" ).datepicker({ dateFormat: 'yy-mm-dd' });
		});
	</script>
</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">

		<?php 
		//echo $_POST['id'];
		$stud_id = $_POST['id'];
		$surname = trim($_POST['surname']);
		$name = trim($_POST['name']);
		$id = trim($_POST['id']);
		$email = trim($_POST['email']);
		$reg_numb = trim($_POST['reg_numb']);
		$phone = trim($_POST['phone']);
		$fyllo= trim($_POST['sex']);
		$cv = ($_POST['cv']);	
		if ($fyllo == 0)
		 { 
		 $sex = 'm';
		 } 
		 else
		 { 
		 $sex = 'f';
		 }
			
		if (isset($_POST['submit']) && $_POST['submit'] == "Καταχώρηση")
		{
			$query = "UPDATE users SET surname  = '$surname', name = '$name', email = '$email', reg_numb = '$reg_numb', phone = '$phone', sex = '$sex', cv = '$cv' where id = '$stud_id'";
			$result_set = mysql_query($query,$con);
			confirm_query($result_set);
			echo "Οι τροποποιήσεις πραγματοποιήθηκαν με επιτυχία";
			 }
			 else 
			 {
		     echo "Αποτυχία τροποποίησης χρήστη";
			 echo '<a href="/admin/student_form_processing.php">Επιστροφή στην οθόνη διαχείρισης φοιτητών</a>';
			 }
			 
		switch($auth->is_admin)
		{
			case"0":
//			echo "foithths";
			?><p>Πατήστε <a href="stud_menu.php">εδώ</a> για επιστροφή στην κεντρική σελίδα του φοιτητή</p> <?php		 		
			break;
			
			case"1":
//			echo "admin";
			?><p>Πατήστε <a href="admin_menu.php">εδώ</a> για επιστροφή στην κεντρική σελίδα των διαχειριστών</p> <?php
			break;
			
			case"2":
//			echo "professor";
			echo "Δεν έχετε δικαίωμα πρόσβασης στη σελίδα αυτή";		
			break;
		}
			
		?>
		<?php mysql_close($con); ?>

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 