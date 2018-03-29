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
print "
<h3>Car Central</h3><hr />
<b>Diplaying the last 20 finished races:</b><br />
<center>
<table width='85%' align='center'>
	<tr style='background:#cc9966;'>
		<th>Race Participants</th><th>Results</th></tr>";
$q=mysql_query("SELECT * FROM race_results ORDER BY rrID DESC LIMIT 20");
while($r=mysql_fetch_array($q)){
print "<tr><td>{$r['rrCHALLENGER']} Vs {$r['rrCHALLENGED']}</td><td> <a href='viewrace.php?race={$r['rrID']}'>View</a></td></tr>";
}
print "<tr><td colspan=2 align=center><hr />
<a href='halloffame.php?action=races'>Best Drivers</a>
<hr />
<b>Current Tournaments:</b><br />
<font color='red'>No tournaments going on at present.</font></td></tr></table></center>";
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
?>