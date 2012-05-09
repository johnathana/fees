<?php

	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php');

	global $auth;

	switch ($auth->role) {

	case auth::Admin :
		$location = "/admin/admin_menu.php";
		break;
	case auth::Professor :
		$location = "/professor/prof_menu.php";
		break;
	case auth::Secretariat :
		$location = "/secretariat/secretariat_menu.php";
		break;
	case auth::Student :
		$location = "/student/stud_menu.php";
		break;
	}

	header("Location: $location");
?>
