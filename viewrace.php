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
$race=abs((int) $_GET['race']);
$q=mysql_query("SELECT * FROM race_results WHERE rrID={$race}", $c);
if(mysql_num_rows($q)==0) { die("Invalid Usage"); }
$r=mysql_fetch_array($q);
print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
	<div class='generalinfo_simple'>");
print "<h3>Race Between {$r['rrCHALLENGER']} and {$r['rrCHALLENGED']}</h3><hr />
Challenger: {$r['rrCHALLENGER']} (Used: {$r['rrCHRCAR']})<br />
Challenged: {$r['rrCHALLENGED']} (Used: {$r['rrCHDCAR']})<br />
Type: {$r['rrTYPE']}<br />";
if($r['rrTYPE'] == "Betted") { print "Bet: \${$r['rrBET']}<br />"; }
print "Winner: {$r['rrWINNER']}<br />
Result: {$r['rrNOTES']}<br /><hr />
&gt; <a href='carcentral.php'>Goto Car Central</a><br />
&gt; <a href='garage.php'>Goto Your Garage</a>";
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
?>