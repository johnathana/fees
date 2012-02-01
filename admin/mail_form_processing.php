<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/admin/mail_functions.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mail.php');
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
	<script type="text/javascript" charset="utf-8"></script>
	
	<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">
		
<?php 		
		$sender = $auth->email;
		$receivers = trim($_POST['receivers']);
		$mail_subject = trim($_POST['mail_subject']);
		$mail_contents = trim($_POST['mail_contents']);
		
	//	echo $sender; 
		
//      $sender=get_user_mail($mail_username);  //apostoleas
		
		
		if (empty($sender)) 
		{
		echo "Δεν είναι δυνατή η αποστολή email";
		echo '<a href="mail_form.php">Επιστροφή στη φόρμα αποστολής e-mail</a>';
		}
		else{
		
		//tha ginei apostoli mail
		
		switch ($receivers) {	       
		       case 1:
			    $addresses=select_all_users_mail();
				$recvs = implode(',', $addresses);
               break;
               case 2:
			    $addresses=select_all_professors_mail();
			    $recvs = implode(',', $addresses);
               break;
               case 3:
			    $addresses=select_all_students_mail();
			    $recvs = implode(',', $addresses);
               break;
			   case 4:
			    $addresses=select_all_admins_mail();
			    $recvs = implode(',', $addresses);
               break;
              }

			  /* echo tests
			  echo $recvs;
		      echo $mail_subject;
		      echo $mail_contents; */
			  
		
		     if (workoffer_mail($recvs, $mail_subject, $mail_contents)) {
             echo("<p>Το μύνημά σας εστάλθηκε επιτυχώς!</p>");
			 ?><p>Πατήστε <a href="admin_menu.php">εδώ</a> για επιστροφή στην κεντρική σελίδα των διαχειριστών</p> <?php
             } 
		     else {
             echo("<p>Message delivery failed...</p>");
			 echo '<a href="mail_form.php">Επιστροφή στη φόρμα αποστολής e-mail</a>';
            }
	
		}	
		
	
	?> 

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 