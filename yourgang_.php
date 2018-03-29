<?php
include "globals.php";

if(!$ir['gang'])
{
print "You're not in a gang.";
}
else
{
$gq=$db->query("SELECT g.*,oc.* FROM gangs g LEFT JOIN orgcrimes oc ON g.gangCRIME=oc.ocID WHERE g.gangID={$ir['gang']}");
$gangdata=$db->fetch_row($gq);
print "<h3><u>Your Gang - {$gangdata['gangNAME']}</u></h3>";
$wq=$db->query("SELECT * FROM gangwars where warDECLARER={$ir['gang']} or warDECLARED={$ir['gang']}");
if($db->num_rows($wq) > 0)
{
print "<h3><a href='yourgang.php?action=warview'><font color=red>Your gang is currently in ".$db->num_rows($wq)." war(s).</font></a></h3>";
}
switch($_GET['action'])
{
case "idx":
gang_index();
break;

case "summary":
gang_summary();
break;

case "members":
gang_memberlist();
break;

case "kick":
gang_staff_kick();
break;

case "forums":
gang_forums();
break;

case "donate":
gang_donate();
break;

case "donate2":
gang_donate2();
break;

case "warview":
gang_warview();
break;

case "staff":
gang_staff();
break;

case "leave":
gang_leave();
break;

case "atklogs":
gang_atklogs();
break;

case "crimes":
gang_crimes();
break;

default:
gang_index();
break;
}
}
function gang_index()
{
global $db,$ir,$c,$userid,$gangdata;
print "<table cellspacing=1 class='table'><tr><td><a href='yourgang.php?action=summary'>Summary</a></td><td><a href='yourgang.php?action=donate'>Donate</a></td></tr><tr><td><a href='yourgang.php?action=members'>Members</a></td><td><a href='yourgang.php?action=crimes'>Crimes</a></td></tr><tr><td><a href='yourgang.php?action=forums'>Forums</a></td><td><a href='yourgang.php?action=leave'>Leave</a></td></tr>
<tr><td><a href='yourgang.php?action=atklogs'>Attack Logs</a></td><td>";
if($gangdata['gangPRESIDENT'] == $userid || $gangdata['gangVICEPRES'] == $userid )
{
print "<a href='yourgang.php?action=staff&act2=idx'>Staff Room</a>";
}
else
{
print "&nbsp;";
}
print "</td></tr></table><br />

<table cellspacing=1 class='table'><tr style='background:gray;'><td align=center class='h'>Gang Announcement</td></tr>
<tr><td bgcolor='#DDDDDD'>{$gangdata['gangAMENT']}</td></tr></table><br />
<b>Last 10 Gang Events</b><br />";
$q=$db->query("SELECT * FROM gangevents WHERE gevGANG={$ir['gang']} ORDER BY gevTIME DESC LIMIT 10");
print "<table width=75% cellspacing=1 class='table'><tr style='background:gray;'><th>Time</th><th>Event</th></tr>";
while($r=$db->fetch_row($q))
{
print "<tr><td>".date('F j Y, g:i:s a',$r['gevTIME'])."</td><td>{$r['gevTEXT']}</td></tr>";
}
print "</table>";
}
function gang_summary()
{
global $db,$ir,$c,$userid,$gangdata;
print "<b>General</b><br />";
$pq=$db->query("SELECT * FROM users WHERE userid={$gangdata['gangPRESIDENT']}");
$ldr=$db->fetch_row($pq);
$vpq=$db->query("SELECT * FROM users WHERE userid={$gangdata['gangVICEPRES']}");
$coldr=$db->fetch_row($vpq);
print "President: <a href='viewuser.php?u={$ldr['userid']}'>{$ldr['username']}</a><br />
Vice-President: <a href='viewuser.php?u={$coldr['userid']}'>{$coldr['username']}</a><br />";
$cnt=$db->query("SELECT username FROM users WHERE gang={$gangdata['gangID']}");
print "Members: ".$db->num_rows($cnt)."<br />
Capacity: {$gangdata['gangCAPACITY']}<br />
Respect Level: {$gangdata['gangRESPECT']}<hr />
<b>Financial:</b><br />
Money in vault: \${$gangdata['gangMONEY']}<br />
Crystals in vault: {$gangdata['gangCRYSTALS']}";
}
function gang_memberlist()
{
global $db,$ir,$c,$userid,$gangdata;
print "<table cellspacing=1 class='table'><tr style='background: gray;'><th>User</th><th>Level</th><th>Days In Gang</th><th>&nbsp;</th></tr>";
$q=$db->query("SELECT * FROM users WHERE gang={$gangdata['gangID']} ORDER BY daysingang DESC, level DESC");
while($r=$db->fetch_row($q))
{
print "<tr><td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a></td><td>{$r['level']}</td>
<td>{$r['daysingang']}</td><td>";
if($gangdata['gangPRESIDENT'] == $userid || $gangdata['gangVICEPRES'] == $userid )
{
print "<a href='yourgang.php?action=kick&ID={$r['userid']}'>Kick</a>";
}
else
{
print "&nbsp;";
}
print "</td></tr>";
}
print "</table><br />
<a href='yourgang.php'>&gt; Back</a>";
}

