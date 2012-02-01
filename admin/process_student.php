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
	<script type="text/javascript" language="javascript" src="dataTables/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="media/js/ZeroClipboard.js"></script>
	<script type="text/javascript" language="javascript" src="media/js/TableTools.min.js"></script>
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
					/* StudId */{"bVisible": false },
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
			var studid = (fnGetSelected(oTable));
			var str = '<input type="hidden" name="id" value="'+studid+'"/>';
			$('#demo').html(str);
		});
		
		$('#myStudForm').submit(function()
		{
			var studid = (fnGetSelected(oTable));
			
			if (studid != null)//έχει επιλεγεί κάποιο φοιτητή
			{
				return true;
			}
			else//δεν έχει επιλέξει κάποιο φοιτητή
			{
				alert("Πρέπει πρώτα να επιλέξετε ένα φοιτητή");
				return false;
			}
		});
		
		}); 
		
		function redirect_menu()
		{
			window.location.href = "/admin/student_form_processing.php";
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
	     $email = $auth->email;
//		 echo $email;
		 
		switch($auth->is_admin)
		{
			case auth::Student:
//			echo "foithths";
			
			 $query_id = "SELECT id FROM users WHERE email='$email'";			 
			 $result_set_id = mysql_query($query_id,$con);
			 confirm_query($result_set_id);
			 $row_id = mysql_fetch_assoc($result_set_id);
			
			 $stud_id = $row_id['id'];
//			 echo $stud_id;
			 
			 if(isset($_GET['id']))
			 {
		     echo $_GET['id'];
			 echo "server error: Παρακαλώ συνδεθείτε ξανα";
			 }
			 else 
			 {
			 $_GET = array("id" => $stud_id);
//			 print_r($_POST['id']);	
			 
			 $query = "SELECT * FROM users WHERE id='$stud_id'";
			 $result_set = mysql_query($query,$con);
			 confirm_query($result_set);
			 $row = mysql_fetch_assoc($result_set);
			 extract($row); 	
			 }
			break;
			
			case auth::Admin:
//			echo "admin";
			
			if(isset($_GET['id'])) //exei epilexsei kapoio foithth
			{
					$stud_id = $_GET['id'];
					$query = "SELECT * FROM users WHERE id='$stud_id'";
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
					$row = mysql_fetch_assoc($result_set);
					extract($row);
			}		
			else  //validation
			{
				echo "<p>Δεν έχετε επιλέξει κάποιον φοιτητή!</p>";
			}	
			break;
			
			case auth::Professor:
//			echo "professor";
			echo "Δεν έχετε δικαίωμα πρόσβασης στη σελίδα αυτή";		
			break;
		}
?>
     								
	                <div id="container">
        	                <div class="full_width big">
                	                <h2>Επεξεργασία φοιτητή</h2>
                        	         <br />
	                        </div>

					<form action="student_update.php" method="post">
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
							<td>Αριθμός Μητρώου </td><td><input type="text" name="reg_numb" value="<?php echo $reg_numb;?>" /></td>
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
							<td>Βιογραφικό </td><td><textarea name="cv" cols="40" rows="4"><?php echo $cv; ?></textarea></td>
						</tr>
					    </table>
					    <br>
					    <p><input class="button" type="button" id="edit_btn" onClick="redirect_menu();" value="Ακύρωση" />
						<input class="button" type="submit" name="submit" value="Καταχώρηση" /></td>
						</br>
					</form>  
					<?php mysql_close($con); ?>
			</div>
	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html>
