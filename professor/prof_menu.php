<!DOCTYPE html> 
<html> 
<head>
	<?php
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php');
	?>

	<link type="text/css" href="../jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css" rel="Stylesheet" />
	<script type="text/javascript" src="../jquery-validation-1.8.0/jquery.validate.min.js"></script>
	<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('input[name=create]').click(function()
		{
			window.location.href="/professor/create_workoffer.php";
		});
		$('input[name=overview]').click(function()
		{
			window.location.href="/professor/workoffers_overview.php";
		});
		$('input[name=management]').click(function()
		{
			window.location.href="/professor/personal_workoffer_list.php";
		});
		$('input[name=assignhours]').click(function()
		{
			window.location.href="/professor/assign_hours.php";
		});
    }); 
	</script>
</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); ?>

	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<div id="container">
			<h3 style="text-align:center; line-height:58px; font-size:18px">Κεντρικό Μενού Διδάσκοντα </h3>
			<table align="center">
				<tr><td><input style="width:130px; height:35px;" class="button" type="button" name="create" value="Δημιουργία παροχής" /></td></tr>
				<tr><td><input style="width:130px; height:35px;" class="button" type="button" name="overview" value="Επισκόπηση παροχών" /></td></tr>
				<tr><td><input style="width:130px; height:35px;" class="button" type="button" name="management" value="Διαχείριση παροχών" /></td></tr>
				<tr><td><input style="width:130px; height:35px;" class="button" type="button" name="assignhours" value="Ανάθεση Ωρών" /></td></tr>
			</table>
		</div>
		
		
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

