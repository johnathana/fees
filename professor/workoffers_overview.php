<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	 ?>
	
	<style type="text/css" title="currentStyle">
		@import "../dataTables/css/demo_page.css";
		@import "../dataTables/css/demo_table_jui.css";
		@import "../jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css";
		@import "../media/css/TableTools.css";
	</style>
	<script type="text/javascript" language="javascript" src="../dataTables/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="../media/js/ZeroClipboard.js"></script>
	<script type="text/javascript" language="javascript" src="../media/js/TableTools.min.js"></script>
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
		
		var oTableTools = new TableTools( oTable, {
			"sSwfPath": "../media/swf/copy_cvs_xls_pdf.swf",
			"aButtons": [ "copy","xls", "print" ]
        } );


		$('#demo_jui').before( oTableTools.dom.container );


		$('input[name=menu]').click(function()
		{
			window.location.href="/professor/prof_menu.php";
		}); 

		}); 


		function radio_click()
		{
			if($('input[name=filter1]:checked').val() == "one")
			{
				if($('input[name=filter2]:checked').val() == "current")
				{
					if($('input[name=filter3]:checked').val() == "live")
					{
						window.location.href="workoffers_overview.php?choice=111";
					}
					else
					{
						window.location.href="workoffers_overview.php?choice=112";
					}
				}
				else
				{
					if($('input[name=filter3]:checked').val() == "live")
					{
						window.location.href="workoffers_overview.php?choice=121";
					}
					else
					{
						window.location.href="workoffers_overview.php?choice=122";
					}
				}
			}
			else
			{
				if($('input[name=filter2]:checked').val() == "current")
				{
					if($('input[name=filter3]:checked').val() == "live")
					{
						window.location.href="workoffers_overview.php?choice=211";
					}
					else
					{
						window.location.href="workoffers_overview.php?choice=212";
					}
				}
				else
				{
					if($('input[name=filter3]:checked').val() == "live")
					{
						window.location.href="workoffers_overview.php?choice=221";
					}
					else
					{
						window.location.href="workoffers_overview.php?choice=222";
					}
				}
			}	 
		}


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
				}
			}
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
				<h2>Επισκόπηση Παροχών</h2> 
				<br />
			</div>
			
			<form id="myForm"  method="POST" >
				<div id="demo" ></div>
				<div class="demo_jui" id="demo_jui">
				
				<?php
					if (isset($_GET['personal']) && isset($_GET['current'])) {  
						$personal = $_GET['personal'];
						$current = $_GET['current'];

						$result = get_data($auth->mail, $personal, $current);
					}
					else
						$result = get_workoffer_list($auth->mail, 0, 0);
				?>

				<table style="width: 350px">
				<tr>
					<td><label>Προσωπικές παροχές</td>
					<td><input type="radio" name="filter1" onClick="radio_click();" value="one" <?php if ($personal) {echo "checked=\"true\"";} ?> /></label></td>
					<td style="width: 50px"></td>
					<td><label>Όλων των καθηγητών</td>
					<td><input type="radio" name="filter1" onClick="radio_click();" value="all" <?php if ($personal) {echo "checked=\"false\"";}?> /></label></td>
				</tr>
				<tr>
					<td><label>Τρέχουσες παροχές</td>
					<td><input type="radio" name="filter3" onClick="radio_click();" value="live"
					<?php if($choice=="111"||$choice=="121"||$choice=="211"||$choice=="221"){echo "checked=\"true\"";}?> /></label></td>
					<td style="width: 50px"></td>
					<td><label>Παλιές παροχές</td>
					<td><input type="radio" name="filter3" onClick="radio_click();" value="dead"
					<?php if($choice=="112"||$choice=="122"||$choice=="212"||$choice=="222"){echo "checked=\"true\"";}?>/></label></td>
				</tr>
				</table>
					
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
				<thead>
					<tr>
						<th>ID παροχής</th>
						<th>Καθηγητής</th>
						<th>Τίτλος παροχής</th>
						<th>Αριθμός υποψηφίων</th>
						<th>Απαιτήσεις γνώσεων</th>
						<th>Παραδοτέα </th>
						<th>Απαιτούμενες ώρες υλοποίησης</th>
						<th>Λήξη προθεσμίας</th>
						<th>Ακαδημαϊκό έτος</th>
						<th>Χειμερινού εξαμήνου</th>
					</tr>
				</thead>
				<tbody>	
				<?php
					while($row = mysql_fetch_assoc($result)) {
						extract($row);
						echo "<tr>\n";
						echo "<td>$id</td><td>$professor_name</td><td>$title</td><td>$candidates</td><td>$requirements</td><td>$deliverables</td><td>$hours</td><td>$deadline</td><td>$start_date</td>";
						echo "</tr>\n";
					}
				?>
				</tbody>
				</table>
				
				<br />
				<input type="button" name="menu" value="Αρχικό μενού" class="button"/>
				</div>
			</form>	
				
			<div class="spacer"></div>
		</div>
	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

