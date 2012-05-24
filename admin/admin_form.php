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
		
		if($('input[name=filter1]:checked').val() == "one")
		{
			if($('input[name=filter2]:checked').val() == "current")
			{
				if($('input[name=filter3]:checked').val() == "live")
				{
					window.location.href="admin_form.php?choice=111";
				}
				else
				{
					window.location.href="admin_form.php?choice=112";
				}
			}
			else
			{
				if($('input[name=filter3]:checked').val() == "live")
				{
					window.location.href="admin_form.php?choice=121";
				}
				else
				{
					window.location.href="admin_form.php?choice=122";
				}
			}
		}
		else
		{
			if($('input[name=filter2]:checked').val() == "current")
			{
				if($('input[name=filter3]:checked').val() == "live")
				{
					window.location.href="admin_form.php?choice=211";
				}
				else
				{
					window.location.href="admin_form.php?choice=212";
				}
			}
			else
			{
				if($('input[name=filter3]:checked').val() == "live")
				{
					window.location.href="admin_form.php?choice=221";
				}
				else
				{
					window.location.href="admin_form.php?choice=222";
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
	<?php 
		if (isset($_POST['id']))//to id ths workoffer
		{
		$work_id = $_POST['id'];
		$query = "UPDATE work_offers SET published = '1' WHERE id='$work_id'";
		$result_set = mysql_query($query,$con);
		confirm_query($result_set);
	?>
		<div id="container">
			<div class="full_width big">
				<h2>Φόρμα Έγκρισης Παροχών</h2> 
				<br />
			</div>
			
			<form id="myForm"  method="POST" >
				<div id="demo" ></div>
				<div class="demo_jui" id="demo_jui">
				
				<?php   
				if (isset($_GET['choice']))
				{  
					$choice = $_GET['choice'];
					$result = get_admin_data($choice);
				}
				else
				{
					$choice = "111";//proswpikes-trexon etos-energes
					$result = get_admin_data($choice);
				}
				?>
				<table style="width: 300px">
				<tr>
					<td><label>Εγκεκριμένες παροχές</td>
					<td><input type="radio" name="filter1" onClick="radio_click();" value="one" 
					<?php if($choice=="111"||$choice=="112"||$choice=="121"||$choice=="122"){echo "checked=\"true\"";}?> /></label></td>
					<td><label>Προς έγκριση παροχές</td>
					<td><input type="radio" name="filter1" onClick="radio_click();" value="all"
					<?php if($choice=="211"||$choice=="212"||$choice=="221"||$choice=="222"){echo "checked=\"true\"";}?> /></label></td>
				</tr>
				<tr>
					<td><label>Τρέχοντος έτους</td>
					<td><input type="radio" name="filter2" onClick="radio_click();" value="current"
					<?php if($choice=="111"||$choice=="112"||$choice=="211"||$choice=="212"){echo "checked=\"true\"";}?> /></label></td>
					<td><label>Παλιότερων ετών</td>
					<td><input type="radio" name="filter2" onClick="radio_click();" value="old"
					<?php if($choice=="121"||$choice=="122"||$choice=="221"||$choice=="222"){echo "checked=\"true\"";}?>/></label></td>
				</tr>
				<tr>
					<td><label>Ενεργές παροχές</td>
					<td><input type="radio" name="filter3" onClick="radio_click();" value="live"
					<?php if($choice=="111"||$choice=="121"||$choice=="211"||$choice=="221"){echo "checked=\"true\"";}?> /></label></td>
					<td><label>Ανενεργές παροχές</td>
					<td><input type="radio" name="filter3" onClick="radio_click();" value="dead"
					<?php if($choice=="112"||$choice=="122"||$choice=="212"||$choice=="222"){echo "checked=\"true\"";}?>/></label></td>
				</tr>
				</table>
				<br />	
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
				<?php	while($row = mysql_fetch_assoc($result))
						{
							extract($row);
							echo "<tr>\n";
							$ayear_row = get_ayear_from_academic_year_id($academic_year_id);
							echo "<td>$id</td><td>$professor_name</td><td>$title</td><td>$candidates</td><td>$requirements</td><td>$deliverables</td><td>$hours</td><td>$deadline</td><td>$ayear_row[ayear]</td>";
							echo "<td><input type='checkbox' disabled='true' " . (($winter_semester == 1) ? "checked='true'" : "checked='false'") . ">";
							echo "</td></tr>\n";
						}			
				?>	
				</tbody>
				</table>
				
				<br />
				<p>
				<?php if($choice=="211"){?><input class="button" type="submit" name="submit_btn" value="Έγκριση παροχής"  /><?php	}?>
				</p>
				</div>
			</form>		
		</div>
	<?php
		}
		else{
	?>
		<div id="container">
			<div class="full_width big">
				<h2>Φόρμα Έγκρισης Παροχών</h2> 
				<br />
			</div>
			
			<form id="myForm"  method="POST" >
				<div id="demo" ></div>
				<div class="demo_jui" id="demo_jui">
				
				<?php   
				if (isset($_GET['choice']))
				{  
					$choice = $_GET['choice'];
					$result = get_admin_data($choice);
				}
				else
				{
					$choice = "111";//proswpikes-trexon etos-energes
					$result = get_admin_data($choice);
				}
				?>
				<table style="width: 300px">
				<tr>
					<td><label>Εγκεκριμένες παροχές</td>
					<td><input type="radio" name="filter1" onClick="radio_click();" value="one" 
					<?php if($choice=="111"||$choice=="112"||$choice=="121"||$choice=="122"){echo "checked=\"true\"";}?> /></label></td>
					<td><label>Προς έγκριση παροχές</td>
					<td><input type="radio" name="filter1" onClick="radio_click();" value="all"
					<?php if($choice=="211"||$choice=="212"||$choice=="221"||$choice=="222"){echo "checked=\"true\"";}?> /></label></td>
				</tr>
				<tr>
					<td><label>Τρέχοντος έτους</td>
					<td><input type="radio" name="filter2" onClick="radio_click();" value="current"
					<?php if($choice=="111"||$choice=="112"||$choice=="211"||$choice=="212"){echo "checked=\"true\"";}?> /></label></td>
					<td><label>Παλιότερων ετών</td>
					<td><input type="radio" name="filter2" onClick="radio_click();" value="old"
					<?php if($choice=="121"||$choice=="122"||$choice=="221"||$choice=="222"){echo "checked=\"true\"";}?>/></label></td>
				</tr>
				<tr>
					<td><label>Ενεργές παροχές</td>
					<td><input type="radio" name="filter3" onClick="radio_click();" value="live"
					<?php if($choice=="111"||$choice=="121"||$choice=="211"||$choice=="221"){echo "checked=\"true\"";}?> /></label></td>
					<td><label>Ανενεργές παροχές</td>
					<td><input type="radio" name="filter3" onClick="radio_click();" value="dead"
					<?php if($choice=="112"||$choice=="122"||$choice=="212"||$choice=="222"){echo "checked=\"true\"";}?>/></label></td>
				</tr>
				</table>
				<br />	
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
				<?php	while($row = mysql_fetch_assoc($result))
						{
							extract($row);
							echo "<tr>\n";
							$ayear_row = get_ayear_from_academic_year_id($academic_year_id);
							echo "<td>$id</td><td>$professor_name</td><td>$title</td><td>$candidates</td><td>$requirements</td><td>$deliverables</td><td>$hours</td><td>$deadline</td><td>$ayear_row[ayear]</td>";
							echo "<td><input type='checkbox' disabled='true' " . (($winter_semester == 1) ? "checked='true'" : "checked='false'") . ">";
							echo "</td></tr>\n";
						}			
				?>	
				</tbody>
				</table>
				
				<br />
				<p>
				<?php if($choice=="211"){?><input class="button" type="submit" name="submit_btn" value="Έγκριση παροχής"  /><?php	}?>
				</p>
				</div>
			</form>		
		</div>
	<?php	}	?>
	</aside>
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

