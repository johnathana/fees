<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	 ?>
	
	<style type="text/css" title="currentStyle">
		@import "dataTables/css/demo_page.css";
		@import "dataTables/css/demo_table_jui.css";
		@import "jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css";
		@import "media/css/TableTools.css";
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
					
			]
		});
		
		var oTableTools = new TableTools( oTable, {
			"sSwfPath": "media/swf/copy_cvs_xls_pdf.swf"
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
		
		$('#myForm').submit(function()
		{
			var profid = (fnGetSelected(oTable));
			
			if (profid != null)//έχει επιλεγεί κάποιο καθηγητή
			{
				return true;
			}
			else//δεν έχει επιλέξει κάποιο καθηγητή
			{
				alert("Πρέπει πρώτα να επιλέξετε ένα καθηγητή");
				return false;
			}
		});
			
		}); 
		
		function redirect_menu()
		{
			window.location.href = "/admin/prof_form_processing.php";
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

			if(isset($_GET['id'])) //exei epilexsei kapoio kathigiti
			{
					$prof_id = $_GET['id'];
					$query = "SELECT * FROM users WHERE id='$prof_id'";
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
					$row = mysql_fetch_assoc($result_set);
					extract($row); ?>
     								
					<h3>Επεξεργασία καθηγητή </h3>
					<form action="prof_update.php" method="post">
					<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
					<table>
						<tr>
							<td>Επώνυμο </td><td><input type="text" name="surname" value="<?php echo $surname;?>" /></td>
						</tr>
						<tr>
							<td>Όνομα </td><td><input type="text" name="name" value="<?php echo $name;?>" /></td>
						</tr>
						<tr>
							<td>E-mail </td><td><input type="text" name="email" value="<?php echo $email;?>" /></td>
						</tr>
						<tr>
							<td>Κωδικός Πρόσβασης </td><td><input type="text" name="passwd" value="<?php echo '*****';?>" /></td>
						</tr>
						<tr>
							<td>Τηλέφωνο </td><td><input type="text" name="phone" value="<?php echo $phone;?>" /></td>
						</tr>
						<tr>
							<td>Φύλλο </td><td><select name="sex">
							  <option value="0" <?php if ($sex == 'm') { ?> selected="selected"<?php } ?> >Άρεν</option>
							  <option value="1" <?php if ($sex == 'f') { ?> selected="selected"<?php } ?> >Θήλυ</option>
							</select></td>
						</tr>
						<tr>
							<td>Πληροφορίες </td><td><textarea name="cv" cols="40" rows="4"><?php echo $cv; ?></textarea></td>
						</tr>
						</table>
						<br>
						<p><input class="button" type="button" id="edit_btn" onClick="redirect_menu();" value="Ακύρωση" />
						<input class="button" type="submit" name="submit" value="Καταχώρηση" /></p>
						</br>			
					</form>  
					<?php
	    	}
					else  //validation
			{
				echo "<p>Δεν έχετε επιλέξει κάποιον καθηγητή!</p>";
			
			}
		 
		mysql_close($con); 
	    ?>

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 


