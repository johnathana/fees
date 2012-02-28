<?php
include_once('includes/CAS.php');

phpCAS::setDebug(false);
phpCAS::client(SAML_VERSION_1_1,'login.uoa.gr',443,'');
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();
phpCAS::logout();

?>
