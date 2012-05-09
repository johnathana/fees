<!DOCTYPE html> 
<html> 
<head>
	<?php
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
	?>
	
	<link type="text/css" href="../jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css" rel="Stylesheet" />
	<script type="text/javascript" src="../jquery-validation-1.8.0/jquery.validate.min.js"></script>
	<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('input[name=application]').click(function()
		{
			window.location.href="/student/application_form.php";
		});
		$('input[name=overview]').click(function()
		{
			window.location.href="/student/my_applications.php";
		});
    }); 
	</script>
</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');?>

	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<div id="container">
			<h3 style="text-align:center; line-height:58px; font-size:18px">Κεντρικό μενού φοιτητή </h3>
			<table align="center">
				<tr><td><input style="width:130px; height:35px;" class="button" type="button" name="application" value="Αίτηση για παροχή" /></td></tr>
				<tr><td><input style="width:130px; height:35px;" class="button" type="button" name="overview" value="Επισκόπηση αιτήσεων" /></td></tr>		
			</table>
		</div>
		
		
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

