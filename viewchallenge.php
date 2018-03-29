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
$id=abs((int) $_GET['id']);
$q=mysql_query("SELECT ch.*, cp.*, ct.*, u1.username as challenger, u2.username as challenged FROM challenges ch LEFT JOIN cars_playercars cp ON ch.chCHRCAR=cp.cpcID LEFT JOIN cars_types ct ON ct.carID=cp.cpcCAR LEFT JOIN users u1 ON ch.chCHR=u1.userid LEFT JOIN users u2 ON ch.chCHD=u2.userid WHERE ch.chID={$id} AND (ch.chCHR=$userid OR ch.chCHD=$userid)", $c) or die(mysql_error());
if(mysql_num_rows($q) == 0) { die("Invalid Challenge"); }
$r=mysql_fetch_array($q);
print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
	<div class='generalinfo_simple'>");

print "<h2>Challenge From {$r['challenger']} to {$r['challenged']}</h2><hr />
Type: <h3><font color=red>{$r['chTYPE']}</font></h3><br />";
if($r['chTYPE'] == "Betted") { $bet='$'.number_format($r['chBET']); print "Bet: $bet<br />"; }
print "Challengers Car: {$r['carNAME']}<br />
Status: {$r['chSTATUS']}<br />";
if(($userid == $r['chCHD'] or $userid == 1) and $r['chSTATUS'] == "open")
{
$q=mysql_query("SELECT cp.*, ct.* FROM cars_playercars cp LEFT JOIN cars_types ct ON cp.cpcCAR=ct.carID WHERE cp.cpcPLAYER=$userid", $c);
$cars=array();
while($r=mysql_fetch_array($q))
{
$cars[$r['cpcID']]="{$r['carNAME']} - {$r['cpcACCLV']}/{$r['cpcHANLV']}/{$r['cpcSPDLV']}/{$r['cpcSHDLV']}";
}
print "<hr />
<h3>Manage This Challenge</h3>
<b>Accept It:</b><br />
<form action='acceptchallenge.php' method='post'>
Car To Use: <select name=car type=dropdown>";
foreach($cars as $k => $v)
{
print "<option value='$k'>$v</option>";
}
print "</select><br />
<input type='hidden' name='id' value='$id'>
<input type='submit' value='Accept Challenge' /></form><br />
<b>Decline Challenge:</b><br />
&gt; <a href='declinechallenge.php?id={$id}'>Click Here</a>";
}
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
?>