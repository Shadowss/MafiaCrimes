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
$ycq=mysql_query("SELECT pc.*,t.* FROM cars_playercars pc LEFT JOIN cars_types t ON pc.cpcCAR=t.carID WHERE pc.cpcPLAYER=$userid", $c);
while($r=mysql_fetch_array($ycq))
{
$cars[]=$r;
}
if($ir['userid'] <> 3)
{
die("&gt;_&gt;");
}
switch($_GET['action'])
{
default:
index();
break;
}
function index()
{
global $ir, $c, $userid, $h, $cars;
}
$h->endpage();
?>