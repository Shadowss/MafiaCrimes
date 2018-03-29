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
$set=array();
$settq=$db->query("SELECT * FROM settings");
while($r=$db->fetch_row($settq))
{
$set[$r['conf_name']]=$r['conf_value'];
}
$db->query("UPDATE users SET attacking=0");
$db->query("UPDATE gangs SET gangCHOURS=gangCHOURS-1 WHERE gangCRIME>0");
$q=$db->query("SELECT g.*,oc.* FROM gangs g LEFT JOIN orgcrimes oc ON g.gangCRIME=oc.ocID WHERE g.gangCRIME > 0 AND g.gangCHOURS = 0");
while($r=$db->fetch_row($q))
{
$suc=rand(0,1);
if($suc) {
$log=$r['ocSTARTTEXT'].$r['ocSUCCTEXT'];
$muny=(int) (rand($r['ocMINMONEY'],$r['ocMAXMONEY']));
$log=str_replace(array("{muny}","'"),array($muny,"''"),$log);
$db->query("UPDATE gangs SET gangMONEY=gangMONEY+$muny,gangCRIME=0 WHERE gangID={$r['gangID']}");
$db->query("INSERT INTO oclogs VALUES ('',{$r['ocID']},{$r['gangID']}, '$log', 'success', $muny, '{$r['ocNAME']}', unix_timestamp())");
$i=$db->insert_id();
$qm=$db->query("SELECT * FROM users WHERE gang={$r['gangID']}");
while($rm=$db->fetch_row($qm))
{
event_add($rm['userid'],"Your Gang's Organised Crime Succeeded. Go <a href='oclog.php?ID=$i'>here</a> to view the details.",$c);
}
}
else
{
$log=$r['ocSTARTTEXT'].$r['ocFAILTEXT'];
$muny=0;
$log=str_replace(array("{muny}","'"),array($muny,"''"),$log);
$db->query("UPDATE gangs SET gangCRIME=0 WHERE gangID={$r['gangID']}");
$db->query("INSERT INTO oclogs VALUES ('',{$r['ocID']},{$r['gangID']}, '$log', 'failure', $muny, '{$r['ocNAME']}', unix_timestamp())");
$i=$db->insert_id();
$qm=$db->query("SELECT * FROM users WHERE gang={$r['gangID']}");
while($rm=$db->fetch_row($qm))
{
event_add($rm['userid'],"Your Gang's Organised Crime Failed. Go <a href='oclog.php?ID=$i'>here</a> to view the details.",$c);
}
}
}
if(date('G')==17)
{
$db->query("UPDATE users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN jobs j ON j.jID=u.job LEFT JOIN jobranks jr ON u.jobrank=jr.jrID SET u.money=u.money+jr.jrPAY, u.exp=u.exp+(jr.jrPAY/20) 
WHERE u.job > 0 AND u.jobrank > 0");
$db->query("UPDATE userstats us LEFT JOIN users u ON u.userid=us.userid LEFT JOIN jobs j ON j.jID=u.job LEFT JOIN jobranks jr ON u.jobrank=jr.jrID SET us.strength=(us.strength+1)+jr.jrSTRG-1,us.labour=(us.labour+1)+jr.jrLABOURG-1,us.IQ=(us.IQ+1)+jr.jrIQG-1 WHERE u.job > 0 AND u.jobrank > 0");
}
if($set['validate_period'] == 60 && $set['validate_on'])
{
$db->query("UPDATE users SET verified=0");

}

print "

<meta HTTP-EQUIV='REFRESH' content='5; url=staff.php?action=cmanual'>
<style type='text/css'>
.style2 {
    text-align: center;
}
.style3 {
    text-align: center;
    color: #008000;
}
.style4 {
    color: #FFFFFF;
}
</style>


<body style='background-color: #000000'>

<h2 class='style3'>Cron Job Successfully Ran</h2>

<div class='style2'>
    <h3>

<a href='staff.php?action=cmanual'><span class='style4'>Back</span></a></h3>
</div> 

";

?>
