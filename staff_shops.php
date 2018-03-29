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

include "sglobals.php";
if($ir['user_level'] > 2)
{
die("403");
}
//This contains shop stuffs
switch($_GET['action'])
{
case 'newshop': new_shop_form(); break;
case 'newshopsub': new_shop_submit(); break;
case 'newstock': new_stock_form(); break;
case 'newstocksub': new_stock_submit(); break;
case 'delshop': delshop(); break;
default: print "Error: This script requires an action."; break;
}
function new_shop_form()
{
global $db,$ir,$c,$h;
print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Adding a New Shop</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


<form action='staff_shops.php?action=newshopsub' method='post'>
Shop Name: <input type='text' STYLE='color: black;  background-color: white;' name='sn' value='' /><br />
Shop Desc: <input type='text' STYLE='color: black;  background-color: white;' name='sd' value='' /><br />
Shop Location: ".location_dropdown($c,"sl")."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Create Shop' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}

function new_shop_submit()
{
global $db,$ir,$c,$h;
if(!isset($_POST['sn']) || !isset($_POST['sd']))
{
print "You missed a field, go back and try again.<br />
<a href='staff_shops.php?action=newshop'>&gt; Back</a>";
}
else
{
$sn=$_POST['sn'];
$sd=$_POST['sd'];
$db->query("INSERT INTO shops VALUES('',{$_POST['sl']},'$sn','$sd')");
print "The $sn Shop was successfully added to the game.";
stafflog_add("Added Shop $sn");
}
}
function new_stock_form()
{
global $db,$ir,$c,$h;
print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Adding an item to a shop</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_shops.php?action=newstocksub' method='post'>
Shop: ".shop_dropdown($c,"shop")."<br />
Item: ".item_dropdown($c,"item")."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Add Item To Shop' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function new_stock_submit()
{
global $db,$ir,$c,$h;
$db->query("INSERT INTO shopitems VALUES('',{$_POST['shop']},{$_POST['item']})");
print "Item ID {$_POST['item']} was successfully added to shop ID {$_POST['shop']}";
stafflog_add("Added Item ID {$_POST['item']} to shop ID {$_POST['shop']}");
}
function delshop()
{
global $db, $ir, $c, $h;
if($_POST['shop'])
{
$sn=$db->fetch_single($db->query("SELECT shopNAME FROM shops WHERE shopID={$_POST['shop']}"));
$db->query("DELETE FROM shops WHERE shopID={$_POST['shop']}");
$db->query("DELETE FROM shopitems WHERE sitemSHOP={$_POST['shop']}");
print "Shop {$sn} Deleted.";
stafflog_add("Deleted Shop $sn");
}
else
{
print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Delete Shop</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


Deleting a shop will remove it from the game permanently. Be sure.<form action='staff_shops.php?action=delshop' method='post'>
Shop: ".shop_dropdown($c, "shop")."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Delete Shop' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}



function report_clear()
{
global $db,$db,$ir,$c,$h,$userid;
if($ir['user_level'] > 3)
{
die("403");
}
$_GET['ID'] = abs((int) $_GET['ID']);
stafflog_add("Cleared player report ID {$_GET['ID']}");
$db->query("DELETE FROM preports WHERE prID={$_GET['ID']}");
print "Report cleared and deleted!<br />
<a href='staff_users.php?action=reportsview'>&gt; Back</a>";
}
$h->endpage();
?>
