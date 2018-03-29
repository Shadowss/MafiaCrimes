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
print "<h3>Sell a Car</h3><hr />
&gt; <a href='garage.php'>Back To Garage</a><hr />
<table width=100% border=6> <tr style='background:#cc9966'><th>Car</th><th>Acceleration</th> <th>Handling</th><th>Speed</th><th>Shield</th><th>Sell</th></tr>";
$q=mysql_query("SELECT cp.*, ct.* FROM cars_playercars cp LEFT JOIN cars_types ct ON cp.cpcCAR=ct.carID WHERE cp.cpcPLAYER=$userid", $c);
$count=0;
$cars=array();
while($r=mysql_fetch_array($q))
{
$count++;
$acc=$r['cpcACCLV']*$r['carACC'];
$han=$r['cpcHANLV']*$r['carHAN'];
$spd=$r['cpcSPDLV']*$r['carSPD'];
$shd=$r['cpcSHDLV']*$r['carSHD'];
print "<tr><td>{$r['carNAME']}</td> <td>Lv{$r['cpcACCLV']} ($acc)</td>  <td>Lv{$r['cpcHANLV']} ($han)</td> <td>Lv{$r['cpcSPDLV']} ($spd)</td> <td>Lv{$r['cpcSHDLV']} ($shd)</td> <td><a href='carmadd.php?ID={$r['cpcID']}'><font color='red'>Add To Market</font></a></td> </tr>";
$cars[$r['cpcID']]="{$r['carNAME']} - {$r['cpcACCLV']}/{$r['cpcHANLV']}/{$r['cpcSPDLV']}/{$r['cpcSHDLV']}";
}
if($count == 0) { print "<tr><th colspan=6>No Cars In Your Garage to sell</th></tr>"; }
print "</table>";
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
?>