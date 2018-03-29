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
$_GET['ID'] = isset($_GET['ID']) && is_numeric($_GET['ID']) ? abs(@intval($_GET['ID'])) : false;
print "<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Crystal Market </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>";
$_GET['action'] = isset($_GET['action']) && is_string($_GET['action']) ? strtolower(trim($_GET['action'])) : "";
switch($_GET['action'])
{
case "buy":
crystal_buy();
break;

case "remove":
crystal_remove();
break;

case "add":
crystal_add();
break;

default:
cmarket_index();
break;
}
function cmarket_index()
{
global $db,$ir,$c,$userid,$h;
print " 

<a href='cmarket.php?action=add'> Add A Listing</a><br /><br />
Viewing all listings...
<table width=75% cellspacing=1 class='table'> <tr style='background:gray'> <th>Adder</th> <th>Qty</th> <th>Price each</th> <th>Price total</th> <th>Links</th> </tr>";
$q=$db->query("SELECT cm.*, u.* FROM crystalmarket cm LEFT JOIN users u ON u.userid=cm.cmADDER ORDER BY cmPRICE/cmQTY ASC");
while($r=$db->fetch_row($q))
{
if($r['cmADDER'] == $userid) { $link = "<a href='cmarket.php?action=remove&ID={$r['cmID']}'>Remove</a>"; } else { $link = "<a href='cmarket.php?action=buy&ID={$r['cmID']}'>Buy</a>"; }
$each= abs(intval($r['cmPRICE'] / $r['cmQTY']));
print "\n<tr> <td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> [{$r['userid']}]</td> <td>{$r['cmQTY']}</td> <td> \$" . number_format($each)."</td> <td>\$".number_format($r['cmPRICE'])."</td> <td>[$link]</td> </tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function crystal_remove()
{
global $db,$ir,$c,$userid,$h;
$q=$db->query("SELECT * FROM `crystalmarket` WHERE `cmID`={$_GET['ID']} AND `cmADDER`=$userid");
if(!$db->num_rows($q))
{
print "Error, either these crystals do not exist, or you are not the owner.<br /><br /> 
<a href='cmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
$h->endpage();
exit;
}
$r=$db->fetch_row($q);
$db->query("UPDATE `users` SET `crystals`=`crystals`+{$r['cmQTY']} where `userid`=$userid");
$db->query("DELETE FROM `crystalmarket` WHERE `cmID`={$_GET['ID']}");
print "Crystals removed from market!<br /><br /> 
<a href='cmarket.php'>Back</a> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}
function crystal_buy()
{
global $db,$ir,$c,$userid,$h;
$q=$db->query("SELECT * FROM crystalmarket cm WHERE cmID={$_GET['ID']}");
if(!$db->num_rows($q))
{
print "Error, either these crystals do not exist, or they have already been bought.<br /> <br /> 
<a href='cmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
$h->endpage();
exit;
}
$r=$db->fetch_row($q);
if($r['cmPRICE'] > $ir['money'])
{
print "Error, you do not have the funds to buy these crystals.<br /><br /> 
<a href='cmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
$h->endpage();
exit;
}
$db->query("UPDATE `users` SET `crystals`=`crystals`+{$r['cmQTY']} where `userid`=$userid");
$db->query("DELETE FROM `crystalmarket` WHERE `cmID`={$_GET['ID']}");
$db->query("UPDATE `users` SET `money`=`money`-{$r['cmPRICE']} where `userid`=$userid");
$db->query("UPDATE `users` SET `money`=`money`+{$r['cmPRICE']} where `userid`={$r['cmADDER']}");
event_add($r['cmADDER'],"<a href='viewuser.php?u=$userid'>{$ir['username']}</a> bought your {$r['cmQTY']} crystals from the market for \$".number_format($r['cmPRICE']).".",$c);
print "You bought {$r['cmQTY']} crystals from the market for \$".number_format($r['cmPRICE']).".<br /> <br />
<a href='cmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";

}
function crystal_add()
{
global $db,$ir,$c,$userid,$h;
$_POST['amnt'] = abs(@intval($_POST['amnt']));
$_POST['price'] = abs(@intval($_POST['price']));
if($_POST['amnt'])
{
if($_POST['amnt'] > $ir['crystals'])
{   
print "You are trying to add more crystals to the market than you have. <br /><br /> 
<a href='cmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
$h->endpage();
exit;  
}
$tp=$_POST['amnt']*$_POST['price'];
$db->query("INSERT INTO `crystalmarket` VALUES('',{$_POST['amnt']},$userid,$tp)");
$db->query("UPDATE `users` SET `crystals`=`crystals`-{$_POST['amnt']} WHERE `userid`=$userid");
print "Crystals added to market!<br /><br /> 
<a href='cmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
$h->endpage();
exit;
}


if($ir['crystals']==0)
{
print"You have no crystals.<br /> <br />
<a href='cmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}

else
{
print " <b>Adding a listing...</b><br /><br />
You have <b>{$ir['crystals']}</b> crystal(s) that you can add to the market.<form action='cmarket.php?action=add' method='post'>
    <table width=100% class =table  border=2 align='center'><tr>
<td>Crystals:</td> <td><input type='text' STYLE='color: black;  background-color: white;' name='amnt' value='{$ir['crystals']}' /></td></tr><tr>
<td>Price Each:</td> <td><input type='text' STYLE='color: black;  background-color: white;' name='price' value='200' /></td></tr><tr>
<td colspan=2 align=center><input type='submit' STYLE='color: black;  background-color: white;' value='Add To Market' /></tr></table></form><br /> 
<a href='cmarket.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}
}
$h->endpage();
?>