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
//This contains forum stuffs
switch($_GET['action'])
{
case "addforum": addcity(); break;
case "editforum": editcity(); break;
case "delforum": delcity(); break;
default: print "Error: This script requires an action."; break;
}
function addcity()
{
global $db, $ir, $c, $h, $userid;
global $db;
$name=$_POST['name'];
$desc=$_POST['desc'];
$auth=$_POST['auth'];
if($auth and $desc and $name)
{
$q=$db->query("SELECT * FROM forum_forums WHERE ff_name='{$name}'");
if($db->num_rows($q))
{
print "Sorry, you cannot have two forums with the same name.";
$h->endpage();
exit;
}
$db->query("INSERT INTO forum_forums (ff_name, ff_desc, ff_auth, ff_lp_poster_name, ff_lp_t_name) VALUES('$name', '$desc', '$auth', 'N/A', 'N/A')");
print "Forum {$name} added to the game.";
stafflog_add("Created Forum $name");
}
else
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Add Forum</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_forums.php?action=addforum' method='post'>
Name: <input type='text' STYLE='color: black;  background-color: white;' name='name' /><br />
Description: <input type='text' STYLE='color: black;  background-color: white;' name='desc' /><br />
Authorization: <input type='radio' name='auth' value='public' checked='checked' /> Public <input type='radio' name='auth' value='staff' /> Staff Only<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Add Forum' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
function editcity()
{
global $db, $ir, $c, $h, $userid;
global $db;
switch($_POST['step'])
{
case "2":
$name=$_POST['name'];
$desc=$_POST['desc'];
$auth=$_POST['auth'];
$q=$db->query("SELECT * FROM forum_forums WHERE ff_name='{$name}' AND ff_id!={$_POST['id']}");
if($db->num_rows($q))
{
print "Sorry, you cannot have two forums with the same name.";
$h->endpage();
exit;
}
$name=$_POST['name'];
$q=$db->query("SELECT * FROM forum_forums WHERE ff_id={$_POST['id']}");
$old=$db->fetch_row($q);
$db->query("UPDATE forum_forums SET ff_desc='$desc', ff_name='$name', ff_auth='$auth' WHERE ff_id={$_POST['id']}");
print "Forum $name was edited successfully.";
stafflog_add("Edited forum $name");
break;
case "1":
$q=$db->query("SELECT * FROM forum_forums WHERE ff_id={$_POST['id']}");
$old=$db->fetch_row($q);
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Editing a Forum</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_forums.php?action=editforum' method='post'>
<input type='hidden' name='step' value='2' />
<input type='hidden' name='id' value='{$_POST['id']}' />
Name: <input type='text' STYLE='color: black;  background-color: white;' name='name' value='{$old['ff_name']}' /><br />
Description: <input type='text' STYLE='color: black;  background-color: white;' name='desc' value='{$old['ff_desc']}' /><br />
";
if($old['ff_auth']=="public")
{
print "Authorization: <input type='radio' name='auth' value='public' checked='checked' /> Public <input type='radio' name='auth' value='staff' /> Staff Only<br />";
}
else
{
print "Authorization: <input type='radio' name='auth' value='public' /> Public <input type='radio' name='auth' value='staff' checked='checked' /> Staff Only<br />";
}
print "
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit Forum' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
break;
default:
print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Editing a Forum</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_forums.php?action=editforum' method='post'>
<input type='hidden' name='step' value='1' />
Forum: ".forum2_dropdown($c, "id")."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit Forum' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
break;
}
}
function delcity()
{
global $db,$ir,$c,$h,$userid;
global $db;
if($_POST['forum'])
{
$q=$db->query("SELECT * FROM forum_forums WHERE ff_id={$_POST['forum']}");
$old=$db->fetch_row($q);
if($_POST['forum']==$_POST['forum2']) { die("You cannot select the same crime group to move the crimes to."); }
$db->query("UPDATE forum_posts SET fp_forum_id={$_POST['forum2']} WHERE fp_forum_id={$old['ff_id']}");
$db->query("UPDATE forum_topics SET ft_forum_id={$_POST['forum2']} WHERE ft_forum_id={$old['ff_id']}");
recache_forum($_POST['forum2']);
$db->query("DELETE FROM forum_forums WHERE ff_id={$old['ff_id']}");
print "Forum {$old['ff_name']} deleted and posts have been moved.";
stafflog_add("Deleted forum {$old['ff_name']}");
}
else
{
print "
<script type='text/javascript'>
function checkme()
{
if(document.theform.forum.value==document.theform.forum2.value)
{
alert('You cannot select the same forum to move the posts to.');
return false;
}
return true;
}
</script>

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Delete Forum</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

Deleting a forum is permanent - be sure. .<form action='staff_forums.php?action=delforum' method='post' name='theform'  onsubmit='return checkme();'>
Forum: ".forum2_dropdown($c, "forum")."<br />
Move posts & topics in the deleted forum to: ".forum2_dropdown($c, "forum2")."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Delete Forum' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
function report_clear()
{
global $db,$ir,$c,$h,$userid;
global $db;
if($ir['user_level'] > 3)
{
die("403");
}
$_GET['ID'] = abs((int) $_GET['ID']);
stafflog_add("Cleared player report ID {$_GET['ID']}");
$db->query("DELETE FROM preports WHERE prID={$_GET['ID']}");
print "Report cleared and deleted!<br />
<a href='staff_users.php?action=reportsview'>&gt; Back</a>";
}
function recache_forum($forum)
{
global $ir, $c, $userid, $h, $db;
global $db;
$q=$db->query("SELECT p.*,t.* FROM forum_posts p LEFT JOIN forum_topics t ON p.fp_topic_id=t.ft_id WHERE p.fp_forum_id=$forum ORDER BY p.fp_time DESC LIMIT 1");
if(!$db->num_rows($q))
{
$db->query("update forum_forums set ff_lp_time=0, ff_lp_poster_id=0, ff_lp_poster_name='N/A', ff_lp_t_id=0, ff_lp_t_name='N/A',ff_posts=0, ff_topics=0 where ff_id={$forum}");
}
else
{
$r=$db->fetch_row($q);
$tn=mysql_escape($r['ft_name']);
$pn=mysql_escape($r['fp_poster_name']);
$posts=$db->num_rows($db->query("SELECT fp_id FROM forum_posts WHERE fp_forum_id=$forum"));
$topics=$db->num_rows($db->query("SELECT ft_id FROM forum_topics WHERE ft_forum_id=$forum"));
$db->query("update forum_forums set ff_lp_time={$r['fp_time']}, ff_lp_poster_id={$r['fp_poster_id']}, ff_lp_poster_name='$pn', ff_lp_t_id={$r['ft_id']}, ff_lp_t_name='$tn',ff_posts=$posts, ff_topics=$topics where ff_id={$forum}");
}
}
$h->endpage();
?>
