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
					/* Professor */null,
					/* Title */null,
					/* Lesson */null,
					/* Candidates */null,
					/* Requirements*/null,
					/* Deliverables */null,
					/* Hours */null,
					/* Deadline */null,
					/* At_di */null,
					/* Acad_year */null,
					/* Winter */null,
					/* Addressed */null
        ]
		});
		
		$('input[name=menu]').click(function()
		{
			window.location.href="/student/stud_menu.php";
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
					if (isset($_GET['id']))
					{
						$workoffer_id = $_GET['id'];
						$stud_id = $auth->id;
						$query1 = "SELECT * FROM work_applications WHERE user_id='$stud_id' AND work_id='$workoffer_id'";
						$result_set1 = mysql_query($query1,$con);
						confirm_query($result_set1);
						if(mysql_num_rows($result_set1)>0)//iparxei idi kataxwrimeni afti i aitisi
						{
							echo "Είναι ήδη καταχωρημένη η συγκεκριμένη αίτησή σας!";
							//exit();
						}
						else
						{
							$query = "INSERT INTO work_applications (user_id, work_id) values ('$stud_id', '$workoffer_id')";//NA ALLAXSW TO 1 ME TO ID POY UA VRW APO TO SESSION[EMAIL]
							if (!mysql_query($query,$con))
							{
								die('Error: ' . mysql_error());
							}
							$query5 = "SELECT * FROM work_offers WHERE id='$workoffer_id'";
							$result_set5 = mysql_query($query5,$con);
							confirm_query($result_set5);
							$row5 = mysql_fetch_assoc($result_set5);
							$prof_id = $row5['professor_id'];
							$query = "SELECT * FROM users WHERE id='$prof_id'";
							$result_set = mysql_query($query,$con);
							confirm_query($result_set);
							$row = mysql_fetch_assoc($result_set);
							$to = $row['email'];
							$subject = "Workoffer Application";
							$query = "SELECT name,surname FROM users WHERE id='$stud_id'";
							$result_set = mysql_query($query,$con);
							confirm_query($result_set);
							$row = mysql_fetch_assoc($result_set);
							$message = "Ο φοιτητής ".$row['surname'] ." ".$row['name']." έχει κάνει αίτηση για την παροχή ".$row5['title'].".";
							workoffer_mail($to, $subject, $message);
							
						}
					}
					$stud_id = $auth->id;
					$query = "SELECT work_id,accepted FROM work_applications WHERE user_id='$stud_id'";
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
				?>
				
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
				<thead>
					<tr>
						<th>ID παροχής</th>
						<th>Καθηγητής</th>
						<th>Τίτλος παροχής</th>
						<th>Τίτλος μαθήματος</th>
						<th>Αριθμός υποψηφίων</th>
						<th>Απαιτήσεις γνώσεων</th>
						<th>Παραδοτέα </th>
						<th>Απαιτούμενες ώρες υλοποίησης</th>
						<th>Λήξη προθεσμίας</th>
						<th>Στο χώρο του di</th>
						<th>Ακαδημαϊκό έτος</th>
						<th>Χειμερινού εξαμήνου</th>
						<th>Απευθύνεται σε φοιτητή</th>
					</tr>
				</thead>
				<tbody>	
				<?php	while($row = mysql_fetch_assoc($result_set))
						{
							extract($row);
							$workoffer_id = $row['work_id'];
							$acceptance = $row['accepted'];
							$query1 = "SELECT * FROM work_offers WHERE id='$workoffer_id'";
							$result_set1 = mysql_query($query1,$con);
							confirm_query($result_set1);
							while($row1 = mysql_fetch_assoc($result_set1))
							{
								extract($row1);
								if($acceptance==1)//exei ginei dektos o foititis
								{
									echo "<tr class = 'high'>";
								}
								else
								{
									echo "<tr>";
								}
								if($addressed_for==0)
								{$student_type="Μη εργαζόμενο";}
								elseif($addressed_for==1)
								{$student_type="Μερικώς εργαζόμενο";}
								else
								{$student_type="Πλήρως εργαζόμενο";}
								/*Βρίσκουμε τις τιμές που θέλουμε μέσω των ξένων κλειδιών*/
								$row2 = get_surname_from_professor_id($professor_id);
								$row3 = get_ayear_from_academic_year_id($academic_year_id);
								echo "<td>$id</td><td>$row2[surname]</td>
									<td>$title</td><td>$lesson</td><td>$candidates</td><td>$requirements</td><td>$deliverables</td>
									<td>$hours</td><td>$deadline</td><td>";
								if($at_di==false)
								echo "<input type='checkbox' disabled='true'>";
								else
								echo"<input type='checkbox' disabled='true' checked='true'>";
								echo "</td><td>$row3[ayear]</td><td>";
								if($winter_semester==false)
								echo "<input type='checkbox' disabled='true'>";
								else
								echo"<input type='checkbox' disabled='true' checked='true'>";
								echo"</td><td>$student_type</td>";
								echo "</tr>";
							}
						}	
				?>	
				</tbody>
				</table>
				<br />
				<input type="button" name="menu" value="Αρχικό μενού" class="button"/>
			</form>		
		</div>
			<div class="spacer"></div>
		

	</aside> 
	</div><!--/content--> 
	 
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
	 
	</div><!--/globalfooter--> 
</body> 
</html>