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

include "globals.php";
if($ir['jail'])
{
  die("You cannot bail out people while in jail.");
}
$_GET['ID']=abs((int) $_GET['ID']);
$r=$db->fetch_row($db->query("SELECT * FROM users WHERE userid={$_GET['ID']}"));
if(!$r['userid'])
{
  die("Invalid user");
}
if(!$r['jail'])
{
  die("That user is not in jail!");
}
$cost=$r['level']*2000;
$cf=number_format($cost);
if($ir['money'] < $cost)
{
  die("Sorry, you do not have enough money to bail out {$r['username']}. You need \$$cf.");
}
  print "You successfully bailed {$r['username']} out of jail for \$$cf.<br />
  &gt; <a href='jail.php'>Back</a>";
  $db->query("UPDATE users SET money=money-{$cost} WHERE userid=$userid");
  $db->query("UPDATE users SET jail=0 WHERE userid={$r['userid']}");
  event_add($r['userid'], "<a href='viewuser.php?u={$ir['userid']}'>{$ir['username']}</a> bailed you out of jail.", $c);
$h->endpage();
?>