function gang_staff_kick()
{
global $db,$ir,$c,$userid,$gangdata;
if($gangdata['gangPRESIDENT'] == $userid || $gangdata['gangVICEPRES'] == $userid  )
{
$_GET['ID'] = abs((int) $_GET['ID']);
$who=$_GET['ID'];
if($who==$gangdata['gangPRESIDENT'])
{
print "The gang president cannot be kicked.";
}
else if($who == $userid)
{
print "You cannot kick yourself, if you wish to leave transfer your powers to someone else and then leave like normal.";
}
else
{
$q=$db->query("SELECT * FROM users WHERE userid=$who AND gang={$gangdata['gangID']}");
if($db->num_rows($q))
{
$kdata=$db->fetch_row($q);
$db->query("UPDATE users SET gang=0,daysingang=0 WHERE userid=$who");
print "<b>{$kdata['username']}</b> was kicked from the Gang.";
event_add($who,"You were kicked out of {$gangdata['gangNAME']} by <a href='viewuser.php?u=$userid'>{$ir['username']}</a>",$c);
$db->query("INSERT INTO gangevents VALUES('',{$gangdata['gangID']},unix_timestamp(),'<a href=''viewuser.php?u=$who''>{$kdata['username']}</a> was kicked out of the Gang by <a href=''viewuser.php?u=$userid''>{$ir['username']}</a>');");
}
else
{
print "Trying to kick nonexistant user";
}
}
}
else
{
print "You do not have permission to perform this action.";
}
}
function gang_forums()
{
  global $db,$ir,$c,$userid,$gangdata;
  $q=$db->query("SELECT * FROM forum_forums WHERE ff_auth='gang' AND ff_owner={$ir['gang']}");
if($db->num_rows($q) == 0)
{
$gangdata['gangNAME']=$db->escape($gangdata['gangNAME']);
$db->query("INSERT INTO forum_forums VALUES('', '{$gangdata['gangNAME']}', '', 0, 0, 0, 0, 'N/A', 0, 'N/A', 'gang', {$ir['gang']})");
$r['ff_id']=$db->insert_id();
}
else
{
$r=$db->fetch_row($q);
if($r['ff_name'] != $gangdata['gangNAME'])
{
$gangdata['gangNAME']=$db->escape($gangdata['gangNAME']);
$db->query("UPDATE forum_forums SET ff_name='{$gangdata['gangNAME']}' WHERE ff_id={$r['ff_id']}");
}
}
header("Location: forums.php?viewforum={$r['ff_id']}");
exit;
  /*
$_GET['topic'] = abs((int) $_GET['topic']);
$_GET['reply'] = abs((int) $_GET['reply']);
$_GET['t'] = abs((int) $_GET['t']);
global $db,$ir,$c,$userid,$gangdata;
if($_GET['topic'])
{
$_GET['act2']="viewtopic";
$_GET['t']=$_GET['topic'];
}
if($_GET['reply'])
{
$_GET['act2']="reply";
$_GET['t']=$_GET['reply'];
}
switch($_GET['act2'])
{
case "viewtopic":
gang_forums_viewtopic();
break;

case "reply":
gang_forums_reply();
break;

case "newtopicform":
gang_forums_newt_form();
break;

case "newtopicsub":
gang_forums_newt_sub();
break;

default:
gang_forums_idx();
break;
}
*/
}
function gang_forums_idx()
{
global $db,$ir,$c,$userid,$gangdata;
print "Welcome to your gang forums! [<a href='yourgang.php?action=forums&act2=newtopicform'>Start New Topic</a>]<br />
<table width=80% cellspacing=1 class='table'><tr style='background:gray;'><th>Topic</th><th>Starter</th><th>Replies</th>
<th>Views</th><th>Last Post</th></tr>";
$tpcs=$db->query("SELECT t.*,u1.username as startername,u2.username as lastpostername FROM gangforums_topics t LEFT JOIN users u1 ON t.gft_userid=u1.userid LEFT JOIN users u2 ON t.gft_lastposterid=u2.userid WHERE t.gft_gangid={$gangdata['gangID']} ORDER BY t.gft_lastpost DESC");
while($t=$db->fetch_row($tpcs))
{
print "<tr><td><a href='yourgang.php?action=forums&topic={$t['gft_id']}'>{$t['gft_title']}</a></td><td><a href='viewuser.php?u={$t['gft_userid']}'>{$t['startername']}</a></td>
<td>{$t['gft_replies']}</td><td>{$t['gft_views']}</td><td>";
print date('F j Y, g:i:s a',$t['gft_lastpost']);
print "<br />By: <a href='viewuser.php?u={$t['gft_lastposterid']}'>{$t['lastpostername']}</a></td></tr>";
}
print "</table>";
}
function gang_forums_viewtopic()
{
global $db,$ir,$c,$userid,$gangdata;
$tpcd=$db->query("SELECT t.*,u1.* FROM gangforums_topics t LEFT JOIN users u1 ON t.gft_userid=u1.userid WHERE t.gft_id={$_GET['t']}");
$db->query("UPDATE gangforums_topics SET gft_views=gft_views+1 WHERE gft_id={$_GET['t']}");
$topic=$db->fetch_row($tpcd);
$posts[0]['username']=$topic['username'];
$posts[0]['userid']=$topic['userid'];
$posts[0]['time']=$topic['gft_starttime'];
$posts[0]['level']=$topic['level'];
$posts[0]['nr']=1;
$posts[0]['text']=str_replace("\n","<br />",$topic['gft_text']);
$cntr=0;
$pq=$db->query("SELECT r.*,u.* FROM gangforums_replies r LEFT JOIN users u ON r.gfr_userid=u.userid WHERE r.gfr_topic={$_GET['t']} ORDER BY gfr_posttime ASC;");
while($r=$db->fetch_row($pq))
{
$cntr++;
$posts[$cntr]['username']=$r['username'];
$posts[$cntr]['userid']=$r['userid'];
$posts[$cntr]['time']=$r['gfr_posttime'];
$posts[$cntr]['level']=$r['level'];
$posts[$cntr]['nr']=$cntr+1;
$posts[$cntr]['text']=str_replace("\n","<br />",$r['gfr_text']);
}
print "<table width=80% cellspacing=1 class='table'><tr style='background:gray;'><th colspan=2>{$topic['gft_title']}</th></tr>";
foreach($posts as $cpost)
{
print "<tr><td>Post #{$cpost['nr']}</td><td>Time Posted: ".date('F j Y, g:i:s a',$cpost['time'])."</td></tr>
<tr><td><a href='viewuser.php?u={$cpost['userid']}'>{$cpost['username']}</a><br />Level: {$cpost['level']}</td><td>{$cpost['text']}</td></tr>";
}
print "</table>";
print "<br /><table width=80% cellspacing=1 class='table'><tr style='background: gray;'><th>Add Reply</th></tr>";
print "<tr><td align=center><form action='yourgang.php?action=forums&reply={$_GET['t']}' method='post'><b>Your Post:</b> (no HTML, linebreaks automatically converted to &lt;br /&gt;)<br />
<textarea rows=10 cols=80 name='textpost'></textarea><br />
<input type='submit' value='Post' /></form></td></tr></table>";
}

