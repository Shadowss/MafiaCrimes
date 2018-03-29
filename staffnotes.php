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
if($ir['user_level'] == 2 || $ir['user_level'] == 3 || $ir['user_level'] == 5)
{
$q=$db->query("SELECT staffnotes FROM users WHERE userid={$_POST['ID']}");
$old=addslashes($db->fetch_single($q));
$db->query("UPDATE users SET staffnotes='{$_POST['staffnotes']}' WHERE userid='{$_POST['ID']}'");
$db->query("INSERT INTO staffnotelogs VALUES ('', $userid, {$_POST['ID']}, unix_timestamp(), '$old', '{$_POST['staffnotes']}')");
print "User notes updated!<br />
<a href='viewuser.php?u={$_POST['ID']}'>&gt; Back To Profile</a>";
}
else
{
print "You violent scum.";
}
$h->endpage();
?>

