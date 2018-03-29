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
$db->query("UPDATE fedjail set fed_days=fed_days-1");
$q=$db->query("SELECT * FROM fedjail WHERE fed_days=0");
$ids=array();
while($r=$db->fetch_row($q))
{
$ids[]=$r['fed_userid'];
}
if(count($ids) > 0)
{
$db->query("UPDATE users SET fedjail=0 WHERE userid IN(".implode(",", $ids).")");
}
$db->query("DELETE FROM fedjail WHERE fed_days=0");
$db->query("UPDATE users SET daysingang=daysingang+1 WHERE gang > 0");
$db->query("UPDATE users SET daysold=daysold+1, boxes_opened=0");
$db->query("UPDATE users SET mailban=mailban-1 WHERE mailban > 0");
$db->query("UPDATE users SET donatordays=donatordays-1 WHERE donatordays > 0");
$db->query("UPDATE users SET cdays=cdays-1 WHERE course > 0");
$db->query("UPDATE users SET bankmoney=bankmoney+(bankmoney/50) where bankmoney>0");
$db->query("UPDATE users SET cybermoney=cybermoney+(cybermoney/100*7) where cybermoney>0");
$db->query("UPDATE users SET turns=25");
$db->query("UPDATE users SET rob=0"); 
$db->query("UPDATE users SET rates=1");
$db->query("UPDATE users SET warehouse=0");
$db->query("UPDATE users SET brothel=0");
$q=$db->query("SELECT * FROM users WHERE cdays=0 AND course > 0");

/////////////////////////////////////////////////////////////////////
///////////////////////////DRUGS START////////////////////////////////
///////////////////////////////////////////////////////////////////

//Drugs (oxidati0n and Silvers)
//DRUGS MARKET
mysql_query("UPDATE `drugsmarket` SET `dm_daysleft` = `dm_daysleft` - '1'",$c);
mysql_query("DELETE FROM `drugsmarket` WHERE `dm_daysleft` = '0'",$c);
//Drug Farm itself
mysql_query("UPDATE `drug_collection` SET `dc_age` = `dc_age` + '1'",$c);
mysql_query("UPDATE `drug_farm` SET `df_daysleft` = `df_daysleft` - '1'",$c);
$f=mysql_query("SELECT * FROM `drug_farm` WHERE `df_daysleft` = '0'",$c);
while($r=mysql_fetch_array($f))
{
mysql_query("INSERT INTO `drug_collection` (`dc_id`, `dc_drug`, `dc_user`, `dc_holding`, `dc_age`) VALUES ('NULL', '$r[df_drug]', '$r[df_user]', '0', '0');",$c);
}
mysql_query("DELETE * FROM `drug_farm` WHERE `df_daysleft` = '0'",$c);

/////////////////////////////////////////////////////////////////////
///////////////////////////DRUGS END////////////////////////////////
///////////////////////////////////////////////////////////////////

while($r=$db->fetch_row($q))
{
$cd=$db->query("SELECT * FROM courses WHERE crID={$r['course']}");
$coud=$db->fetch_row($cd);
$userid=$r['userid'];
$db->query("INSERT INTO coursesdone VALUES({$r['userid']},{$r['course']})");
$upd="";
$ev="";
if($coud['crSTR'] > 0)
{
$upd.=",us.strength=us.strength+{$coud['crSTR']}";
$ev.=", {$coud['crSTR']} strength";
}
if($coud['crGUARD'] > 0)
{
$upd.=",us.guard=us.guard+{$coud['crGUARD']}";
$ev.=", {$coud['crGUARD']} guard";
}
if($coud['crLABOUR'] > 0)
{
$upd.=",us.labour=us.labour+{$coud['crLABOUR']}";
$ev.=", {$coud['crLABOUR']} labour";
}
if($coud['crAGIL'] > 0)
{
$upd.=",us.agility=us.agility+{$coud['crAGIL']}";
$ev.=", {$coud['crAGIL']} agility";
}
if($coud['crIQ'] > 0)
{
$upd.=",us.IQ=us.IQ+{$coud['crIQ']}";
$ev.=", {$coud['crIQ']} IQ";
}
$ev=substr($ev,1);
if ($upd) {
$db->query("UPDATE users u LEFT JOIN userstats us ON u.userid=us.userid SET us.userid=us.userid $upd WHERE u.userid=$userid");
}
$db->query("INSERT INTO events VALUES('',$userid,unix_timestamp(),0,'Congratulations, you completed the {$coud['crNAME']} and gained $ev!')");
}
$db->query("UPDATE users SET course=0 WHERE cdays=0");
$db->query("TRUNCATE TABLE votes;");


$db->query("UPDATE `businesses` SET `brank` = '100000' WHERE `brank` > '100000'");

$select_businesses = $db->query("SELECT * FROM `businesses` LEFT JOIN `businesses_classes` ON (`classId` = `busClass`) ORDER BY `busId` ASC");

