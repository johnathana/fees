<!DOCTYPE html> 
<html> 
<head>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
	 require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); ?>
	<link type="text/css" href="../jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css" rel="Stylesheet" />
	<script type="text/javascript" src="../jquery-validation-1.8.0/jquery.validate.min.js"></script>
	<script>
		$(document).ready(function(){
			$('#myForm').validate({
				'rules':{
						'title':'required',
						'requirements':'required',
						'deliverables':'required',
						'deadline':'required',
						'hours':'required'
						}
			});
			$('input[name=menu]').click(function()
			{
				window.location.href="/admin/admin_menu.php";
			});
		});
		$(function() {
			$( "#deadline" ).datepicker({ dateFormat: 'yy-mm-dd' });
		});
	</script>
</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); ?>

	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">

		<div id="container">
			<div class="full_width big">
				<h2>Δημιουργία παροχής </h2>
			</div>
		
		<form id="myForm" action="create_workoffer_processing.php" method="post">
		<table  style="width: 800px">
			<tr>
				<td>Καθηγητής</td>
				<td>
<?php
	$disabled = '';
	
	switch ($auth->role) {
	case auth::Student :
		die("Unauthorized access");
	case auth::Professor :
		$disabled = "disabled";
		break;
	}


	
	$query = "SELECT * FROM users WHERE is_admin = ". $auth::Professor;

	$result_set = mysql_query($query, $con);
	confirm_query($result_set);
	//echo "<select name=\"prof_id\" ". $disabled. ">";?>
		<select name="prof_id">
<?php	while ($row = mysql_fetch_assoc($result_set)) {
		//if ($row['email'] == $auth->email)
			//echo "<option value=\"". $row['id']."\" selected=\"selected\">".$row['surname']."</option>";
		//else
			echo "<option value=\"". $row['id']."\">".$row['surname']."</option>";
	}
	echo "</select>";

?>
				
				
				</td>
			</tr>
			<tr>
				<td>Τίτλος παροχής</td><td><input type="text" name="title" size="40"/></td>
			</tr>
			<tr>
				<td>Τίτλος μαθήματος</td><td><input type="text" name="lesson" size="40"/></td>
			</tr>
			<tr>
				<td>Αριθμός υποψηφίων</td><td> <select name="candidates">
				  <option value="1">1</option>
				  <option value="2">2</option>
				  <option value="3">3</option>
				  <option value="4">4</option>
				</select></td>
			</tr>
			<tr>
				<td>Απευθύνεται σε φοιτητή</td><td> <select name="addressed">
				  <option value="0">Μη εργαζόμενο</option>
				  <option value="1">Μερικώς εργαζόμενο</option>
				  <option value="2">Πλήρως εργαζόμενο</option>
				</select></td>
			</tr>
			<tr>
				<td>Απαιτήσεις γνώσεων</td><td> <textarea name="requirements" cols="40" rows="3"></textarea></td>
			</tr>
			<tr>
			<td>Παραδοτέα</td><td> <textarea name="deliverables" cols="40" rows="3"></textarea></td>
			</tr>
			<tr>
			<td>Απαιτούμενες ώρες υλοποίησης</td><td> <input type="text" name="hours" size="10"/></td>
			</tr>
			<tr>
			<td>Στο χώρο του di</td><td> <input type="checkbox" name="at_di" /></td>
			</tr>
			<tr>
			<td>Χειμερινού εξαμήνου</td><td> <input type="checkbox" name="winter"   /></td>
			</tr>
			<tr>
			<td>Ημερομηνία λήξης</td><td><p><input id="deadline" name="deadline" type="text"></p></td>
			</tr>
			</table>
			<br />
			<?php switch ($auth->is_admin) {
				case auth::Admin :?>
					<p><input type="button" id="admin" name="menu" value="Αρχικό μενού" class="button"/>
					<input type="submit" name="submit" value="Καταχώρηση" class="button"/></p>
			<?php	break;
				case auth::Professor :?>
					<p><input type="button" id="prof" name="menu" value="Αρχικό μενού" class="button"/>
					<input type="submit" name="submit" value="Καταχώρηση" class="button"/></p>
			<?php	break;
				}?>
		
		</form>

	</div>
	</aside> 
	</div><!--/content--> 


	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 


