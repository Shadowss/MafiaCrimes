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
$ac=$ir['new_announcements'];
$q=$db->query("SELECT * FROM announcements ORDER BY a_time DESC");
print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Announcement </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


<table width='80%' cellspacing='1' class='table'>

<tr>
<th>Time</th>
<th>Announcement</th>
</tr>";
while($r=$db->fetch_row($q))
{
if($ac > 0)
{
$ac--;
$new="<br /><b>New!</b>";
}
else
{
$new="";
}
print "<tr><td valign=top>".date('F j Y, g:i:s a', $r['a_time']).$new."</td><td valign=top>{$r['a_text']}</td></tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
if($ir['new_announcements'])
{
$db->query("UPDATE users SET new_announcements=0 WHERE userid={$userid}");
}
$h->endpage();
?>

