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
$_GET['ID'] = abs((int) $_GET['ID']);
if(!$_GET['ID'])
{
die ("Incorrect usage of file.");
}
$q=$db->query("SELECT * FROM oclogs WHERE oclID={$_GET['ID']}");
$r=$db->fetch_row($q);
print "Here is the detailed view on this crime.<br />
<b>Crime:</b> {$r['ocCRIMEN']}<br />
<b>Time Executed:</b> ".date('F j, Y, g:i:s a',$r['ocTIME'])."<br />
{$r['oclLOG']}<br /><br />
<b>Result:</b> {$r['oclRESULT']}<br />
<b>Money Made:</b> \${$r['oclMONEY']}";
$h->endpage();
?>
