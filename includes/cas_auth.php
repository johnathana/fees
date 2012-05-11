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

	var $admin_users = array('stef', 'florias');
	var $secretariat_users = array('mop09269');
	var $belong_to_di = array('ou=inftel,ou=schools,dc=uoa,dc=gr',
				  'ou=therinf,ou=schools,dc=uoa,dc=gr',
				  'ou=cmptsystapp,ou=schools,dc=uoa,dc=gr',
				  'ou=comssigpro,ou=schools,dc=uoa,dc=gr');
	

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
			$this->$role = Admin;
		} else if (in_array($this->user, $secretariat_users, true)) {
			$this->$role = Secretariat;
		} else if ($this->attr['edupersonaffiliation'] == "faculty" || $this->attr['edupersonaffiliation'] == "affiliate") {
			if(in_array($this->attr['edupersonorgunitdn'], $belong_to_di,true))
				$this->$role = Professor;
		} else if ($this->attr['edupersonaffiliation'] == "student") {
			if(in_array($this->attr['edupersonorgunitdn'], $belong_to_di,true))
				$this->$role = Student;	
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

