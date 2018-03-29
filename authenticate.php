<?php
/**************************************************************************************************
| Software Name        : Ravan Scripts Online Mafia Game
| Software Author      : Ravan Soft Tech
| Software Version     : Version 2.0.1 Build 2101
| Website              : http://www.ravan.info/
| E-mail               : support@ravan.info
|**************************************************************************************************
| The source files are subject to the Ravan Scripts End-User License Agreement included in License Agreement.html
| The files in the package must not be distributed in whole or significant part.
| All code is copyrighted unless otherwise advised.
| Do Not Remove Powered By Ravan Scripts without permission .         
|**************************************************************************************************
| Copyright (c) 2010 Ravan Scripts . All rights reserved.
|**************************************************************************************************/
require("poker_includes/tables.php");
function get_rand_id($length)
{
  if($length>0) 
  { 
  $rand_id="";
   for($i=1; $i<=$length; $i++)
   {
   mt_srand((double)microtime() * 1000000);
   $num = mt_rand(1,36);
   $rand_id .= assign_rand_value($num);
   }
  }
return $rand_id;
} 
function assign_rand_value($num)
{
// accepts 1 - 36
  switch($num)
  {
    case "1":
     $rand_value = "a";
    break;
    case "2":
     $rand_value = "b";
    break;
    case "3":
     $rand_value = "c";
    break;
    case "4":
     $rand_value = "d";
    break;
    case "5":
     $rand_value = "e";
    break;
    case "6":
     $rand_value = "f";
    break;
    case "7":
     $rand_value = "g";
    break;
    case "8":
     $rand_value = "h";
    break;
    case "9":
     $rand_value = "i";
    break;
    case "10":
     $rand_value = "j";
    break;
    case "11":
     $rand_value = "k";
    break;
    case "12":
     $rand_value = "l";
    break;
    case "13":
     $rand_value = "m";
    break;
    case "14":
     $rand_value = "n";
    break;
    case "15":
     $rand_value = "o";
    break;
    case "16":
     $rand_value = "p";
    break;
    case "17":
     $rand_value = "q";
    break;
    case "18":
     $rand_value = "r";
    break;
    case "19":
     $rand_value = "s";
    break;
    case "20":
     $rand_value = "t";
    break;
    case "21":
     $rand_value = "u";
    break;
    case "22":
     $rand_value = "v";
    break;
    case "23":
     $rand_value = "w";
    break;
    case "24":
     $rand_value = "x";
    break;
    case "25":
     $rand_value = "y";
    break;
    case "26":
     $rand_value = "z";
    break;
    case "27":
     $rand_value = "0";
    break;
    case "28":
     $rand_value = "1";
    break;
    case "29":
     $rand_value = "2";
    break;
    case "30":
     $rand_value = "3";
    break;
    case "31":
     $rand_value = "4";
    break;
    case "32":
     $rand_value = "5";
    break;
    case "33":
     $rand_value = "6";
    break;
    case "34":
     $rand_value = "7";
    break;
    case "35":
     $rand_value = "8";
    break;
    case "36":
     $rand_value = "9";
    break;
  }
return $rand_value;
}


session_start();
if(get_magic_quotes_gpc() == 0)
{
foreach($_POST as $k => $v)
{
  $_POST[$k]=addslashes($v);
}
foreach($_GET as $k => $v)
{
  $_GET[$k]=addslashes($v);
}
}

include "config.php";
include "language.php";
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
if(!function_exists('sqlesc')){
	function sqlesc($string){
		return "'".mysql_real_escape_string($string)."'";
	}
}
$settq=$db->query("SELECT * FROM settings");
while($r=$db->fetch_row($settq))
{
$set[$r['conf_name']]=$r['conf_value'];
}
if ($_POST['username'] == "" || $_POST['password'] == "")
{
die("<h3>{$set['game_name']} Error</h3>
$nofill<br>
<a href=login.php>&gt; Back</a>");
}
$uq=$db->query("SELECT userid,username,display_pic FROM users WHERE login_name='{$_POST['username']}' AND `userpass`=md5('{$_POST['password']}')");
if ($db->num_rows($uq)==0)
{
die("<h3>{$set['game_name']} Error</h3>
$invalid<br>
<a href=login.php>&gt; $lerrortry</a>");
}
else
{
$_SESSION['loggedin']=1;
$mem=$db->fetch_row($uq);
$_SESSION['userid']=$mem['userid'];
$_SESSION['playername'] = $mem['username'];

$randomcode = get_rand_id(32);
if($db->num_rows($db->query("SELECT * FROM poker_players where userid=".$mem['userid'])))
	$pokerr = $db->query("update ".DB_PLAYERS." set GUID='".$randomcode."'  where userid=".$mem['userid']);
else{
	$avatar = mysql_real_escape_string($mem['display_pic']);
	$time=time();
	$winpot = 1000;
	$result = $db->query("insert into ".DB_PLAYERS." set GUID='".$randomcode."', userid=".sqlesc($mem['userid']).", banned = '0', username = ".sqlesc($mem['username']).", lastlogin = '".$time."' , datecreated = '".$time."' , avatar = '".$avatar."'");
	$result = $db->query("insert into ".DB_STATS." set  player = ".sqlesc($mem['username']).", winpot = '".$winpot."' ");
	header("Location: poker_index.php");
}
$_SESSION['SGUID'] = $randomcode;


$IP = $_SERVER['REMOTE_ADDR'];
$IP=addslashes($IP);
$IP=mysql_real_escape_string($IP);
$IP=strip_tags($IP);
$db->query("UPDATE users SET lastip_login='$IP',last_login=unix_timestamp() WHERE userid={$mem['userid']}");
$db->query("UPDATE users SET active=1 WHERE userid={$mem['userid']}");
if($set['validate_period'] == "login" && $set['validate_on'])
{
$db->query("UPDATE users SET verified=0 WHERE userid={$mem['userid']}");
}
header("Location: index.php");
}

?>

