<?php
/*-----------------------------------------------------
-- Mono Country v1.0 BETA
-- A product of DBS-entertainment
-- Copyright held 2005 by Dabomstew
-- INDEX.php
-----------------------------------------------------*/
function power($num1, $num2)
{
return pow($num1, $num2);
}
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
print "<h3>Tuning Shop</h3><hr />
&gt; <a href='garage.php'>Back To Garage</a><hr />";
if(!$_GET['id']) { die("Invalid Usage"); }
$q=mysql_query("SELECT cp.*,ct.* FROM cars_playercars cp LEFT JOIN cars_types ct ON ct.carID=cp.cpcCAR WHERE cp.cpcID={$_GET['id']} AND cp.cpcPLAYER=$userid", $c);
if(mysql_num_rows($q) == 0) { 
	echo("Invalid Car");
	print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
	die();
}
$r=mysql_fetch_array($q);
$cost['acc']=$r['carACC']*power($r['cpcACCLV']+1,4)*($r['cpcACCLV']*$r['carACC']*10);
$cost['han']=$r['carHAN']*power($r['cpcHANLV']+1,4)*($r['cpcHANLV']*$r['carHAN']*10);
$cost['spd']=$r['carSPD']*power($r['cpcSPDLV']+1,4)*($r['cpcSPDLV']*$r['carSPD']*10);
$cost['shd']=$r['carSHD']*power($r['cpcSHDLV']+1,4)*($r['cpcSHDLV']*$r['carSHD']*10);
if($_GET['buy'])
{
if($_GET['buy'] != "acc" && $_GET['buy'] != "han" && $_GET['buy'] != "spd" && $_GET['buy'] != "shd") { 
	echo("Abusers suck.");
	print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
	die();
}
$upgr_cost=$cost[$_GET['buy']];
if($ir['money'] < $upgr_cost) { 
	echo("You don't have enough money to tune this stat."); 
	print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
	die();
}
mysql_query("UPDATE users SET money=money-{$upgr_cost} WHERE userid=$userid", $c);
$stat="cpc".strtoupper($_GET['buy'])."LV";
mysql_query("UPDATE cars_playercars SET $stat=$stat+1 WHERE cpcID={$_GET['id']}", $c);
print "Car tuned!<br />
&gt; <a href='tune.php?id={$_GET['id']}'>Tune some more</a>";
}
else
{
foreach($cost as $k => $v)
{
$costf[$k]='$'.number_format($v);
}
$acc=$r['cpcACCLV']*$r['carACC'];
$han=$r['cpcHANLV']*$r['carHAN'];
$spd=$r['cpcSPDLV']*$r['carSPD'];
$shd=$r['cpcSHDLV']*$r['carSHD'];
print "Current Stats for your {$r['carNAME']}<br />
<table width='90%'><tr> <th>Stat</th> <th>Amount</th> <th>Cost To Tune</th> <th>Tune</th></tr>
<tr> <td>Acceleration</td> <td>Lv{$r['cpcACCLV']} ($acc)</td> <td>{$costf['acc']}</td> <td><a href='tune.php?id={$_GET['id']}&buy=acc'>Tune</a></td></tr>
<tr><td>Speed</td> <td>Lv{$r['cpcSPDLV']} ($spd)</td> <td>{$costf['spd']}</td> <td><a href='tune.php?id={$_GET['id']}&buy=spd'>Tune</a></td></tr>
 <tr> <td>Handling</td> <td>Lv{$r['cpcHANLV']} ($han)</td> <td>{$costf['han']}</td> <td><a href='tune.php?id={$_GET['id']}&buy=han'>Tune</a></td></tr>
 <tr> <td>Shield</td> <td>Lv{$r['cpcSHDLV']} ($shd)</td>  <td>{$costf['shd']}</td> <td><a href='tune.php?id={$_GET['id']}&buy=shd'>Tune</a></td></tr>
</table>";
}
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
?>