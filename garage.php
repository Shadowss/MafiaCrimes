<?php
/*-----------------------------------------------------
-- Mono Country v2.00
-- A product of DBS-entertainment
-- Copyright held 2006+ by Dabomstew
-- garage.php
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
if(!$_GET['st'] ) { $_GET['st']=0; }
$start=abs((int) $_GET['st']);
$cpp=20;
print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
	<div class='generalinfo_simple'>");
print "<h3>Your Garage</h3><hr />
&gt; <a href='caryard.php'><font color='red'>Buy A Car (Car Yard)</font></a><br />
&gt; <a href='carmarket.php'><font color='red'>Buy A Car (Car Market)</font></a><br />
&gt; <a href='sellcar.php'><font color='red'>Sell Car (On The Car Market)</font></a><br /><hr /><h3>Your Cars</h3>";
$q=mysql_query("SELECT cpcPLAYER FROM cars_playercars WHERE cpcPLAYER=$userid", $c);
$cars=mysql_num_rows($q);
$pages=ceil($cars/$cpp);
print "Pages: ";
for($i=1; $i<=$pages; $i++)
{
$st=($i-1)*$cpp;
if($st == $start)
{
print "<b>$i</b>&nbsp;";
}
else
{
print "<a href='garage.php?st=$st'>$i</a>&nbsp;";
}
}
print "<br />
<table width=100% border=6> <tr style='background:#cc9966'><th>Car</th><th>Acceleration</th> <th>Handling</th><th>Speed</th><th>Shield</th><th>In Challenge?</th><th>Tune</th></tr>";
$q=mysql_query("SELECT cp.*, ct.* FROM cars_playercars cp LEFT JOIN cars_types ct ON cp.cpcCAR=ct.carID WHERE cp.cpcPLAYER=$userid LIMIT $start, $cpp", $c);
$count=0;
$cars=array();
while($r=mysql_fetch_array($q))
{
$count++;
$acc=$r['cpcACCLV']*$r['carACC'];
$han=$r['cpcHANLV']*$r['carHAN'];
$spd=$r['cpcSPDLV']*$r['carSPD'];
$shd=$r['cpcSHDLV']*$r['carSHD'];
$q2=mysql_query("SELECT * FROM challenges WHERE chCHRCAR={$r['cpcID']} AND chSTATUS='open'", $c);
if(mysql_num_rows($q2) == 1) { $challenge="<font color='red'>Yes</font>"; } else { $challenge="<font color='green'>No</font>"; }
print "<tr><td>{$r['carNAME']} </td> <td>Lv{$r['cpcACCLV']} ($acc)</td>  <td>Lv{$r['cpcHANLV']} ($han)</td> <td>Lv{$r['cpcSPDLV']} ($spd)</td> <td>Lv{$r['cpcSHDLV']} ($shd)</td><td>$challenge</td> <td><a href='tune.php?id={$r['cpcID']}'>Tune</a></td> </tr>";
$cars[$r['cpcID']]="{$r['carNAME']} - {$r['cpcACCLV']}/{$r['cpcHANLV']}/{$r['cpcSPDLV']}/{$r['cpcSHDLV']}";
}
if($count == 0) { print "<tr><th colspan=6>No Cars In Your Garage</th></tr>"; }
print "</table>";
$totalraces=$ir['cars_races_won']+$ir['cars_races_lost'];
$races_highstakes=$ir['cars_won']+$ir['cars_lost'];
if($ir['cars_races_income'] > 0)
{
$income = '<font color="green">$'.number_format($ir['cars_races_income'])."</font>";
}
else if($ir['cars_races_income'] == 0)
{
$income='$0';
}
else
{
$income = '<font color="red">-$'.number_format(abs($ir['cars_races_income']))."</font>";
}
print "<hr />
<h3>Your Driver's Record</h3>
<table width=100% border=6>
<tr>
<td width='50%'>Cars Owned</td>
<td width='50%'>{$ir['cars_owned']}</td>
</tr>
<tr>
<td>Cars Won In Races</td>
<td>{$ir['cars_won']}</td>
</tr>
<tr>
<td>Cars Lost In Races</td>
<td>{$ir['cars_lost']}</td>
</tr>
<tr>
<td>Challenges Sent</td>
<td>{$ir['cars_challs_sent']}</td>
</tr>
<tr>
<td>Challenges Accepted</td>
<td>{$ir['cars_challs_accpt']}</td>
</tr>
<tr>
<td>Challenges Declined</td>
<td>{$ir['cars_challs_decln']}</td>
</tr>
<tr>
<td>Races Won</td>
<td>{$ir['cars_races_won']}</td>
</tr>
<tr>
<td>Races Lost</td>
<td>{$ir['cars_races_lost']}</td>
</tr>
<tr>
<td>Total Races</td>
<td>$totalraces</td>
</tr>
<tr>
<td>Total Income From Betted Races</td>
<td>$income</td>
</tr>
<tr>
<td>Friendly Races</td>
<td>{$ir['cars_races_friendly']}</td>
</tr>
<tr>
<td>Betted Races</td>
<td>{$ir['cars_races_betted']}</td>
</tr>
<tr>
<td>High-Stakes Races</td>
<td>{$races_highstakes}</td>
</tr>
</table>";
print "<hr />
<h3>Pending Challenges To You</h3>
<table width='90%'><tr> <th>Challenger</th> <th>When Sent?</th> <th>View</th> </tr>";
$q=mysql_query("SELECT c.*,u.* FROM challenges c LEFT JOIN users u ON c.chCHR=u.userid WHERE chCHD=$userid AND chSTATUS = 'open'", $c);
if(mysql_num_rows($q) == 0)
{
print "<tr><th colspan=3>No Pending Challenges</th></tr>";
}
else
{
while($r=mysql_fetch_array($q))
{
print "<tr><td>{$r['username']}</td> <td>".date('F j Y, g:i:s a', $r['chTIME'])."</td> <td><a href='viewchallenge.php?id={$r['chID']}'>View</a></td></tr>";
}
}
print "</table>";
print "<hr />
<h3>Pending Challenges Sent By You</h3>
<table width='90%'><tr> <th>Challenged</th> <th>When Sent?</th> <th>Cancel</th> </tr>";
$q=mysql_query("SELECT c.*,u.* FROM challenges c LEFT JOIN users u ON c.chCHD=u.userid WHERE chCHR=$userid AND chSTATUS = 'open'", $c);
if(mysql_num_rows($q) == 0)
{
print "<tr><th colspan=3>No Pending Sent Challenges</th></tr>";
}
else
{
while($r=mysql_fetch_array($q))
{
print "<tr><td>{$r['username']}</td> <td>".date('F j Y, g:i:s a', $r['chTIME'])."</td> <td><a href='cancelchallenge.php?id={$r['chID']}'>Cancel</a></td></tr>";
}
}
print "</table>";
if($count > 0)
{
print "<hr />
<h3 name=\"challenge\">Challenge Someone To A Race</h3>";
foreach($cars as $k => $v)
{
if($ir['userid'] == 241)
{
print $k." = ".$v."<br>";
}
}
print "
<form action='makechallenge.php' method='post'>
Player ID To Challenge: <input type='text' name='id' value='".$_GET["selectprouser"]."' /><br />
Type: <select name='type' type='dropdown'><option>Friendly</option> <option>Betted</option> <option>High-Stakes</option></select><br />
Car to Use: <select name='car' type='dropdown'>";
foreach($cars as $k => $v)
{
if($_GET['selectprocar'] == $k)
$selected = 'selected';
else
$selected = "youwant = \"battlefield 1942 and battlefield 2\"";
print "<option value='$k' $selected>$v</option>";
}
print "</select><br />
Bet (if Betted Race): <input type='text' name='bet' value='0' /><br />
<input type='submit' value='Send Challenge' /></form>";
}
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
?>