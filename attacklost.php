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

$atkpage=1;
include "globals.php";

$_GET['ID']==abs((int) $_GET['ID']);
$_SESSION['attacking']=0;
$_SESSION['attacklost']=0;
$od=$db->query("SELECT * FROM users WHERE userid={$_GET['ID']}");
if($db->num_rows($od))
{
$r=$db->fetch_row($od);
print "

<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 100px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

You lost to {$r['username']}";
$expgain=abs(($ir['level']-$r['level'])^3);
$expgainp=$expgain/$ir['exp_needed']*100;
print " and lost $expgainp% EXP!";
$db->query("UPDATE users SET exp=exp-$expgain, attacking=0 WHERE userid=$userid");
$db->query("UPDATE users SET exp=0 WHERE exp<0");
event_add($r['userid'],"<a href='viewuser.php?u=$userid'>{$ir['username']}</a> attacked you and lost.",$c);
$atklog=mysql_escape_string($_SESSION['attacklog']);
$db->query("INSERT INTO attacklogs VALUES('',$userid,{$_GET['ID']},'lost',unix_timestamp(),0,'$atklog');");
$chk_one = $db->query(sprintf("SELECT * FROM `battle_members` WHERE `bmemberUser` = '%u'", $ir['userid']));
$chk_two = $db->query(sprintf("SELECT * FROM `battle_members` WHERE `bmemberUser` = '%u'", $r['userid']));
   if (mysql_num_rows($chk_one) AND mysql_num_rows($chk_two))
    {
      $score = rand(12, 24);
      $db->query(sprintf("UPDATE `battle_members` SET `bmemberScore` = `bmemberScore` - '%d', `bmemberLosses` = `bmemberLosses` + '1' WHERE `bmemberUser` = '%u'", $score, $ir['userid']));
      $db->query(sprintf("UPDATE `battle_members` SET `bmemberScore` = `bmemberScore` + '%d', `bmemberWins` = `bmemberWins` + '1' WHERE `bmemberUser` = '%u'", $score, $r['userid']));
      echo '<br/><br/>You have lost '.$score.' points from the score on the battle ladder, bad luck.<br />';
    }
$warq=$db->query("SELECT * FROM gangwars WHERE (warDECLARER={$ir['gang']} AND warDECLARED={$r['gang']}) OR (warDECLARED={$ir['gang']} AND warDECLARER={$r['gang']})");
if ($db->num_rows($warq) > 0)
{
$war=$db->fetch_row($warq);
$db->query("UPDATE gangs SET gangRESPECT=gangRESPECT+1 WHERE gangID={$r['gang']}");
$db->query("UPDATE gangs SET gangRESPECT=gangRESPECT-1 WHERE gangID={$ir['gang']}");
print "<br />You lost 1 respect for your gang!";
}
}
else
{
print "You lost to Mr. Non-existant! =O";
}
$h->endpage();
?>
