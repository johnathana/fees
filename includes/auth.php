<?php

define("FAKE_AUTH", 1);

if (FAKE_AUTH)
	include_once($_SERVER['DOCUMENT_ROOT'].'/includes/fake_auth.php');
else
	include_once($_SERVER['DOCUMENT_ROOT'].'/includes/cas_auth.php');

?>
