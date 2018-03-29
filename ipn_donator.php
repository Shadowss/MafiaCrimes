<?

/**************************************************************************************************
| Software Name        : Ravan Scripts Online Mafia Game
| Software Author      : Ravan Soft Tech
| Software Version     : Version 2.0.1 Build 2101
| Website              : http://www.ravan.info/
| E-mail               : support@ravan.info
|**************************************************************************************************
| The source files are subject to the Ravan Scripts End-User License Agreement included in License Agreement.html
| The files in the package must not be distributed in whole or significant part.
| All code is copyrighted unless otherwise advised.
| Do Not Remove Powered By Ravan Scripts without permission .         
|**************************************************************************************************
| Copyright (c) 2010 Ravan Scripts . All rights reserved.
|**************************************************************************************************/

include "config.php";
include "language.php";
global $_CONFIG;
define("MONO_ON", 1);
require "class/class_db_{$_CONFIG['driver']}.php";
$db=new database;
$db->configure($_CONFIG['hostname'],
 $_CONFIG['username'],
 $_CONFIG['password'],
 $_CONFIG['database'],
 $_CONFIG['persistent']);
$db->connect();
$c=$db->connection_id;
require 'global_func.php';
$set=array();
$settq=$db->query("SELECT * FROM settings");
while($r=$db->fetch_row($settq))
{
$set[$r['conf_name']]=$r['conf_value'];
}

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];


if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
// check the payment_status is Completed
if($payment_status != "Completed") { fclose ($fp);die(""); }
if($db->num_rows($db->query("SELECT * FROM dps_accepted WHERE dpTXN='{$txn_id}'")) > 0) { fclose ($fp);die(""); }
// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
if($receiver_email != $set['paypal']) { fclose ($fp);die(""); }
// check that payment_amount/payment_currency are correct
if($payment_currency != "USD") { fclose ($fp);die(""); }
// parse for pack
$packr=explode('|',$item_name);
if(str_replace("www.","",$packr[0]) != str_replace("www.","",$_SERVER['HTTP_HOST'])) { fclose($fp); die(""); }
if($packr[1] != "DP") { fclose($fp);die(""); }
$pack=$packr[2];
if( $pack != 1 and $pack != 2 and $pack != 3 and $pack != 4 and $pack != 5) { fclose($fp);die(""); }
if(($pack == 1 || $pack == 2 || $pack == 3) && $payment_amount != "1.00") { fclose ($fp);die(""); }
if($pack == 4 && $payment_amount != "5.00") { fclose ($fp);die(""); }
if($pack == 5 && $payment_amount != "7.00") {fclose ($fp);die(""); }
// grab IDs
$buyer=$packr[3];
$for=$buyer;
// all seems to be in order, credit it.
if($pack==1)
{
$db->query("UPDATE users u LEFT JOIN userstats us ON u.userid=us.userid SET u.money=u.money+5000,u.crystals=u.crystals+50,
us.IQ=us.IQ+50,u.donatordays=u.donatordays+14 WHERE u.userid={$for}");
$d=30;
$t="standard";
}
else if($pack==2)
{
$db->query("UPDATE users u LEFT JOIN userstats us ON u.userid=us.userid SET u.crystals=u.crystals+100,u.donatordays=u.donatordays+14 WHERE u.userid={$for}");
$d=30;
$t="crystals";
}
else if($pack==3)
{
$db->query("UPDATE users u LEFT JOIN userstats us ON u.userid=us.userid SET
us.IQ=us.IQ+120,u.donatordays=u.donatordays+14 WHERE u.userid={$for}");
$d=30;
$t="iq";
}
else if($pack==4)
{
$db->query("UPDATE users u LEFT JOIN userstats us ON u.userid=us.userid SET u.money=u.money+15000,u.crystals=u.crystals+75,
us.IQ=us.IQ+80,u.donatordays=u.donatordays+28 WHERE u.userid={$for}");
$d=55;
$t="fivedollars";
}
else if($pack==5)
{
$db->query("UPDATE users u LEFT JOIN userstats us ON u.userid=us.userid SET u.money=u.money+35000,u.crystals=u.crystals+160,
us.IQ=us.IQ+180,u.donatordays=u.donatordays+42 WHERE u.userid={$for}");
$d=115;
$t="tendollars";
}
// process payment
event_add($for, "Your \${$payment_amount} Pack {$pack} Donator Pack has been successfully credited to you.", $c);

$db->query("INSERT INTO dps_accepted VALUES('', {$buyer}, {$for}, '$t', unix_timestamp(), '$txn_id')");
}
else if (strcmp ($res, "INVALID") == 0) {
}
}

fclose ($fp);
}
?>
