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
$_GET['ID'] = abs((int) $_GET['ID']);
$_GET['price'] = make_bigint( $_GET['price']);
$q=mysql_query("SELECT * FROM challenges WHERE chCHRCAR={$_GET['ID']} AND chSTATUS='open'", $c);
if(mysql_num_rows($q) >0) { die("You are already challenging someone with this car."); }
if($_GET['price'])
{
$q1=mysql_query("SELECT * FROM carmarket WHERE cmADDER={$userid}", $c);
if(mysql_num_rows($q1) >= 3) { die("You can only put up to 3 listings on the car market at a time. Please remove some to add some more."); }
$q=mysql_query("SELECT iv.*,i.* FROM cars_playercars iv LEFT JOIN cars_types i ON iv.cpcCAR=i.carID WHERE cpcID={$_GET['ID']} and cpcPLAYER=$userid",$c);
if(mysql_num_rows($q)==0)
{
print "Invalid Car ID";
}
else
{
$r=mysql_fetch_array($q);
mysql_query("INSERT INTO carmarket VALUES ('','{$r['cpcCAR']}',{$r['cpcACCLV']}, {$r['cpcHANLV']}, {$r['cpcSPDLV']}, {$r['cpcSHDLV']}, $userid,{$_GET['price']})", $c);
mysql_query("DELETE FROM cars_playercars WHERE cpcID={$_GET['ID']}", $c);
mysql_query("INSERT INTO imarketaddlogs VALUES ( '', {$r['cpcCAR']}, {$_GET['price']}, {$r['cpcID']}, $userid, unix_timestamp(), '{$ir['username']} added a {$r['carNAME']} to the car market for \${$_GET['price']}')", $c);

print "{$r['carNAME']} added to market.";

}
}
else
{
$q=mysql_query("SELECT iv.*,i.* FROM cars_playercars iv LEFT JOIN cars_types i ON iv.cpcCAR=i.carID WHERE cpcID={$_GET['ID']} and cpcPLAYER=$userid",$c);
if(mysql_num_rows($q)==0)
{
print "Invalid Car ID";
}
else
{
$r=mysql_fetch_array($q);
print "Adding a car to the car market...<br />
You can only put up to 3 listings on the car market at a time. Please remove some to add some more if you have 3 already.
<form action='carmadd.php' method='get'>
<input type='hidden' name='ID' value='{$_GET['ID']}' />
Price: \$<input type='text' name='price' value='0' /><br />
<input type='submit' value='Add' /></form>";


}
}
$h->endpage();
?>
