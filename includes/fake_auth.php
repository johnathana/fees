<?php


class auth {

	var $role =0;
	
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

		$this->user = 'mop09261';
		$this->attr = array('mail' => 'mop09269@di.uoa.gr',
               'title'  => 'Postgraduate Student',
               'cn'   => 'John Ios',
			   'edupersonaffiliation' => 'student',
			   'edupersonorgunitdn' => 'ou=inftel,ou=schools,dc=uoa,dc=gr');
		
		
		$this->role = self::Professor;
	} 
}


$auth = new auth;

?>
