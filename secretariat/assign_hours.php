<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php');
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
        /* WorkAppId */{"bVisible": false },
        /* Applied */null,
        /* Name */null,
        /* Email */null,
		/* Professor name */null,
		/* Title */null,
		/* Acad_year */null,
		/* Winter */null,
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
			window.location.href="/secretariat/secretariat_menu.php";
		}); 
		
		$('input[name=submit_btn]').click(function()
		{
			var workapp_id = (fnGetSelected(oTable));
			if (workapp_id == null)//δεν έχει επιλέξει κάποια παροχή
			{
				alert("Πρέπει πρώτα να επιλέξετε μια αίτηση παροχής έργου");
				return false;
			}
			else //έχει επιλεγεί κάποια παροχή
			{
				alert("Ανακατεύθυνση στις αναγνωρισμένες ώρες των φοιτητών για παροχές που έχουν κάνει");
				window.location.href="view_hours.php?id="+workapp_id;
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
				<h2>Πίνακας Αιτήσεων Παροχών Έργου</h2> 
			</div>
			
			<form name="myForm" >
				<div id="demo" ></div>
				
				<?php
					$query = "SELECT * FROM work_applications WHERE accepted=true ";//fere tis diathesimes paroxes
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
				?>
				
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
				<thead>
					<tr>
						<th>ID αίτησης</th>
						<th>Ημερ/νια αίτησης</th>
						<th>Όνομα φοιτητή</th>
						<th>Email φοιτητή</th>
						<th>Καθηγητής</th>
						<th>Τίτλος παροχής</th>
						<th>Ακαδημαϊκό έτος</th>
						<th>Χειμερινού εξαμήνου</th>
					</tr>
				</thead>
				<tbody>	
				<?php	while($row = mysql_fetch_assoc($result_set))
						{
							//extract($row);
							$query1 = "SELECT * FROM work_offers WHERE id = $row[work_id] ";//fere tis diathesimes paroxes
							$result_set1 = mysql_query($query1,$con);
							confirm_query($result_set1);
							$workoffer_row = mysql_fetch_assoc($result_set1);
							$academic_year_id = $workoffer_row['academic_year_id'];
							$ayear_row = get_ayear_from_academic_year_id($academic_year_id);
							echo "<tr>";
							echo "<td>$row[id]</td><td>$row[applied]</td><td>$row[student_name]</td><td>$row[student_email]</td><td>$workoffer_row[professor_name]</td><td>$workoffer_row[title]</td><td>$ayear_row[ayear]</td><td>$workoffer_row[winter_semester]</td>";
							echo "</tr>";
						}
					
				?>	
				</tbody>
				</table>
				
				<table>
				<tr>
				<td>Αναγνωρισμένες ώρες</td><td> <input type="text" name="hours" size="10"/></td>
				</tr>
				</table>
				<br />
				<p><input class="button" type="button" name="submit_btn" value="Καταχώρηση ωρών"  />
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
