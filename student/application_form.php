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
		
		/* Add a click handler to the rows - this could be used as a callback */
		$("#example tbody").click(function(event) {
			$(oTable.fnSettings().aoData).each(function (){
				$(this.nTr).removeClass('row_selected');
			});
			$(event.target.parentNode).addClass('row_selected');
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
				window.location.href="my_applications.php?id=" + workid;
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
					//$query = "select * from work_offers where published = true and is_available = true and now() < deadline";
					$query = "select * from work_offers where published = true and is_available = true";
					$result_set = mysql_query($query, $con);
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
						extract($row);
						echo "<tr>";
						echo "<td>$id</td><td>$professor_name</td><td>$title</td><td>$candidates</td><td>$hours</td><td>$requirements</td><td>$deliverables</td><td>$deadline</td><td>$start_date</td><td>$end_date</td>";
						echo "</tr>";
					}
				?>
				</tbody>
				</table>
				<br />
				<p>
					<input class="button" type="button" name="submit_btn" value="Αίτηση"  />
					<input type="button" name="menu" value="Αρχικό μενού" class="button" onClick="window.location.href='/index.php'" />
				</p>
			</form>
			
		</div>
			<div class="spacer"></div>


	</aside> 
	</div><!--/content--> 
	 
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
	 
	</div><!--/globalfooter--> 
</body> 
</html>
