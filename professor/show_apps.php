<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mail.php');		
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	 ?>
	<title>Πίνακας παροχών</title>
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
        /* WorkAppId */{"bVisible": false },
        /* Applied */null,
        /* Accepted */null,
        /* Name */null,
        /* Email */null,
        ]
		});
		
		var oTableTools = new TableTools( oTable, {
			"sSwfPath": "../media/swf/copy_cvs_xls_pdf.swf",
			"aButtons": [ "copy","xls", "print" ]
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
			var accepted = (fnGetSelected1(oTable));
			if (accepted == 'ΝΑΙ'){
			$('input[name=submit_btn]').attr('disabled',true);
			$('input[name=erase]').attr('disabled',false);
			}
			else{
			$('input[name=erase]').attr('disabled',true);
			$('input[name=submit_btn]').attr('disabled',false);
			}
			if(workapp_id!=null)
			{
				$.post('html_onclick.php',{ id : workapp_id },
				function(data)
				{
					var condition = JSON.parse(data);

					if(condition.answer == "nothing"){
					var str1 = '<div style="font-family:arial;color:red;">Ο φοιτητής δεν έχει γίνει δεκτός σε κάποια παροχή.</div>';
					$('#test').html(str1);
					}
					else{
					var str1 = '<div style="font-family:arial;color:red;">Ο φοιτητής έχει γίνει δεκτός στις εξής παροχές: '+condition.answer+'</div>';
					$('#test').html(str1);
					
					}
				});
			}
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
		
		$('input[name=menu]').click(function()
		{
			window.location.href="/professor/prof_menu.php";
		}); 
		
		$('input[name=back]').click(function()
		{
			window.location.href="personal_workoffer_list.php";
		});
		
		$('input[name=btn]').click(function()
		{
		var workappid = fnGetSelected(oTable);
		if(workappid!=null)
		{
			$( "#dialog:ui-dialog" ).dialog( "destroy" );

			$.post('user_processing.php',{ id : workappid },
			function(data)
			{
			  $("#dialog-message").html(data);
			});

			$( "#dialog-message" ).dialog({
					modal: true,
					buttons: {
							Ok: function() {
									$( this ).dialog( "close" );
							}
					}
			});
		}
		else//δεν έχει επιλέξει κάποια παροχή 
		{
			alert("Πρώτα πρέπει να επιλέξετε μια παροχή έργου");
		}
		});
		$('input[name=erase]').click(function()
		{
		var workappid = fnGetSelected(oTable);
		if(workappid!=null)
		{
			$.post('recantation.php',{ id : workappid },
			function(data)
			{
			  alert(data);
			  if (data!=null)
			  {
				<?php if(isset($_GET['id'])){?>window.location.href="/professor/show_apps.php?id=<?php echo $_GET['id']?>";
				<?php }else{?>window.location.href="/professor/show_apps.php?id=<?php echo $_POST['workoffer_id']?>";<?php }?>
			  }
			});
			
			
		}
		else//δεν έχει επιλέξει κάποια παροχή 
		{
			alert("Πρώτα πρέπει να επιλέξετε μια παροχή έργου");
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
				}
			}
			return null;
		}
		function fnGetSelected1( oTableLocal )
		{
			var aReturn = new Array();
			var aTrs = oTableLocal.fnGetNodes();
			
			for ( var i=0 ; i<aTrs.length ; i++ )
			{
				if ( $(aTrs[i]).hasClass('row_selected') )
				{
					var aRowData = new Array();
					aRowData = oTable.fnGetData(aTrs[i]);

					return aRowData[2];
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
		<div id="dialog-message" title="Πληροφορίες φοιτητή" hidden></div>
		

	<?php 
		
			if(isset($_GET['id']))//exei epilexsei kapoia paroxi apo to personal workoffer list
			{
				$workid = $_GET['id'];
				$query1 = "SELECT candidates, title, is_available FROM work_offers WHERE id = '$workid'";
				$res = mysql_query($query1,$con);
				confirm_query($res);
				$row1 = mysql_fetch_assoc($res);?>
				<div id="container">
				<div class="full_width big">
				<h2>Πίνακας αιτήσεων για την παροχή <?php echo $row1['title'];?></h2>
				<br />
				<div id="test" ></div>
				</div>
				<?php
				$query = "SELECT * FROM work_applications WHERE work_id = '$workid' AND accepted = '1'";
				$workapps = mysql_query($query, $con);
				confirm_query($workapps);
				$row = mysql_fetch_assoc($workapps);
				if($row1['candidates'] == mysql_num_rows($workapps))
					echo "Έχει συμπληρωθεί ο μέγιστος αριθμός φοιτητών"."<br />";

				if ($row1['is_available'] == 0)
					echo "Η παροχή έχει απενεργοποιηθεί"."<br />";
				
				$query = "SELECT * FROM work_applications WHERE work_id = '$workid'";
				$workapps = mysql_query($query,$con);
				confirm_query($workapps);?>
				 	<form id="myForm" action="show_apps.php" method="POST" >
					<input type="hidden" name="workoffer_id" value="<?php echo $_GET['id'];?>" />
					<div id="demo" ></div>
					<div class="demo_jui" id="demo_jui"></div>
						<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
						<thead>
							<tr>
								<th>ID αίτησης</th>
								<th>Ημερ/νια αίτησης</th>
								<th>Του/Της έχει ανατεθεί</th>
								<th>Όνομα φοιτητή</th>
								<th>Email φοιτητή</th>
							</tr>
						</thead>
						<tbody>

						<?php
							while($row = mysql_fetch_assoc($workapps))
							{
								extract($row);
								$accepted = ($accepted == 1) ? "Ναι" : "Όχι";

								echo "<tr>";
								echo "<td>$id</td><td>$applied</td><td>$accepted</td><td>$student_name</td><td>$student_email</td>";
								echo "</tr>";
							}
						?>

						</tbody>
						</table>
						<br />
						<p><input class="button" type="button" name="back" value="Πίσω"  />
						<input type="button" name="menu" value="Αρχικό μενού" class="button"/>
						<input class="button" type="submit" name="submit_btn" value="Ανάθεση παροχής στο φοιτητή"  />
						<input class="button" type="button" name="erase" value="Αναίρεση παροχής από φοιτητή"  />
						<input class="button" type="button" name="btn" value="Πληροφορίες"  /></p>
					</form>
				</div>
				<?php		
			}
			//diadikasia anathesis paroxis sto foititi
			elseif (isset($_POST['workoffer_id']))//to id ths work-offer
			{
				if (isset($_POST['id']))//to id ths work-application
				{
					$workoffer_id = $_POST['workoffer_id'];
					$workapp_id = $_POST['id'];
					$query1 = "SELECT candidates,is_available,title FROM work_offers WHERE id='$workoffer_id'";
					$result_set1 = mysql_query($query1,$con);
					confirm_query($result_set1);
					$row1 = mysql_fetch_assoc($result_set1);
					$max_candidates = $row1['candidates'];?>
					<div id="container">
					<div class="full_width big">
					<h2>Πίνακας αιτήσεων για την παροχή <?php echo $row1['title'];?></h2>
					<br />
					<div id="test" ></div>
					</div>
					<?php
					$query2 = "SELECT * FROM work_applications WHERE work_id = '$workoffer_id' AND accepted = '1'";
					$workapps = mysql_query($query2,$con);
					confirm_query($workapps);
					if (mysql_num_rows($workapps) >= $max_candidates)
					{
						echo "Δεν μπορεί να γίνει η παραπάνω ανάθεση"."<br />";
						echo "Ο μέγιστος επιτρεπόμενος αριθμός φοιτητών είναι $max_candidates και τους έχετε ήδη επιλέξει"."<br />";
					}
					elseif ($row1['is_available'] == 0)
					{
						echo "Η παροχή έχει απενεργοποιηθεί"."<br />";
					}
					else
					{
						$query = "UPDATE work_applications SET accepted = '1' WHERE id='$workapp_id'";
						$result_set = mysql_query($query,$con);
						confirm_query($result_set);
						if(mysql_affected_rows() > 0)
						{	
							echo "Επιτυχής καταχώρηση στη βάση δεδομένων"."<br />";
							//diadikasia apostolis email
							$query5 = "SELECT student_email FROM work_applications WHERE id='$workapp_id'";
							$result_set5 = mysql_query($query5,$con);
							confirm_query($result_set5);
							$work_app_row = mysql_fetch_assoc($result_set5);
							$to = $work_app_row['student_email'];
							$subject = "Application accepted";
							$message = "Η αίτησή σας για την παροχή ".$row1['title']." έγινε αποδεκτή.";
							send_mail($to, $subject, $message);
							$query3 = "SELECT * FROM work_applications WHERE work_id = '$workoffer_id' AND accepted = '1'";
							$workapps = mysql_query($query3,$con);
							confirm_query($workapps);
							if (mysql_num_rows($workapps) == $max_candidates)
							{
								$que = "UPDATE work_offers SET is_available = '0' WHERE id='$workoffer_id'";
								$result_set = mysql_query($que,$con);
								confirm_query($result_set);
							}
						}	
					}
					$query = "SELECT * FROM work_applications WHERE work_id = '$workoffer_id'";
					$workapps = mysql_query($query,$con);
					confirm_query($workapps);?>
						<form id="myForm" action="show_apps.php" method="POST" >
						<input type="hidden" name="workoffer_id" value="<?php echo $_POST['workoffer_id'];?>" />
						<div id="demo" ></div>
						<div class="demo_jui" id="demo_jui"></div>
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
							<thead>
								<tr>
									<th>ID αίτησης</th>
									<th>Ημερ/νια αίτησης</th>
									<th>Του/Της έχει ανατεθεί</th>
									<th>Όνομα φοιτητή</th>
									<th>Email φοιτητή</th>
								</tr>
							</thead>
							<tbody>	
						<?php
						while($row = mysql_fetch_assoc($workapps))
						{
							extract($row);
							if($accepted == 1)
								$accepted = "ΝΑΙ";
							else
								$accepted = "ΟΧΙ";
							echo "<tr>";	
							echo "<td>$id</td><td>$applied</td><td>$accepted</td><td>$student_name</td><td>$student_email</td>";
							echo "</tr>";
						}
						?>
							</tbody>
							</table>
							<br />
							<p>
								<input class="button" type="button" name="back" value="Πίσω"  />
								<input type="button" name="menu" value="Αρχικό μενού" class="button"/>
								<input class="button" type="submit" name="submit_btn" value="Ανάθεση παροχής στο φοιτητή"  />
								<input class="button" type="button" name="erase" value="Αναίρεση παροχής από φοιτητή"  />
								<input class="button" type="button" name="btn" value="Πληροφορίες"  />
							</p>
						</form>
					</div><?php
				}
			}
			else//validation
			{
				echo "<p>Δεν έχετε επιλέξει κάποια παροχή!</p>";
				?><p>Επιστροφή στις <a href="personal_workoffer_list.php">παροχές μου</a></p>
				<?php
			}
		
		mysql_close($con);
	 
	?>

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

