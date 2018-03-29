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
if($ir['jail'] or $ir['hospital']) { print "This page cannot be accessed while in jail or hospital.";

$h->endpage(); 
exit; 
}
print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'><marquee>Your home!</marquee> </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div>

</div>
<div class='generalinfo_simple'>
<br>
<br>
<br />

<table class='table' width='85%'>

<tr valign='middle'>
<th width='34%'><img src='images/user_suit.png' alt='Home' />Your personal stuff</th>
</tr>

<tr style='height: 100%;'>
<td valign='top'>
<a href='viewuser.php?u={$ir['userid']}'>Your Profile</a><br />
<a href='business_home.php'>Your Business</a><br />  
<a href='garage.php'>Garage</a><br />
<a href='inventory.php'>Inventory</a><br />
<a href='drugfarm.php?action=mydrugs'>Your Drugs</a><br />
<a href='mailbox.php'>Mailbox</a><br />
<a href='gamestation.php'>Game Station</a><br />
<a href='streets.php'>Search Streets</a><br />
<a href='attacklist.php'>Player Attack List</a><br />

";
$checkforshop=$db->query("select * from usershops where userid=$userid");
if(mysql_num_rows($checkforshop)!=0)
{
print"<a href='myshop.php'>Your Shop</a> <br/>";
}

print "

<a href='polling.php'>Polls</a><br />
<a href='forums.php'>Forums</a><br />

</td>
</tr></table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div>



This is your referal link: http://{$domain}/signup.php?REF=$userid <br><br />
Every signup from this link earns you two valuable crystals!";
$h->endpage();
?>

