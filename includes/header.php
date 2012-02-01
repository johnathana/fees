	<article id="main" class="content"> 
		<header id="pageheader"> 
			<h1>Ηλεκτρονική Πλατφόρμα Διαχείρισης Παροχών</h1>
		</header>
	</article><!--/main--> 

<?php
	global $auth;

	if (isset($auth) && $auth->logged) {
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/menu.php');
	}
?>