function gang_forums_reply()
{
global $db,$ir,$c,$userid,$gangdata;
$t=$_GET['t'];
$post=str_replace(array("<",">","'"),array("&lt;","&gt;","''"),$_POST['textpost']);
$db->query("INSERT INTO gangforums_replies VALUES('',$userid,{$gangdata['gangID']},$t,'$post',unix_timestamp())");
$db->query("UPDATE gangforums_topics SET gft_replies=gft_replies+1,gft_lastpost=unix_timestamp(),gft_lastposterid=$userid WHERE gft_id=$t");
print "<table width=80% cellspacing=1 class='table'><tr style='background:gray;'><th>News</th></tr><tr><td align=center>Reply Posted!</td></tr></table><br />";
gang_forums_viewtopic();
}

function gang_forums_newt_form()
{
global $db,$ir,$c,$userid,$gangdata;
print "<b>Creating New Topic....</b><br />
<table cellspacing=1 class='table'>
<form action='yourgang.php?action=forums&act2=newtopicsub' method='post'>
<tr><td>Title:</td><td> <input type='text' name='topictitle' value='' /></td></tr>
<tr><td><b>Your Topic:</b> <br /><small>(no HTML, linebreaks automatically converted to &lt;br /&gt;)</small></td><td><textarea rows=7 cols=40 name='topictext'></textarea></td></tr><tr>
<td colspan=2 align=center><input type='submit' value='Post' /></td></tr></form></table>";
}

function gang_forums_newt_sub()
{
global $db,$ir,$c,$userid,$gangdata;
$title=str_replace(array("<",">","'"),array("&lt;","&gt;","''"),$_POST['topictitle']);
$post=str_replace(array("<",">","'"),array("&lt;","&gt;","''"),$_POST['topictext']);
$db->query("INSERT INTO gangforums_topics VALUES('',$userid,{$gangdata['gangID']},'$title','$post',0,0,unix_timestamp(),$userid,
unix_timestamp())");
$iq=$db->query("SELECT max(gft_id) AS tid FROM gangforums_topics");
$iee=$db->fetch_row($iq);
print "<table width=80% cellspacing=1 class='table'><tr style='background:gray;'><th>News</th></tr><tr><td align=center>Topic Posted!</td></tr></table><br />";
$_GET['t']=$iee['tid'];
gang_forums_viewtopic();
}

function gang_donate()
{
global $db,$ir,$c,$userid,$gangdata;
print "<b>Enter the amounts you wish to donate.</b><br />
You have \${$ir['money']} money and {$ir['crystals']} crystals.<br />
<form action='yourgang.php?action=donate2' method='post'><table height=300  cellspacing=1 class='table'><tr><td><b>Money:</b><br />
<input type='text' name='money' value='0'/></td><td><b>Crystals:</b><br />
<input type='text' name='crystals' value='0' /></td></tr>
<tr><td colspan=2 align=center><input type='submit' value='Donate' /></td></tr></table></form>";
}
function gang_donate2()
{
global $db,$ir,$c,$userid,$gangdata;
$_POST['money'] = abs((int) $_POST['money']);
$_POST['crystals'] = abs((int) $_POST['crystals']);
if($_POST['money'] > $ir['money'])
{
print "You are trying to donate more money than you have.";
}
else if($_POST['crystals'] > $ir['crystals'])
{
print "You are trying to donate more crystals than you have.";
}
else
{
$db->query("UPDATE users SET money=money-{$_POST['money']},crystals=crystals-{$_POST['crystals']} WHERE userid=$userid");
$db->query("UPDATE gangs SET gangMONEY=gangMONEY+{$_POST['money']},gangCRYSTALS=gangCRYSTALS+{$_POST['crystals']} WHERE gangID={$gangdata['gangID']}");
$db->query("INSERT INTO gangevents VALUES('',{$gangdata['gangID']},unix_timestamp(),\"<a href='viewuser.php?u=$userid'>{$ir['username']}</a> donated \${$_POST['money']} and/or {$_POST['crystals']} crystals to the Gang.\");");
print "You donated \${$_POST['money']} and/or {$_POST['crystals']} crystals to the Gang.";
}
}

