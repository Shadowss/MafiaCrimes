<?php

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

include "globals.php";
if($_GET['action'] == "cancel")
{
print "You have cancelled your donation. Please donate later...";
}
else if($_GET['action'] == "done")
{
if(!$_GET['tx'])
{
die ("Get a life.");
}
print "Thank you for your payment to {$set['game_name']}. Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at <a href='http://www.paypal.com'>www.paypal.com</a> to view details of this transaction. Your will potion(s) should be credited within a few minutes, if not, contact an admin for assistance.";
}
$h->endpage();
?>
