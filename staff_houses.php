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
case "addhouse": addhouse(); break;
case "edithouse": edithouse(); break;
case "delhouse": delhouse(); break;
default: print "Error: This script requires an action."; break;
}
function addhouse()
{
global $db, $ir, $c, $h, $userid;
$price=abs((int) $_POST['price']);
$will=abs((int) $_POST['will']);
$name=$_POST['name'];
$hsepic=$_POST['hsepic']; 
if($price and $will and $name)
{
$q=$db->query("SELECT * FROM houses WHERE hWILL={$will}");
if($db->num_rows($q))
{
print "Sorry, you cannot have two houses with the same maximum will.";
$h->endpage();
exit;
}
$db->query("INSERT INTO houses VALUES(NULL, '$name', '$price', '$will', '$hsepic')");
print "House {$name} added to the game.";
stafflog_add("Created House $name");
}
else
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Add House</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


<form action='staff_houses.php?action=addhouse' method='post'>
Name: <input type='text' name='name' /><br />
Price: <input type='text' name='price' /><br />
Max Will: <input type='text' name='will' /><br /><br /><br />
<b>House Pic URL</b><br />
<input type='text' name='hsepic' /><hr />
<input type='submit' value='Add House' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
function edithouse()
{
global $db, $ir, $c, $h, $userid;
switch($_POST['step'])
{
case "2":
$price=abs((int) $_POST['price']);
$will=abs((int) $_POST['will']);
$q=$db->query("SELECT * FROM houses WHERE hWILL={$will} AND hID!={$_POST['id']}");
if($db->num_rows($q))
{
print "Sorry, you cannot have two houses with the same maximum will.";
$h->endpage();
exit;
}
$name=$_POST['name'];
$hsepic=$_POST['hsepic']; 
$q=$db->query("SELECT * FROM houses WHERE hID={$_POST['id']}");
$old=$db->fetch_row($q);
if($old['hWILL'] == 100 && $old['hWILL'] != $will)
{
die("Sorry, this house's will bar cannot be edited.");
}
$db->query("UPDATE houses SET hWILL=$will, hPRICE=$price, hNAME='$name', hPic='$hsepic' WHERE hID={$_POST['id']}");
$db->query("UPDATE users SET maxwill=$will WHERE maxwill={$old['hWILL']}");
$db->query("UPDATE users SET will=maxwill WHERE will > maxwill");
print "House $name was edited successfully.";
stafflog_add("Edited house $name");
break;
case "1":
$q=$db->query("SELECT * FROM houses WHERE hID={$_POST['house']}");
$old=$db->fetch_row($q);
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Editing a House</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_houses.php?action=edithouse' method='post'>
<input type='hidden' name='step' value='2' />
<input type='hidden' name='id' value='{$_POST['house']}' />
Name: <input type='text' name='name' value='{$old['hNAME']}' />
Price: <input type='text' name='price' value='{$old['hPRICE']}' /><br />
Max Will: <input type='text' name='will' value='{$old['hWILL']}' /><br />
<b>House Pic URL</b><br />
<input type='text' name='hsepic' value='{$old['hPIC']}' /><hr />
<input type='submit' value='Edit House' /></form> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
break;
default:
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Editing a House</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_houses.php?action=edithouse' method='post'>
<input type='hidden' name='step' value='1' />
House: ".house_dropdown($c, "house")."<br />
<input type='submit' value='Edit House' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
break;
}
}
function delhouse()
{
global $db,$ir,$c,$h,$userid;
if($_POST['house'])
{
$q=$db->query("SELECT * FROM houses WHERE hID={$_POST['house']}");
$old=$db->fetch_row($q);
if($old['hWILL']==100)
{
die("This house cannot be deleted.");
}
$q2=$db->query("SELECT * FROM users WHERE maxwill={$old['hWILL']}");
$ids=array();
while($r=$db->fetch_row($q2))
{
$ids[]=$r['userid'];
}
if(count($ids))
{
$db->query("UPDATE users SET money=money+{$old['hPRICE']}, maxwill=100 WHERE userid IN(".implode(', ', $ids).")");
}
$db->query("UPDATE users SET will=maxwill WHERE will > maxwill");
$db->query("DELETE FROM houses WHERE hID={$old['hID']}");
print "House {$old['hNAME']} deleted.";
stafflog_add("Deleted house {$old['hNAME']}");
}
else
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Delete House </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

Deleting a house is permanent - be sure. Any users that are currently on the house you delete will be returned to the first house, and their money will be refunded.<form action='staff_houses.php?action=delhouse' method='post'>
House: ".house_dropdown($c, "house")."<br />
<input type='submit' value='Delete House' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
function report_clear()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 3)
{
die("403");
}
$_GET['ID'] = abs((int) $_GET['ID']);
stafflog_add("Cleared player report ID {$_GET['ID']}");
$db->query("DELETE FROM preports WHERE prID={$_GET['ID']}");
print "Report cleared and deleted!<br />
<a href='staff_users.php?action=reportsview'>> Back</a>";
}
$h->endpage();
?>