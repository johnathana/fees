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


	 });

		function radio_click()
		{
			var personal = ($('input[name=filter1]:checked').val() == "one") ? 1 : 0;
			var current = ($('input[name=filter3]:checked').val() == "live") ? 1 : 0;

			window.location.href = "workoffers_overview.php?current="+current+"&personal="+personal;
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
					} else {
						$personal = 1;
                                                $current = 1;
					}

                                        $result = get_workoffer_list($auth->mail, $personal, $current);
				?>

				<table style="width: 350px">
				<tr>
					<td><label>Προσωπικές παροχές</td>
					<td><input type="radio" name="filter1" onClick="radio_click();" value="one" <?php if ($personal) {echo "checked=\"true\"";} ?> /></label></td>
					<td style="width: 50px"></td>
					<td><label>Όλων των καθηγητών</td>
					<td><input type="radio" name="filter1" onClick="radio_click();" value="all" <?php if (!$personal) {echo "checked=\"true\"";}?> /></label></td>
				</tr>
				<tr>
					<td><label>Τρέχουσες παροχές</td>
					<td><input type="radio" name="filter3" onClick="radio_click();" value="live"
					<?php if($current){echo "checked=\"true\"";}?> /></label></td>
					<td style="width: 50px"></td>
					<td><label>Παλιές παροχές</td>
					<td><input type="radio" name="filter3" onClick="radio_click();" value="dead"
					<?php if(!$current){echo "checked=\"true\"";}?>/></label></td>
				</tr>
				</table>
					
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
				<thead>
					<tr>
						<th>ID παροχής</th>
						<th>Καθηγητής</th>
						<th>Τίτλος παροχής</th>
						<th>Αριθμός φοιτητών</th>
						<th>Ώρες ανά φοιτητή</th>
						<th>Απαιτήσεις γνώσεων</th>
						<th>Παραδοτέα </th>
						<th>Λήξη προθεσμίας</th>
						<th>Ημερομηνία έναρξης</th>
						<th>Ημερομηνία τέλους</th>
					</tr>
				</thead>
				<tbody>	
				<?php
					while($row = mysql_fetch_assoc($result)) {
						extract($row);
						echo "<tr>\n";
						echo "<td>$id</td><td>$professor_name</td><td>$title</td><td>$candidates</td><td>$hours</td><td>$requirements</td><td>$deliverables</td><td>$deadline</td><td>$start_date</td><td>$end_date</td>";
						echo "</tr>\n";
					}
				?>
				</tbody>
				</table>
				
				<br />
				<input type="button" name="menu" value="Αρχικό μενού" class="button" onclick="window.location.href='/index.php'" />
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

