
<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php');
	global $auth;
?>

<div class="content promos"> 
	<div class="grid3col">
		<div class="column first" style="width: 150px">
			<a href="/account.php"><?php echo $auth->email;?></a>
		</div>
		<div class="column last" style="width: 100px">
			<a href="/logout.php">Αποσύνδεση</a>
		</div>
	</div>
</div>
