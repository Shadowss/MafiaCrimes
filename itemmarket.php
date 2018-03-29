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
<div class='info_mid'><h2 style='padding-top:10px;'> Item Market </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

";
switch($_GET['action'])
{
case "buy":
item_buy();
break;
case "gift1":
item_gift1();
break;
case "gift2":
item_gift2();
break;
case "remove":
itemm_remove();
break;
default:
imarket_index();
break;
}
function imarket_index()
{
global $db,$ir,$c,$userid,$h;
print "Viewing all listings...
<table width=75% cellspacing=1 class='table'> <tr style='background:gray'> <th>Adder</th> <th>Item</th> <th>Price</th> <th>Links</th> </tr>";
$q=$db->query("SELECT im.*, i.*, u.*,it.* FROM itemmarket im LEFT JOIN items i ON im.imITEM=i.itmid LEFT JOIN users u ON u.userid=im.imADDER LEFT JOIN itemtypes it ON i.itmtype=it.itmtypeid ORDER BY i.itmtype, i.itmname ASC");
$lt="";
while($r=$db->fetch_row($q))
{
if($lt!=$r['itmtypename'])
{
$lt=$r['itmtypename'];
print "\n<tr style='background: gray;'><th colspan=4>{$lt}</th></tr>";
}
if($r['imCURRENCY']=="money") { $price="\$".number_format($r['imPRICE']); } else { $price=number_format($r['imPRICE'])." crystals"; }
if($r['imADDER'] == $userid) { $link = "[<a href='itemmarket.php?action=remove&ID={$r['imID']}'>Remove</a>]"; } else { $link = "[<a href='itemmarket.php?action=buy&ID={$r['imID']}'>Buy</a>] [<a href='itemmarket.php?action=gift1&ID={$r['imID']}'>Gift</a>]"; }
print "\n<tr> <td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> [{$r['userid']}]</td> <td>{$r['itmname']}</td> <td>$price</td> <td>[<a href='iteminfo.php?ID={$r['itmid']}'>Info</a>] $link</td> </tr>";
}
print "</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}
function itemm_remove()
{
global $db,$ir,$c,$userid,$h;
$q=$db->query("SELECT im.*,i.* FROM itemmarket im LEFT JOIN items i ON im.imITEM=i.itmid WHERE imID={$_GET['ID']} AND imADDER=$userid");
if(!$db->num_rows($q))
{
print "Error, either this item does not exist, or you are not the owner.<br />
<a href='itemmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
$h->endpage();
exit;
}
$r=$db->fetch_row($q);
item_add($userid, $r['imITEM'], 1);
$i=($db->insert_id()) ? $db->insert_id() : 99999;
$db->query("DELETE FROM itemmarket WHERE imID={$_GET['ID']}");
$db->query("INSERT INTO imremovelogs VALUES ('', {$r['imITEM']}, {$r['imADDER']}, $userid, {$r['imID']}, $i, unix_timestamp(), '{$ir['username']} removed a {$r['itmname']} from the item market.')");
print "Item removed from market!<br />
<a href='itemmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function item_buy()
{
global $db,$ir,$c,$userid,$h;
$q=$db->query("SELECT * FROM itemmarket im LEFT JOIN items i ON i.itmid=im.imITEM WHERE imID={$_GET['ID']}",$c);
if(!$db->num_rows($q))
{
print "Error, either this item does not exist, or it has already been bought.<br />
<a href='itemmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
$h->endpage();
exit;
}
$r=$db->fetch_row($q);
$curr=$r['imCURRENCY'];
if($r['imPRICE'] > $ir[$curr])
{
print "Error, you do not have the funds to buy this item.<br />
<a href='itemmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
$h->endpage();
exit;
}
item_add($userid, $r['imITEM'], 1);
$i=($db->insert_id()) ? $db->insert_id() : 99999;
$db->query("DELETE FROM itemmarket WHERE imID={$_GET['ID']}");
$db->query("UPDATE users SET $curr=$curr-{$r['imPRICE']} where userid=$userid");
$db->query("UPDATE users SET $curr=$curr+{$r['imPRICE']} where userid={$r['imADDER']}");
if($curr=="money")
{
event_add($r['imADDER'],"<a href='viewuser.php?u=$userid'>{$ir['username']}</a> bought your {$r['itmname']} item from the market for \$".number_format($r['imPRICE']).".",$c);
$db->query("INSERT INTO imbuylogs VALUES ('', {$r['imITEM']}, {$r['imADDER']}, $userid,  {$r['imPRICE']}, {$r['imID']}, $i, unix_timestamp(), '{$ir['username']} bought a {$r['itmname']} from the item market for \${$r['imPRICE']} from user ID {$r['imADDER']}')");
print "You bought the {$r['itmname']} from the market for \$".number_format($r['imPRICE'])."
<br/><a href='itemmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}
else
{
event_add($r['imADDER'],"<a href='viewuser.php?u=$userid'>{$ir['username']}</a> bought your {$r['itmname']} item from the market for ".number_format($r['imPRICE'])." crystals.",$c);
$db->query("INSERT INTO imbuylogs VALUES ('', {$r['imITEM']}, {$r['imADDER']}, $userid,  {$r['imPRICE']}, {$r['imID']}, $i, unix_timestamp(), '{$ir['username']} bought a {$r['itmname']} from the item market for {$r['imPRICE']} crystals from user ID {$r['imADDER']}')");
print "You bought the {$r['itmname']} from the market for ".number_format($r['imPRICE'])." crystals.<br />
<a href='itemmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}
}
function item_gift1()
{
global $db,$ir,$c,$userid,$h;
$q=$db->query("SELECT * FROM itemmarket im LEFT JOIN items i ON i.itmid=im.imITEM WHERE imID={$_GET['ID']}");
if(!$db->num_rows($q))
{
print "Error, either this item does not exist, or it has already been bought.<br />
<a href='itemmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
$h->endpage();
exit;
}
$r=$db->fetch_row($q);
$curr=$r['imCURRENCY'];
if($r['imPRICE'] > $ir[$curr])
{
print "Error, you do not have the funds to buy this item.<br />
<a href='itemmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
$h->endpage();
exit;
}
if($curr=="money")
{
print "Buying the <b>{$r['itmname']}</b> for \$".number_format($r['imPRICE'])." as a gift...<br />
<form action='itemmarket.php?action=gift2' method='post'>
<input type='hidden' name='ID' value='{$_GET['ID']}' />
User to give gift to: ".user_dropdown($c,'user')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Buy Item and Send Gift' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
else
{
print "Buying the <b>{$r['itmname']}</b> for ".number_format($r['imPRICE'])." crystals as a gift...<br />
<form action='itemmarket.php?action=gift2' method='post'>
<input type='hidden' name='ID' value='{$_GET['ID']}' />
User to give gift to: ".user_dropdown($c,'user')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Buy Item and Send Gift' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
function item_gift2()
{
global $db,$ir,$c,$userid,$h;
$q=$db->query("SELECT * FROM itemmarket im LEFT JOIN items i ON i.itmid=im.imITEM WHERE imID={$_POST['ID']}");
if(!$db->num_rows($q))
{
print "Error, either this item does not exist, or it has already been bought.<br />
<a href='itemmarket.php'>Back</a> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
$h->endpage();
exit;
}
$r=$db->fetch_row($q);
$curr=$r['imCURRENCY'];
if($r['imPRICE'] > $ir[$curr])
{
print "Error, you do not have the funds to buy this item.<br />
<a href='itemmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
$h->endpage();
exit;
}
item_add($_POST['user'], $r['imITEM'], 1);
$i=($db->insert_id()) ? $db->insert_id() : 99999;
$db->query("DELETE FROM itemmarket WHERE imID={$_POST['ID']}");
$db->query("UPDATE users SET $curr=$curr-{$r['imPRICE']} where userid=$userid");
$db->query("UPDATE users SET $curr=$curr+{$r['imPRICE']} where userid={$r['imADDER']}");
if($curr=="money")
{
event_add($r['imADDER'],"<a href='viewuser.php?u=$userid'>{$ir['username']}</a> bought your {$r['itmname']} item from the market for \$".number_format($r['imPRICE']).".",$c);
event_add($_POST['user'], "<a href='viewuser.php?u=$userid'>{$ir['username']}</a> bought you a {$r['itmname']} from the item market as a gift.",$c);
$u=$db->query("SELECT username FROM users WHERE userid={$_POST['user']}");
$uname=$db->fetch_single($u);
$db->query("INSERT INTO imbuylogs VALUES ('', {$r['imITEM']}, {$r['imADDER']}, $userid,  {$r['imPRICE']}, {$r['imID']}, $i, unix_timestamp(), '{$ir['username']} bought a {$r['itmname']} from the item market for \${$r['imPRICE']} from user ID {$r['imADDER']} as a gift for $uname [{$_POST['user']}]')");
print "You bought the {$r['itmname']} from the market for \$".number_format($r['imPRICE'])." and sent the gift to $uname.<br />
<a href='itemmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
else
{
event_add($r['imADDER'],"<a href='viewuser.php?u=$userid'>{$ir['username']}</a> bought your {$r['itmname']} item from the market for ".number_format($r['imPRICE'])." crystals.",$c);
event_add($_POST['user'], "<a href='viewuser.php?u=$userid'>{$ir['username']}</a> bought you a {$r['itmname']} from the item market as a gift.",$c);
$u=$db->query("SELECT username FROM users WHERE userid={$_POST['user']}");
$uname=$db->fetch_single($u);
$db->query("INSERT INTO imbuylogs VALUES ('', {$r['imITEM']}, {$r['imADDER']}, $userid,  {$r['imPRICE']}, {$r['imID']}, $i, unix_timestamp(), '{$ir['username']} bought a {$r['itmname']} from the item market for {$r['imPRICE']} crystals from user ID {$r['imADDER']} as a gift for $uname [{$_POST['user']}]')");
print "You bought the {$r['itmname']} from the market for ".number_format($r['imPRICE'])." crystals and sent the gift to $uname.<br />
<a href='itemmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
$h->endpage();
?>
