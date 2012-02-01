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
					/* Professor */null,
					/* Title */null,
					/* Lesson */null,
					/* Candidates */null,
					/* Requirements*/null,
					/* Deliverables */null,
					/* Hours */null,
					/* Deadline */null,
					/* At_di */null,
					/* Acad_year */null,
					/* Winter */null,
					/* Addressed */null
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
			var workid = (fnGetSelected(oTable));
			var str = '<input type="hidden" name="id" value="'+workid+'"/>';
			$('#demo').html(str);
		});
		$('input[name=menu1]').click(function()
		{
			window.location.href="/admin/admin_menu.php";
		});
		$('input[name=menu2]').click(function()
		{
			window.location.href="/professor/prof_menu.php";
		});
		}); 
		function radio_click()
		{
			
			if($('input[name=myradio]:checked').val() == "live")
			{
				window.location.href="personal_workoffer_list.php?check=live";
			}
			else
				window.location.href="personal_workoffer_list.php?check=notlive"; 
		}
		function check_redirect1()
		{
			var workid = (fnGetSelected(oTable));
			
			if (workid == null)//δεν έχει επιλέξει κάποια παροχή
			{
				alert("Πρέπει πρώτα να επιλέξετε μια παροχή έργου");
				return false;
			}
			else //έχει επιλεγεί κάποια παροχή
			{
				window.location.href="edit_workoffer.php?id="+workid+"";
			}
		}
		function check_redirect2()
		{
			var workid = (fnGetSelected(oTable));
			
			if (workid == null)//δεν έχει επιλέξει κάποια παροχή
			{
				alert("Πρέπει πρώτα να επιλέξετε μια παροχή έργου");
				return false;
			}
			else //έχει επιλεγεί κάποια παροχή
			{
				window.location.href="show_apps.php?id="+workid+"";
			}
		}
		function redirect_create()
		{
			window.location.href = "/professor/prof_menu.php";
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
		if (isset($_POST['id']))//exei ginei edit i paroxi kai twra kanoume update sti vasi prin ti fortwsi tou pinaka
		{
			$workoffer_id = $_POST['id'];
			$title = trim($_POST['title']);
			$lesson = trim($_POST['lesson']);
			$candidates = trim($_POST['candidates']);
			$requirements = trim($_POST['requirements']);
			$deliverables = trim($_POST['deliverables']);
			$hours = trim($_POST['hours']);
			$addressed = ($_POST['addressed']);
			$deadline = ($_POST['deadline']);
			if (isset($_POST['at_di']))
				$at_di = ($_POST['at_di'] == "on"  ? 1 : 0);
			else
				$at_di = 0;	
			if (isset($_POST['winter'])) 
				$winter = ($_POST['winter'] == "on" ? 1 : 0);
			else 
				$winter = 0;
			if (isset($_POST['non_available']))
			{
				$is_available = ($_POST['non_available'] == "on" ? 0 : 1);
				if (isset($_POST['submit']) && $_POST['submit'] == "Καταχώρηση")
				{
					$query = "UPDATE work_offers SET title = '$title', lesson = '$lesson', candidates = '$candidates',  requirements = '$requirements', deliverables = '$deliverables', hours = '$hours', deadline = '$deadline', at_di = '$at_di', winter_semester = '$winter', is_available = '$is_available', addressed_for = '$addressed' WHERE id='$workoffer_id'";
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
				}
			}
			else
			{	//elenxos an itan prin checked kai twra egine unchecked (diladi energopoiithike i paroxi)
				$query2 = "SELECT * FROM work_applications WHERE work_id = '".$_POST['id']."' AND accepted = '1'";
				$workapps = mysql_query($query2,$con);
				confirm_query($workapps);
				$q = "SELECT is_available FROM work_offers WHERE id = '".$_POST['id']."'";
				$result = mysql_query($q,$con);
				confirm_query($result);
				$row = mysql_fetch_assoc($result);
				if (mysql_num_rows($workapps) == 0 && $row['is_available'] == 0)
				{
					$is_available = 1;
					if (isset($_POST['submit']) && $_POST['submit'] == "Καταχώρηση")
					{
						$query = "UPDATE work_offers SET title = '$title', lesson = '$lesson', candidates = '$candidates',  requirements = '$requirements', deliverables = '$deliverables', hours = '$hours', deadline = '$deadline', at_di = '$at_di', winter_semester = '$winter', is_available = '$is_available', addressed_for = '$addressed' WHERE id='$workoffer_id'";
						$result_set = mysql_query($query,$con);
						confirm_query($result_set);
					}
				}
				else//itan kai prin kai meta unchecked h itan disabled (diladi unchecked)
				{
					if (isset($_POST['submit']) && $_POST['submit'] == "Καταχώρηση")
					{
						//apla den ginetai update to is_available kai paramenei oti itan prin sti vasi
						/*na elenxsw an itan prin sti vasi to is_avail 0 kai meta o prof afxsise tous candidates*/
						$q = "SELECT candidates FROM work_offers WHERE id = '".$_POST['id']."'";
						$result = mysql_query($q,$con);
						confirm_query($result);
						$row = mysql_fetch_assoc($result);
						if ($row['candidates'] == $candidates)//den allaxse to plithos twn candidates
						{
							$query = "UPDATE work_offers SET title = '$title', lesson = '$lesson', candidates = '$candidates',  requirements = '$requirements', deliverables = '$deliverables', hours = '$hours', deadline = '$deadline', at_di = '$at_di', winter_semester = '$winter', addressed_for = '$addressed' WHERE id='$workoffer_id'";
							$result_set = mysql_query($query,$con);
							confirm_query($result_set);
						}
						else//eite meiwthike eite afxsithike to plithos twn candidates
						{
							if ($row['candidates'] < $candidates)
							{
								$is_available = 1;
								$query = "UPDATE work_offers SET title = '$title', lesson = '$lesson', candidates = '$candidates',  requirements = '$requirements', deliverables = '$deliverables', hours = '$hours', deadline = '$deadline', at_di = '$at_di', winter_semester = '$winter', is_available = '$is_available', addressed_for = '$addressed' WHERE id='$workoffer_id'";
								$result_set = mysql_query($query,$con);
								confirm_query($result_set);
							}
							else//diladi $row['candidates'] > $candidates)
							{
								if ($candidates == mysql_num_rows($workapps)) { $is_available = 0; }
								else { $is_available = 1; }//gia tin akriveia itan 1 kai paramenei 1 giati logw edit_workoffer panda to $candidates >= mysql_num_rows($workapps)
								$query = "UPDATE work_offers SET title = '$title', lesson = '$lesson', candidates = '$candidates',  requirements = '$requirements', deliverables = '$deliverables', hours = '$hours', deadline = '$deadline', at_di = '$at_di', winter_semester = '$winter', is_available = '$is_available', addressed_for = '$addressed' WHERE id='$workoffer_id'";
								$result_set = mysql_query($query,$con);
								confirm_query($result_set);
							}
						}
					}
				}
			}
		}
	?>
		<div id="container">
			<div class="full_width big">
				<h2>Διαχείριση Παροχών</h2>
				<br />
			</div>

			<p>Επιλέξτε μια παροχή και στη συνέχεια πατήστε επεξεργασία για τροποποίηση της συγκεκριμένης παροχής ή επιλέξτε αιτήσεις για να δείτε τις αιτήσεις των φοιτητών</p>
			<form id="myForm"  method="POST" >
				<div id="demo" ></div>
				<div class="demo_jui" id="demo_jui">
				
				<?php   
				if (isset($_GET['check']) && $_GET['check'] == "notlive"){  ?>
				<table style="width: 150px">
				<tr>
					<td><label>Ενεργές παροχές</td>
					<td><input type="radio" name="myradio" onClick="radio_click();" value="live" /></label></td>
				</tr>
				<tr>
					<td><label>Ανενεργές παροχές</td>
					<td><input type="radio" name="myradio" onClick="radio_click();" value="dead" checked="true" /></label></td>
				</tr>
				</table>
				<?php
					switch ($auth->is_admin) {
					case auth::Student :
						die("Unauthorized access");
					case auth::Admin :
						$query = "SELECT * FROM work_offers WHERE has_expired = true";//fere tis anenerges paroxes olwn twn kathigitwn 
						$result_set = mysql_query($query,$con);
						confirm_query($result_set);
						break;
					case auth::Professor :
						$query = "SELECT * FROM work_offers WHERE professor_id = '".$auth->id."' AND has_expired = true";//fere tis anenerges paroxes enos kathigiti
						$result_set = mysql_query($query,$con);
						confirm_query($result_set);
						break;
					}
				}
				else { 
				?>
				<table style="width: 150px">
				<tr>
					<td><label>Ενεργές παροχές</td>
					<td><input type="radio" name="myradio" onClick="radio_click();" value="live" checked="true" /></label></td>
				</tr>
				<tr>
					<td><label>Ανενεργές παροχές</td>
					<td><input type="radio" name="myradio" onClick="radio_click();" value="dead"  /></label></td>
				</tr>
				</table>
				<?php
					switch ($auth->is_admin) {
					case auth::Student :
						die("Unauthorized access");
					case auth::Admin :
						$query = "SELECT * FROM work_offers WHERE has_expired = false";//fere tis energes paroxes olwn twn kathigitwn 
						$result_set = mysql_query($query,$con);
						confirm_query($result_set);
						break;
					case auth::Professor :
						$query = "SELECT * FROM work_offers WHERE professor_id = '".$auth->id."' AND has_expired = false";//fere tis anenerges paroxes enos kathigiti
						$result_set = mysql_query($query,$con);
						confirm_query($result_set);
						break;
					}
				}
				?>
				
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
				<thead>
					<tr>
						<th>ID παροχής</th>
						<th>Καθηγητής</th>
						<th>Τίτλος παροχής</th>
						<th>Τίτλος μαθήματος</th>
						<th>Αριθμός υποψηφίων</th>
						<th>Απαιτήσεις γνώσεων</th>
						<th>Παραδοτέα </th>
						<th>Απαιτούμενες ώρες υλοποίησης</th>
						<th>Λήξη προθεσμίας</th>
						<th>Στο χώρο του πανεπιστημίου</th>
						<th>Ακαδημαϊκό έτος</th>
						<th>Χειμερινού εξαμήνου</th>
						<th>Απευθύνεται σε φοιτητή</th>
					</tr>
				</thead>
				<tbody>	
				<?php	while($row = mysql_fetch_assoc($result_set))
						{
							echo "<tr>";
							extract($row);
							if($addressed_for==0)
								{$student_type="Μη εργαζόμενο";}
							elseif($addressed_for==1)
								{$student_type="Μερικώς εργαζόμενο";}
							else
								{$student_type="Πλήρως εργαζόμενο";}
							/*Βρίσκουμε τις τιμές που θέλουμε μέσω των ξένων κλειδιών*/
							$row1 = get_surname_from_professor_id($professor_id);
							$row2 = get_ayear_from_academic_year_id($academic_year_id);
							echo "<td>$id</td><td>$row1[surname]</td>
								<td>$title</td><td>$lesson</td><td>$candidates</td><td>$requirements</td><td>$deliverables</td>
								<td>$hours</td><td>$deadline</td><td>";
							if($at_di==false)
								echo "<input type='checkbox' disabled='true'>";
							else
								echo"<input type='checkbox' disabled='true' checked='true'>";
							echo "</td><td>$row2[ayear]</td><td>";
							if($winter_semester==false)
								echo "<input type='checkbox' disabled='true'>";
							else
								echo"<input type='checkbox' disabled='true' checked='true'>";
							echo"</td><td>$student_type</td>";
							echo "</tr>";
						}			
				?>	
				</tbody>
				</table>
				
				<br />
				<p>
					
					<?php switch ($auth->is_admin) {
					case auth::Admin :?>
					<input type="button" id="admin" name="menu1" value="Αρχικό μενού" class="button"/>
					<?php	break;
					case auth::Professor :?>
					<input type="button" id="prof" name="menu2" value="Αρχικό μενού" class="button"/>
					<?php	break;	}?>
					<input class="button" type="button" id="edit_btn" onClick="check_redirect1();" value="Επεξεργασία"  />
					<input class="button" type="button" id="apps_btn" onClick="check_redirect2();" value="Αιτήσεις για αυτήν την παροχή"  />
				</p>
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

