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
$tresder=(int) rand(100,999);
global $db, $ir, $userid, $h, $db;
$cityname = $db->fetch_single($db->query("SELECT cityname FROM cities WHERE cityid = ".$ir['location']));
$citycount = $db->fetch_single($db->query("SELECT COUNT(*) FROM users WHERE location = ".$ir['location'])); 
if($ir['jail'] or $ir['hospital']) { print "This page cannot be accessed while in jail or hospital.";

$h->endpage(); 
exit; 
}
print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'><marquee>Gangs</marquee> </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div>

</div>
<div class='generalinfo_simple'>
<br>
<br>
<br />

<table class='table' width='85%'>

<tr valign='middle'>
<th width='34%'><img src='images/user_suit.png' alt='Gang Area' /> Gangs area</th>
</tr>

<tr style='height: 100%;'>
<td valign='top'>
<a href='gangs.php'>Gang List</a><br />
<a href='gangs.php?action=gang_wars'>Gang Wars</a><br />
<a href='yourgang.php'>Your Gang</a><br />
</td>
</tr></table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div>



This is your referal link: http://{$domain}/signup.php?REF=$userid <br><br />
Every signup from this link earns you two valuable crystals!";
$h->endpage();
?>

