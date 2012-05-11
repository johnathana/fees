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
		
		
		
		$this->user = 'mop09269';
		$this->attr = array('mail' => 'mop09269@di.uoa.gr',
               'title'  => 'Postgraduate Student',
               'cn'   => 'John Ios',
			   'edupersonaffiliation' => 'student',
			   'edupersonorgunitdn' => 'ou=inftel,ou=schools,dc=uoa,dc=gr');
		
		
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
 
}


$auth = new auth;

?>
