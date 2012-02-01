<!DOCTYPE html> 
<html> 
<head> 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>


</head> 


<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/jFormer/jformer.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');

	global $auth;
	$user = get_user_info($auth->id);

?>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#name").val("<?php echo $user['name']; ?>");
			$("#surname").val("<?php echo $user['surname']; ?>");
			$("[name=sex]").filter("[value=<?php echo $user['sex']; ?>]").attr("checked","checked");

			$("#reg_numb").val("<?php echo $user['reg_numb']; ?>");
			$("#phone").val("<?php echo $user['phone']; ?>");
			$("#cv").val("<?php echo $user['cv']; ?>");

			$("#email").val("<?php echo $user['email']; ?>");
			$("#email").attr('disabled', true);
		});
	</script>

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">
		   

<?php

// Create the form
$registration = new JFormer('registration', array(
            'submitButtonText' => 'Αποθήκευση',
        ));

// Create the form page
$jFormPage1 = new JFormPage($registration->id . 'Page', array(
            'title' => '<h2 style="margin-bottom: 10px;">Επεξεργασία λογαριασμού</h2>',
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
        'validationOptions' => array('integer', 'minLength' => 5),
    )),
    new JFormComponentSingleLineText('phone', 'Τηλέφωνο:', array(
        'validationOptions' => array('required', 'phone'),
    )),
    new JFormComponentSingleLineText('email', 'E-mail:', array(
        'validationOptions' => array('email'),
    )),
    new JFormComponentSingleLineText('old_password', 'Παλιός κωδικός:', array(
        'type' => 'password',
        'validationOptions' => array('password'),
    )),
    new JFormComponentSingleLineText('password', 'Νέος κωδικός:', array(
        'type' => 'password',
        'validationOptions' => array('password'),
    )),
    new JFormComponentSingleLineText('passwordConfirm', 'Επιβεβαίωση νέου κωδικού:', array(
        'type' => 'password',
        'validationOptions' => array('password', 'matches' => 'password'),
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
// 	return array('failureHtml' => json_encode($formValues));

	global $con;
	global $auth;

	$old_password = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->old_password));

	if ($old_password != "") {

		$password = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->password));

		if ($password == "")
			return array('failureHtml' => 'Παρακάλω εισάγετε το νέο password');

		if ( !$auth->check_login($auth->email, sha1($old_password)) )
			return array('failureHtml' => 'Λάθος password');

		$sql = "update users set passwd='".sha1($password)."' where id = '".$auth->id."'";
		mysql_query($sql, $con) || die('Error: ' . mysql_error());
	}

	$name  = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->name));
	$surname = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->surname));
	$sex = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->sex));
	$reg_numb = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->reg_numb));
	$phone = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->phone));
	$cv = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->cv));


	$sql = "update users set name='".$name."', surname='".$surname."', reg_numb='".$reg_numb."', phone='".$phone."', sex='".$sex."', cv='".$cv."' where id = '". $auth->id ."'";

	mysql_query($sql, $con) || die('Error: ' . mysql_error());

	return array(
		'successPageHtml' => '<h2>Η επεξεργασία ολοκληρώθηκε.</h2><br>
		<input type="button" name="menu" value="Αρχικό μενού" class="button" onClick="window.location.href=\'/index.php\'"/>'
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
