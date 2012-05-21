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


	if ( is_null($_GET['id']) )
	{
		die("Δεν έχει επιλεγεί παροχή");
	}

	if ( is_int($_GET['id']) )
	{
		die();
	}
	if ( is_numeric($_GET['id']) ) {
	$auth->work_id = $_GET['id'];
	}
	$query = "SELECT * FROM work_offers WHERE id='".$_GET['id']."'";
	$result_set = mysql_query($query,$con);
	confirm_query($result_set);
	$row = mysql_fetch_assoc($result_set);
	extract($row);
	$query1 = "SELECT * FROM faculty WHERE id='$faculty_id'";
	$result_set1 = mysql_query($query1,$con);
	confirm_query($result_set1);
	$faculty_row = mysql_fetch_assoc($result_set1);
	$query2 = "SELECT * FROM workoffer_categories WHERE id='$category_id'";
	$result_set2 = mysql_query($query2,$con);
	confirm_query($result_set2);
	$category_row = mysql_fetch_assoc($result_set2);
	$query3 = "SELECT * FROM workoffer_categories";
	$resultset3 = mysql_query($query3,$con);
	confirm_query($resultset3);
	$categoryarray = array();
	while ($row3 = mysql_fetch_array($resultset3))
	{	
		array_push($categoryarray, array ('value' => $row3["id"], 'label' => $row3["category"]));  
	}
	$query4 = "SELECT * FROM faculty";
	$resultset4 = mysql_query($query4,$con);
	confirm_query($resultset4);
	$facultyarray = array();
	while ($row4 = mysql_fetch_array($resultset4))
	{	
		array_push($facultyarray, array ('value' => $row4["id"], 'label' => $row4["title"]));  
	}
	
?>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#title").val("<?php echo $title; ?>");
			$("#category").val('<?php echo $category_row['category']; ?>');
			$("#faculty").val('<?php echo $faculty_row['title']; ?>');
			$("#candidates").val('<?php echo $candidates; ?>');
			$("#requirements").val("<?php echo $requirements; ?>");
			$("#deliverables").val("<?php echo $deliverables; ?>");
			$("#hours").val("<?php echo $hours; ?>");
			$('input[name=winter_semester]').attr('checked', '<? echo $winter_semester; ?>');
			$('input[name=is_available]').attr('checked', '<? echo $is_available; ?>');

			$("#deadline").datepicker({ dateFormat: 'yy-mm-dd' });
			$("#deadline").val("<?php echo $deadline; ?>");
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
            'title' => '<h2 style="margin-bottom: 10px;">Επεξεργασία παροχής</h2>',
        ));

// Create the form section
$jFormSection1 = new JFormSection($registration->id . 'Section1', array(
        ));

// Create the form section
$jFormSection2 = new JFormSection($registration->id . 'Section2', array(
        ));

// Add components to the section
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('title', 'Τίτλος παροχής:', array(
        'validationOptions' => array('required')
    )),
	new JFormComponentDropDown('category', 'Κατηγορία παροχής:', $categoryarray,
		array('validationOptions' => array('required')),
		array('tip' => '<p>Επιλέξτε κατηγορία</p>')
	),
	new JFormComponentDropDown('faculty', 'Κατηγορία μεταπτυχιακού:', $facultyarray,
		array('validationOptions' => array('required')),
		array('tip' => '<p>Επιλέξτε κατηγορία</p>')
	),
    new JFormComponentDropDown('candidates', 'Αριθμός υποψηφίων:',
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
			),
			'validationOptions' => array('required')
	)),
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
	new JFormComponentSingleLineText('hours', 'Απαιτούμενες ώρες υλοποιήσης:', array(
        'validationOptions' => array('required','integer', 'maxLength' => 4),
    )),
	new JFormComponentMultipleChoice('winter_semester', '',
            array(
                array('value' => '1', 'label' => 'Χειμερινού εξαμήνου'),
    )),
	new JFormComponentMultipleChoice('is_available', '',
            array(
                array('value' => '1', 'label' => 'Απενεργοποίηση παροχής'),
    )),
	new JFormComponentSingleLineText('deadline', 'Ημερομηνία λήξης:', array(
        'validationOptions' => array('required')
    )),
));

// Add the section to the page
$jFormPage1->addJFormSection($jFormSection1);

// Add the page to the form
$registration->addJFormPage($jFormPage1);


// Set the function for a successful form submission
function onSubmit($formValues) {
	//return array('failureHtml' => json_encode($formValues));

	global $con;
	global $auth;
	return array('failureHtml' => '<h2>Η παροχή δεν καταχωρήθηκε</h2>');
	$id = $auth->work_id;
	$title = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->title));
	$candidates = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->candidates));
	$category_id = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->category));
	$faculty_id = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->faculty));
	$requirements = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->requirements));
	$deliverables = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->deliverables));
	$hours = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->hours));
	$winter_semester = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->winter_semester[0]));
	$is_available = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->is_available[0]));
	$deadline = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->deadline));

	$query = "UPDATE work_offers SET title = '$title',category_id = '$category_id', faculty_id = '$faculty_id', candidates = '$candidates',  requirements = '$requirements', deliverables = '$deliverables', hours = '$hours', deadline = '$deadline', winter_semester = '$winter_semester', is_available = '$is_available' WHERE id='$id'";


	$result_set = mysql_query($query,$con);
	confirm_query($result_set);

	return array(
		'successPageHtml' => '<script type="text/javascript">window.location.href="/index.php";</script>'
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
