<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mail.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	 ?>
	<style type="text/css" title="currentStyle">
		@import "../dataTables/css/demo_page.css";
		@import "../dataTables/css/demo_table_jui.css";
		@import "../jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css";
	</style>
	<script type="text/javascript" language="javascript" src="../dataTables/js/jquery.dataTables.js"></script>
		
		
		<script type="text/javascript" charset="utf-8">
		var oTable;
		
		$(document).ready(function(){ 
		/* Init the table */
		oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"sScrollX": "100%",
		//"sScrollXInner": "850px",
		"bScrollCollapse": true,
		"aoColumns": [
			/* WorkOfferId */{"bVisible": false },
			/* Professor name */null,
			/* Title */null,
			/* Candidates */null,
			/* Requirements*/null,
			/* Deliverables */null,
			/* Hours */null,
			/* Deadline */null,
			/* Acad_year */null,
			/* Winter */null,
			]
		});
		
		
		}); 
		
		</script>
</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">
		
		<div id="container">
			<div class="full_width big">
				<h2>Πίνακας παροχών στις οποίες έχετε κάνει αίτηση</h2>
				<br>
				<p>Οι γραμμές με <label class="high">αυτό το χρώμα</label> υποδηλώνουν ότι έχετε γίνει δεκτός/ή για τις συγκεκριμένες παροχές</p>
			</div>

			<form name="myForm" >
				<div id="demo" ></div>
				
				<?php
					if (isset($_GET['id']))//tha bei stin if an exei ginei redirect apo application_form
					{
						$workoffer_id = $_GET['id'];
						$stud_email = $auth->attr['mail'];
						$stud_name = $auth->attr['cn'];
						$query1 = "SELECT * FROM work_applications WHERE student_email='$stud_email' AND work_id='$workoffer_id'";
						$result_set1 = mysql_query($query1,$con);
						confirm_query($result_set1);
						if(mysql_num_rows($result_set1)>0)//iparxei idi kataxwrimeni afti i aitisi
						{
							echo "<p><font color='red'>Είναι ήδη καταχωρημένη η συγκεκριμένη αίτησή σας!</font></p>";
						}
						else
						{
							$query = "INSERT INTO work_applications (student_email, student_name, work_id) values ('$stud_email', '$stud_name', '$workoffer_id')";
							if (!mysql_query($query,$con))
							{
								die('Error: ' . mysql_error());
							}
							$query5 = "SELECT * FROM work_offers WHERE id='$workoffer_id'";
							$result_set5 = mysql_query($query5,$con);
							confirm_query($result_set5);
							$row5 = mysql_fetch_assoc($result_set5);
							$to = $row5['professor_email'];
							$subject = "Workoffer Application";
							$message = "Ο φοιτητής ".$auth->attr['cn'] ." έχει κάνει αίτηση για την παροχή ".$row5['title'].".";
							send_mail($to, $subject, $message);
							
						}
					}
					$stud_email = $auth->mail;
					$query = "SELECT work_id,accepted FROM work_applications WHERE student_email='$stud_email'";
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
				?>
				
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
				<thead>
					<tr>
						<th>ID παροχής</th>
						<th>Καθηγητής</th>
						<th>Τίτλος παροχής</th>
						<th>Αριθμός φοιτητών</th>
						<th>Ώρες ανά φοιτητή</th>
						<th>Απαιτήσεις γνώσεων</th>
						<th>Παραδοτέα</th>
						<th>Λήξη προθεσμίας υποβολής</th>
						<th>Ημερομηνία έναρξης</th>
						<th>Ημερομηνία λήξης</th>
					</tr>
				</thead>
				<tbody>
				<?php	while ($row = mysql_fetch_assoc($result_set))
					{
						$workoffer_id = $row['work_id'];
						$acceptance = $row['accepted'];
						$query1 = "SELECT * FROM work_offers WHERE id='$workoffer_id'";
						$result_set1 = mysql_query($query1, $con);
						confirm_query($result_set1);

						while ($row1 = mysql_fetch_assoc($result_set1))
						{
							extract($row1);
							echo "<tr".(($acceptance==1) ? " class = 'high'>" : ">");
							
							/*Βρίσκουμε τις τιμές που θέλουμε μέσω των ξένων κλειδιών*/
							//$row2 = get_surname_from_professor_id($professor_id);
							echo "<td>$id</td><td>$professor_name</td><td>$title</td><td>$candidates</td><td>$hours</td><td>$requirements</td><td>$deliverables</td><td>$deadline</td><td>$start_date</td><td>$end_date</td>";
							echo "</tr>\n";
						}
					}
				?>
				</tbody>
				</table>
				<br />
				<input type="button" name="menu" value="Αρχικό μενού" class="button" onClick="window.location.href='/index.php'"/>
			</form>		
		</div>
			<div class="spacer"></div>
		

	</aside> 
	</div><!--/content--> 
	 
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
	 
	</div><!--/globalfooter--> 
</body> 
</html>
