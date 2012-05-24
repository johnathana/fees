<!DOCTYPE html> 
<html> 
<head>
	<?php
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	?>

	<link type="text/css" href="../jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css" rel="Stylesheet" />
	<script type="text/javascript" src="../jquery-validation-1.8.0/jquery.validate.min.js"></script>
	<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('input[name=assign_hours]').click(function()
		{
			window.location.href="/secretariat/assign_hours.php";
		});
		$('input[name=view_hours]').click(function()
		{
			window.location.href="/secretariat/view_hours.php";
		});
    }); 
	</script>
</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>

	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<div id="container">
			<h3 style="text-align:center; line-height:58px; font-size:18px">Κεντρικό Μενού Γραμματείας </h3>
			<table align="center">
				<tr><td><input style="width:130px; height:35px;" class="button" type="button" name="assign_hours" value="Ανάθεση Ωρών" /></td></tr>
				<tr><td><input style="width:130px; height:35px;" class="button" type="button" name="view_hours" value="Αναγνωρισμένες Ώρες" /></td></tr>
			</table>
		</div>
		
		
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

