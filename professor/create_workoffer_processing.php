<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
		//require 'form.libs.php'; 
	?>
	<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('input[name=menu]').click(function()
		{
			window.location.href="/admin/admin_menu.php";
		});
    }); 
	</script>
</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">

<?php /*  function get_errors($form_data,$rules){
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
	$errors=get_errors($_POST,$form_rules); */
	//if(!count($errors)){
	//save the data into the database
		$id = trim($_POST['prof_id']);
		$title = trim($_POST['title']);
		$lesson = trim($_POST['lesson']);
		$candidates = trim($_POST['candidates']);
		$requirements = trim($_POST['requirements']);
		$deliverables = trim($_POST['deliverables']);
		$hours = trim($_POST['hours']);
		$addressed = ($_POST['addressed']);
		$deadline = ($_POST['deadline']);    
		
		if (isset($_POST['at_di']))
			$at_di = ($_POST['at_di'] == "on"  ? 1 : 0);
		else
			$at_di = 0;	
		if (isset($_POST['winter'])) 
			$winter = ($_POST['winter'] == "on" ? 1 : 0);
		else 
			$winter = 0;
		
		$year = get_current_year();
		$academic_year_id = $year['id'];
		
		$sql="INSERT INTO work_offers (professor_id, title, lesson, candidates, requirements, deliverables, hours, deadline, at_di, academic_year_id, winter_semester, is_available, has_expired, addressed_for)
		VALUES
		('$id','$title','$lesson','$candidates', '$requirements','$deliverables','$hours','$deadline','$at_di','$academic_year_id','$winter',true, false,'$addressed')";
		
		$set = mysql_query($sql,$con);
		confirm_query($set);
		mysql_close($con);

	echo "<br />"."Επιτυχής καταχώρηση"."<br /><br />";?>
	<input type="button" name="menu" value="Αρχικό μενού" class="button"/>
	<?php
	//}
	/*else{
	echo '<strong>Λάθη που βρέθηκαν στη φόρμα:</strong><ul><li>';
	//echo join('</li><li>',$errors);
	echo '</li></ul><p>Διορθώστε τα λάθη και κάντε καταχώρηση!</p>';
	echo '<a href="create_workoffer.php">Επιστροφή στην αρχική φόρμα</a>';
	}*/
	?> 

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

