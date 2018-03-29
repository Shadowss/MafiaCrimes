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
if($ir['user_level'] != 2 && $ir['user_level'] != 3 && $ir['user_level'] != 5)
{
die("You cannot mailbann users.");
}
if($_POST['user'])
{
global $ir,$c,$h,$userid;
$q=$db->query("SELECT * FROM users WHERE userid={$_POST['user']}");
$them=$db->fetch_row($q);
if($them['user_level'] == 2 || $them['user_level'] == 3 || $them['user_level'] == 5)
{
die("You cannot mailbann fellow staff.");
}
print "User mail banned."; 
$re=$db->query("UPDATE users SET
mailban={$_POST['days']},mb_reason='{$_POST['reason']}'
WHERE userid={$_POST['user']}");
event_add($_POST['user'],"You were banned from mail for
{$_POST['days']} day(s) for the following reason:
{$_POST['reason']}",$c);
}
else
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> MailBann User</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

This user wont be able to access mail box for days. Do not abuse !<br />
<form action='mailban.php' method='post'>
User: ".user_dropdown($c,'user',$_GET['userid'])."<br />
Days: <input type='text' STYLE='color: black;  background-color: white;' name='days' /><br />
Reason: <input type='text' STYLE='color: black;  background-color: white;' name='reason' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Mailbann User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
$h->endpage();
?>
