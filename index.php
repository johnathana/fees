<!DOCTYPE html> 
<?php
include_once('includes/CAS.php');

phpCAS::setDebug(false);
phpCAS::client(SAML_VERSION_1_1,'login.uoa.gr',443,'');
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();
if (isset($_REQUEST['logout'])) {
       phpCAS::logout();
}



$user=phpCAS::getUser();
$attr=phpCAS::getAttributes();


?>
<html> 
<head>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
</head> 


<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/jFormer/jformer.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php');

	global $auth;

	if ($auth->logged) {

		$location = "";

		switch ($auth->is_admin) {

		case auth::Admin :
			$location = "/admin/admin_menu.php";
			break;
		case auth::Professor :
			$location = "/professor/prof_menu.php";
			break;
		case auth::Student :
			$location = "/student/stud_menu.php";
			break;
		}

		header("Location: $location");
	}
?>

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">
		   

<?php
echo $user;
var_dump($attr);
// Create the form
$login = new JFormer('loginForm', array(
    'submitButtonText' => 'Είσοδος',
));

// Create the form page
$jFormPage1 = new JFormPage($login->id.'Page', array(
    'title' => '<h2 style="margin-bottom: 10px;">Σύνδεση</h2>',
));

// Create the form section
$jFormSection1 = new JFormSection($login->id.'Section', array());

// Check to see if the remember me checkbox should be checked by default

// Add components to the section
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('email', 'Email:', array(
        'validationOptions' => array('required', 'email'),
        'tip' => '<p>Παρακαλώ πληκρολογήστε το <b>email</b> σας</p>',
    )),

    new JFormComponentSingleLineText('password', 'Κωδικός:', array(
        'type' => 'password',
        'validationOptions' => array('required', 'password'),
        'tip' => '<p>Παρακαλώ πληκρολογήστε το <b>password</b> σας</p>',
    )),
    new JFormComponentMultipleChoice('rememberMe', '', 
        array(
            array('value' => 'remember', 'label' => 'Διατήρηση σύνδεσης σε αυτόν τον υπολογιστή')
        ),
        array(
        'tip' => '<p></p>',
        )
    ),
    new JFormComponentHtml('<div class="jFormComponent"><a href="/password_reset.php" ">Ξέχασα το password μου</a></div>')
));

// Add the section to the page
$jFormPage1->addJFormSection($jFormSection1);

// Add the page to the form
$login->addJFormPage($jFormPage1);

// Set the function for a successful form submission
function onSubmit($formValues) {
	$formValues = $formValues->loginFormPage->loginFormSection;

	global $auth;
	if ($auth->login($formValues->email, $formValues->password, !empty($formValues->rememberMe))) {
		$response = array('successPageHtml' => '<script type="text/javascript">window.location.href="/index.php";</script>');
	} else {
		$response = array('failureNoticeHtml' => 'Λάθος username ή password.', 'failureJs' => "$('#password').val('').focus();");
	}

	return $response;
}


// Process any request to the form
$login->processRequest();

?>
	<div style="margin: 15px">
	<table>
		<tr><a href="register.php">Δημιουργία λογαρισμού</a></tr>
		<tr><a href="/manual/manual_workoffer.pdf">Οδηγίες χρήσης πλατφόρμας</a></tr>
	</table>
	</div>
	</aside> 
</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 