function gang_staff()
{
global $db,$ir,$c,$userid,$gangdata;
if($gangdata['gangPRESIDENT'] == $userid || $gangdata['gangVICEPRES'] == $userid  )
{
switch($_GET['act2'])
{
case "idx":
gang_staff_idx();
break;

case "apps":
gang_staff_apps();
break;

case "vault":
gang_staff_vault();
break;

case "vicepres":
gang_staff_vicepres();
break;
case "pres":
gang_staff_pres();
break;

case "upgrade":
gang_staff_upgrades();
break;

case "declare":
gang_staff_wardeclare();
break;

case "surrender":
gang_staff_surrender();
break;

case "viewsurrenders":
gang_staff_viewsurrenders();
break;

case "crimes":
gang_staff_orgcrimes();
break;

case "massmailer":
gang_staff_massmailer();
break;

case "desc":
gang_staff_desc();
break;

case "ament":
gang_staff_ament();
break;

case "name":
gang_staff_name();
break;

case "tag":
gang_staff_tag();
break;

case "masspayment":
gang_staff_masspayment();
break;

default:
gang_staff_idx();
break;
}
}
else
{
print "Get out of here j00 cheater.";
}
}
function gang_staff_idx()
{
global $db,$ir,$c,$userid,$gangdata;
print "<b>General</b><br />
<a href='yourgang.php?action=staff&act2=vault'>Vault Management</a><br />
<a href='yourgang.php?action=staff&act2=apps'>Application Management</a><br />
<a href='yourgang.php?action=staff&act2=vicepres'>Change Vice-President</a><br />
<a href='yourgang.php?action=staff&act2=upgrade'>Upgrade Gang</a><br />
<a href='yourgang.php?action=staff&act2=crimes'>Organised Crimes</a><br />
<a href='yourgang.php?action=staff&act2=masspayment'>Mass Payment</a><br />
<a href='yourgang.php?action=staff&act2=ament'>Change Gang Announcement.</a><br />";
if($gangdata['gangPRESIDENT'] == $userid )
{
print "<hr /><a href='yourgang.php?action=staff&act2=pres'>Change President</a><br />
<a href='yourgang.php?action=staff&act2=declare'>Declare War</a><br />
<a href='yourgang.php?action=staff&act2=surrender'>Surrender</a><br />
<a href='yourgang.php?action=staff&act2=viewsurrenders'>View or Accept Surrenders</a><br />
<a href='yourgang.php?action=staff&act2=massmailer'>Mass Mail Gang</a><br />
<a href='yourgang.php?action=staff&act2=name'>Change Gang Name</a><br />
<a href='yourgang.php?action=staff&act2=desc'>Change Gang Desc.</a><br />
<a href='yourgang.php?action=staff&act2=tag'>Change Gang Tag</a>";
}
}

function gang_staff_apps()
{
global $db,$ir,$c,$userid,$gangdata,$h;
$_GET['app'] = abs((int) $_GET['app']);
if($_GET['app'])
{
$aq=$db->query("SELECT a.*,u.* FROM applications a LEFT JOIN users u ON a.appUSER=u.userid WHERE a.appID={$_GET['app']} AND a.appGANG={$gangdata['gangID']}");
if ($db->num_rows($aq))
{
$appdata=$db->fetch_row($aq);
if($_GET['what'] == 'decline')
{
$db->query("DELETE FROM applications WHERE appID={$_GET['app']}");
event_add($appdata['appUSER'],"Your application to join the {$gangdata['gangNAME']} gang was declined",$c);
$db->query("INSERT INTO gangevents VALUES ('',{$gangdata['gangID']},unix_timestamp(),\"<a href='viewuser.php?u=$userid'>{$ir['username']}</a> has declined <a href='viewuser.php?u={$appdata['appUSER']}'>{$appdata['username']}</a>'s application to join the Gang.\");");
print "You have declined the application by {$appdata['username']}.<br />
<a href='yourgang.php?action=staff&act2=apps'>&gt; Back</a>";
}
else
{
$cnt=$db->query("SELECT username FROM users WHERE gang={$gangdata['gangID']}");
if($gangdata['gangCAPACITY'] == $db->num_rows($cnt))
{
print "Your gang is full, you must upgrade it to hold more before you can accept another user!";
$h->endpage();
exit;
}
else if ($appdata['gang'] != 0)
{
print "That person is already in a gang.";
$h->endpage();
exit;
}
$db->query("DELETE FROM applications WHERE appID={$_GET['app']}");
event_add($appdata['appUSER'],"Your application to join the {$gangdata['gangNAME']} gang was accepted, Congrats!",$c);
$db->query("INSERT INTO gangevents VALUES ('',{$gangdata['gangID']},unix_timestamp(),\"<a href='viewuser.php?u=$userid'>{$ir['username']}</a> has accepted <a href='viewuser.php?u={$appdata['appUSER']}'>{$appdata['username']}</a>'s application to join the Gang.\");");
$db->query("UPDATE users SET gang={$gangdata['gangID']},daysingang=0 WHERE userid={$appdata['userid']}");
print "You have accepted the application by {$appdata['username']}.<br />
<a href='yourgang.php?action=staff&act2=apps'>&gt; Back</a>";
}
}
}
else
{
print "<b>Applications</b><br />
<table width=85% cellspacing=1 class='table'><tr style='background:gray;'><th>User</th><th>Level</th><th>Money</th><th>Reason</th>
<th>&nbsp;</th></tr>";
$q=$db->query("SELECT a.*,u.* FROM applications a LEFT JOIN users u ON a.appUSER=u.userid WHERE a.appGANG={$gangdata['gangID']}");
while($r=$db->fetch_row($q))
{
print "<tr><td><a href='viewuser.php?u={$r['userid']}'>{$r['username']} [{$r['userid']}]</a></td><td>{$r['level']}</td><td>\${$r['money']}</td>
<td>{$r['appTEXT']}</td><td><a href='yourgang.php?action=staff&act2=apps&app={$r['appID']}&what=accept'>
Accept</a> | <a href='yourgang.php?action=staff&act2=apps&app={$r['appID']}&what=decline'>
Decline</a></td></tr>";
}
print "</table>";
}
}

