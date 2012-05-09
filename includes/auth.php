<?php

//include_once('includes/CAS.php');


class auth {

	var $role = 0;

	const Student = 0;
	const Admin = 1;
	const Professor = 2;
	const Secretariat = 3;

	var $email = '';
	var $logged = false;

	var $id = 0;

	
	var $user;
	var $attr;

	
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

		switch ($this->attr['title']) {
		case "admin":
			$role = Admin;
			break;
		case "professor":
			$role = Professor;
			break;
		case "secretariat":
			$role = Secretariat;
			break;
		default:
			$role = Student;
			break;
		}
	}

	function logout() {
		phpCAS::logout();
	}
}


$auth = new auth;

?>
