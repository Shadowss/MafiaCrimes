<?php
session_start();
require "global_func.php";
if($_SESSION['loggedin']==0) { header("Location: login.php");exit; }
$userid=$_SESSION['userid'];
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
while($r=$db->fetch_row($settq))
{
$set[$r['conf_name']]=$r['conf_value'];
}
$domain=$_SERVER['HTTP_HOST'];

global $jobquery, $housequery;
if($jobquery)
{
$is=$db->query("SELECT u.*,us.*,j.*,jr.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN jobs j ON j.jID=u.job LEFT JOIN jobranks jr ON jr.jrID=u.jobrank WHERE u.userid=$userid");
}
else if($housequery)
{
$is=$db->query("SELECT u.*,us.*,h.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN houses h ON h.hWILL=u.maxwill WHERE u.userid=$userid");
}
else
{
$is=$db->query("SELECT u.*,us.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.userid=$userid");
}
$ir=$db->fetch_row($is);
if($ir['force_logout'])
{
$db->query("UPDATE users SET force_logout=0 WHERE userid=$userid");
session_unset();
session_destroy();
header("Location: login.php");
exit;
}

$_GET['ID'] = abs((int) $_GET['ID']);
$q=mysql_query("SELECT * FROM votes WHERE userid=$userid AND site='{$_GET['ID']}'",$c);
if(mysql_num_rows($q) > 0)
{
print "You have already voted on this site today!";
die("");
}
else
{
$blak=mysql_query("SELECT * FROM votingsites WHERE id={$_GET['ID']}",$c);
if($db->num_rows($blak) == 0)
{
print"<center>This voting site does not exist!</center>";
die("");
}
else
{
$r=mysql_fetch_array($blak);
}
$id=$_GET['ID'];
$reward=$r['reward'];
if($r['rewardtype'] == 1)
{
$muneh=money_formatter($reward);
mysql_query("INSERT INTO votes values ($userid,$id)",$c);
event_add($userid,"Thank you for voting! You have receieved $muneh!", $c);
mysql_query("UPDATE users SET money=money+$reward WHERE userid=$userid",$c);
}
if($r['rewardtype'] == 2)
{
mysql_query("INSERT INTO votes values ($userid,$id)",$c);
if($reward > 1)
{
event_add($userid,"Thank you for voting! You have receieved $reward crystals!", $c);
}
else
{
event_add($userid,"Thank you for voting! You have receieved $reward crystal!", $c);
}
mysql_query("UPDATE users SET crystals=crystals+$reward WHERE userid=$userid",$c);
}
if($r['rewardtype'] == 3)
{
$juk=mysql_query("SELECT * FROM items WHERE itmid=$reward",$c);
$item=mysql_fetch_array($juk);
mysql_query("INSERT INTO votes values ($userid,$id)",$c);
mysql_query("INSERT INTO inventory values ('',$reward,$userid,1)",$c);
event_add($userid,"Thank you for voting! You have receieved a/an {$item['itmname']}!", $c);
}
if($r['rewardtype'] == 4)
{
mysql_query("INSERT INTO votes values ($userid,$id)",$c);
event_add($userid,"Thank you for voting! You have receieved $reward energy!", $c);
mysql_query("UPDATE users SET energy=energy+$reward WHERE userid=$userid",$c);
}
if($r['rewardtype'] == 5)
{
mysql_query("INSERT INTO votes values ($userid,$id)",$c);
event_add($userid,"Thank you for voting! You have receieved $reward brave!", $c);
mysql_query("UPDATE users SET brave=brave+$reward WHERE userid=$userid",$c);
}
if($r['rewardtype'] == 6)
{
mysql_query("INSERT INTO votes values ($userid,$id)",$c);
event_add($userid,"Thank you for voting! You have receieved $reward will!", $c);
mysql_query("UPDATE users SET will=will+$reward WHERE userid=$userid",$c);
}
print"<meta http-equiv='refresh' content='0;url={$r['url']}' />";
exit;
}
?>