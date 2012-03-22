<?php

include_once('includes/CAS.php');


class auth {

	const Student = 0;
	const Admin = 1;
	const Professor = 2;

	var $email = '';
	var $logged = false;

	var $id = 0;
	var $is_admin = 0;


	
	function auth() {
		phpCAS::setDebug(false);
		phpCAS::client(SAML_VERSION_1_1,'login.uoa.gr',443,'');
		phpCAS::setNoCasServerValidation();
		phpCAS::forceAuthentication();

		global $user=phpCAS::getUser();
		global $attr=phpCAS::getAttributes();
		echo $attr['title'];
		
	}
 
	function logout() {
		phpCAS::logout();
	}
}

	$auth = new auth;

?>
