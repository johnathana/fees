<?php


class auth {

	var $role = 0;
	var $faculty_id = 7;
	var $work_id; //tha xrisimopoiithei mono gia tin edit_test prokeimenou na perasoume stin onSubmit function to id tis pros update workoffer
	
	const Student = 0;
	const Admin = 1;
	const Professor = 2;
	const Secretariat = 3;

	var $user;
	var $attr;
	var $mail;

	function auth() {

		$this->user = 'mop09261';
		$this->attr = array('mail' => 'mop09261@di.uoa.gr',
               'title'  => 'JOHN',
               'cn'   => 'John Ios',
			   'edupersonaffiliation' => 'professor',
			   'edupersonorgunitdn' => 'ou=inftel,ou=schools,dc=uoa,dc=gr');

		$this->role = self::Professor;
		$this->mail = "mop09261@di.uoa.gr";
	} 
}


$auth = new auth;

?>
