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

?>
<style>
.version li{

background-color: transparent;

background-image: url("../images/navi_img.gif");

background-repeat: no-repeat;

background-attachment: scroll;

background-position: left center;

padding-left: 15px;

}
</style>
<?
print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'><marquee>Version</marquee> </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div>

</div>
<div class='generalinfo_simple'>
<br>
<br>
<br />
<table class='table' width='85%'>

<tr valign='middle'>
<th width='34%'><img src='images/user_suit.png' alt='Version' /> Version 1.0.2 </th>
</tr>

<tr style='height: 100%;'>
<td valign='top' style='text-align:left;'>
<ul class='version'>
<li>Inventory bugfix. Potions now fully works.</li>
<hr />
<li>Added crime stats.</li>
<hr />
<li>Improved script for redimension pictures on forum.</li>
<hr />
<li>Added mission for beginners.</li>
<hr />
<li>Private message and events bugfix.</li>
<hr />
<li>Some bugfix.</li>
<hr />
<li>Better and improved Protection.</li>
<hr />
<li>Better and improved Brothel House.</li>
<hr />
<li>Better and improved School/Education.</li>
<hr />


</ul>
</td>
</tr></table> 
<p>&nbsp;</p>

<table class='table' width='85%'>

<tr valign='middle'>
<th width='34%'><img src='images/user_suit.png' alt='Version' /> Version 1.0.1 </th>
</tr>

<tr style='height: 100%;'>
<td valign='top' style='text-align:left;'>
<ul class='version'>
<li>Inventory modified with Equip/Unequip and show weapons , armour and potions and also view your race. </li>
<hr />
<li>Explore with town just move your mouse over a building to see what options are available.</li>
<hr />
<li>Attack modified , you can view life , race and avatar. You have 3 options Normal Attack , Auto Attack and Run away.</li>
<hr />
<li>Gym with javascript.</li>
<hr />
<li>Shop with pictures and javascript.</li>
<hr />
<li>Help tutorial for all important category. You cand disable from control panel.</li>
<hr />
<li>Crimes with 4 category and crime stats. You can view your chance to complete crime , what item or course you need.</li>
<hr />
<li>Better shoutbox.</li>
<hr />
<li>Signup with 3 race : Gangster , P.I.M.P. and Street Babe.</li>
<hr />
<li>Better forum.</li>
<hr />
<li>Mod Cars.</li>
<hr />
<li>Drugs with grow , premade drugs , and sell drugs.</li>
<hr />
<li>Better Hospital with Heal player.</li>
<hr />
<li>Multyplayer Poker.</li>
<hr />
<li>Some BugFix.</li>
<hr />
</ul>
</td>
</tr></table> 
</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div>
<br />


This is your referal link: http://{$domain}/signup.php?REF=$userid <br><br />
Every signup from this link earns you two valuable crystals!";
$h->endpage();
?>

