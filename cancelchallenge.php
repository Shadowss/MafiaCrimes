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



if(!$id) { die("Invalid Usage"); }
$q=mysql_query("SELECT ch.*, cp.*, ct.*, u1.username as challenger, u2.username as challenged FROM challenges ch LEFT JOIN cars_playercars cp ON ch.chCHRCAR=cp.cpcID LEFT JOIN cars_types ct ON ct.carID=cp.cpcCAR LEFT JOIN users u1 ON ch.chCHR=u1.userid LEFT JOIN users u2 ON ch.chCHD=u2.userid WHERE ch.chID={$id} AND ch.chCHR=$userid AND ch.chSTATUS='open'", $c) or die(mysql_error());
if(mysql_num_rows($q) == 0) { die("Invalid Challenge"); }
$r=mysql_fetch_array($q);
mysql_query("UPDATE users SET money=money+{$r['chBET']} WHERE userid={$r['chCHR']}", $c);
event_add($r['chCHR'],"You cancelled the challenge to {$r['challenged']}", $c);
event_add($r['chCHD'],"{$ir['username']} cancelled their challenge to you.", $c);
mysql_query("UPDATE challenges SET chSTATUS='cancelled' WHERE chID={$id}", $c);
print "Challenge cancelled.";
$h->endpage();
?>