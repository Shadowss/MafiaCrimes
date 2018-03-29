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

include "sglobals.php";
if($ir['user_level'] > 2)
{
die("403");
}
//This contains battletent stuffs
switch($_GET['action'])
{
case "addbot": addbot(); break;
case "editbot": editbot(); break;
case "delbot": delbot(); break;
default: print "Error: This script requires an action."; break;
}
function addbot()
{
global $db,$ir,$c,$h,$userid;
$_POST['userid']=abs((int) $_POST['userid']);
$_POST['money']=abs((int) $_POST['money']);
if($_POST['userid'] && $_POST['money'])
{
$q=$db->query("SELECT * FROM users WHERE userid={$_POST['userid']}");
if($db->num_rows($q)==0)
{
print "Non-existant user.";
$h->endpage();
exit;
}
$r=$db->fetch_row($q);
if($r['user_level'] != 0)
{
print "Challenge bots must be NPCs.";
$h->endpage();
exit;
}
$q2=$db->query("SELECT * FROM challengebots WHERE cb_npcid={$r['userid']}");
if($db->num_rows($q2))
{
print "This user is already a Challenge Bot. If you wish to change the payout, edit the Challenge Bot.";
$h->endpage();
exit;
}
$db->query("INSERT INTO challengebots VALUES('{$r['userid']}', '{$_POST['money']}')");
print "Challenge Bot {$r['username']} added.";
stafflog_add("Added Challenge Bot {$r['username']}.");
}
else
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Adding a Battle Tent Challenge Bot</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
<form action='staff_battletent.php?action=addbot' method='post'>
Bot: ".user_dropdown($c, 'userid')."<br />
Bounty for Beating: <input type='text' STYLE='color: black;  background-color: white;' name='money' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Add Challenge Bot' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
function editbot()
{
global $db,$ir,$c,$h,$userid;
switch($_GET['step'])
{
case "2":
$_POST['userid']=abs((int) $_POST['userid']);
$_POST['money']=abs((int) $_POST['money']);
$q=$db->query("SELECT * FROM users WHERE userid={$_POST['userid']}");
if($db->num_rows($q)==0)
{
print "Non-existant user.";
$h->endpage();
exit;
}
$r=$db->fetch_row($q);
$q2=$db->query("SELECT * FROM challengebots WHERE cb_npcid={$r['userid']}");
if(!$db->num_rows($q2))
{
print "This user is not a Challenge Bot.";
$h->endpage();
exit;
}
$db->query("UPDATE challengebots SET cb_money={$_POST['money']} WHERE cb_npcid={$r['userid']}");
print "Challenge Bot {$r['username']} was updated.";
stafflog_add("Edited Challenge Bot {$r['username']}.");
break;
case "1":
$_POST['userid']=abs((int) $_POST['userid']);
$q=$db->query("SELECT * FROM users WHERE userid={$_POST['userid']}");
if($db->num_rows($q)==0)
{
print "Non-existant user.";
$h->endpage();
exit;
}
$r=$db->fetch_row($q);
$q2=$db->query("SELECT * FROM challengebots WHERE cb_npcid={$r['userid']}");
if(!$db->num_rows($q2))
{
print "This user is not a Challenge Bot.";
$h->endpage();
exit;
}
$r2=$db->fetch_row($q2);
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Edit Challenge Bot</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

You are editing the challenge bot: <b>{$r['username']}</b><form action='staff_battletent.php?action=editbot&step=2' method='post'>
Bounty for Beating: <input type='text' STYLE='color: black;  background-color: white;' name='money' value='{$r2['cb_money']}' /><br />
<input type='hidden' name='userid' value='{$r['userid']}' />
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit Challenge Bot' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
break;
default:
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Edit Challenge Bot</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_battletent.php?action=editbot&step=1' method='post'>
Bot: ".challengebot_dropdown($c, 'userid')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit Challenge Bot' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
break;
}
}
function delbot()
{
global $db,$ir,$c,$h,$userid;
$_POST['userid']=abs((int) $_POST['userid']);
$_POST['delcb']=abs((int) $_POST['delcb']);
if($_POST['userid'])
{
$q=$db->query("SELECT * FROM users WHERE userid={$_POST['userid']}");
if($db->num_rows($q)==0)
{
print "Non-existant user.";
$h->endpage();
exit;
}
$r=$db->fetch_row($q);
$q2=$db->query("SELECT * FROM challengebots WHERE cb_npcid={$r['userid']}");
if(!$db->num_rows($q2))
{
print "This user is not a Challenge Bot.";
$h->endpage();
exit;
}
$r2=$db->fetch_row($q2);
$db->query("DELETE FROM challengebots WHERE cb_npcid={$r['userid']}");
if($_POST['delcb'])
{
$db->query("DELETE FROM challengesbeaten WHERE npcid={$r['userid']}");
}
print "Challenge Bot {$r['username']} removed.";
stafflog_add("Removed Challenge Bot {$r['username']}");
}
else
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Remove Challenge Bot</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<b>NB:</b> This will not delete the user from the game, only remove their entry as a Battle Tent Challenge Bot.<form action='staff_battletent.php?action=delbot' method='post'>
Bot: ".challengebot_dropdown($c, "userid")."<br />
Delete challengesbeaten entries for this bot? <input type='radio' name='delcb' value='1' checked='checked' /> Yes <input type='radio' name='delcb' value='0' /> No<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Remove Bot' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
$h->endpage();
?>
