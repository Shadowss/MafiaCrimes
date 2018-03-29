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

session_start();
if(get_magic_quotes_gpc() == 0)
{
foreach($_POST as $k => $v)
{
  $_POST[$k]=addslashes($v);
}
foreach($_GET as $k => $v)
{
  $_GET[$k]=addslashes($v);
}
}
require "global_func.php";
if($_SESSION['loggedin']==0) { header("Location: login.php");exit; }
$userid=$_SESSION['userid'];
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
$is=$db->query("SELECT u.*,us.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.userid=$userid");
$ir=$db->fetch_row($is);
if($_GET['a']=='inbox')
{
// We'll be outputting a PDF
header('Content-type: text/html');

// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="inbox_archive_'.$userid.'_'.time().'.htm"');
print "<table width=75% border=2><tr style='background:gray'><th>From</th><th>Subject/Message</th></tr>";
$q=$db->query("SELECT m.*,u.* FROM mail m LEFT JOIN users u ON m.mail_from=u.userid WHERE m.mail_to=$userid ORDER BY mail_time DESC ");
while($r=$db->fetch_row($q))
{
$sent=date('F j, Y, g:i:s a',$r['mail_time']);
print "<tr><td>";
if($r['userid'])
{
print "{$r['username']} [{$r['userid']}]";
}
else
{
print "SYSTEM";
}
print "</td>\n<td>{$r['mail_subject']}</td></tr><tr><td>Sent at: $sent<br /> </td><td>{$r['mail_text']}</td></tr>";
}
print "</table>";
}
else if($_GET['a']=='outbox')
{
// We'll be outputting a PDF
header('Content-type: text/html');

// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="outbox_archive_'.$userid.'_'.time().'.htm"');
print "<table width=75% border=2><tr style='background:gray'><th>To</th><th>Subject/Message</th></tr>";
$q=$db->query("SELECT m.*,u.* FROM mail m LEFT JOIN users u ON m.mail_to=u.userid WHERE m.mail_from=$userid ORDER BY mail_time DESC");
while($r=$db->fetch_row($q))
{
$sent=date('F j, Y, g:i:s a',$r['mail_time']);
print "<tr><td>{$r['username']} [{$r['userid']}]</td><td>{$r['mail_subject']}</td></tr><tr><td>Sent at: $sent<br /></td><td>{$r['mail_text']}</td></tr>";
}
print "</table>";
}
?> 
