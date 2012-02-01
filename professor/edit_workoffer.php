<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	 ?>
	<title>Πίνακας παροχών</title>
	<style type="text/css" title="currentStyle">
		@import "../jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css";
	</style>
	<script type="text/javascript" src="../jquery-validation-1.8.0/jquery.validate.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		var oTable;
		
		$(document).ready(function(){ 
		$('#myForm').validate({
				'rules':{
						'title':'required',
						'requirements':'required',
						'deliverables':'required',
						'deadline':'required',
						'hours':'required'
						}
		});
		$('input[name=menu]').click(function()
		{
			window.location.href="/professor/prof_menu.php";
		});
		$( "#deadline" ).datepicker({ dateFormat: 'yy-mm-dd' });
		<?php 
		if(isset($_GET['id']))
		{
			$query2 = "SELECT * FROM work_applications WHERE work_id = '".$_GET['id']."' AND accepted = '1'";
			$workapps = mysql_query($query2,$con);
			confirm_query($workapps);
			$q = "SELECT is_available FROM work_offers WHERE id = '".$_GET['id']."'";
			$result = mysql_query($q,$con);
			confirm_query($result);
			$row = mysql_fetch_assoc($result);
			if (mysql_num_rows($workapps) >= 1)
			{
				?>$('input[name=non_available]').attr('disabled', true);
				  	<?php
			}
			if (mysql_num_rows($workapps) == 0 && $row['is_available'] == 0)//monadiki periptwsi na einai checked to pedio apenergopoiisi paroxis
			{
				?>$('input[name=non_available]').attr('checked', true); <?php
			}
		}
		?>
		}); 
	</script>
</head> 
	
<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">
		
		<div id="container">
			<div class="full_width big">
				<h2>Επεξεργασία παροχής </h2><br />
				<p>Μπορείτε να αυξομειώσετε το μέγεθος των πεδίων (Απαιτήσεις γνώσεων και Παραδοτέα) τραβώντας τα από την κάτω δεξιά μεριά. </p>
			</div>

	<?php 
			if(isset($_GET['id']))//exei epilegei kapoia paroxi
			{
					$workoffer_id = $_GET['id'];
					$query = "SELECT * FROM work_offers WHERE id='$workoffer_id'";
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
					$row = mysql_fetch_assoc($result_set);
					extract($row); ?>
					
					<form id="myForm" action="personal_workoffer_list.php" method="post">
					<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
					<table>
						<tr>
							<td>Τίτλος παροχής</td><td><input type="text" name="title" value="<?php echo $title;?>" /></td>
						</tr>
						<tr>
							<td>Τίτλος μαθήματος</td><td><input type="text" name="lesson" value="<?php echo $lesson;?>" /></td>
						</tr>
						<tr>
							<td>Αριθμός υποψηφίων</td>
							<td><select name="candidates">
							<?php for($i=mysql_num_rows($workapps);$i<5;$i++)
									{
										?><option value="<?php echo $i; ?>"<?php if ($candidates == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option><?php
									}
							?>
							</select></td>
						</tr>
						<tr>
							<td>Απευθύνεται σε φοιτητή</td><td><select name="addressed">
							  <option value="0" <?php if ($addressed_for == 0) { ?> selected="selected"<?php } ?> >Μη εργαζόμενο</option>
							  <option value="1" <?php if ($addressed_for == 1) { ?> selected="selected"<?php } ?> >Μερικώς εργαζόμενο</option>
							  <option value="2" <?php if ($addressed_for == 2) { ?> selected="selected"<?php } ?> >Πλήρως εργαζόμενο</option>
							</select></td>
						</tr>
						<tr>
							<td>Απαιτήσεις γνώσεων</td><td> <textarea name="requirements" cols="40" rows="3" ><?php echo $requirements; ?></textarea></td>
						</tr>
						<tr>
						<td>Παραδοτέα</td><td> <textarea name="deliverables" cols="40" rows="3" ><?php echo $deliverables; ?></textarea></td>
						</tr>
						<tr>
						<td>Απαιτούμενες ώρες υλοποίησης</td><td> <input type="text" name="hours" value="<?php echo $hours; ?>"/></td>
						</tr>
						<tr>
						<td>Στο χώρο του πανεπιστημίου</td><td> <input type="checkbox" name="at_di" <?php if($at_di==true) echo "checked='true'"; ?>  /></td>
						</tr>
						<tr>
						<td>Χειμερινού εξαμήνου</td><td> <input type="checkbox" name="winter" <?php if($winter_semester==true) echo "checked='true'"; ?> /></td>
						</tr>
						<tr>
						<td>Απενεργοποίηση παροχής</td><td> <input type="checkbox" id="non_available" name="non_available"  /></td>
						</tr>
						<tr>
						<td>Ημερομηνία λήξης</td><td><p><input id="deadline" name="deadline" type="text" value="<?php echo $deadline?>"></p></td>
						</tr>
						</table>
						<br />
						<p><input type="button" name="menu" value="Ακύρωση" class="button"/>
						<input class="button" type="submit" name="submit" value="Καταχώρηση" /></p>
						
					
					</form>
					
					<?php			
			}
			else//validation
			{
				echo "<p>Δεν έχετε επιλέξει κάποια παροχή!</p>";
				?><p>Επιστροφή στις <a href="personal_workoffer_list.php">παροχές μου</a></p>
				<?php
				
			}
		mysql_close($con);
	 
	?>
		</div>
	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

