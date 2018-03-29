<?php

/**************************************************************************************************
| Software Name        : Mafia Game Scripts Online Mafia Game
| Software Author      : Mafia Game Scripts
| Software Version     : Version 2.3.1 Build 2301
| Website              : http://www.mafiagamescript.net/
| E-mail               : support@mafiagamescript.net
|**************************************************************************************************
| The source files are subject to the Mafia Game Script End-User License Agreement included in License Agreement.html
| The files in the package must not be distributed in whole or significant part.
| All code is copyrighted unless otherwise advised.
| Do Not Remove Powered By Mafia Game Scripts without permission .         
|**************************************************************************************************
| Copyright (c) 2010 Mafia Game Script . All rights reserved.
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
$db->query("UPDATE users set hospital=hospital-1 WHERE hospital>0");
$db->query("UPDATE `users` SET jail=jail-1 WHERE `jail` > 0");
$db->query("UPDATE users SET traveltime=traveltime-1 WHERE traveltime > 0");
$db->query("UPDATE users SET bguard=bguard-1 WHERE bguard>0");
$db->query("UPDATE users SET bguard=0 WHERE bguard<0");
$hc=$db->num_rows($db->query("SELECT * FROM users WHERE hospital > 0"));
$jc=$db->num_rows($db->query("SELECT * FROM users WHERE jail > 0"));
$db->query("UPDATE settings SET conf_value='$hc' WHERE conf_name='hospital_count'");
$db->query("UPDATE settings SET conf_value='$jc' WHERE conf_name='jail_count'");

?>
