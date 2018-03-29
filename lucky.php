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
print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'>Lucky Boxes </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> 

";
if($_GET['open'])
{
if($ir['boxes_opened'] >= 5)
{
    
print "

<div id='mainOutput' style='text-align: center; color: white;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

Sorry, you have already opened 5 boxes today. Come back tomorrow.";
$h->endpage(); 
exit;

}
if($ir['money'] < 1000)
{
print"

<div id='mainOutput' style='text-align: center; color: white;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

Sorry, it costs \$1,000 to open a box. Come back when you have enough.";
$h->endpage(); 
exit;

}
$num=rand(1, 5);
$db->query("UPDATE users SET boxes_opened=boxes_opened+1, money=money-1000 WHERE userid=$userid");
$ir['money']-=1000;
switch($num)
{
case 1:
$tokens=rand(1,5);
print "

<div id='mainOutput' style='text-align: center; color: green;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>


You have gained {$tokens} crystals.  

";
$db->query("UPDATE users SET crystals=crystals+{$tokens} WHERE userid={$userid}");
break;
case 2:
$money=rand(330, 3300);
print "

<div id='mainOutput' style='text-align: center; color: green;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

You have gained \${$money} 

";
$db->query("UPDATE users SET money=money+{$money} WHERE userid={$userid}");
break;
case 3:
$stole=min(rand($ir['money']/10, $ir['money']/5), 5000);
print "

<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

You lost \${$stole} 

";
$db->query("UPDATE users SET money=money-{$stole} WHERE userid={$userid}");
break;
case 4:
print "

<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

You found nothing !

";
break;
case 5:
print "

<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

You found nothing !


";
break;
}
print "

<br> </br>
<b><a href='lucky.php?open=1'><font color='green'>Okay! Open Another</font></a></b> | 
<b><a href='explore.php'><font color='red'>Enough! Back to Town</font></a></b>

";
}
else
{
print "

<div id='mainOutput' style='text-align: center; color: white;  width: 550px; border: 1px solid #222222; height: 90px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

A man comes up to you and whispers, \"I have magical boxes, I let you open one for \$1,000. You can open a maximum of 5 a day. Deal or no deal?<br /> <br />
<b><a href='lucky.php?open=1'><font color='green'>Okay, open one</font></a> </b> |
<b><a href='explore.php'><font color='red'>No thanks</font></a></b><br /><br />";
}
$h->endpage();
?>
