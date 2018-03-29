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
print "This feature is for donators only.";
$h->endpage();
exit;

}
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Friends List</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

";
switch($_GET['action'])
{
case "add":
add_friend();
break;

case "remove":
remove_friend();
break;

case "ccomment":
change_comment();
break;

default:
friends_list();
break;
}
function friends_list()
{
global $db,$ir,$c,$userid;
print "<a href='friendslist.php?action=add'>&gt; Add a Friend</a><br />
These are the people on your friends list. ";
print "{$ir['friend_count']} people have added you to their list.<br />
Most liked: [";
$q2r=$db->query("SELECT u.username,u.userid AS fl_ADDED FROM users u ORDER BY u.friend_count DESC LIMIT 5");
$r=0;
while($r2r=$db->fetch_row($q2r))
{
$r++;
if($r > 1) { print " | "; }
print "<a href='viewuser.php?u={$r2r['fl_ADDED']}'>{$r2r['username']}</a>";
}
print "]<br />
<table width=90% class='table' cellspacing='1'><tr style='background:gray'> <th>ID</th> <th>Name</th> <th>Mail</th> <th>Send Cash</th> <th>Remove</th> <th>Comment</th> <th>Change Comment</th> <th>Online?</th></tr>";
$q=$db->query("SELECT fl.*,u.* FROM friendslist fl LEFT JOIN users u ON fl.fl_ADDED=u.userid WHERE fl.fl_ADDER=$userid ORDER BY u.username ASC");
while($r=$db->fetch_row($q))
{
if($r['laston'] >= time()-15*60) { $on="<font color=green><b>Online</b></font>"; } else { $on="<font color=red><b>Offline</b></font>"; }
$d="";
if($r['donatordays']) { $r['username'] = "<font color=red>{$r['username']}</font>";$d="<img src='donator.gif' alt='Donator: {$r['donatordays']} Days Left' title='Donator: {$r['donatordays']} Days Left' />"; }
if(!$r['fl_COMMENT']) { $r['fl_COMMENT']="N/A"; }
print "<tr> <td>{$r['userid']}</td> <td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> $d</td> <td><a href='mailbox.php?action=compose&ID={$r['userid']}'>Mail</a></td> <td><a href='sendcash.php?ID={$r['userid']}'>Send Cash</a></td> <td><a href='friendslist.php?action=remove&f={$r['fl_ID']}'>Remove</a></td> <td>{$r['fl_COMMENT']}</td> <td><a href='friendslist.php?action=ccomment&f={$r['fl_ID']}'>Change</a></td> <td>$on</td></tr>";
}
print "</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function add_friend()
{
global $db,$ir,$c,$userid;
$_POST['ID'] = abs((int) $_POST['ID']);
$_POST['comment']=str_replace(array("<",">","\n"),array("&lt;","&gt;","<br />"), $_POST['comment']);

if($_POST['ID'])
{
$qc=$db->query("SELECT * FROM friendslist WHERE fl_ADDER=$userid AND fl_ADDED={$_POST['ID']}");
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
$db->query("INSERT INTO friendslist VALUES('', $userid, {$_POST['ID']}, '{$_POST['comment']}')");
$r=$db->fetch_row($q);
$db->query("UPDATE users SET friend_count=friend_count+1 WHERE userid={$_POST['ID']}");
print "{$r['username']} was added to your friends list.<br />
<a href='friendslist.php'>&gt; Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
else
{
print "Adding a friend!<form action='friendslist.php?action=add' method='post'>
Friend's ID: <input type='text' STYLE='color: black;  background-color: white;' name='ID' value='{$_GET['ID']}' /><br />
Comment (optional): <br />
<textarea name='comment' rows='7' cols='40'></textarea><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Add Friend' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}

}
function remove_friend()
{
global $db,$ir,$c,$userid;
$q=$db->query("SELECT * FROM friendslist WHERE fl_ID={$_GET['f']} AND fl_ADDER=$userid");
if($db->num_rows($q) == 0)
{
die("Cannot remove a nonexistant entry.");
}
$r=$db->fetch_row($q);
$db->query("DELETE FROM friendslist WHERE fl_ID={$_GET['f']} AND fl_ADDER=$userid");
$db->query("UPDATE users SET friend_count=friend_count-1 WHERE userid={$r['fl_ADDED']}");
print "Friends list entry removed!<br />
<a href='friendslist.php'>&gt; Back</a>";
}
function change_comment()
{
global $db,$ir,$c,$userid;
$_POST['f'] = abs((int) $_POST['f']);
$_POST['comment']=str_replace(array("<",">","\n"),array("&lt;","&gt;","<br />"), $_POST['comment']);
if($_POST['comment'])
{
$db->query("UPDATE friendslist SET fl_COMMENT='{$_POST['comment']}' WHERE fl_ID={$_POST['f']} AND fl_ADDER=$userid");
print "Comment for friend changed!<br />
<a href='friendslist.php'>&gt; Back</a>";
}
else
{
$_GET['f'] = abs((int) $_GET['f']);
$q=$db->query("SELECT * FROM friendslist WHERE fl_ID={$_GET['f']} AND fl_ADDER=$userid");
if($db->num_rows($q))
{
$r=$db->fetch_row($q);
$comment=str_replace(array("&lt;","&gt;","<br />"), array("<",">","\n"), $r['fl_COMMENT']);
print "Changing a comment.<form action='friendslist.php?action=ccomment' method='post'>
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