while($bs=$db->fetch_row($select_businesses))
{
$amount = $db->num_rows($db->query(sprintf("SELECT * FROM `businesses_members` WHERE `bmembBusiness` = '%u'", $bs['busId'])));
$active = $db->num_rows($db->query(sprintf("SELECT * FROM `users` WHERE `business` = '%u' AND active='%d'", $bs['busId'], 1)));

$new_customers = ($bs['brank']*($active)+ rand(10, 20)*$bs['classCost'] / 200);
$new_profit = (($new_customers)+ rand(110, 990));
$new_rank = ($bs['classId']*($active)/2);
$db->query(sprintf("UPDATE `businesses` SET `busYCust` = `busCust`, `busYProfit` = `busProfit`, `busCust` = '%d', `busProfit` = '%d', `busCash` = '%d' WHERE `busId` = '%u'", $new_customers, $new_profit, ($new_profit + $bs['busCash']), $bs['busId']));
$db->query(sprintf("UPDATE `businesses` SET `busDays` = `busDays` + '1'"));
$db->query(sprintf("UPDATE `users` SET `activedays` = `activedays` + '1' WHERE `active` = '1'"));
$db->query(sprintf("UPDATE `users` SET `active` = '0' WHERE `active` = '1'"));
$db->query(sprintf("UPDATE `businesses` SET `brank` = `brank` + '%d' WHERE `busId` = '%u'",  $new_rank, $bs['busId']));
$fetch_members = $db->query(sprintf("SELECT * FROM `businesses_members` LEFT JOIN `users` ON (`userid` = `bmembMember`) LEFT JOIN `businesses_ranks` ON (`rankId` = `bmembRank`) WHERE `bmembBusiness` = '%u'", $bs['busId'])) OR die('Cron not run');
$db->query("UPDATE userstats SET labour = labour + 50, IQ = IQ + 50, strength = strength + 50 WHERE userid = {$bs['busDirector']}");
$db->query("UPDATE users SET comppoints = comppoints + 1 WHERE userid = {$bs['busDirector']}");

while($fm=$db->fetch_row($fetch_members))
{

$db->query(sprintf("UPDATE `userstats` SET `{$fm['rankPrim']}` = `{$fm['rankPrim']}` + '%.6f', `{$fm['rankSec']}` = `{$fm['rankSec']}` + '%.6f' WHERE (`userid` = '%u')", $fm['rankPGain'], $fm['rankSGain'], $fm['userid'])) OR die('Cron not run');

$db->query(sprintf("UPDATE `users` SET `money` = `money` + '%d' WHERE `userid` = '%u'", $fm['bmembCash'], $fm['userid'])) OR die('Cron not run');

$db->query(sprintf("UPDATE `users` SET `comppoints` = `comppoints` + '1' WHERE `userid` = '%u'", $fm['userid'])) OR die('Cron not run');




if($bs['busCash'] < $fm['bmembCash'])
{
$text = "Member ID {$fm['bmembMember']} was not paid their \$".number_format($fm['bmembCash'])." due to lack of funds." OR die('Cron not run');
$db->query(sprintf("INSERT INTO `businesses_alerts` (`alertId`, `alertBusiness`, `alertText`, `alertTime`) VALUES ('NULL', '%u', '%s', '%d')", $bs['busId'], $text, time())) OR die('Cron not run');
$db->query(sprintf("UPDATE `businesses` SET `busDebt` = `busDebt` + '%d' WHERE `busId` = '%u'", $fm['bmembCash'], $bs['busId'])) OR die('Cron not run');
}
else
{
$db->query(sprintf("UPDATE `businesses` SET `busCash` = `busCash` - '%d' WHERE `busId` = '%u'", $fm['bmembCash'], $bs['busId'])) OR die('Cron not run');
}
}
if($bs['busDebt'] > $bs['classCost'])
{
$send_event = $db->query(sprintf("SELECT `bmembMember` FROM WHERE `bmembBusiness` = '%u' ORDER BY `bmembId` DESC", $bs['busId'])) OR die('Cron not run') ;
while($se=$db->fetch_row($send_event))
{
$text = "The {$bs['busName']} business went bankrupt\, all members have been made redundent." OR die('Cron not run');
insert_event($se['bmembMember'], $text);
}
$db->query(sprintf("DELETE FROM `businesses_members` WHERE (`bmembBusiness` = '%u')", $bs['busId'])) OR die('Cron not run');
$db->query(sprintf("DELETE FROM `businesses` WHERE (`busId` = '%u')", $bs['busId'])) OR die('Cron not run');
}
}



print "

<meta HTTP-EQUIV='REFRESH' content='5; url=staff.php?action=cmanual'>
<style type='text/css'>
.style2 {
    text-align: center;
}
.style3 {
    text-align: center;
    color: #008000;
}
.style4 {
    color: #FFFFFF;
}
</style>


<body style='background-color: #000000'>

<h2 class='style3'>Cron Job Successfully Ran</h2>

<div class='style2'>
    <h3>

<a href='staff.php?action=cmanual'><span class='style4'>Back</span></a></h3>
</div> 

";



?>
