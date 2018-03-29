<?php
/*-----------------------------------------------------
-- Advanced Drugs Mod v2
-- Coded by Oxidati0n
-- Copyright 2007 NickMedia
-- Nicholas - oxidati0n.info Productions
-----------------------------------------------------*/
include "globals.php";
print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
	<div class='generalinfo_simple'>");
print "<h3>Drugs Market</h3>";
switch($_GET['action'])
{
case "buy":
drugs_buy();
break;

default:
drugs_index();
break;
}
function drugs_index()
{
global $ir,$c,$userid,$h;
print "<center><b>Showing all listings shown by drug dealers</b><br />
<table width=100% border=1> <tr style='background:black'> <th>Seller</th> <th>Drug</th> <th>Type</th> <th>Price</th> <th>Links</th> </tr>";
$q=mysql_query("SELECT dm.*,d.*,u.* FROM drugsmarket dm LEFT JOIN drugs d ON dm.dm_drug=d.drug_id LEFT JOIN users u ON dm.dm_from=u.userid ORDER BY dm.dm_time,dm.dm_daysleft DESC",$c);
while($r=mysql_fetch_array($q))
{
if($r['dm_from'] == $userid) { $link = "<i>N/A</i>"; } else { $link = "[<a href='drugsmarket.php?action=buy&ID={$r['dm_id']}'>Buy</a>]"; }
print "\n<tr> <td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> [{$r['userid']}]</td> <td>{$r['drug_name']}</td> <td>{$r['dm_type']}</td> <td>\$".number_format($r['dm_price'])."</td> <td>{$link}</td> </tr>";
}
print "</table></center>";
}

function drugs_buy()
{
global $ir,$c,$userid,$h,$db;
$q=mysql_query("SELECT * FROM drugsmarket WHERE dm_id={$_GET['ID']}",$c);
if(!mysql_num_rows($q))
{
print "Error, either these drugs do not exist, or they have already been bought.<br />
<a href='drugsmarket.php'>Back</a>";
$h->endpage();
exit;
}
$r=mysql_fetch_array($q);
if($r['dm_price'] > $ir['money'])
{
print "Error, you do not have the funds to buy these drugs.<br />
<a href='drugsmarket.php'> Back</a>";
$h->endpage();
exit;
}
if(eregi('Outdated', $r['dm_type']))
{
$days=15;
} elseif(eregi('Edible', $r['dm_type']))
{
$days=6;
} else
{
$days=3;
}
$db->query("INSERT INTO drug_collection (dc_id, dc_drug, dc_user, dc_holding, dc_age) VALUES ('NULL', '".$r['drug_id']."', '$userid', '0', '$days');",$c);
$db->query("DELETE FROM drugsmarket WHERE dm_id={$_GET['ID']}",$c);
$db->query("UPDATE users SET money=money-{$r['dm_price']} where userid=$userid",$c);
$db->query("UPDATE users SET money=money+{$r['dm_price']} where userid={$r['dm_from']}",$c);
event_add($r['dm_from'],"<a href='viewuser.php?u=$userid'>{$ir['username']}</a> bought your {$r['drug_name']} drug from the market for \$".number_format($r['dm_price']).".",$c);
print "You bought the <b>$r[drug_name]</b> drug from the market for \$".number_format($r['dm_price']).".";

}
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
?>