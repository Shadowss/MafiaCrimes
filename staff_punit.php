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

//This contains punishment stuffs
switch($_GET['action'])
{
case 'fedform': fed_user_form(); break;
case 'fedsub': fed_user_submit(); break;
case 'fedeform': fed_edit_form(); break;
case 'fedesub': fed_edit_submit(); break;
case 'mailform': mail_user_form(); break;
case 'mailsub': mail_user_submit(); break;
case 'forumform': forum_user_form(); break;
case 'forumsub': forum_user_submit(); break;
case 'unfedform': unfed_user_form(); break;
case 'unfedsub': unfed_user_submit(); break;
case 'unmailform': unmail_user_form(); break;
case 'unmailsub': unmail_user_submit(); break;
case 'unforumform': unforum_user_form(); break;
case 'unforumsub': unforum_user_submit(); break;
case 'ipform': ip_search_form(); break;
case 'ipsub': ip_search_submit(); break;
case 'massjailip': mass_jail(); break;
default: print "Error: This script requires an action."; break;
}
function fed_user_form()
{
global $db,$ir,$c,$h,$userid;
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Jailing User</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

The user will be put in fed jail and will be unable to do anything in the game.<br />
<form action='staff_punit.php?action=fedsub' method='post'>
User: ".user_dropdown($c,'user',$_GET['XID'])."<br />
Days: <input type='text' STYLE='color: black;  background-color: white;' name='days' /><br />
Reason: <input type='text' STYLE='color: black;  background-color: white;' name='reason' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Jail User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function fed_user_submit()
{
global $db,$ir,$c,$h,$userid;
$re=$db->query("UPDATE users SET fedjail=1 WHERE userid={$_POST['user']}");
if($db->affected_rows())
{
$db->query("INSERT INTO fedjail VALUES('',{$_POST['user']},{$_POST['days']},$userid,'".
$_POST['reason']."')");
}
$db->query("INSERT INTO jaillogs VALUES('',$userid, {$_POST['user']}, {$_POST['days']}, '{$_POST['reason']}',unix_timestamp())");
print "User jailed.";
stafflog_add("Fedded ID {$_POST['user']} for {$_POST['days']}");
}
function fed_edit_form()
{
global $db,$ir,$c,$h,$userid;
print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Editing Fedjail Reason</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

You are editing a player's sentence in fed jail.<br />
<form action='staff_punit.php?action=fedesub' method='post'>
User: ".fed_user_dropdown($c,'user')."<br />
Days: <input type='text' STYLE='color: black;  background-color: white;' name='days' /><br />
Reason: <input type='text' STYLE='color: black;  background-color: white;' name='reason' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Jail User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function fed_edit_submit()
{
global $db,$ir,$c,$h,$userid;

$db->query("DELETE FROM fedjail WHERE fed_userid={$_POST['user']}");
$db->query("INSERT INTO fedjail VALUES('',{$_POST['user']},{$_POST['days']},$userid,'".
$_POST['reason']."')");

$db->query("INSERT INTO jaillogs VALUES('',$userid, {$_POST['user']}, {$_POST['days']}, '{$_POST['reason']}',unix_timestamp())");
print "User's sentence edited.";
stafflog_add("Edited user ID {$_POST['user']}'s fedjail sentence");
}

function mail_user_form()
{
global $db,$ir,$c,$h,$userid;
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Mail Banning User</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

The user will be banned from the mail system.<br />
<form action='staff_punit.php?action=mailsub' method='post'>
User: ".user_dropdown($c,'user',$_GET['ID'])."<br />
Days: <input type='text' STYLE='color: black;  background-color: white;' name='days' /><br />
Reason: <input type='text' STYLE='color: black;  background-color: white;' name='reason' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Mailban User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function mail_user_submit()
{
global $db,$ir,$c,$h,$userid;
$_POST['reason']=$_POST['reason'];
$re=$db->query("UPDATE users SET mailban={$_POST['days']},mb_reason='{$_POST['reason']}' WHERE userid={$_POST['user']}");
event_add($_POST['user'],"You were banned from mail for {$_POST['days']} day(s) for the following reason: {$_POST['reason']}",$c);
print "User mail banned.";
stafflog_add("Mail banned User ID {$_POST['user']} for {$_POST['days']} days");
}
function forum_user_form()
{
global $db,$ir,$c,$h,$userid;
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Forum Banning User</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

The user will be banned from the forums.<br />
<form action='staff_punit.php?action=forumsub' method='post'>
User: ".user_dropdown($c,'user',$_GET['ID'])."<br />
Days: <input type='text' STYLE='color: black;  background-color: white;' name='days' /><br />
Reason: <input type='text' STYLE='color: black;  background-color: white;' name='reason' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Forumban User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function forum_user_submit()
{
global $db,$ir,$c,$h,$userid;
$_POST['reason']=$_POST['reason'];
$re=$db->query("UPDATE users SET forumban={$_POST['days']},fb_reason='{$_POST['reason']}' WHERE userid={$_POST['user']}");
event_add($_POST['user'],"You were banned from the forums for {$_POST['days']} day(s) for the following reason: {$_POST['reason']}",$c);
print "User forum banned.";
stafflog_add("Forum banned User ID {$_POST['user']} for {$_POST['days']} days");
}
function unfed_user_form()
{
global $db,$ir,$c,$h,$userid;
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Unjailing User</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

The user will be taken out of fed jail.<br />
<form action='staff_punit.php?action=unfedsub' method='post'>
User: ".fed_user_dropdown($c,'user')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Unjail User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function unfed_user_submit()
{
global $db,$ir,$c,$h,$userid;
$db->query("UPDATE users SET fedjail=0 WHERE userid={$_POST['user']}");
$db->query("DELETE FROM fedjail WHERE fed_userid={$_POST['user']}");
$db->query("INSERT INTO unjaillogs VALUES('',$userid, {$_POST['user']}, unix_timestamp())");
print "User unjailed.";
stafflog_add("Unfedded user ID {$_POST['user']}");
}
function unmail_user_form()
{
global $db,$ir,$c,$h,$userid;
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Un-mailbanning User</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

The user will be taken out of mail ban.<br />
<form action='staff_punit.php?action=unmailsub' method='post'>
User: ".mailb_user_dropdown($c,'user')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Un-mailban User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function unmail_user_submit()
{
global $db,$ir,$c,$h,$userid;
$db->query("UPDATE users SET mailban=0 WHERE userid={$_POST['user']}");
print "User un-mailbanned.";
event_add($_POST['user'], "You were unbanned from mail. You can now use it again.", $c);
stafflog_add("Un-mailbanned user ID {$_POST['user']}");
}
function unforum_user_form()
{
global $db,$ir,$c,$h,$userid;
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Un-forumbanning User</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

The user will be taken out of forum ban.<br />
<form action='staff_punit.php?action=unforumsub' method='post'>
User: ".forumb_user_dropdown($c,'user')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Un-forumban User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function unforum_user_submit()
{
global $db,$ir,$c,$h,$userid;
$db->query("UPDATE users SET forumban=0 WHERE userid={$_POST['user']}");
print "User un-forumbanned.";
event_add($_POST['user'], "You were unbanned from the forums. You can now use them again.", $c);
stafflog_add("Un-forumbanned user ID {$_POST['user']}");
}
function ip_search_form()
{
global $db,$ir,$c,$h,$userid;
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> IP Search</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_punit.php?action=ipsub' method='post'>
IP: <input type='text' STYLE='color: black;  background-color: white;' name='ip' value='...' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Search' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function ip_search_submit()
{
global $db,$ir,$c,$h,$userid, $domain;
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Searching for users with the IP: <b>{$_POST['ip']}</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table width=75%><tr style='background:gray'> <th>User</th> <th>Level</th> <th>Money</th> </tr>";
$q=$db->query("SELECT * FROM users WHERE lastip='{$_POST['ip']}'");
$ids=array();
while($r=$db->fetch_row($q))
{
$ids[]=$r['userid'];
print "\n<tr> <td> <a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a></td> <td> {$r['level']}</td> <td>{$r['money']}</td> </tr>";
}
print "</table><br />
<b>Mass Jail</b><br />
<form action='staff_punit.php?action=massjailip' method='post'>
<input type='hidden' name='ids' value='".implode(",",$ids)."' /> Days: <input type='text' STYLE='color: black;  background-color: white;' name='days' value='300' /> <br />
Reason: <input type='text' STYLE='color: black;  background-color: white;' name='reason' value='Same IP users, Mail fedjail@{$domain} with your case.' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Mass Jail' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function mass_jail()
{
global $db,$ir,$c,$h,$userid;
$ids=explode(",",$_POST['ids']);
foreach($ids as $id)
{
$re=$db->query("UPDATE users SET fedjail=1 WHERE userid={$id}");
if($db->affected_rows())
{
$db->query("INSERT INTO fedjail VALUES('',{$id},{$_POST['days']},$userid,'".
mysql_real_escape_string($_POST['reason'],$c)."')");
}
$db->query("INSERT INTO jaillogs VALUES('',$userid, {$id}, {$_POST['days']}, '{$_POST['reason']}',unix_timestamp())");
print "User jailed : $id.";

}
stafflog_add("Mass jailed IDs {$_POST['ids']}");
}

$h->endpage();
?>
