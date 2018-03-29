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
if(mysql_num_rows($db->query("SELECT * FROM dps_accepted WHERE dpTXN='{$txn_id}'", $c)) > 0) { fclose ($fp);die(""); }
if(mysql_num_rows($db->query("SELECT * FROM willps_accepted WHERE dpTXN='{$txn_id}'", $c)) > 0) { fclose ($fp);die(""); }
// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
if($receiver_email != $set['paypal']) { fclose ($fp);die(""); }
// check that payment_amount/payment_currency are correct
if($payment_currency != "USD") { fclose ($fp);die(""); }
// parse for pack
$packr=explode('|',$item_name);
if(str_replace("www.","",$packr[0]) != str_replace("www.","",$_SERVER['HTTP_HOST'])) { fclose($fp); die(""); }
if($packr[1] != "WP") { fclose($fp);die(""); }
$pack=$packr[2];
if( $pack != 1 and $pack != 5) { fclose($fp);die(""); }
if(($pack == 1) && $payment_amount != "1.00") { fclose ($fp);die(""); }
if($pack == 5 && $payment_amount != "4.50") { fclose ($fp);die(""); }
// grab IDs
$buyer=$packr[3];
$for=$buyer;
// all seems to be in order, credit it.
if($pack==1)
{
item_add($for, $set['willp_item'], 1);

}
else if($pack==5)
{
item_add($for, $set['willp_item'], 5);

}
// process payment

event_add($for, "Your \${$payment_amount} worth of Will Potions ($pack) has been successfully credited.", $c);
$db->query("INSERT INTO willps_accepted VALUES('', {$buyer}, {$for}, '$pack', unix_timestamp(), '$txn_id')", $c);
}
else if (strcmp ($res, "INVALID") == 0) {
fwrite($f,"Invalid?");
}
}
fclose ($fp);
}
?>
