<?php

include_once('includes/CAS.php');


class auth {

	var $role = 0;

	const Student = 0;
	const Admin = 1;
	const Professor = 2;
	const Secretariat = 3;

	var $user;
	var $attr;

	$admin_users = array('stef', 'florias');
	$secretariat_users = array('mop09269');
	
	function auth() {
		phpCAS::setDebug(false);
		phpCAS::client(SAML_VERSION_1_1, 'login.uoa.gr', 443, '');
		phpCAS::setNoCasServerValidation();
		phpCAS::forceAuthentication();

		//global $user;
		$this->user = phpCAS::getUser();
		//global $attr;
		$this->attr = phpCAS::getAttributes();
		//echo $attr['title'];

		if (in_array($this->user, $admin_users, true)) {
			$role = Admin;
		} else if (in_array($this->user, $secretariat_users, true)) {
			$role = Secretariat;
		} else {
			die("Access denied");
		}
	}

	function logout() {
		phpCAS::logout();
	}
}


$auth = new auth;

?>

