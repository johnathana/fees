<?php

include_once('includes/CAS.php');

phpCAS::setDebug(false);
phpCAS::client(SAML_VERSION_1_1,'login.uoa.gr',443,'');
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();
if (isset($_REQUEST['logout'])) {
       phpCAS::logout();
}



$user=phpCAS::getUser();
$attr=phpCAS::getAttributes();

echo $user;
echo $attr;

?>

