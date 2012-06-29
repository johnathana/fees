<!DOCTYPE html> 
<html> 
<head> 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
	<style type="text/css" title="currentStyle">
		@import "../jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css";
	</style>
	
</head> 


<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/jFormer/jformer.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');
	
	session_start();
	
	global $auth;
	
?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#start_date").datepicker({ dateFormat: 'yy-mm-dd' });
			$("#end_date").datepicker({ dateFormat: 'yy-mm-dd' });
			$("#deadline").datepicker({ dateFormat: 'yy-mm-dd' });
		});
	</script>

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">

<?php
	
	$query = "SELECT * FROM workoffer_categories";
	$resultset = mysql_query($query,$con);
	confirm_query($resultset);
	$categoryarray = array();
	array_push($categoryarray, array ('value' => '','label' => ' - Select an Option - ','selected' => true));	
	while ($row = mysql_fetch_array($resultset))
	{	
		array_push($categoryarray, array ('value' => $row["id"], 'label' => $row["category"]));  
	}
	
	$query1 = "SELECT * FROM faculty";
	$resultset1 = mysql_query($query1,$con);
	confirm_query($resultset1);
	$facultyarray = array();
	array_push($facultyarray, array ('value' => '','label' => ' - Select an Option - ','selected' => true));	
	while ($row = mysql_fetch_array($resultset1))
	{	
		array_push($facultyarray, array ('value' => $row["id"], 'label' => $row["title"]));  
	}

// Create the form
$registration = new JFormer('registration', array(
            'submitButtonText' => 'Αποθήκευση',
        ));

// Create the form page
$jFormPage1 = new JFormPage($registration->id . 'Page', array(
            'title' => '<h2 style="margin-bottom: 10px;">Δημιουργία παροχής</h2>',
        ));

// Create the form section
$jFormSection1 = new JFormSection($registration->id . 'Section1', array(
        ));

// Create the form section
$jFormSection2 = new JFormSection($registration->id . 'Section2', array(
        ));

// Add components to the section
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentSingleLineText('title', 'Τίτλος παροχής έργου:', array(
	    'validationOptions' => array('required')
	)),
	new JFormComponentDropDown('category', 'Κατηγορία παροχής έργου:', $categoryarray,
		array('validationOptions' => array('required')),
		array('tip' => '<p>Επιλέξτε κατηγορία</p>')
	),
	new JFormComponentDropDown('faculty', 'Πρόγραμμα μεταπτυχιακού:', $facultyarray,
		array('validationOptions' => array('required')),
		array('tip' => '<p>Επιλέξτε κατηγορία</p>')
	),
	new JFormComponentDropDown('candidates', 'Αριθμός φοιτητών:',
		array(
			array(
				'value' => '1',
				'label' => '1'
			),
			array(
				'value' => '2',
				'label' => '2'
			),
			array(
				'value' => '3',
				'label' => '3'
			),
			array(
				'value' => '4',
				'label' => '4'
			)
		)
	),
	new JFormComponentTextArea('requirements', 'Απαιτήσεις γνώσεων:', array(
		'width' => 'medium',
        'height' => 'medium',
        'validationOptions' => array('required'),
	)),
	new JFormComponentTextArea('deliverables', 'Παραδοτέα:', array(
        'width' => 'medium',
        'height' => 'medium',
		'validationOptions' => array('required'),
	)),
	new JFormComponentSingleLineText('hours', 'Απαιτούμενες ώρες υλοποιήσης (ανά φοιτητή) :', array(
        'validationOptions' => array('required','integer', 'maxLength' => 4),
    )),
    new JFormComponentSingleLineText('start_date', 'Έναρξη παροχής έργου:', array(
        'validationOptions' => array('required')
    )),
    new JFormComponentSingleLineText('end_date', 'Λήξη παροχής έργου:', array(
        'validationOptions' => array('required')
    )),
    new JFormComponentSingleLineText('deadline', 'Ημερομηνία λήξης υποβολής ενδιαφέροντος:', array(
        'validationOptions' => array('required')
    )),
));

// Add the section to the page
$jFormPage1->addJFormSection($jFormSection1);

// Add the page to the form
$registration->addJFormPage($jFormPage1);


// Set the function for a successful form submission
function onSubmit($formValues) {

	global $con;
	global $auth;
	
	$title = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->title));
	$candidates = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->candidates));
	$category_id = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->category));
	$faculty_id = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->faculty));
	$requirements = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->requirements));
	$deliverables = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->deliverables));
	$hours = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->hours));
	$start_date = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->start_date));
	$end_date = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->end_date));
	$deadline = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->deadline));


	$query = "INSERT INTO work_offers (professor_email, professor_name, title, candidates, category_id, faculty_id, requirements, deliverables, hours, start_date, end_date, deadline, is_available, published) 
	VALUES ('".$auth->mail."','".$auth->attr['cn']."','".$title."','".$candidates."','".$category_id."','".$faculty_id."','".$requirements."','".$deliverables."','".$hours."','".$start_date."','".$end_date."','".$deadline."', true, false);";
	$result_set = mysql_query($query,$con);
	confirm_query($result_set);

	return array(
		'successPageHtml' => '<h2>Η παροχή καταχωρήθηκε</h2><br>
		<input type="button" name="menu" value="Αρχικό μενού" class="button" onClick="window.location.href=\'/professor/prof_menu.php\'"/>'
	);

	return array('failureHtml' => '<h2>Η παροχή δεν καταχωρήθηκε</h2>');
}

// Process any request to the form
$registration->processRequest();

?>

	<div style="margin: 0px 0px 5px 10px">
		<input type="button" name="menu" value="Ακύρωση" class="button" onClick="window.location.href='/index.php'"/> 	
	</div>
	

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 
