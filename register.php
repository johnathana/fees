<!DOCTYPE html> 
<html> 
<head> 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connection.php');?>
</head> 


<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/jFormer/jformer.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mail.php');
?>

<body id="overview">

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">
		   

<?php

// Create the form
$registration = new JFormer('registration', array(
            'submitButtonText' => 'Δημιουργία',
        ));

// Create the form page
$jFormPage1 = new JFormPage($registration->id . 'Page', array(
            'title' => '<h2 style="margin-bottom: 10px;">Δημιουργία λογαριασμού</h2>',
        ));

// Create the form section
$jFormSection1 = new JFormSection($registration->id . 'Section1', array(
        ));

// Create the form section
$jFormSection2 = new JFormSection($registration->id . 'Section2', array(
        ));

// Add components to the section
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('name', 'Όνομα:', array(
        'validationOptions' => array('required')
    )),
    new JFormComponentSingleLineText('surname', 'Επώνυμο:', array(
        'validationOptions' => array('required')
    )),
     new JFormComponentMultipleChoice('sex', 'Φύλο:',
            array(
                array('value' => 'm', 'label' => 'Άνδρας'),
                array('value' => 'f', 'label' => 'Γυναίκα'),
            ),
            array(
                'multipleChoiceType' => 'radio',
                'validationOptions' => array('required'),
    )),
    new JFormComponentSingleLineText('reg_numb', 'Κωδικός μητρώου:', array(
        'validationOptions' => array('required', 'integer', 'minLength' => 5),
    )),
    new JFormComponentSingleLineText('phone', 'Τηλέφωνο:', array(
        'validationOptions' => array('required', 'phone'),
    )),
    new JFormComponentSingleLineText('email', 'E-mail:', array(
        'validationOptions' => array('required', 'email'),
    )),
    new JFormComponentSingleLineText('emailConfirm', 'Επιβεβαίωση e-mail:', array(
        'validationOptions' => array('required', 'email', 'matches' => 'email'),
    )),
    new JFormComponentSingleLineText('password', 'Κωδικός:', array(
        'type' => 'password',
        'validationOptions' => array('required', 'password'),
    )),
    new JFormComponentSingleLineText('passwordConfirm', 'Επιβεβαίωση κωδικού:', array(
        'type' => 'password',
        'validationOptions' => array('required', 'password', 'matches' => 'password'),
    )),
    new JFormComponentTextArea('cv', 'Βιογραφικό:', array(
        'width' => 'medium',
        'height' => 'medium',
        //'validationOptions' => array('required'),
    )),
));

// Add the section to the page
$jFormPage1->addJFormSection($jFormSection1);

// Add the page to the form
$registration->addJFormPage($jFormPage1);


// Set the function for a successful form submission
function onSubmit($formValues) {
	//return array('failureHtml' => json_encode($formValues));

	$email  = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->email));
	$passwd = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->password));
	$name  = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->name));
	$surname = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->surname));
	$sex = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->sex));
	$reg_numb = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->reg_numb));
	$phone = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->phone));
	$cv = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->cv));

	global $con;
	$sql = "select * from users where email = '". mysql_real_escape_string($email) . "'";
	mysql_query($sql, $con) || die('Error: ' . mysql_error());

	$result = mysql_query($sql, $con);
	
	if (mysql_num_rows($result) > 0) {
		$response = array('failureNoticeHtml' => 'Το email ανήκει σε υπάρχον λογαριασμό');
		return $response;
	}

	$sql = "insert into users (email, passwd, name, surname, reg_numb, phone, sex, cv) values ('".$email."', '".sha1($passwd)."', '".$name."', '".$surname."', '".$reg_numb."', '".$phone."', '".$sex."', '".$cv."')";

	mysql_query($sql, $con) || die('Error: ' . mysql_error());

	workoffer_mail($email, 'Account activation', 'Ο λογαριασμός σας δημιουργήθηκε με επιτυχία.');

	return array(
		'successPageHtml' => '<h2>Η δημιουργία ολοκληρώθηκε.</h2><br>
		<p>Ελέξτε το email σας ' . $email . ' για ενεργοποίηση του λογαριασμού σας.</p>'
	);
}

// Process any request to the form
$registration->processRequest();

?>
	<div style="margin: 15px">
		<a href="/">Πίσω</a>
	</div>

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 
