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
$id=abs((int) $_POST['id']);

$car=abs((int) $_POST['car']);

if(!$id || !$car) { die("Invalid Usage"); }
$q=mysql_query("SELECT ch.*, cp.*, ct.*, u1.username as challenger, u2.username as challenged FROM challenges ch LEFT JOIN cars_playercars cp ON ch.chCHRCAR=cp.cpcID LEFT JOIN cars_types ct ON ct.carID=cp.cpcCAR LEFT JOIN users u1 ON ch.chCHR=u1.userid LEFT JOIN users u2 ON ch.chCHD=u2.userid WHERE ch.chID={$id} AND (ch.chCHR=$userid OR ch.chCHD=$userid)", $c) or die(mysql_error());
if(mysql_num_rows($q) == 0) { die("Invalid Challenge"); }
$r=mysql_fetch_array($q);
if($r['chSTATUS']=="open") {
$bet=$r['chBET'];
if($bet > $ir['money']) { die("The bet is too large."); }
$q=mysql_query("SELECT cp.*,ct.* FROM cars_playercars cp LEFT JOIN cars_types ct ON ct.carID=cp.cpcCAR WHERE cp.cpcID={$car} AND cp.cpcPLAYER=$userid", $c);
if(mysql_num_rows($q) == 0) { die("Invalid Car"); }
$m=mysql_fetch_array($q);
if($m['cpcID'] == $r['cpcID']) { die("???"); }
//kk, time to race =D
print "OK, you will receive the results of this race in an event.";
mysql_query("UPDATE users SET money=money-$bet WHERE userid={$userid}", $c);

$q=mysql_query("SELECT * FROM cars_tracks ORDER BY rand() LIMIT 1", $c);
$t=mysql_fetch_array($q);
$stats_y=0;
$stats_y+=$m['cpcACCLV']*$m['carACC']*$t['ctrkACC'];
$stats_y+=$m['cpcHANLV']*$m['carHAN']*$t['ctrkHAN'];
$stats_y+=$m['cpcSPDLV']*$m['carSPD']*$t['ctrkSPD'];
$stats_y+=$m['cpcSHDLV']*$m['carSHD']*$t['ctrkSHD'];

$stats_o=0;
$stats_o+=$r['cpcACCLV']*$r['carACC']*$t['ctrkACC'];
$stats_o+=$r['cpcHANLV']*$r['carHAN']*$t['ctrkHAN'];
$stats_o+=$r['cpcSPDLV']*$r['carSPD']*$t['ctrkSPD'];
$stats_o+=$r['cpcSHDLV']*$r['carSHD']*$t['ctrkSHD'];
$stats_y*=rand(800,1200);
$stats_o*=rand(800,1200);
$notes="No-one won anything";
mysql_query("UPDATE users SET cars_challs_accpt=cars_challs_accpt+1 WHERE userid=$userid", $c);
if($stats_y > $stats_o)
{
$winner=$ir['username'];
$winnings=$bet*2;
mysql_query("UPDATE users SET money=money+$winnings, cars_races_income=cars_races_income+$bet,cars_races_won=cars_races_won+1 WHERE userid={$r['chCHD']}", $c);
mysql_query("UPDATE users SET cars_races_income=cars_races_income-$bet,cars_races_lost=cars_races_lost+1 WHERE userid={$r['chCHR']}", $c);
if($bet > 0)
{
$notes="{$r['challenged']} won \$$winnings"; 
}
if($r['chTYPE'] == "High-Stakes")
{
mysql_query("UPDATE cars_playercars SET cpcPLAYER=$userid WHERE cpcID={$r['cpcID']}", $c);
$notes="{$r['challenged']} won {$r['challenger']}\'s {$r['carNAME']}";
mysql_query("UPDATE users SET cars_lost=cars_lost+1 WHERE userid={$r['chCHR']}", $c);
mysql_query("UPDATE users SET cars_won=cars_won+1,cars_owned=cars_owned+1 WHERE userid={$r['chCHD']}", $c);
}
else if($r['chTYPE'] == "Betted")
{
mysql_query("UPDATE users SET cars_races_betted=cars_races_betted+1 WHERE userid IN ({$r['chCHR']}, {$r['chCHD']})", $c);
}
else
{
mysql_query("UPDATE users SET cars_races_friendly=cars_races_friendly+1 WHERE userid IN ({$r['chCHR']}, {$r['chCHD']})", $c);
}
}
else
{
$winner=$r['challenger'];
$winnings=$bet*2;
if($bet > 0)
{
$notes="{$r['challenger']} won \$$winnings"; 
}
mysql_query("UPDATE users SET money=money+$winnings, cars_races_income=cars_races_income+$bet,cars_races_won=cars_races_won+1 WHERE userid={$r['chCHR']}", $c);
mysql_query("UPDATE users SET cars_races_income=cars_races_income-$bet,cars_races_lost=cars_races_lost+1 WHERE userid={$r['chCHD']}", $c);
if($r['chTYPE'] == "High-Stakes")
{
mysql_query("UPDATE cars_playercars SET cpcPLAYER={$r['chCHR']} WHERE cpcID={$m['cpcID']}", $c);
$notes="{$r['challenger']} won {$r['challenged']}\'s {$m['carNAME']}";
mysql_query("UPDATE users SET cars_lost=cars_lost+1 WHERE userid={$r['chCHD']}", $c);
mysql_query("UPDATE users SET cars_won=cars_won+1,cars_owned=cars_owned+1 WHERE userid={$r['chCHR']}", $c);
}
else if($r['chTYPE'] == "Betted")
{
mysql_query("UPDATE users SET cars_races_betted=cars_races_betted+1 WHERE userid IN ({$r['chCHR']}, {$r['chCHD']})", $c);
}
else
{
mysql_query("UPDATE users SET cars_races_friendly=cars_races_friendly+1 WHERE userid IN ({$r['chCHR']}, {$r['chCHD']})", $c);
}
}
$challengercar=$r['carNAME'];
$challengedcar=$m['carNAME'];
mysql_query("INSERT INTO race_results VALUES('', '{$r['chTYPE']}', '{$r['chBET']}', '{$r['challenger']}', '{$r['challenged']}', '$challengercar', '$challengedcar','$winner', '$notes')", $c);
$i=mysql_insert_id($c);
event_add($r['chCHR'], "Your race with {$r['challenged']} is finished. Click <a href='viewrace.php?race={$i}'><font color='green'>here</font></a> to view the results.</a>", $c);
event_add($r['chCHD'], "Your race with {$r['challenger']} is finished. Click <a href='viewrace.php?race={$i}'><font color='green'>here</font></a> to view the results.</a>", $c);
mysql_query("UPDATE challenges SET chSTATUS='accepted' WHERE chID={$id}", $c);
}
$h->endpage();
?>