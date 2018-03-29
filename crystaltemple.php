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
if(!$_GET['spend'])
{
print "

<div class='icolumn2' id='mainContentDiv'>
<div><img src='images/generalinfo_top.jpg' alt='' /></div>
<div class='generalinfo_simple'>


<style type='text/css'>
.style1b {
    color: #008000;
}
</style>


<h4 class='style1b'>Welcome to the crystal temple!</h4>
<br />
You have <b>{$ir['crystals']}</b> crystals.<br />
What would you like to spend your crystals on?<br />
<br />


<table class=table>

<tr><td><a href='crystaltemple.php?spend=refill'>Energy Refill </td><td> {$set['ct_refillprice']} Crystals</a></td></tr>
<tr><td><a href='crystaltemple.php?spend=IQ'>IQ </td><td> {$set['ct_iqpercrys']} IQ per crystal</a></td></tr>
<tr><td><a href='crystaltemple.php?spend=rob'>Rob Skill </td><td> 1 Rob Skill per 30 crystals</a></td></tr>     
<tr><td><a href='crystaltemple.php?spend=money'>Money </td><td> \$".number_format($set['ct_moneypercrys'])." per crystal</a></td></tr>
</table> </div>
<div><img src='images/generalinfo_btm.jpg' alt='' /></div><br> </div></div></div> </div> </div> ";
}
else
{
if($_GET['spend'] == 'refill')
{
if($ir['crystals'] <$set['ct_refillprice'])
{
print "You don't have enough crystals!";
}
else if($ir['energy'] == $ir['maxenergy'])
{
print "You already have full energy.";
}
else
{
$db->query("UPDATE users SET energy=maxenergy,crystals=crystals-{$set['ct_refillprice']} WHERE userid=$userid");
print "You have paid {$set['ct_refillprice']} crystals to refill your energy bar.";
}
}  


if($_GET['spend'] == 'rob')
{
if($ir['crystals'] <30)
{
print "You don't have enough crystals!";
}

else
{
$db->query("UPDATE users SET crystals=crystals-30 WHERE userid=$userid");
$db->query("UPDATE userstats SET robskill=robskill+1 WHERE userid=$userid");
print "You have paid 30 crystals for One Rob Skill";
}
}      
  
else if($_GET['spend'] == 'IQ')
{
print "

<div class='icolumn2' id='mainContentDiv'>
<div><img src='images/generalinfo_top.jpg' alt='' /></div>
<div class='generalinfo_simple'>

Type in the amount of crystals you want to swap for IQ.<br />
You have <b>{$ir['crystals']}</b> crystals.<br />
One crystal = {$set['ct_iqpercrys']} IQ.<form action='crystaltemple.php?spend=IQ2' method='post'><input type='text' STYLE='color: black;  background-color: white;' name='crystals' /><br /><input type='submit' STYLE='color: black;  background-color: white;' value='Swap' /></form></div>
<div><img src='images/generalinfo_btm.jpg' alt='' /></div><br> </div></div></div> </div> </div>";
}
else if($_GET['spend'] == 'IQ2')
{
$_POST['crystals']=(int) $_POST['crystals'];
if($_POST['crystals'] <= 0 || $_POST['crystals'] > $ir['crystals'])
{
print "Error, you either do not have enough crystals or did not fill out the form.<br />
<a href='crystaltemple.php?spend=IQ'>Back</a>";
}
else
{
$iqgain=$_POST['crystals']*$set['ct_iqpercrys'];
$db->query("UPDATE users SET crystals=crystals-{$_POST['crystals']} WHERE userid=$userid");
$db->query("UPDATE userstats SET IQ=IQ+$iqgain WHERE userid=$userid");
print "You traded {$_POST['crystals']} crystals for $iqgain IQ.";
}
}
else if($_GET['spend'] == 'money')
{
print "<div class='icolumn2' id='mainContentDiv'>
<div><img src='images/generalinfo_top.jpg' alt='' /></div>
<div class='generalinfo_simple'>Type in the amount of crystals you want to swap for money.<br />
You have <b>{$ir['crystals']}</b> crystals.<br />
One crystal = \$".number_format($set['ct_moneypercrys']).".<form action='crystaltemple.php?spend=money2' method='post'><input type='text' STYLE='color: black;  background-color: white;' name='crystals' /><br /><input type='submit' STYLE='color: black;  background-color: white;' value='Swap' /></form></div>
<div><img src='images/generalinfo_btm.jpg' alt='' /></div><br> </div></div></div> </div> </div>";
}
else if($_GET['spend'] == 'money2')
{
$_POST['crystals']=(int) $_POST['crystals'];
if($_POST['crystals'] <= 0 || $_POST['crystals'] > $ir['crystals'])
{
print "Error, you either do not have enough crystals or did not fill out the form.<br />
<a href='crystaltemple.php?spend=money'>Back</a>";
}
else
{
$iqgain=$_POST['crystals']*$set['ct_moneypercrys'];
$db->query("UPDATE users SET crystals=crystals-{$_POST['crystals']},money=money+$iqgain WHERE userid=$userid");
print "You traded {$_POST['crystals']} crystals for \$".number_format($iqgain).".";
}
}
}

$h->endpage();
?>
