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


	if ( isset($_GET['id']) ) {

		$workoffer_id = intval($_GET['id']);
		$_SESSION['workoffer_id'] = $workoffer_id;

		$query = "SELECT * FROM work_offers WHERE id='".$workoffer_id."'";
		$result_set = mysql_query($query, $con);
		confirm_query($result_set);
		$row = mysql_fetch_assoc($result_set);
		extract($row);
		
		$query2 = "SELECT * FROM work_applications WHERE work_id = '".$workoffer_id."' AND accepted = '1'";
		$workapps = mysql_query($query2,$con);
		confirm_query($workapps);
		$q = "SELECT is_available FROM work_offers WHERE id = '".$workoffer_id."'";
		$result = mysql_query($q,$con);
		confirm_query($result);
		$row = mysql_fetch_assoc($result);
		if (mysql_num_rows($workapps) >= 1)
		{
			$chkbx_off = "anenergo";
		}
		if (mysql_num_rows($workapps) == 0 && $row['is_available'] == 0)//monadiki periptwsi na einai checked to pedio apenergopoiisi paroxis
		{
			$chkbx_off = "tsekarismeno";
		}
// 		if (mysql_num_rows($workapps) == 0 && $row['is_available'] != 0)
// 		{
// 			$chkbx_off = "mh_tsekarismeno";
// 		}
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

	} else {
		// Save mode
		// Please don't die() !!!
	}
?>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#title").val("<?php echo $title; ?>");
			$("#category").val('<?php echo $category_row['id']; ?>');
			$("#faculty").val('<?php echo $faculty_row['id']; ?>');
			$("#candidates").val('<?php echo $candidates; ?>');
			$("#requirements").val("<?php echo $requirements; ?>");
			$("#deliverables").val("<?php echo $deliverables; ?>");
			$("#hours").val("<?php echo $hours; ?>");

			<?php
				if($chkbx_off == "tsekarismeno") {
					echo "$('input[name=non_available]').attr('checked', 'true');";
				} else if ($chkbx_off == "anenergo") {
					echo "$('input[name=non_available]').attr('disabled', true);";
				}
			?>
 

			$("#start_date").datepicker({ dateFormat: 'yy-mm-dd' });
			$("#start_date").val("<?php echo $start_date; ?>");

			$("#end_date").datepicker({ dateFormat: 'yy-mm-dd' });
			$("#end_date").val("<?php echo $end_date; ?>");

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
	new JFormComponentSingleLineText('hours', 'Απαιτούμενες ώρες υλοποιήσης (ανά φοιτητή):', array(
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
	new JFormComponentMultipleChoice('non_available', '',
            array(
                array('value' => '1', 'label' => 'Απενεργοποίηση παροχής'),
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


	$title = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->title));
	$candidates = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->candidates));
	$category_id = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->category));
	$faculty_id = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->faculty));
	$requirements = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->requirements));
	$deliverables = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->deliverables));
	$hours = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->hours));
	$is_available = (trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->non_available[0])) == 1) ? 0 : 1; 
	$start_date = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->start_date));
	$end_date = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->end_date));
	$deadline = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->deadline));

	$query = "UPDATE work_offers SET title = '$title',category_id = '$category_id', faculty_id = '$faculty_id', candidates = '$candidates',  requirements = '$requirements', deliverables = '$deliverables', hours = '$hours', deadline = '$deadline', start_date = '$start_date', end_date = '$end_date', is_available = '$is_available' WHERE id='".$_SESSION['workoffer_id']."'";
	//return array('failureHtml' => $query);

	$result_set = mysql_query($query, $con);
	confirm_query($result_set);

	return array(
		'successPageHtml' => '<script type="text/javascript">window.location.href="/professor/personal_workoffer_list.php";</script>'
	);
}

// Process any request to the form
$registration->processRequest();

?>
	<div style="margin: 15px">
	<p>
		<input type="button" id="prof" name="menu" value="Αρχικό μενού" class="button" onClick="window.location.href='/index.php'"/>
	</p>
	</div>

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 
