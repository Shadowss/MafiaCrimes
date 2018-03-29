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
$type=$_POST['type'];
$car=abs((int) $_POST['car']);
$bet=abs((int) $_POST['bet']);
if(!$id || !$car || !$type) { die("Invalid Usage"); }
if($id == $userid) { die("You can't challenge yourself..."); }
if($type=="Betted" and !$bet) { die("You must place a bet"); }
if($type=="Betted" and $bet > $ir['money']) { die("Your bet is too large."); }
if($type != "Betted") { $bet=0; }
$q=mysql_query("SELECT cp.*,ct.* FROM cars_playercars cp LEFT JOIN cars_types ct ON ct.carID=cp.cpcCAR WHERE cp.cpcID={$car} AND cp.cpcPLAYER=$userid", $c);
if(mysql_num_rows($q) == 0) { die("Invalid Car"); }
$q=mysql_query("SELECT * FROM users WHERE userid={$id}", $c);
if(mysql_num_rows($q) == 0) { die("Invalid User"); }
$r=mysql_fetch_array($q);
$q=mysql_query("SELECT * FROM challenges WHERE chCHRCAR={$car} AND chSTATUS='open'", $c);
if(mysql_num_rows($q) >0) { die("You are already challenging someone with this car."); }
$q=mysql_query("SELECT * FROM cars_playercars WHERE cpcPLAYER={$id}", $c);
if(mysql_num_rows($q) == 0) { die("That player doesn't have any cars to race you with!"); }
mysql_query("INSERT INTO challenges VALUES('', $userid, $id, 'open', $car, '$type', $bet, unix_timestamp())", $c);
$i=mysql_insert_id($c);
mysql_query("UPDATE users SET money=money-$bet, cars_challs_sent=cars_challs_sent+1 WHERE userid=$userid", $c);
event_add($userid, "You have made a race challenge to {$r['username']}. Click <a href='viewchallenge.php?id={$i}'><font color='red'>here</font></a> to view it.", $c);
event_add($id, "You were challenged to a race by {$ir['username']}. Click <a href='viewchallenge.php?id={$i}'><font color='red'>here</font></a> to view their challenge.", $c);
print "Challenge was sent. If there was a bet, it has been pre-emptively taken from you.<br />
&gt; <a href='garage.php'>Back</a>";
$h->endpage();
?>