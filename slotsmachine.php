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
$tresder = (int) (rand(100,999));
$maxbet=$ir['level']*250;
$_GET['tresde']=abs((int) $_GET['tresde']);
if(($_SESSION['tresde'] == $_GET['tresde']) || $_GET['tresde']<100)
{
die ("Error, you cannot refresh or go back on the slots, please use a side link to go somewhere else.<br />
<a href='slotsmachine.php?tresde=$tresder'>&gt; Back</a>");
}
$_SESSION['tresde']=$_GET['tresde'];
$_GET['bet']=abs((int) $_GET['bet']);
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Slots</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br> 


";
if($_GET['bet'])
{
if($_GET['bet'] > $ir['money'])
{
die("You are trying to bet more than you have.<br />
<a href='slotsmachine.php?tresde=$tresder'>&gt; Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>");
}
else if($_GET['bet'] > $maxbet)
{
die("You have gone over the max bet.<br />
<a href='slotsmachine.php?tresde=$tresder'>&gt; Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>");
}

$slot[1]=(int) rand(0,9);
$slot[2]=(int) rand(0,9);
$slot[3]=(int) rand(0,9);
print "You place \${$_GET['bet']} into the slot and pull the pole.<br />
You see the numbers: <b>$slot[1] $slot[2] $slot[3]</b><br />
You bet \${$_GET['bet']} ";
if($slot[1]==$slot[2] && $slot[2]==$slot[3])
{
$won=$_GET['bet']*26;
$gain=$_GET['bet']*25;
print "and won \$$won by lining up 3 numbers pocketing you \$$gain extra.</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
else if ($slot[1]==$slot[2] || $slot[2]==$slot[3] || $slot[1]==$slot[3])
{
$won=$_GET['bet']*3;
$gain=$_GET['bet']*2;
print "and won \$$won by lining up 2 numbers pocketing you \$$gain extra.</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
else
{
$won=0;
$gain=-$_GET['bet'];
print "and lost it.";
}
$db->query("UPDATE users SET money=money+({$gain}) where userid=$userid");
$tresder = (int) (rand(100,999));
print "<br /> <br /><br />
<b><a href='slotsmachine.php?bet={$_GET['bet']}&tresde=$tresder'>Another time, same bet.</a></b> | 
<b><a href='slotsmachine.php?tresde=$tresder'>I'll continue, but I'm changing my bet.</a></b> | 
<b><a href='explore.php'> Enough's enough, I'm off.</a></b></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
else
{   
print "Ready to try your luck? Play today!<br />
The maximum bet for your level is \$$maxbet.<br />
<form action='slotsmachine.php' method='get'>
Bet: \$<input type='text' STYLE='color: black;  background-color: white;' name='bet' value='5' /><br />
<input type='hidden' name='tresde' value='$tresder' />
<input type='submit' STYLE='color: black;  background-color: white;' value='Play!!' />
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}

$h->endpage();
?>
