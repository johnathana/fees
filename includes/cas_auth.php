<?php

include_once('includes/CAS.php');


class auth {

	var $role = 0;
	var $faculty_id = 0;

	const Student = 0;
	const Admin = 1;
	const Professor = 2;
	const Secretariat = 3;

	var $user;
	var $attr;
	var $mail;

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

	
		$this->user = phpCAS::getUser();
		$this->attr = phpCAS::getAttributes();
		$this->mail = $this->attr['mail'];
		
		if ($this->attr['edupersonaffiliation'] == "student") {
			switch ($this->attr['edupersonorgunitdn']){
				case 'ou=ypoloepi,ou=postgrads,dc=uoa,dc=gr' :
				$this->faculty_id = 1;
				break;
				case 'ou=proplirosyst,ou=postgrads,dc=uoa,dc=gr' :
				$this->faculty_id = 2;
				break;
				case 'ou=tecsystiypolo,ou=postgrads,dc=uoa,dc=gr' :
				$this->faculty_id = 3;
				break;
				case 'ou=systepikdikt,ou=postgrads,dc=uoa,dc=gr' :
				$this->faculty_id = 4;
				break;
				case 'ou=epexsimatepik,ou=postgrads,dc=uoa,dc=gr' :
				$this->faculty_id = 5;
				break;
				case 'ou=neestechpli,ou=postgrads,dc=uoa,dc=gr' :
				$this->faculty_id = 6;
				break;
				case 'ou=dioioikontilep,ou=postgrads,dc=uoa,dc=gr' :
				$this->faculty_id = 7;
				break;
				default :
				$this->faculty_id = 0;
				break;
			}
		}
		if (in_array($this->user, $this->admin_users, true)) {
			$this->role = self::Admin;
		} else if (in_array($this->user, $this->secretariat_users, true)) {
			$this->role = self::Secretariat;
		} else if ($this->attr['edupersonaffiliation'] == "faculty" || $this->attr['edupersonaffiliation'] == "affiliate") {
			if(in_array($this->attr['edupersonorgunitdn'], $this->belong_to_di,true)) {
				$this->role = self::Professor; }
		} else if ($this->attr['edupersonaffiliation'] == "student") {
			if(in_array($this->attr['edupersonorgunitdn'], $this->belong_to_di,true)) {
				$this->role = self::Student;	}
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

