<!DOCTYPE html> 
<html> 
<head>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
</head> 


<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/jFormer/jformer.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mail.php');
?>

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connection.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">
		   

<?php

// Create the form
$registration = new JFormer('registration', array(
            'submitButtonText' => 'Αποστολή',
        ));

// Create the form page
$jFormPage1 = new JFormPage($registration->id.'Page', array(
    'title' => '<h2 style="margin-bottom: 10px;">Ξέχασα το password μου</h2>',
));

// Create the form section
$jFormSection1 = new JFormSection($registration->id.'Section', array());

// Check to see if the remember me checkbox should be checked by default

// Add components to the section
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('email', 'Email:', array(
        'validationOptions' => array('required', 'email'),
        'tip' => '<p>Παρακαλώ πληκρολογήστε το <b>email</b> σας</p>',
    ))
));

// Add the section to the page
$jFormPage1->addJFormSection($jFormSection1);

// Add the page to the form
$registration->addJFormPage($jFormPage1);

// Set the function for a successful form submission
function onSubmit($formValues) {
	$email  = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection->email));

	global $con;
	$sql = "select * from users where email = '". $email . "'";

	$result = mysql_query($sql, $con);
	
	if (mysql_num_rows($result) == 0) {
		$response = array('failureNoticeHtml' => 'Το email δεν αντιστοιχεί σε υπάρχοντα λογαριασμό');
		return $response;
	}

	# Generate random password
	$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';

	$new_passwd = '';
	for ($i = 0; $i < 8; $i++) {
		$new_passwd .= $characters[rand(0, strlen($characters) - 1)];
	}

	$sql = "update users set passwd = '". sha1($new_passwd) . "' where email = '". $email ."'";
	mysql_query($sql, $con) || die('Error: ' . mysql_error());

	workoffer_mail($email, 'Password reset', 'Το νέο σας password είναι το: '.$new_passwd);

	return array(
		'successPageHtml' => '<h2>Το password σας άλλαξε</h2><br>
		<p>Το νέο password έχει σταλεί στο email σας ' . $email . '</p>'
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
