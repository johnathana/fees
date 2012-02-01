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
					/* ProfId */{"bVisible": false },
					/* Product */null,
					/* Description */null,
					/* Rating */null,
					/* Price */null,
					/* Product */null,
					/* Description */null,
					/* Rating */null,
					/* Product */null,
			]
		});
		
		var oTableTools = new TableTools( oTable, {
			"sSwfPath": "../media/swf/copy_cvs_xls_pdf.swf"
        } );
		
		$('#demo_jui').before( oTableTools.dom.container );		
		
		/* Add a click handler to the rows - this could be used as a callback */
		$("#example tbody").click(function(event) {
			$(oTable.fnSettings().aoData).each(function (){
				$(this.nTr).removeClass('row_selected');
			});
			$(event.target.parentNode).addClass('row_selected');
			var profid = (fnGetSelected(oTable));
			var str = '<input type="hidden" name="id" value="'+profid+'"/>';
			$('#demo').html(str);
		});
		
		}); 
		
	//	$('#myProfForm').submit(function()
	    function redirect_change()
		{
			var profid = (fnGetSelected(oTable));
		
			if (profid == null) // δεν έχει επιλεγεί κάποιο καθηγητή
			{
			    alert("Πρέπει πρώτα να επιλέξετε ένα καθηγητή");
				return false;
			}
			else     //έχει επιλέξει κάποιο καθηγητή				
			{
			    window.location.href="/admin/process_prof.php?id="+profid+"";		
			 } 
		}
		function redirect_insert()
		{
			window.location.href = "/admin/process_new_prof.php";
		}
			function redirect_menu()
		{
			window.location.href = "/admin/admin_menu.php";
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
				<h2>Πίνακας Καθηγητών</h2>
             <br />				
			</div>
			<h3>Επιλέξτε διδάσκοντα και στη συνέχεια πατήστε "επεξεργασία" για την επεξεργασία των στοιχείων του ή επιλέξτε "καταχώρηση νέου διδάσκοντα" για τη δημιουργία νέου λογαριασμού</h3>
			<form id="myProfForm" method="POST" >
				<div id="demo" ></div>
				
				<?php
					$query = "SELECT * FROM users WHERE is_admin='2'";//get all professors
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
				?>
				
				<div class="demo_jui" id="demo_jui">
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
				<thead>
					<tr>
					    <th>ID καθηγητή</th>
						<th>Επώνυμο</th>
						<th>Όνομα</th>
						<th>E-mail</th>
						<th>Τηλέφωνο</th>
						<th>Φύλλο</th>
						<th>Πληροφορίες</th>
						<th>Ημερομηνία δημιουργίας λογαριασμού</th>
						<th>Τελευταία είσοδος στο σύστημα</th>
					</tr>
				</thead>
				<tbody>	
				<?php 	while($row = mysql_fetch_assoc($result_set))
						{
	 	 	        	 echo "<tr>";
			     		 extract($row);
						 if($sex=='m')
							{$fyllo="Άρεν";}
						 elseif($sex=='f')
							{$fyllo="Θήλυ";}
						 else
							{$fyllo="???";} 
						 echo "<td>$id</td><td>$surname</td><td>$name</td><td>$email</td><td>$phone</td>
								<td>$fyllo</td><td>$cv</td><td>$created</td><td>$last_login</td>";
					     echo "</tr>"; 
						} 		
				?>	
				</tbody> 
				</table>
				<br>
				<p>
				 <input class="button" type="button" id="edit_btn" onClick="redirect_menu();" value="Αρχικό μενού"  />	
	             <input class="button" type="button" id="edit_btn" onClick="redirect_change();" value="Επεξεργασία"  />	
				 <input class="button" type="button" id="edit_btn" onClick="redirect_insert();" value="Kαταχώρηση νέου διδάσκοντα"  />	
				</p>
				<input type='hidden' name='sent_prof' value='yes' />
			</form>	
			
			
		</div>
			<div class="spacer"></div>

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

