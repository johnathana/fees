<!DOCTYPE html> 
<html> 
<head>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php');
     require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php');?>
	<link type="text/css" href="../jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css" rel="Stylesheet" />
	<script type="text/javascript" src="../jquery-validation-1.8.0/jquery.validate.min.js"></script>
	<script>
		$(document).ready(function(){
		$('#myMailForm').validate({
				'rules':{
				        'receivers':'required',
						'mail_subject':'required',
						'mail_contents':'required',
						}
						});
						});
		$(function() {
			$( "#deadline" ).datepicker({ dateFormat: 'yy-mm-dd' });
		});
		function redirect_menu()
		{
			window.location.href = "/admin/admin_menu.php";
		}
	</script>
</head>

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">

		<div id="container">
			<div class="full_width big">
				<h2>Αποστολή ενημερωτικών e-mail</h2>
			</div>

		<form id="myMailForm" action="mail_form_processing.php" method="post">
		<table>	    
			<tr>
				<td>ΠΡΟΣ</td><td> <select name="receivers">
				  <option value="1">Όλους τους εγγεγραμένους χρήστες</option>
				  <option value="2">Διδάσκοντες</option>
				  <option value="3">Φοιτητές</option>
				  <option value="4">Διαχειριστές Συστήματος</option>
				</select></td>
			</tr>
			<tr>
				<td>Θέμα</td><td><input type="text" name="mail_subject" size="80"/></td>
			</tr>
			<tr>
				<td>Κείμενο Περιεχομένου</td><td> <textarea name="mail_contents" cols="80" rows="6"></textarea></td>
			</tr>
			</table>
			<br>
			<input class="button" type="button" id="edit_btn" onClick="redirect_menu();" value="Ακύρωση" />
			<td align="center"><input class="button" type="submit" name="sent_mail" value="Αποστολή"/></td>
			</br>
		
		</form>
		
		</div>
	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

 
</html>