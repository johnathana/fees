<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		//require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/fake_instance.php'); 
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
		
		/* Add a click handler to the rows - this could be used as a callback */
		$("#example tbody").click(function(event) {
			$(oTable.fnSettings().aoData).each(function (){
				$(this.nTr).removeClass('row_selected');
			});
			$(event.target.parentNode).addClass('row_selected');
		});
		
		$('input[name=menu]').click(function()
		{
			window.location.href="/student/stud_menu.php";
		}); 
		
		$('input[name=submit_btn]').click(function()
		{
			var workid = (fnGetSelected(oTable));
			if (workid == null)//δεν έχει επιλέξει κάποια παροχή
			{
				alert("Πρέπει πρώτα να επιλέξετε μια παροχή έργου");
				return false;
			}
			else //έχει επιλεγεί κάποια παροχή
			{
				alert("Ανακατεύθυνση στις παροχές που έχετε κάνει αίτηση");
				window.location.href="my_applications.php?id="+workid;
			}
		});
		
		}); 
		
		/* Get the rows which are currently selected */
		function fnGetSelected( oTableLocal )
		{
			var aReturn = new Array();
			var aTrs = oTableLocal.fnGetNodes();
			
			for ( var i=0 ; i<aTrs.length ; i++ )
			{
				if ( $(aTrs[i]).hasClass('row_selected') )
				{
					var aRowData = new Array();
					aRowData = oTable.fnGetData(aTrs[i]);

					return aRowData[0];
					//aReturn.push( aTrs[i] );
				}
			}
			//return aReturn;
			return null;
		}
		
		</script>
</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter">

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">
		
		<div id="container">
			<div class="full_width big">
				<h2>Πίνακας Παροχών</h2> 
			</div>
			
			<form name="myForm" >
				<div id="demo" ></div>
				
				<?php
					$query = "SELECT * FROM work_offers WHERE is_available=true AND has_expired=false";//fere tis diathesimes paroxes
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
							echo "<tr>";
							if($addressed_for==0)
							{$student_type="Μη εργαζόμενο";}
							elseif($addressed_for==1)
							{$student_type="Μερικώς εργαζόμενο";}
							else
							{$student_type="Πλήρως εργαζόμενο";}
							/*Βρίσκουμε τις τιμές που θέλουμε μέσω των ξένων κλειδιών*/
							//$row1 = get_surname_from_professor_id($professor_id);
							$row2 = get_ayear_from_academic_year_id($academic_year_id);
							echo "<td>$id</td><td>$professor_name</td>
								<td>$title</td><td>$lesson</td><td>$candidates</td><td>$requirements</td><td>$deliverables</td>
								<td>$hours</td><td>$deadline</td><td>";
							if($at_di==false)
							echo "<input type='checkbox' disabled='true'>";
							else
							echo"<input type='checkbox' disabled='true' checked='true'>";
							echo "</td><td>$row2[ayear]</td><td>";
							if($winter_semester==false)
							echo "<input type='checkbox' disabled='true'>";
							else
							echo"<input type='checkbox' disabled='true' checked='true'>";
							echo"</td><td>$student_type</td>";
							echo "</tr>";
						}
					
				?>	
				</tbody>
				</table>
				<br />
				<p><input class="button" type="button" name="submit_btn" value="Καταχώρηση"  />
				<input type="button" name="menu" value="Αρχικό μενού" class="button"/>	</p>
			</form>	
			
		</div>
			<div class="spacer"></div>
		

	</aside> 
	</div><!--/content--> 
	 
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
	 
	</div><!--/globalfooter--> 
</body> 
</html>