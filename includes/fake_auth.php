<?php


class auth {

	var $role = 0;

	const Student = 0;
	const Admin = 1;
	const Professor = 2;
	const Secretariat = 3;

	var $user;
	var $attr;

	
	function auth() {
		//global $user;
		$this->user = "mop09269";
		//global $attr;
		$this->attr = array('mail' => 'professor1@di.uoa.gr',
               'title'  => 'Professor',
               'cn'   => 'Professor1');
		//echo $attr['title'];
		
		$role = Professor;
	}
 
}


$auth = new auth;

?>