function gang_staff_vault()
{
global $db,$ir,$c,$userid,$gangdata;
$_POST['who'] = abs((int) $_POST['who']);
if($_POST['who'])
{
$_POST['crystals']=abs($_POST['crystals']);
$_POST['money']=abs($_POST['money']);
if($_POST['crystals'] > $gangdata['gangCRYSTALS'])
{
print "The vault does not have that many crystals!";
}
else if($_POST['money'] > $gangdata['gangMONEY'])
{
print "The vault does not have that much money!";
}
else
{
$who=(int) $_POST['who'];
$md=$db->query("SELECT * FROM users WHERE userid=$who");
$data=$db->fetch_row($md);
$money=(int) $_POST['money'];
$crys=(int) $_POST['crystals'];
$db->query("UPDATE users SET money=money+$money,crystals=crystals+$crys WHERE userid=$who");
$db->query("UPDATE gangs SET gangMONEY=gangMONEY-$money,gangCRYSTALS=gangCRYSTALS-$crys WHERE gangID={$gangdata['gangID']}");
event_add($who,"You were given \$$money and/or $crys crystals from your Gang.",$c);
$db->query("INSERT INTO gangevents VALUES('',{$gangdata['gangID']},unix_timestamp(),\"<a href='viewuser.php?u=$who'>{$data['username']}</a> was given \$$money and/or $crys crystals from the Gang.\")");
print "<a href='viewuser.php?u=$who'>{$data['username']}</a> was given \$$money and/or $crys crystals from the Gang.";
}
}
else
{
print "The vault has \${$gangdata['gangMONEY']} and {$gangdata['gangCRYSTALS']} crystals.<br />
<form action='yourgang.php?action=staff&act2=vault' method='post'>
Give \$<input type='text' name='money' /> and <input type='text' name='crystals' /> crystals<br />
To: <select name='who' type='dropdown'>";
$q=$db->query("SELECT userid,username FROM users WHERE gang={$gangdata['gangID']}");
while($r=$db->fetch_row($q))
{
print "\n<option value='{$r['userid']}'>{$r['username']}</option>";
}
print "</select><br />
<input type='submit' value='Give' /></form>";
}
}
function gang_staff_vicepres()
{
global $db,$ir,$c,$userid,$gangdata;
if(isset($_POST['subm']))
{
$q=$db->query("SELECT * FROM users WHERE userid={$_POST['vp']} AND gang={$ir['gang']}");
if($db->num_rows($q) < 1) { die("Invalid user or user not in your gang."); }
$memb=$db->fetch_row($q);
$db->query("UPDATE gangs SET gangVICEPRES={$_POST['vp']} WHERE gangID={$gangdata['gangID']}");
event_add($memb['userid'],"You were transferred vice-presidency of {$gangdata['gangNAME']}.",$c);
print "Vice-Presidency was transferred to {$memb['username']}";
}
else
{
print "<form action='yourgang.php?action=staff&act2=vicepres' method='post'>
Enter the ID of the new vice-president.<br />
<input type='hidden' name='subm' value='submit' />
ID: <input type='text' name='vp' value='{$gangdata['gangVICEPRES']}' maxlength='7' width='7' /><br />
<input type='submit' value='Change' /></form>";
}
}
function gang_staff_wardeclare()
{
global $db,$ir,$c,$userid,$gangdata;
if(isset($_POST['subm']))
{
$_POST['gang'] = abs((int) $_POST['gang']);
$db->query("INSERT INTO gangwars VALUES('',{$ir['gang']},{$_POST['gang']},unix_timestamp())");
$ggq=$db->query("SELECT * FROM gangs WHERE gangID={$_POST['gang']}");
$them=$db->fetch_row($ggq);
$event=str_replace("'","''","<a href='gangs.php?action=view&ID={$ir['gang']}'>{$gangdata['gangNAME']}</a> declared war on <a href='gangs.php?action=view&ID={$_POST['gang']}'>{$them['gangNAME']}</a>");
$db->query("INSERT INTO gangevents VALUES('',{$ir['gang']},unix_timestamp(),'$event') , ('',{$_POST['gang']},unix_timestamp(),'$event')");
print "You have declared war!";
}
else
{
print "<form action='yourgang.php?action=staff&act2=declare' method='post'>
Choose who to declare war on.<br />
<input type='hidden' name='subm' value='submit' />
Gang: <select name='gang' type='dropdown'>";
$q=$db->query("SELECT * FROM gangs WHERE gangID != {$ir['gang']}");
while($r=$db->fetch_row($q))
{
print "<option value='{$r['gangID']}'>{$r['gangNAME']}</option>\n";
}
print "</select><br />
<input type='submit' value='Declare' /></form>";
}
}
function gang_staff_surrender()
{
global $db,$ir,$c,$userid,$gangdata;
if(!isset($_POST['subm']))
{
print "<form action='yourgang.php?action=staff&act2=surrender' method='post'>
Choose who to surrender to.<br />
<input type='hidden' name='subm' value='submit' />
Gang: <select name='war' type='dropdown'>";
$wq=$db->query("SELECT * FROM gangwars where warDECLARER={$ir['gang']} or warDECLARED={$ir['gang']}");

while($r=$db->fetch_row($wq))
{
if($gangdata['gangID'] == $r['warDECLARER']) { $w="You";$f="warDECLARED"; } else { $w="Them";$f="warDECLARER"; }
$d=date('F j, Y, g:i:s a',$r['warTIME']);
$ggq=$db->query("SELECT * FROM gangs WHERE gangID=".$r[$f]);
$them=$db->fetch_row($ggq);
print "<option value='{$r['warID']}'>{$them['gangNAME']}</option>";
}
print "</select><br />
Message: <input type='text' name='msg' /><br />
<input type='submit' value='Surrender' /></form>";
}
else
{
$_POST['war'] = abs((int) $_POST['war']);
$wq=$db->query("SELECT * FROM gangwars where warID={$_POST['war']}");
$r=$db->fetch_row($wq);
if($gangdata['gangID'] == $r['warDECLARER']) { $w="You";$f="warDECLARED"; } else { $w="Them";$f="warDECLARER"; }
$db->query("INSERT INTO surrenders VALUES('',{$_POST['war']},{$ir['gang']},".$r[$f].",'{$_POST['msg']}')");
$ggq=$db->query("SELECT * FROM gangs WHERE gangID=".$r[$f]);
$them=$db->fetch_row($ggq);
$event=str_replace("'","''","<a href='gangs.php?action=view&ID={$ir['gang']}'>{$gangdata['gangNAME']}</a> have asked to surrender the war against <a href='gangs.php?action=view&ID={$them['gangID']}'>{$them['gangNAME']}</a>");
$db->query("INSERT INTO gangevents VALUES('',{$ir['gang']},unix_timestamp(),'$event') , ('',".$r[$f].",unix_timestamp(),'$event')");
print "You have asked to surrender.";
}
}
function gang_staff_viewsurrenders()
{
global $db,$ir,$c,$userid,$gangdata;
if(!isset($_POST['subm']))
{
print "<form action='yourgang.php?action=staff&act2=viewsurrenders' method='post'>
Choose who to accept the surrender from.<br />
<input type='hidden' name='subm' value='submit' />
Gang: <select name='sur' type='dropdown'>";
$wq=$db->query("SELECT s.*,w.* FROM surrenders s LEFT JOIN gangwars w ON s.surWAR=w.warID WHERE surTO={$ir['gang']}");

while($r=$db->fetch_row($wq))
{
if($gangdata['gangID'] == $r['warDECLARER']) { $w="You";$f="warDECLARED"; } else { $w="Them";$f="warDECLARER"; }
$ggq=$db->query("SELECT * FROM gangs WHERE gangID=".$r[$f]);
$them=$db->fetch_row($ggq);
print "<option value='{$r['surID']}'>War vs. {$them['gangNAME']} (Msg: {$r['surMSG']})</option>";
}
print "</select><br /><input type='submit' value='Accept Surrender' /></form>";
}
else
{
$_POST['sur'] = abs((int) $_POST['sur']);
$q=$db->query("SELECT surWAR FROM surrenders WHERE surID={$_POST['sur']}");
list($_POST['war']) = $db->fetch_row($q);
$wq=$db->query("SELECT * FROM gangwars where warID={$_POST['war']}");
$r=$db->fetch_row($wq);
if($gangdata['gangID'] == $r['warDECLARER']) { $w="You";$f="warDECLARED"; } else { $w="Them";$f="warDECLARER"; }
$db->query("DELETE FROM surrenders WHERE surID={$_POST['sur']}");
$db->query("DELETE FROM gangwars WHERE warID={$_POST['war']}");
$ggq=$db->query("SELECT * FROM gangs WHERE gangID=".$r[$f]);
$them=$db->fetch_row($ggq);
$event=str_replace("'","''","<a href='gangs.php?action=view&ID={$ir['gang']}'>{$gangdata['gangNAME']}</a> have accepted the surrender from <a href='gangs.php?action=view&ID={$them['gangID']}'>{$them['gangNAME']}</a>, the war is over!");
$db->query("INSERT INTO gangevents VALUES('',{$ir['gang']},unix_timestamp(),'$event') , ('',".$r[$f].",unix_timestamp(),'$event')");
print "You have accepted surrender, the war is over.";
}
}
function gang_staff_orgcrimes()
{
global $db,$ir,$c,$userid,$gangdata;
$_POST['crime'] = abs((int) $_POST['crime']);
if($_POST['crime'])
{
if($gangdata['gangCRIME'] != 0)
{
print "Your gang is already doing a crime!";
}
else
{
$db->query("UPDATE gangs SET gangCRIME={$_POST['crime']},gangCHOURS=24 WHERE gangID={$ir['gang']}");
print "You have started to plan this crime. It will take 24 hours.";
}
}
else
{
print "<h3>Organised Crimes</h3>
<form action='yourgang.php?action=staff&act2=crimes' method='post'>Choose a crime that your gang should commit.<br />
<select name='crime' type='dropdown'>";
$cnt=$db->query("SELECT username FROM users WHERE gang={$gangdata['gangID']}");
$membs=$db->num_rows($cnt);
$q=$db->query("SELECT * FROM orgcrimes WHERE ocUSERS <= $membs");
while($r=$db->fetch_row($q))
{
print "<option value='{$r['ocID']}'>{$r['ocNAME']} ({$r['ocUSERS']} members needed)</option>";
}
print "</select><br /><input type='submit' value='Commit' /></form>";
}
}
function gang_staff_pres()
{
global $db,$ir,$c,$userid,$gangdata;
if($gangdata['gangPRESIDENT'] == $userid)
{
if(isset($_POST['subm']))
{
$q=$db->query("SELECT * FROM users WHERE userid={$_POST['vp']} AND gang={$ir['gang']}", $c);
if($db->num_rows($q) < 1) { die("Invalid user or user not in your gang."); }
$memb=$db->fetch_row($q);
$db->query("UPDATE gangs SET gangPRESIDENT={$_POST['vp']} WHERE gangID={$gangdata['gangID']}");
event_add($memb['userid'],"You were transferred presidency of {$gangdata['gangNAME']}.",$c);
print "Presidency was transferred to {$memb['username']}";
}
else
{
print "<form action='yourgang.php?action=staff&act2=pres' method='post'>
Enter the ID of the new president.<br />
<input type='hidden' name='subm' value='submit' />
ID: <input type='text' name='vp' value='{$gangdata['gangPRESIDENT']}' maxlength='7' width='7' /><br />
<input type='submit' value='Change' /></form>";
}
}
}
function gang_staff_upgrades()
{
global $db,$ir,$c,$userid,$gangdata;
if(isset($_POST['membs']))
{
$_POST['membs']=abs($_POST['membs']);
if($_POST['membs']*100000 > $gangdata['gangMONEY'])
{
print "Your gang does not have enough money to upgrade that much capacity.";
}
else
{
$cost=$_POST['membs']*100000;
$db->query("UPDATE gangs SET gangCAPACITY=gangCAPACITY+{$_POST['membs']},gangMONEY=gangMONEY-$cost WHERE gangID={$ir['gang']}");
print "You paid \$$cost to add {$_POST['membs']} capacity to your gang.";
}
}
else
{
print "<b><u>Capacity</u></b><br />
Current Capacity: {$gangdata['gangCAPACITY']}<br />
<form action='yourgang.php?action=staff&act2=upgrade' method='post'>Enter the amount of extra capacity you need. Each extra member slot costs \$100,000.<br />
<input type='text' name='membs' /><br />
<input type='submit' value='Buy' /></form>";
}
}
function gang_leave()
{
global $db,$ir,$c,$userid,$gangdata;
if($gangdata['gangPRESIDENT'] == $userid || $gangdata['gangVICEPRES'] == $userid)
{
print "You cannot leave while you are still president or vice-president of your gang.";
}
else
{
$db->query("UPDATE users SET gang=0,daysingang=0 WHERE userid=$userid");
$db->query("INSERT INTO gangevents VALUES ('',{$ir['gang']},unix_timestamp(),'<a href=''viewuser.php?u=$userid''>{$ir['username']}</a> left the gang.');");
print "You left your gang.";
}
}
function gang_warview()
{
global $db,$ir,$c,$userid,$gangdata;
$wq=$db->query("SELECT * FROM gangwars where warDECLARER={$ir['gang']} or warDECLARED={$ir['gang']}");
print "<b>These are the wars your gang is in.</b><br />
<table width=75% cellspacing=1 class='table'><tr style='background:gray'><th>Time Started</th><th>Versus</th><th>Who Declared</th></tr>";
while($r=$db->fetch_row($wq))
{
if($gangdata['gangID'] == $r['warDECLARER']) { $w="You";$f="warDECLARED"; } else { $w="Them";$f="warDECLARER"; }
$d=date('F j, Y, g:i:s a',$r['warTIME']);
$ggq=$db->query("SELECT * FROM gangs WHERE gangID=".$r[$f]);
$them=$db->fetch_row($ggq);
print "<tr><td>$d</td><td><a href='gangs.php?action=view&ID={$them['gangID']}'>{$them['gangNAME']}</a></td><td>$w</td></tr>";
}
print "</table>";
}
function gang_atklogs()
{
global $db,$ir,$c,$userid,$gangdata;
$atks=$db->query("SELECT a.*,u1.username as attackern,u1.gang as attacker_gang, u2.username as attackedn,u2.gang as attacked_gang FROM attacklogs a LEFT JOIN users u1 ON a.attacker=u1.userid LEFT JOIN users u2 ON a.attacked=u2.userid WHERE (u1.gang={$ir['gang']} OR u2.gang={$ir['gang']}) AND result='won' ORDER BY time DESC LIMIT 50");
print "<b>Attack Logs - The last 50 attacks involving someone in your gang</b><br />
<table width=75%  cellspacing=1 class='table'><tr style='background:gray'><th>Time</th><th>Attack</th></tr>";
while($r=$db->fetch_row($atks))
{
if($r['attacker_gang'] == $ir['gang']) { $color="green"; } else { $color="red"; }
$d=date('F j, Y, g:i:s a',$r['time']);
print "<tr><td>$d</td><td><a href='viewuser.php?u={$r['attacker']}'>{$r['attackern']}</a> <font color='$color'>attacked</font> <a href='viewuser.php?u={$r['attacked']}'>{$r['attackedn']}</a></td></tr>";
}
print "</table>";
}
function gang_crimes()
{
global $db,$ir,$c,$userid,$gangdata;
if($gangdata['gangCRIME'])
{
print "This is the crime your gang is planning at the moment.<br />
<b>Crime:</b> {$gangdata['ocNAME']}<br />
<b>Hours Left:</b> {$gangdata['gangCHOURS']}";
}
else
{
print "Your gang is not currently planning a crime.";
}
}
function gang_staff_massmailer()
{
global $db,$ir,$c,$userid,$gangdata;
if($_POST['text'])
{
$subj="This is a mass mail from your gang";
$q=$db->query("SELECT * FROM users WHERE gang={$ir['gang']}");
while($r=$db->fetch_row($q))
{
$db->query("INSERT INTO mail VALUES('', 0, {$ir['userid']}, {$r['userid']}, unix_timestamp(),'$subj','{$_POST['text']}')");
print "Mass mail sent to {$r['username']}.<br />";
}
print "Mass mail sending complete!<br />
<a href='yourgang.php?action=staff'>&gt; Back</a>";
}
else
{
print "<b>Mass Mailer</b><br />
<form action='yourgang.php?action=staff&act2=massmailer' method='post'> Text: <br />
<textarea name='text' rows='7' cols='40'></textarea><br />
<input type='submit' value='Send' /></form>";
}
}
function gang_staff_masspayment()
{
global $db,$ir,$c,$userid,$gangdata;
$_POST['amnt']=abs((int) $_POST['amnt']);
if($_POST['amnt'])
{
$q=$db->query("SELECT * FROM users WHERE gang={$ir['gang']}");
while($r=$db->fetch_row($q))
{
if($gangdata['gangMONEY'] >= $_POST['amnt'])
{
event_add($r['userid'],"You were given \${$_POST['amnt']} from your gang.",$c);
$db->query("UPDATE users SET money=money+{$_POST['amnt']} WHERE userid={$r['userid']}", $c);
$gangdata['gangMONEY']-=$_POST['amnt'];
print "Money sent to {$r['username']}.<br />";
}
else
{
print "Not enough in the vault to pay {$r['username']}!<br />";
}
}
$db->query("UPDATE gangs SET gangMONEY={$gangdata['gangMONEY']} WHERE gangID={$ir['gang']}", $c);
$db->query("INSERT INTO gangevents VALUES('',{$ir['gang']},unix_timestamp(), 'A mass payment of \${$_POST['amnt']} was sent to the members of the Gang.')");
print "Mass payment sending complete!<br />
<a href='yourgang.php?action=staff'>&gt; Back</a>";
}
else
{
print "<b>Mass Payment</b><br />
<form action='yourgang.php?action=staff&act2=masspayment' method='post'> Amount: <input type='text' name='amnt' />
<input type='submit' value='Send' /></form>";
}
}
function gang_staff_desc()
{
global $db,$ir,$c,$userid,$gangdata;
if($gangdata['gangPRESIDENT'] == $userid  )
{
if(isset($_POST['subm']))
{
$_POST['vp']=str_replace(array("<", ">", "\n"), array("&lt;", "&gt;", "<br />"), $_POST['vp']);
$db->query("UPDATE gangs SET gangDESC='{$_POST['vp']}' WHERE gangID={$gangdata['gangID']}");
print "Gang description changed!<br />
<a href='yourgang.php?action=staff'>&gt; Back</a>";
}
else
{
print "Current Description: <br />
{$gangdata['gangDESC']} <form action='yourgang.php?action=staff&act2=desc' method='post'>
Enter the new description.<br />
<input type='hidden' name='subm' value='submit' />
Desc: <br />
<textarea name='vp' cols='40' rows='7'></textarea><br />
<input type='submit' value='Change' /></form>";
}
}
}
function gang_staff_ament()
{
global $db,$ir,$c,$userid,$gangdata;
if(isset($_POST['subm']))
{
$_POST['vp']=str_replace(array("<", ">", "\n"), array("&lt;", "&gt;", "<br />"), $_POST['vp']);
$db->query("UPDATE gangs SET gangAMENT='{$_POST['vp']}' WHERE gangID={$gangdata['gangID']}");
print "Gang announcement changed!<br />
<a href='yourgang.php?action=staff'>&gt; Back</a>";
}
else
{
$gd=str_replace(array("&lt;", "&gt;", "<br />"), array("<", ">", "\n"), $gangdata['gangAMENT']);
print "Current Announcement: <br />
{$gangdata['gangAMENT']} <form action='yourgang.php?action=staff&act2=ament' method='post'>
Enter the new announcement.<br />
<input type='hidden' name='subm' value='submit' />
Desc: <br />
<textarea name='vp' cols='40' rows='7'>{$gd}</textarea><br />
<input type='submit' value='Change' /></form>";
}
}
function gang_staff_name()
{
global $db,$ir,$c,$userid,$gangdata;
if($gangdata['gangPRESIDENT'] == $userid )
{
if(isset($_POST['subm']))
{
$_POST['vp']=str_replace(array("<", ">", "\n"), array("&lt;", "&gt;", "<br />"), $_POST['vp']);
$db->query("UPDATE gangs SET gangNAME='{$_POST['vp']}' WHERE gangID={$gangdata['gangID']}");
print "Gang name changed!<br />
<a href='yourgang.php?action=staff'>&gt; Back</a>";
}
else
{
print "Current Name: <br />
{$gangdata['gangNAME']} <form action='yourgang.php?action=staff&act2=name' method='post'>
Enter the new name.<br />
<input type='hidden' name='subm' value='submit' />
Name: <input type='text' name='vp' value='' /><br />
<input type='submit' value='Change' /></form>";
}
}
}
function gang_staff_tag()
{
global $db,$ir,$c,$userid,$gangdata;
if($gangdata['gangPRESIDENT'] == $userid )
{
if(isset($_POST['subm']))
{
$_POST['vp']=str_replace(array("<", ">", "\n"), array("&lt;", "&gt;", "<br />"), $_POST['vp']);
$db->query("UPDATE gangs SET gangPREF='{$_POST['vp']}' WHERE gangID={$gangdata['gangID']}");
print "Gang tag changed!<br />
<a href='yourgang.php?action=staff'>&gt; Back</a>";
}
else
{
print "Current Tag: <br />
{$gangdata['gangPREF']} <form action='yourgang.php?action=staff&act2=tag' method='post'>
Enter the new tag.<br />
<input type='hidden' name='subm' value='submit' />
tag: <input type='text' name='vp' value='' /><br />
<input type='submit' value='Change' /></form>";
}
}
}

$h->endpage();
?>