<?php

define("FAKE_AUTH", 1);

if (FAKE_AUTH)
	include_once('includes/fake_auth.php');
else
	include_once('includes/cas_auth.php');

?>
