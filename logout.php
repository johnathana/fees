<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php');

	global $auth;

	if ($auth->logged) {
		$auth->logout();
	}

	header("Location: /index.php");
?>
