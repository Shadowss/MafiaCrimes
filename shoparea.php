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
<div class='info_mid'><h2 style='padding-top:10px;'><marquee>You Are Currently Exploring ".$cityname."'s shops !</marquee> </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div>

</div>
<div class='generalinfo_simple'>
<br>
<br>
<br />

<table class='table' width='85%'>

<tr valign='middle'>
<th width='34%'><img src='images/basket.png' alt='shop' /> Shops</th>
</tr>

<tr style='height: 100%;'>
<td valign='top'>
<a href='shops.php'>City Shops</a><br />
<a href='playershops.php'>Player Shops</a><br /> 
<a href='itemmarket.php'>Item Market</a><br />
<a href='cmarket.php'>Crystal Market</a><br />
<a href='caryard.php'>Car Yard</a><br />
<a href='sellcar.php'>Sell Car</a><br />
<a href='carmarket.php'>Car Market</a><br />
<a href='estate.php'>Real Estate</a><br />
<a href='drugfarm.php'>Drug Farm</a><br />
<a href='drugsmarket.php'>Drugs Market</a><br />
<a href='crystaltemple.php'>Crystal Temple</a><br />
<a href='stocks.php'>Stock Market</a><br />
</td>
</tr></table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div>



This is your referal link: http://{$domain}/signup.php?REF=$userid <br><br />
Every signup from this link earns you two valuable crystals!";
$h->endpage();
?>

