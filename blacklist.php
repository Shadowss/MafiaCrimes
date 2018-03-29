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
if($ir['donatordays'] == 0)
{
die("This feature is for donators only.");
}
print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Black List</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

";
switch($_GET['action'])
{
case "add":
add_enemy();
break;

case "remove":
remove_enemy();
break;

case "ccomment":
change_comment();
break;

default:
black_list();
break;
}
function black_list()
{
global $db,$ir,$c,$userid;
print "<a href='blacklist.php?action=add'>&gt; Add an Enemy</a><br />
These are the people on your black list. ";
$q_y=$db->query("SELECT * FROM blacklist WHERE bl_ADDED=$userid");
print "{$ir['enemy_count']} people have added you to their list.<br />Most hated: [";
$q2r=$db->query("SELECT u.username,u.userid as bl_ADDED FROM users u ORDER BY enemy_count DESC LIMIT 5");
$r=0;
while($r2r=$db->fetch_row($q2r))
{
$r++;
if($r > 1) { print " | "; }
print "<a href='viewuser.php?u={$r2r['bl_ADDED']}'>{$r2r['username']}</a>";
}
print "]
<table width=90% class='table' cellspacing='1'><tr style='background:gray'> <th>ID</th> <th>Name</th> <th>Mail</th> <th>Attack</th> <th>Remove</th> <th>Comment</th> <th>Change Comment</th> <th>Online?</th></tr>";
$q=$db->query("SELECT bl.*,u.* FROM blacklist bl LEFT JOIN users u ON bl.bl_ADDED=u.userid WHERE bl.bl_ADDER=$userid ORDER BY u.username ASC");
while($r=$db->fetch_row($q))
{
if($r['laston'] >= time()-15*60) { $on="<font color=green><b>Online</b></font>"; } else { $on="<font color=red><b>Offline</b></font>"; }
$d="";
if($r['donatordays']) { $r['username'] = "<font color=red>{$r['username']}</font>";$d="<img src='donator.gif' alt='Donator: {$r['donatordays']} Days Left' title='Donator: {$r['donatordays']} Days Left' />"; }
if(!$r['bl_COMMENT']) { $r['bl_COMMENT']="N/A"; }
print "<tr> <td>{$r['userid']}</td> <td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> $d</td> <td><a href='mailbox.php?action=compose&ID={$r['userid']}'>Mail</a></td> <td><a href='attack.php?ID={$r['userid']}'>Attack</a></td> <td><a href='blacklist.php?action=remove&f={$r['bl_ID']}'>Remove</a></td> <td>{$r['bl_COMMENT']}</td> <td><a href='blacklist.php?action=ccomment&f={$r['bl_ID']}'>Change</a></td> <td>$on</td></tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function add_enemy()
{
global $db,$ir,$c,$userid;
$_POST['ID'] = abs((int) $_POST['ID']);
$_POST['comment']=str_replace(array("<",">","\n"),array("&lt;","&gt;","<br />"), $_POST['comment']);

if($_POST['ID'])
{
$qc=$db->query("SELECT * FROM blacklist WHERE bl_ADDER=$userid AND bl_ADDED={$_POST['ID']}");
$q=$db->query("SELECT * FROM users WHERE userid={$_POST['ID']}");
if($db->num_rows($qc))
{
print "You cannot add the same person twice.</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
else if($userid==$_POST['ID'])
{
print "You cannot be so lonely that you have to try and add yourself.</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
else if($db->num_rows($q)==0)
{
print "Oh no, you're trying to add a ghost.</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
else
{
$db->query("INSERT INTO blacklist VALUES('', $userid, {$_POST['ID']}, '{$_POST['comment']}')");
$r=$db->fetch_row($q);
$db->query("UPDATE users SET enemy_count=enemy_count+1 WHERE userid={$_POST['ID']}");
print "{$r['username']} was added to your black list.<br />
<a href='blacklist.php'>&gt; Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
else
{
print "Adding an enemy!<form action='blacklist.php?action=add' method='post'>
Enemy's ID: <input type='text' STYLE='color: black;  background-color: white;' name='ID' value='{$_GET['ID']}' /><br />
Comment (optional): <br />
<textarea name='comment' rows='7' cols='40'></textarea><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Add Enemy' /></form>";
}

}
function remove_enemy()
{
global $db,$ir,$c,$userid;
$q=$db->query("SELECT * FROM blacklist WHERE bl_ID={$_GET['f']} AND bl_ADDER=$userid");
if($db->num_rows($q) == 0)
{
die("Cannot remove a nonexistant entry.");
}
$r=$db->fetch_row($q);
$db->query("DELETE FROM blacklist WHERE bl_ID={$_GET['f']} AND bl_ADDER=$userid");
$db->query("UPDATE users SET enemy_count=enemy_count-1 WHERE userid={$r['bl_ADDED']}");
print "black list entry removed!<br />
<a href='blacklist.php'>&gt; Back</a>";
}
function change_comment()
{
global $db,$ir,$c,$userid;
$_POST['f'] = abs(@intval($_POST['f']));
$_POST['comment']=str_replace(array("<",">","\n"),array("&lt;","&gt;","<br />"), $_POST['comment']);
if($_POST['comment'])
{
$db->query("UPDATE blacklist SET bl_COMMENT='".mysql_real_escape_string($_POST['comment'])."' WHERE bl_ID={$_POST['f']} AND bl_ADDER=$userid");
print "Comment for enemy changed!<br />
<a href='blacklist.php'>&gt; Back</a>";
}
else
{
$_GET['f'] = abs(@intval($_GET['f']));
$q=$db->query("SELECT * FROM blacklist WHERE bl_ID={$_GET['f']} AND bl_ADDER=$userid");
if($db->num_rows($q))
{
$r=$db->fetch_row($q);
$comment=str_replace(array("&lt;","&gt;","<br />"), array("<",">","\n"), $r['fl_COMMENT']);
print "Changing a comment.<form action='blacklist.php?action=ccomment' method='post'>
<input type='hidden' name='f' value='{$_GET['f']}' /><br />
Comment: <br />
<textarea rows='7' cols='40' name='comment'>$comment</textarea><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Change Comment' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
else
{
print "Stop trying to edit comments that aren't yours.";
}
}
}



$h->endpage();
?>
