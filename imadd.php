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
$_GET['ID'] = abs((int) $_GET['ID']);
$_GET['price'] = abs((int) $_GET['price']);
if($_GET['price'])
{
$q=$db->query("SELECT iv.*,i.* FROM inventory iv LEFT JOIN items i ON iv.inv_itemid=i.itmid WHERE inv_id={$_GET['ID']} and inv_userid=$userid");
if($db->num_rows($q)==0)
{
print "

<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

Invalid Item ID     <br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>

";
}
else
{
$r=$db->fetch_row($q);
$db->query("INSERT INTO itemmarket VALUES ('','{$r['inv_itemid']}',$userid,{$_GET['price']}, '{$_GET['currency']}')");
item_remove($userid, $r['inv_itemid'], 1);
$db->query("INSERT INTO imarketaddlogs VALUES ( '', {$r['inv_itemid']}, {$_GET['price']}, {$r['inv_id']}, $userid, unix_timestamp(), '{$ir['username']} added a {$r['itmname']} to the itemmarket for {$_GET['price']} {$_GET['currency']}')");
print "

<div id='mainOutput' style='text-align: center; color: green;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

Item added to market.      <br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>


";
}
}
else
{
$q=$db->query("SELECT * FROM inventory WHERE inv_id={$_GET['ID']} and inv_userid=$userid");
if($db->num_rows($q)==0)
{
print "
<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>
Invalid Item ID                 <br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>

";
}
else
{
$r=$db->fetch_row($q);
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Add to Market</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

Adding an item to the item market...
<form action='imadd.php' method='get'>
<input type='hidden' name='ID' value='{$_GET['ID']}' />
Price: <input type='text' STYLE='color: black;  background-color: white;' name='price' value='0' /> <select name='currency' type='dropdown'><option value='money'>Money</option><option value='crystals'>Crystals</option></select><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Add' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
$h->endpage();
?>

