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
//itemsend
$_GET['ID'] = abs((int) $_GET['ID']);
$_GET['qty'] = abs((int) $_GET['qty']);
if($_GET['qty'] && $_GET['user'])
{
$id=$db->query("SELECT iv.*,it.* FROM inventory iv LEFT JOIN items it ON iv.inv_itemid=it.itmid WHERE iv.inv_id={$_GET['ID']} AND iv.inv_userid=$userid LIMIT 1");
if($db->num_rows($id)==0)
{
print "


<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

Invalid item ID   <br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>

";
}
else
{
$r=$db->fetch_row($id);
$m=$db->query("SELECT * FROM users WHERE userid={$_GET['user']} LIMIT 1");
if($_GET['qty'] > $r['inv_qty'])
{
print "

<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

You are trying to send more than you have!  <br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>

</div></div> 

";
}
else if( $_GET['qty'] <= 0)
{
print "

<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

You know, I'm not dumb, j00 cheating hacker. <br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>

";
}
else if($db->num_rows($m) == 0)
{
print "

<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

You are trying to send to an invalid user!  <br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>

";
}
else
{
$rm=$db->fetch_row($m);
//are we sending it all
item_remove($userid, $r['inv_itemid'], $_GET['qty']);
item_add($_GET['user'], $r['inv_itemid'], $_GET['qty']);
print "

<div id='mainOutput' style='text-align: center; color: green;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

You sent {$_GET['qty']} {$r['itmname']}(s) to {$rm['username']}

<br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>

";
event_add($_GET['user'],"You received {$_GET['qty']} {$r['itmname']}(s) from <a href='viewuser.php?u=$userid'>{$ir['username']}</a>",$c);
$db->query("INSERT INTO itemxferlogs VALUES('',$userid,{$_GET['user']},{$r['itmid']},{$_GET['qty']},unix_timestamp(), '{$ir['lastip']}', '{$rm['lastip']}')");
}
}
}
else if($_GET['ID'])
{
$id=$db->query("SELECT iv.*,it.* FROM inventory iv LEFT JOIN items it ON iv.inv_itemid=it.itmid WHERE iv.inv_id={$_GET['ID']} AND iv.inv_userid=$userid LIMIT 1");
if($db->num_rows($id)==0)
{
print "
<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

Invalid item ID <br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>";
}
else
{
$r=$db->fetch_row($id);
print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Send Items</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>



<b>Enter who you want to send {$r['itmname']} to and how many you want to send. You have {$r['inv_qty']} to send.</b><br />
<form action='itemsend.php' method='get'>
<input type='hidden' name='ID' value='{$_GET['ID']}' />User ID: <input type='text' STYLE='color: black;  background-color: white;' name='user' value='' /><br />
Quantity: <input type='text' STYLE='color: black;  background-color: white;' name='qty' value='' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Send Items (no prompt so be sure!' /></form>
</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>

";
}
}
else
{
print "

<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

Invalid use of file. <br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>";
}
$h->endpage();
?>
