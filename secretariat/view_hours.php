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
	<script type="text/javascript" language="javascript" src="../dataTables/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="../media/js/ZeroClipboard.js"></script>
	<script type="text/javascript" language="javascript" src="../media/js/TableTools.min.js"></script>
		
		<script type="text/javascript" charset="utf-8">
		var oTable;
		
		$(document).ready(function(){ 
		$('#myForm').validate({	
								'rules':
									{'hours':'required'}
							  });
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
		
		var oTableTools = new TableTools( oTable, {
			"sSwfPath": "../media/swf/copy_cvs_xls_pdf.swf",
			"aButtons": [ "copy", "xls", "print" ]
        } );
		
		$('#demo_jui').before( oTableTools.dom.container );	
		
		/* Add a click handler to the rows - this could be used as a callback */
		$("#example tbody").click(function(event) {
			$(oTable.fnSettings().aoData).each(function (){
				$(this.nTr).removeClass('row_selected');
			});
			$(event.target.parentNode).addClass('row_selected');
			var workapp_id = (fnGetSelected(oTable));
			var str = '<input type="hidden" name="id" value="'+workapp_id+'"/>';
			$('#demo').html(str);
		});
		
		$('input[name=menu]').click(function()
		{
			window.location.href="/secretariat/secretariat_menu.php";
		}); 
		
		$('#myForm').submit(function()
		{
			var workapp_id = (fnGetSelected(oTable));
			
			if (workapp_id != null)//έχει επιλεγεί κάποια αίτηση φοιτητή
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
				<h2>Πίνακας Αναγνωρισμένων Ωρών Παροχών Έργου</h2> 
			</div>
			
			<form name="myForm" action="view_hours.php" method="POST">
				<div id="demo" ></div>
				<div class="demo_jui" id="demo_jui"></div>
				<?php
					if(isset($_POST['id']) && isset($_POST['hours']))
					{
						$workapp_id = $_POST['id'];
						$hours = $_POST['hours'];
						$query = "UPDATE work_applications SET hours_accepted = '$hours' WHERE id='$workapp_id'";
						$result_set = mysql_query($query,$con);
						confirm_query($result_set);
						$query1 = "SELECT student_email FROM work_applications group by student_email";
						$result_set1 = mysql_query($query1,$con);
						confirm_query($result_set1);
						
						while($row = mysql_fetch_assoc($result_set1))
						{
							print_r($row['student_email']);
							echo "<br />";
						}
						
					}
					else
					{
						//please don't die
					}
					
				?>
				
				
				
				<br />
				<p>
				<input type="button" name="menu" value="Αρχικό μενού" class="button"/>	</p>
			</form>	
			<div class="spacer"></div>
		</div>
	</aside> 
	</div><!--/content--> 
	 
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
	 
	</div><!--/globalfooter--> 
</body> 
</html>
