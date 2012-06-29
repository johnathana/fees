<?php

function send_mail($to, $subject, $message)
{
	$subject = "=?utf-8?B?" . base64_encode('[ODT - Workoffer] ' . $subject) . "?=";

	$headers = "From: workoffer <webmaster@workoffer.di.uoa.gr>\r\n";
	$headers .= "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/plain; charset=utf-8\r\n";
	$headers .="Content-Transfer-Encoding: 8bit";

	$message = htmlspecialchars_decode($message, ENT_QUOTES);//optional - I use encoding to POST data
	
	return mail($to, $subject, $message, $headers);
}

?>

