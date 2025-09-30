<?php
/**
* SIP Security
*
**/

define("ROOT", dirname(__FILE__));

$debug= false;
if($debug){
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
}

include "core/autoload.php";

ob_start();
session_start();
Core::$root="";

// validar la maquina donde se esta ingresando
$_SESSION['ip'] = ipCheck(); 
$hostname = gethostbyaddr($_SESSION['ip']);

if ($hostname <> $_SESSION['ip']) {
    $a = explode(".",$hostname);
    if (is_array($a)) {
        $_SESSION['ip'] = $a[0];    
    }
} 

// si quieres que se muestre las consultas SQL debes decomentar la siguiente linea
Core::$debug_sql = false;

$lb = new Lb();
$lb->start();
$_SESSION['error'] = 0;

function ipCheck() {
	if (getenv('HTTP_CLIENT_IP')) {$ip = getenv('HTTP_CLIENT_IP');}
	elseif (getenv('HTTP_X_FORWARDED_FOR')) {$ip = getenv('HTTP_X_FORWARDED_FOR');}
	elseif (getenv('HTTP_X_FORWARDED')) {$ip = getenv('HTTP_X_FORWARDED');}
	elseif (getenv('HTTP_FORWARDED_FOR')) {	$ip = getenv('HTTP_FORWARDED_FOR');}
	elseif (getenv('HTTP_FORWARDED')) {	$ip = getenv('HTTP_FORWARDED');}
  else {$ip = $_SERVER['REMOTE_ADDR'];}
  
  if (trim($ip) == '') {$ip = '0.0.0.0';}
	return $ip;
}
