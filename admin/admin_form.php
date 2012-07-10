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
	$(document).ready(function() {
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

		$("#example tbody").click(function(event) {
			$(oTable.fnSettings().aoData).each(function (){
				$(this.nTr).removeClass('row_selected');
			});
			$(event.target.parentNode).addClass('row_selected');
			var work_id = (fnGetSelected(oTable));
			var str = '<input type="hidden" name="id" value="'+work_id+'"/>';
			$('#demo').html(str);
		});
		
		$('#myForm').submit(function()
		{
			var work_id = (fnGetSelected(oTable));
			
			if (work_id != null)//έχει επιλεγεί κάποια αίτηση φοιτητή
			{
				return true;
			}
			else//δεν έχει επιλέξει κάποιο φοιτητή
			{
				alert("Πρέπει πρώτα να επιλέξετε έναν φοιτητή για την ανάθεση");
				return false;
			}
		});
    });


	function radio_click()
	{
		var pending = ($('input[name=filter1]:checked').val() == "pending") ? 1 : 0;
		var current = ($('input[name=filter2]:checked').val() == "current") ? 1 : 0;

		window.location.href = "admin_form.php?current="+current+"&pending="+pending;
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

	<?php
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');


		if (isset($_POST['id']))//to id ths workoffer
		{
			$work_id = $_POST['id'];
			$query = "UPDATE work_offers SET published = '1' WHERE id='$work_id'";
			$result_set = mysql_query($query,$con);
			confirm_query($result_set);
		}


		if (isset($_GET['pending']) && isset($_GET['current'])) {  
			$pending = $_GET['pending'];
			$current = $_GET['current'];
		} else {
			$pending = 1;
			$current = 1;
		}

		$result = get_workoffer_list($auth->mail, $personal, $current);

	?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
	<aside class="column first" id="optimized">

		<div id="container">
			<div class="full_width big">
				<h2>Φόρμα Έγκρισης Παροχών</h2> 
				<br />
			</div>
			
			<form id="myForm"  method="POST" >
				<div id="demo" ></div>
				<div class="demo_jui" id="demo_jui">
				
				<table style="width: 350px">
				<tr>
					<td><label>Προς έγκριση παροχές</td>
					<td><input type="radio" name="filter1" onClick="radio_click();" value="pending" <?php if ($pending)  {echo "checked=\"true\"";}?> /></label></td>
					<td style="width: 50px"></td>
					<td><label>Εγκεκριμένες παροχές</td>
					<td><input type="radio" name="filter1" onClick="radio_click();" value="notpending" <?php if (!$pending) {echo "checked=\"true\"";}?> /></label></td>
				</tr>
				<tr>
					<td><label>Τρέχοuσες παροχές</td>
					<td><input type="radio" name="filter2" onClick="radio_click();" value="current" <?php if ($current) {echo "checked=\"true\"";}?> /></label></td>
					<td style="width: 50px"></td>
					<td><label>Παλιές παροχές</td>
					<td><input type="radio" name="filter2" onClick="radio_click();" value="old" <?php if (!$current) {echo "checked=\"true\"";}?>/></label></td>
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
						<th>Παραδοτέα</th>
						<th>Λήξη προθεσμίας υποβολής</th>
						<th>Ημερομηνία έναρξης</th>
						<th>Ημερομηνία λήξης</th>
					</tr>
				</thead>
				<tbody>	
				<?php	while($row = mysql_fetch_assoc($result))
					{
						extract($row);
						echo "<tr>\n";
						echo "<td>$id</td><td>$professor_name</td><td>$title</td><td>$candidates</td><td>$hours</td><td>$requirements</td><td>$deliverables</td><td>$deadline</td><td>$start_date</td><td>$end_date</td>";
						echo "</tr>\n";
					}
				?>	
				</tbody>
				</table>
				
				<br />
				<p>
				<input class="button" type="submit" name="submit_btn" value="Έγκριση παροχής"  />
				</p>
				</div>
			</form>
		</div>
	</aside>
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

