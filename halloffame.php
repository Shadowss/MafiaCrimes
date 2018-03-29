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
$filters=array(
'nodon' => 'AND donatordays=0',
'don' => 'AND donatordays > 0',
'all' => '');
$filter=(isset($filters[$_GET['filter']])) ? $_GET['filter'] : 'all';
$myf=$filters[$filter];
$bt1=($filter=="nodon") ? "<b>" : "";
$bet1=($filter=="nodon") ? "</b>" : "";
$bt2=($filter=="don") ? "<b>" : "";
$bet2=($filter=="don") ? "</b>" : "";
$bt3=($filter=="all") ? "<b>" : "";
$bet3=($filter=="all") ? "</b>" : "";
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Hall Of Fame</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


Filter: [$bt1<a href='halloffame.php?action={$_GET['action']}&filter=nodon'>Non-Donators</a>$bet1 | $bt2<a href='halloffame.php?action={$_GET['action']}&filter=don'>Donators</a>$bet2 | $bt3<a href='halloffame.php?action={$_GET['action']}&filter=all'>All Users</a>$bet3]  
<table width=75% cellspacing=1 class='table'> <tr> <td><a href='halloffame.php?action=level&filter={$filter}'>LEVEL</a></td> <td><a href='halloffame.php?action=money&filter={$filter}'>MONEY</a></td> <td><a href='halloffame.php?action=respect&filter={$filter}'>RESPECT</a></td> <td><a href='halloffame.php?action=crystals&filter={$filter}'>CRYSTALS</a></td> <td><a href='halloffame.php?action=total&filter={$filter}'>TOTAL STATS</a></td> </tr>
<tr> <td><a href='halloffame.php?action=strength&filter={$filter}'>STRENGTH</a></td> <td><a href='halloffame.php?action=agility&filter={$filter}'>AGILITY</a></td> <td><a href='halloffame.php?action=guard&filter={$filter}'>GUARD</a></td> <td><a href='halloffame.php?action=labour&filter={$filter}'>LABOUR</a></td> <td><a href='halloffame.php?action=iq&filter={$filter}'>IQ</a></td> </tr> </table>";
switch($_GET['action'])
{
case "level":
hof_level();
break;
case "money":
hof_money();
break;
case "crystals":
hof_crystals();
break;
case "respect":
hof_respect();
break;
case "total":
hof_total();
break;
case "strength":
hof_strength();
break;
case "agility":
hof_agility();
break;
case "guard":
hof_guard();
break;
case "labour":
hof_labour();
break;
case "iq":
hof_iq();
break;
default:
hof_level();
break;
}
function hof_level()
{
global $db,$ir,$c,$userid, $myf;
print "Showing the 20 users with the highest levels<br />
<table width=75% cellspacing=1 class='table'><tr style='background:gray'> <th>Pos</th> <th>User</th> <th>Level</th> </tr>";
$q=$db->query("SELECT u.*,g.* FROM users u LEFT JOIN gangs g ON g.gangID=u.gang WHERE u.user_level != 0 $myf ORDER BY level DESC,userid ASC LIMIT 20");
$p=0;
while($r=$db->fetch_row($q))
{
$p++;
if($r['userid'] == $userid) { $t="<b>";$et="</b>"; } else { $t="";$et=""; }
print "<tr> <td>$t$p$et</td> <td>$t{$r['gangPREF']} {$r['username']} [{$r['userid']}]$et</td> <td>$t{$r['level']}$et</td> </tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function hof_money()
{
global $db,$ir,$c,$userid, $myf;
print "Showing the 20 users with the highest amount of money<br />
<table width=75% cellspacing=1 class='table'><tr style='background:gray'> <th>Pos</th> <th>User</th> <th>Money</th> </tr>";
$q=$db->query("SELECT u.*,g.* FROM users u LEFT JOIN gangs g ON g.gangID=u.gang WHERE u.user_level != 0 $myf ORDER BY money DESC,userid ASC LIMIT 20");
$p=0;
while($r=$db->fetch_row($q))
{
$p++;
if($r['userid'] == $userid) { $t="<b>";$et="</b>"; } else { $t="";$et=""; }
print "<tr> <td>$t$p$et</td> <td>$t{$r['gangPREF']} {$r['username']} [{$r['userid']}]$et</td> <td>$t\$".money_formatter($r['money'],'')."$et</td> </tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function hof_crystals()
{
global $db,$ir,$c,$userid, $myf;
print "Showing the 20 users with the highest amount of crystals<br />
<table width=75% cellspacing=1 class='table'><tr style='background:gray'> <th>Pos</th> <th>User</th> <th>Crystals</th> </tr>";
$q=$db->query("SELECT u.*,g.* FROM users u LEFT JOIN gangs g ON g.gangID=u.gang WHERE u.user_level != 0 $myf ORDER BY crystals DESC,userid ASC LIMIT 20");
$p=0;
while($r=$db->fetch_row($q))
{
$p++;
if($r['userid'] == $userid) { $t="<b>";$et="</b>"; } else { $t="";$et=""; }
print "<tr> <td>$t$p$et</td> <td>$t{$r['gangPREF']} {$r['username']} [{$r['userid']}]$et</td> <td>$t".money_formatter($r['crystals'],'')."$et</td> </tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}

function hof_respect()
{
global $db,$ir,$c,$userid;
print "Showing the 20 gangs with the highest amount of respect<br />
<table width=75% cellspacing=1 class='table'><tr style='background:gray'> <th>Pos</th> <th>Gang</th> <th>Respect</th> </tr>";
$q=$db->query("SELECT * FROM gangs ORDER BY gangRESPECT DESC,gangID ASC LIMIT 20");
$p=0;
while($r=$db->fetch_row($q))
{
$p++;
if($r['gangID'] == $ir['gang']) { $t="<b>";$et="</b>"; } else { $t="";$et=""; }
print "<tr> <td>$t$p$et</td> <td>$t{$r['gangNAME']} [{$r['gangID']}]$et</td> <td>$t".money_formatter($r['gangRESPECT'],'')."$et</td> </tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}

function hof_total()
{
global $db,$ir,$c,$userid, $myf;
print "Showing the 20 users with the highest total stats<br />
<table width=75% cellspacing=1 class='table'><tr style='background:gray'> <th>Pos</th> <th>User</th> </tr>";
$q=$db->query("SELECT u.*,g.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN gangs g ON g.gangID=u.gang WHERE u.user_level != 0 $myf ORDER BY (us.strength+us.agility+us.guard+us.labour+us.IQ) DESC,u.userid ASC LIMIT 20");
$p=0;
while($r=$db->fetch_row($q))
{
$p++;
if($r['userid'] == $ir['userid']) { $t="<b>";$et="</b>"; } else { $t="";$et=""; }
print "<tr> <td>$t$p$et</td> <td>$t{$r['gangPREF']} {$r['username']} [{$r['userid']}]$et</td> </tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function hof_strength()
{
global $db,$ir,$c,$userid, $myf;
print "Showing the 20 users with the highest strength<br />
<table width=75% cellspacing=1 class='table'><tr style='background:gray'> <th>Pos</th> <th>User</th> </tr>";
$q=$db->query("SELECT u.*,g.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN gangs g ON g.gangID=u.gang WHERE u.user_level != 0 $myf ORDER BY us.strength DESC,u.userid ASC LIMIT 20");
$p=0;
while($r=$db->fetch_row($q))
{
$p++;
if($r['userid'] == $ir['userid']) { $t="<b>";$et="</b>"; } else { $t="";$et=""; }
print "<tr> <td>$t$p$et</td> <td>$t{$r['gangPREF']} {$r['username']} [{$r['userid']}]$et</td> </tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function hof_agility()
{
global $db,$ir,$c,$userid, $myf;
print "Showing the 20 users with the highest agility<br />
<table width=75% cellspacing=1 class='table'><tr style='background:gray'> <th>Pos</th> <th>User</th> </tr>";
$q=$db->query("SELECT u.*,g.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN gangs g ON g.gangID=u.gang WHERE u.user_level != 0 $myf ORDER BY us.agility DESC,u.userid ASC LIMIT 20");
$p=0;
while($r=$db->fetch_row($q))
{
$p++;
if($r['userid'] == $ir['userid']) { $t="<b>";$et="</b>"; } else { $t="";$et=""; }
print "<tr> <td>$t$p$et</td> <td>$t{$r['gangPREF']} {$r['username']} [{$r['userid']}]$et</td> </tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function hof_guard()
{
global $db,$ir,$c,$userid, $myf;
print "Showing the 20 users with the highest guard<br />
<table width=75% cellspacing=1 class='table'><tr style='background:gray'> <th>Pos</th> <th>User</th> </tr>";
$q=$db->query("SELECT u.*,g.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN gangs g ON g.gangID=u.gang WHERE u.user_level != 0 $myf ORDER BY us.guard DESC,u.userid ASC LIMIT 20");
$p=0;
while($r=$db->fetch_row($q))
{
$p++;
if($r['userid'] == $ir['userid']) { $t="<b>";$et="</b>"; } else { $t="";$et=""; }
print "<tr> <td>$t$p$et</td> <td>$t{$r['gangPREF']} {$r['username']} [{$r['userid']}]$et</td> </tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function hof_labour()
{
global $db,$ir,$c,$userid, $myf;
print "Showing the 20 users with the highest labour<br />
<table width=75% cellspacing=1 class='table'><tr style='background:gray'> <th>Pos</th> <th>User</th> </tr>";
$q=$db->query("SELECT u.*,g.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN gangs g ON g.gangID=u.gang WHERE u.user_level != 0 $myf ORDER BY us.labour DESC,u.userid ASC LIMIT 20");
$p=0;
while($r=$db->fetch_row($q))
{
$p++;
if($r['userid'] == $ir['userid']) { $t="<b>";$et="</b>"; } else { $t="";$et=""; }
print "<tr> <td>$t$p$et</td> <td>$t{$r['gangPREF']} {$r['username']} [{$r['userid']}]$et</td> </tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function hof_iq()
{
global $db,$ir,$c,$userid, $myf;
print "Showing the 20 users with the highest IQ<br />
<table width=75% cellspacing=1 class='table'><tr style='background:gray'> <th>Pos</th> <th>User</th> </tr>";
$q=$db->query("SELECT u.*,g.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid LEFT JOIN gangs g ON g.gangID=u.gang WHERE u.user_level != 0 $myf ORDER BY us.IQ DESC,u.userid ASC LIMIT 20");
$p=0;
while($r=$db->fetch_row($q))
{
$p++;
if($r['userid'] == $ir['userid']) { $t="<b>";$et="</b>"; } else { $t="";$et=""; }
print "<tr> <td>$t$p$et</td> <td>$t{$r['gangPREF']} {$r['username']} [{$r['userid']}]$et</td> </tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
$h->endpage();
?>
