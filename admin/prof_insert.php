<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/jFormer/jformer.php');
	    require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connection.php');
        require 'admins_form.libs.php'; 		
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
		function get_errors($form_data,$rules){
		//returns an array of errors
		$errors=array();

		//validate each existing input
		foreach($form_data as $name=>$value){
			if(!isset($rules[$name]))continue;
			$hname=htmlspecialchars($name);
			$rule=$rules[$name];

			//make sure that 'required' values are set
			if(isset($rule['required']) && $rule['required'] && !$value)
			$errors[]='Field '.$hname.' is required.';

			$rules[$name]['found']=true;
		}
		//check for missing inputs
		foreach($rules as $name=>$values){
			if(!isset($values['found']) && isset($values['required']) && $values['required'])
			$errors[]='Field '.htmlspecialchars($name).' is required.';
		}
		//return array of errors
		return $errors;
	}
	
	$errors=get_errors($_POST,$newprof_form_rules);
	
	if(count($errors)){
	echo '<strong>Λάθη που βρέθηκαν στη φόρμα:</strong><ul><li>';
	echo join('</li><li>',$errors);
	echo '</li></ul><p>Διορθώστε τα λάθη και κάντε καταχώρηση!</p>';
	echo '<a href="prof_form_processing.php">Επιστροφή στην οθόνη διαχείρισης καθηγητών</a>';
	}
		else
		{
		$surname = trim($_POST['surname']);
		$name = trim($_POST['name']);
		$email = trim($_POST['email']);
		$passwd = trim($_POST['passwd']);
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
		 global $con;
		 $query_mail = "select * from users where email = '$email'";
	     $result_query_mail = mysql_query($query_mail, $con);
	     $row_mail = mysql_fetch_assoc($result_query_mail) ;
		 
		 if (empty($row_mail)) 
	 {
	    	$query = "INSERT INTO users (surname, name, email, passwd, is_admin, phone, sex, cv) VALUES ('$surname','$name','$email', sha('$passwd'),'2','$phone','$sex','$cv')";
			$result_set = mysql_query($query,$con);
			confirm_query($result_set);
			echo "Επιτυχής δημιουργία λογαριασμού";
			?><p>Πατήστε <a href="admin_menu.php">εδώ</a> για επιστροφή στην κεντρική σελίδα των διαχειριστών</p> <?php
		}
		
		else
		{
		   echo "Το email ανήκει σε υπάρχον λογαριασμό";
		   ?><p>Πατήστε <a href="process_new_prof.php">εδώ</a> για διόρθωση των στοιχείων</p> <?php
	    } 
		
	 }
	}
		?>
		<?php mysql_close($con); ?>

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 