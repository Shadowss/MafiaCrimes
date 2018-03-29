<?php
include 'inc/config.php';

session_start();
ob_start();
if(get_magic_quotes_gpc() == 0){
  foreach($_POST as $k => $v)
  {
    $_POST[$k]=addslashes($v);
  }
  foreach($_GET as $k => $v)
  {
    $_GET[$k]=addslashes($v);
  }
}

function anti_inject($campo){
	foreach($campo as $key => $val){
		$val = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$val);
		$val = trim($val);
		$val = strip_tags($val);
		$val = addslashes($val);
		$campo[$key] = $val;
	}
	return $campo; //Returns the the var clean
} 
$_GET = anti_inject($_GET);
$_POST = anti_inject($_POST);
require "global_func.php";
if($_SESSION['loggedin']==0) { header("Location: login.php");exit; }
$userid=0+$_SESSION['userid'];
require "header.php";
include "config.php";
global $_CONFIG;
define("MONO_ON", 1);
require "class/class_db_{$_CONFIG['driver']}.php";
$db=new database;
$db->configure($_CONFIG['hostname'],
 $_CONFIG['username'],
 $_CONFIG['password'],
 $_CONFIG['database'],
 $_CONFIG['persistent']);
$db->connect();
$c=$db->connection_id;
$set=array();
$settq=$db->query("SELECT * FROM settings");
while($r=$db->fetch_row($settq)){
	$set[$r['conf_name']]=$r['conf_value'];
}
$domain=$_SERVER['HTTP_HOST'];
global $jobquery, $housequery;
if($jobquery){
	$is=$db->query("SELECT u.*,us.*,j.*,jr.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN jobs j ON j.jID=u.job LEFT JOIN jobranks jr ON jr.jrID=u.jobrank WHERE u.userid=$userid");
}else if($housequery){
	$is=$db->query("SELECT u.*,us.*,h.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN houses h ON h.hWILL=u.maxwill WHERE u.userid=$userid");
}else{
	$is=$db->query("SELECT u.*,us.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.userid=$userid");
}
$ir=$db->fetch_row($is);
if($ir['force_logout']){
	$db->query("UPDATE users SET force_logout=0 WHERE userid=$userid");
	session_unset();
	session_destroy();
	header("Location: login.php");
	exit;
}
global $macropage;
if($macropage && !$ir['verified'] && $set['validate_on']==1){
	header("Location: macro1.php?refer=$macropage");
	exit;
} 
check_level();

//$h = new headers;
//$h->startheaders();
$fm=money_formatter($ir['money']);
$cm=money_formatter($ir['crystals'],'');
$lv=date('F j, Y, g:i a',$ir['laston']);
//global $atkpage;
//if($atkpage){
//	$h->userdata($ir,$lv,$fm,$cm,0);
//}else{
//	$h->userdata($ir,$lv,$fm,$cm);
//}
//$h->menuarea();
?>
