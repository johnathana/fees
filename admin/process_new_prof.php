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
	<link type="text/css" href="jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css" rel="Stylesheet" />
	<script type="text/javascript" src="jquery-validation-1.8.0/jquery.validate.min.js"></script>
<script>
		$(document).ready(function(){
		$('#myNewProfForm').validate({
				'rules':{
						'surname':'required',
						'name':'required',
						'email':'required',
						'passwd':'required',
						'phone':'required',
						}
						});
						});
		$(function() {
			$( "#deadline" ).datepicker({ dateFormat: 'yy-mm-dd' });
		});
		function redirect_menu()
		{
			window.location.href = "/admin/prof_form_processing.php";
		}
		function redirect_menu()
		{
			window.location.href = "/admin/prof_form_processing.php";
		}
	</script>
</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">
     								
					<h3>Δημιουργία νέου λογαριασμού καθηγητή </h3>
					<form id="myNewProfForm" action="prof_insert.php" method="post">
					<table>
						<tr>
							<td>Επώνυμο </td><td><input type="text" name="surname" size="40" /></td>
						</tr>
						<tr>
							<td>Όνομα </td><td><input type="text" name="name" size="40" /></td>
						</tr>
						<tr>
							<td>E-mail </td><td><input type="text" name="email" size="40" /></td>
						</tr>
						<tr>
							<td>Κωδικός Πρόσβασης </td><td><input type="text" name="passwd" size="40" /></td>
						</tr>
						<tr>
							<td>Τηλέφωνο </td><td><input type="text" name="phone" size="40" /></td>
						</tr>
						<tr>
							<td>Φύλλο </td><td><select name="sex">
							  <option value="0">Άρεν</option>
							  <option value="1">Θήλυ</option>
							</select></td>
						</tr>
						<tr>
							<td>Πληροφορίες </td><td><textarea " name="cv" cols="40" rows="4" /></textarea></td>
						</tr>
						</table>
						<br>
						<p><input class="button" type="button" id="edit_btn" onClick="redirect_menu();" value="Ακύρωση" />
						<input class="button" type="submit" name="submit" value="Καταχώρηση" /></p>
						</br>
					
					</form>  

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html>