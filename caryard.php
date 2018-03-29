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
print "<h3>Car Yard</h3><hr />";
$car=abs((int) $_GET['car']);
if($car)
{
$q=mysql_query("SELECT * FROM cars_types WHERE carID={$car} and carBUYABLE=1", $c);
if(mysql_num_rows($q) == 0)
{
echo("Invalid Car");
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
die();
}
$r=mysql_fetch_array($q);
if($r['carCOST'] > $ir['money'])
{
echo("You do not have enough money to buy this car.");
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
die();
}
mysql_query("UPDATE users SET money=money-{$r['carCOST']},cars_owned=cars_owned+1 where userid=$userid", $c);
mysql_query("INSERT INTO cars_playercars VALUES('', $userid, $car, 1, 1, 1, 1)", $c);
print "You bought a {$r['carNAME']}!<br />
&gt; <a href='caryard.php'>Back to Caryard</a><br />
&gt; <a href='garage.php'>Goto Your Garage</a><br />";
}
else
{
print "<table width=100% border=6> <tr style='background:#cc9966'> <th>Car</th><th>Description</th><th>Base Acceleration</th><th>Base Handling</th><th>Base Speed</th><th>Base Shield</th><th>Price</th><th>Buy</th></tr>";
$q=mysql_query("SELECT * FROM cars_types WHERE carBUYABLE=1 ORDER BY carCOST", $c);
while($r=mysql_fetch_array($q))
{
$price='$'.number_format($r['carCOST']);
print "<tr><td>{$r['carNAME']}</td><td>{$r['carDESC']}</td> <td>{$r['carACC']}</td> <td>{$r['carHAN']}</td><td>{$r['carSPD']}</td> <td>{$r['carSHD']}</td> <td>$price</td> <td><a href='caryard.php?car={$r['carID']}'>Buy</a></td> </tr>";
}
print "</table>";
}
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
?>