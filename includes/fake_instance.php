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
	
	var $user;
	var $attr;

	
	function auth() {
		//global $user;
		$user = "mop09269";
		//global $attr;
		$attr = array('mail' => 'mop09269@di.uoa.gr',
               'title'  => 'Postgraduate Student',
               'cn'   => 'Ioannis Iosifidis');
		//echo $attr['title'];
		
	}
 
}

	$auth = new auth;

?>
