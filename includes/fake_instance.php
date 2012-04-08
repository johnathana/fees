<?php

//include_once('includes/CAS.php');


class auth {

	const Student = 0;
	const Admin = 1;
	const Professor = 2;

	var $email = '';
	var $logged = false;

	var $id = 0;
	var $is_admin = 0;
	
	var $user;
	var $attr;

	
	function auth() {
		//global $user;
		$this->user = "mop09269";
		//global $attr;
		$this->attr = array('mail' => 'professor1@di.uoa.gr',
               'title'  => 'Postgraduate Student',
               'cn'   => 'Professor1');
		//echo $attr['title'];
		
	}
 
}

	$auth = new auth;
	

?>
