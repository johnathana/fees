<?php


class auth {

	var $role =0;
	
	const Student = 0;
	const Admin = 1;
	const Professor = 2;
	const Secretariat = 3;

	var $user;
	var $attr;

	function auth() {

		$this->user = 'mop09261';
		$this->attr = array('mail' => 'ioaios@di.uoa.gr',
               'title'  => 'Associate Professor',
               'cn'   => 'John Ios',
			   'edupersonaffiliation' => 'faculty',
			   'edupersonorgunitdn' => 'ou=inftel,ou=schools,dc=uoa,dc=gr');

		$this->role = self::Professor;
	} 
}


$auth = new auth;

?>
