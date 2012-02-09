<?php

include_once('includes/CAS.php');

phpCAS::setDebug(false);
phpCAS::client(SAML_VERSION_1_1,'login.uoa.gr',443,'');
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();
if (isset($_REQUEST['logout'])) {
       phpCAS::logout();
}

$access=false;
$aff=array();
$ou=array();
$allow_users=array(
       'stef',
       'florias',
       'dennis',
       'elekar',
       'loupa',
       'epal',
       'folga',
       'vpothitou',
       'leo',
);

$user=phpCAS::getUser();
$attr=phpCAS::getAttributes();

if(in_array($user,$allow_users,true)) {
       $access=true;
}

if (isset($attr['edupersonaffiliation'])) {
       if(is_array($attr['edupersonaffiliation'])) {
               $aff=$attr['edupersonaffiliation'];
       } else {
               $aff=array($attr['edupersonaffiliation']);
       }
}

if (isset($attr['edupersonorgunitdn'])) {
       if(is_array($attr['edupersonorgunitdn'])) {
               $ou=$attr['edupersonorgunitdn'];
       } else {
               $ou=array($attr['edupersonorgunitdn']);
       }
}

if(in_array('faculty',$aff,true)) {
       if(in_array('ou=therinf,ou=schools,dc=uoa,dc=gr',$ou,true)) $access=true;
       if(in_array('ou=cmptsystapp,ou=schools,dc=uoa,dc=gr',$ou,true))
$access=true;
       if(in_array('ou=comssigpro,ou=schools,dc=uoa,dc=gr',$ou,true)) $access=true;
}

if ($access!==true) {
       die("Access denied.");
}

?>

