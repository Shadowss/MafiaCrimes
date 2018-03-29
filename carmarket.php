<?php
/*-----------------------------------------------------
-- Mono Country v1.0 BETA
-- A product of DBS-entertainment
-- Copyright held 2005 by Dabomstew
-- INDEX.php
-----------------------------------------------------*/
session_start();
require "global_func.php";
if($_SESSION['loggedin']==0) { header("Location: login.php");exit; }
include "mysql.php";
$userid=$_SESSION['userid'];
require "header.php";
$h = new headers;
$h->startheaders();
global $c;
$is=mysql_query("SELECT u.*,us.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.userid=$userid",$c) or die(mysql_error());
$ir=mysql_fetch_array($is);
check_level();
$fm=money_formatter($ir['money']);
$cm=money_formatter($ir['crystals'],'');
$lv=date('F j, Y, g:i a',$ir['laston']);
$h->userdata($ir,$lv,$fm,$cm);
$h->menuarea();
print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
	<div class='generalinfo_simple'>");
print "<h3>Car Market</h3><hr />";
switch($_GET['action'])
{
case "buy":
crystal_buy();
break;

case "remove":
crystal_remove();
break;


default:
cmarket_index();
break;
}
function cmarket_index()
{
global $ir,$c,$userid,$h;
print "
Viewing all listings...
<table width=100% border=6> <tr style='background:#cc9966'> <th>Seller</th> <th>Car</th> <th>Acceleration Level</th> <th>Handling Level</th> <th>Speed Level</th> <th>Shield Level</th> <th>Price</th> <th>Links</th> </tr>";
$q=mysql_query("SELECT cm.*, u.*,ct.* FROM carmarket cm LEFT JOIN users u ON u.userid=cm.cmADDER LEFT JOIN cars_types ct ON ct.carID=cm.cmCAR ORDER BY cmPRICE ASC",$c);
while($r=mysql_fetch_array($q))
{
if($r['cmADDER'] == $userid) { $link = "<a href='carmarket.php?action=remove&ID={$r['cmID']}'>Remove</a>"; } else { $link = "<a href='carmarket.php?action=buy&ID={$r['cmID']}'>Buy</a>"; }
print "\n<tr> <td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> [{$r['userid']}]</td> <td>{$r['carNAME']}</td> <td>{$r['cmACC']}</td> <td>{$r['cmHAN']}</td> <td>{$r['cmSPD']}</td> <td>{$r['cmSHD']} <td>\$".number_format($r['cmPRICE'])."</td> <td>[$link]</td> </tr>";
}
print "</table>";
}
function crystal_remove()
{
global $ir,$c,$userid,$h;
$q=mysql_query("SELECT cm.*,c.* FROM carmarket cm LEFT JOIN cars_types c ON cm.cmCAR=c.carID WHERE cmID={$_GET['ID']} AND cmADDER=$userid",$c);
if(!mysql_num_rows($q))
{
print "Error, either this car does not exist, or you are not the owner.<br />
<a href='carmarket.php'>&gt; Back</a>";
$h->endpage();
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
exit;
}
$r=mysql_fetch_array($q);

mysql_query("INSERT INTO cars_playercars VALUES('', $userid, {$r['cmCAR']}, {$r['cmACC']}, {$r['cmHAN']}, {$r['cmSPD']}, {$r['cmSHD']})", $c);
$i=mysql_insert_id($c);
mysql_query("INSERT INTO imremovelogs VALUES ('', {$r['cmCAR']}, {$r['cmADDER']}, $userid, {$r['cmID']}, $i, unix_timestamp(), '{$ir['username']} removed a {$r['carNAME']} from the car market belonging to ID {$r['cmADDER']}.')", $c);
mysql_query("DELETE FROM carmarket WHERE cmID={$_GET['ID']}",$c);
print "Car removed from market!<br />
<a href='carmarket.php'>&gt; Back</a>";
}
function crystal_buy()
{
global $ir,$c,$userid,$h;
$q=mysql_query("SELECT cm.*,ct.* FROM carmarket cm LEFT JOIN cars_types ct ON ct.carID=cm.cmCAR WHERE cmID={$_GET['ID']}",$c);
if(!mysql_num_rows($q))
{
print "Error, either this car does not exist, or it has already been bought.<br />
<a href='carmarket.php'>&gt; Back</a>";
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
exit;
}
$r=mysql_fetch_array($q);
if($r['cmPRICE'] > $ir['money'])
{
print "Error, you do not have the funds to buy this car.<br />
<a href='carmarket.php'>&gt; Back</a>";
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
exit;
}
mysql_query("INSERT INTO cars_playercars VALUES('', $userid, {$r['cmCAR']}, {$r['cmACC']}, {$r['cmHAN']}, {$r['cmSPD']}, {$r['cmSHD']})", $c);
$i=mysql_insert_id($c);
mysql_query("DELETE FROM carmarket WHERE cmID={$_GET['ID']}",$c);
mysql_query("UPDATE users SET money=money-{$r['cmPRICE']},cars_owned=cars_owned+1 where userid=$userid",$c);
mysql_query("UPDATE users SET money=money+{$r['cmPRICE']} where userid={$r['cmADDER']}",$c);
event_add($r['cmADDER'],"<a href='viewuser.php?u=$userid'>{$ir['username']}</a> bought your {$r['carNAME']} from the market for \$".number_format($r['cmPRICE']).".",$c,'trading');
mysql_query("INSERT INTO imbuylogs VALUES ('', {$r['cmCAR']}, {$r['cmADDER']}, $userid,  {$r['cmPRICE']}, {$r['cmID']}, $i, unix_timestamp(), '{$ir['username']} bought a {$r['carNAME']} from the car market for \${$r['cmPRICE']} from user ID {$r['cmADDER']}')", $c);
print "You bought the {$r['carNAME']} from the market for \$".number_format($r['cmPRICE']).".";

}
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
?>