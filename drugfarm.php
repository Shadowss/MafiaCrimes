<?php
include "globals.php";
function drug_dropdown($connection,$ddname="drug",$selected=-1)
{
$ret="<select name='$ddname' type='dropdown'>";
$q=mysql_query("SELECT * FROM drugs ORDER BY drug_name ASC",$connection);
if($selected == -1) { $first=0; } else { $first=1; }
while($r=mysql_fetch_array($q))
{
$ret.="\n<option value='{$r['drug_id']}'";
if ($selected == $r['drug_id'] || $first == 0) { $ret.=" selected='selected'";$first=1; } 
$ret.=">{$r['drug_name']}</option>";
}
$ret.="\n</select>";
return $ret;
}
function drugt_dropdown($connection,$ddname="drug",$selected=-1)
{
$ret="<select name='$ddname' type='dropdown'>";
$q=mysql_query("SELECT * FROM drugs WHERE drug_available=1 ORDER BY drug_name ASC",$connection);
if($selected == -1) { $first=0; } else { $first=1; }
while($r=mysql_fetch_array($q))
{
$ret.="\n<option value='{$r['drug_id']}'";
if ($selected == $r['drug_id'] || $first == 0) { $ret.=" selected='selected'";$first=1; } 
$ret.=">{$r['drug_name']}</option>";
}
$ret.="\n</select>";
return $ret;
}

print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
	<div class='generalinfo_simple'>");

print "<h3>Drug Farm</h3><br />";
if(!$_GET['action'])
{
print "<br />
<b>Welcome to the Drug Farm</b><br />
What would you like to do today?<br />";
if($ir['own_farm'] == 0)
{
print "<a href='drugfarm.php?action=buy'>Buy a part of the farm</a><br /><br />";
}
print "<a href='drugfarm.php?action=grow'>Grow a drug</a> | <a href='drugfarm.php?action=premade'>Buy a Premade Drug</a><br />";
} elseif($_GET['action'] == "grow") {
$q=mysql_query("SELECT * FROM `drug_farm` WHERE `df_user` = '$userid'",$c);
if(mysql_num_rows($q) > 6 and $ir['own_farm'] == 1)
{
print "You already have 7 drugs on the farm, Thats the maximum you can grow on your own.<br />
<a href='drugfarm.php'>Back</a><br />";
} elseif(mysql_num_rows($q) > 1 and $ir['own_farm'] == 0)
{
print "You already have 2 drugs on the farm, Thats the maximum you can grow on your own.<br />
To grow 7 drugs you need to purchase a part of the farm, Click <a href='drugfarm.php?action=buy'>here</a> to purchase one<br />
<a href='drugfarm.php'>Back</a><br />";
} elseif($_POST['drug'])
{
if($ir['own_farm'] == 0 and $ir['money'] < 500)
{
print "You do not have enough money to rent a part of the field for drugs<br />
You need <b>\$500</b> per drug<br />
Or you can buy a part of the farm permanently <a href='drugfarm.php?action=buy'>here</a><br />
<a href='drugfarm.php'>Back</a><br />";
} else {
$q2=mysql_query("SELECT * FROM `drugs` WHERE `drug_id` = ".sqlesc($_POST['drug'])."",$c) or die("ERROR1");
$r2=mysql_fetch_assoc($q2);
$query = "INSERT INTO drug_farm (df_user, df_drug, df_daysleft) VALUES ('$userid', ".sqlesc($_POST["drug"]).", ".sqlesc($r2["drug_growdays"]).")";
mysql_query($query,$c) or die($query);
if($ir['own_farm'] == 0)
{
mysql_query("UPDATE `users` SET `money` = `money` - '500' WHERE `userid` = '$userid'",$c);
}
print "You have started to plant the <b>$r2[drug_name]</b> drug<br />
This drug will take <b>$r2[drug_growdays]</b> days to grow<br />
<a href='drugfarm.php'>Back</a><br />";
}
} else {
if($ir['own_farm'] == 1) { $s="do own part of the farm so you don't have to pay a fee."; } else { $s="do <b>not</b> own a part of the farm so you will have to pay a \$500 fee"; }
print "<b>Grow a drug</b><br />
You currently ".$s."<br />
Do you want to grow a drug?<br />
<br />";
if($ir['level'] >= 3)
{
print "<form action='drugfarm.php?action=grow' method='post'>
Drug to Grow: ".drugt_dropdown($c)."<br />
<input type='submit' value='Grow Drug'><br /></form>";
} else {
print "<b><i>You must be at least level three to grow a drug</i></b><br />";
}

}

} else if($_GET['action'] == "buy")
{
if($_GET['conf'] == "Y")
{
if($ir['money'] < 100000)
{
print "You don't have enough money to buy part of the land<br />
<a href='drugfarm.php'>Back</a><br />";
} else {
mysql_query("UPDATE `users` SET `money` = `money` - '100000', `own_farm` = '1' WHERE `userid` = '$userid'",$c);
print "You have successfully brought a part of the farm<br />
<a href='drugfarm.php'>Back</a><br />";
}
} else {
print "<b>Purchase Part of the farm</b><br />
Do you want part of the farm<br />
You are paying <b>\$100,000</b> and you can plant <b>7</b> drugs at once.<br />
<a href='drugfarm.php?action=buy&conf=Y'>Purchase Part of land!</a><br />";
}
} elseif($_GET['action'] == "premade")
{
$q=mysql_query("SELECT * FROM `drugs` WHERE `drug_available` = '1'",$c);
print "<b>Purchase Pre-made products</b><br />
<br />
<table width=90% border=1><tr><th>Drug Name</th><th>Type</th><th>Price</th><th>Description</th><th>Buy</th></tr>";
if(mysql_num_rows($q) == 0)
{
print "We have no drugs for sale at this time.<br/>";
}
while($r=mysql_fetch_array($q))
{
print "<tr><td>".$r['drug_name']."</td><td>".$r['drug_type']."</td><td>\$".number_format($r['drug_premadeprice'])."</td><td>".$r['drug_description']."</td><td><a href='drugfarm.php?action=buydrug&ID={$r['drug_id']}'>Purchase</a></td></tr>";
}
print "</table>";
} elseif($_GET['action'] == "buydrug" and $_GET['ID'])
{
$_GET['ID']=abs(strip_tags((int) $_GET['ID']));
$q=mysql_query("SELECT * FROM `drugs` WHERE `drug_id` = '$_GET[ID]' AND `drug_available` = '1'",$c);
if(mysql_num_rows($q) == 0)
{
print "Theres no drug available with that ID!";
} else {
$r=mysql_fetch_array($q);
if($r['drug_premadeprice'] > $ir['money'])
{
print "You don't have enough money to purchase this drug<br />
<a href='drugfarm.php?action=premade'>Back</a><br />";
} else {
mysql_query("INSERT INTO `drug_collection` (`dc_id`, `dc_drug`, `dc_user`, `dc_holding`, `dc_age`) VALUES ('NULL', '$_GET[ID]', '$userid', '0', '0');",$c);
mysql_query("UPDATE `users` SET `money` = `money` - '$r[drug_premadeprice]' WHERE `userid` = '$userid'",$c);
print "You have successfully brought the <b>$r[drug_name]</b> drug!<br />
<a href='drugfarm.php?action=mydrugs'>Your Drugs</a><br />";
} } 
} elseif($_GET['action'] == "mydrugs")
{
$q=mysql_query("SELECT * FROM `drug_collection` WHERE `dc_user` = '$userid'",$c);
if(mysql_num_rows($q) == 0)
{
print "<b>You have no drugs</b><br /><a href='index.php'>Back</a><br />";
} else {
print "<font size=+1>My Drugs</font><br />
To use a drug, you must first hold it to use it.<br />";

$q2=mysql_query("SELECT dc.*,d.* FROM drug_collection dc LEFT JOIN drugs d ON dc.dc_drug=d.drug_id WHERE dc.dc_user='$userid' AND dc.dc_holding='1'",$c);
print "<table width=95% border=1><tr><th>Drug</th><th>Type</th><th>Drug Status</th><th>Holding</th><th>Links</th></tr>";
if(mysql_num_rows($q2) == 0) { print "<tr><td colspan=5>You are not holding any drugs</td></tr>"; }
while($r=mysql_fetch_array($q2))
{
if($r['dc_age'] > 15) { $status="<font color=darkred>Outdated</font>"; } elseif($r['dc_age'] > 6) { $status="<font color=orange>Edible</font>"; } else { $status="<font color=darkred>Fresh</font>"; }
if($r['dc_holding'] == 1) { $hold="<font color=darkgreen>Yes</font>"; } else { $hold="<font color=darkred>No</font>"; }
print "<tr><td>".$r['drug_name']."</td><td>".$r['drug_type']."</td><td>$status</td><td>$hold</td><td><a href='drugfarm.php?action=throw&ID={$r['dc_id']}'>[Throw Away]</a> 
<a href='drugfarm.php?action=unhold&ID={$r['dc_id']}'>[Unhold]</a> <a href='drugfarm.php?action=marketadd&ID={$r['dc_id']}'>[Add to Market]</a> <a href='drugfarm.php?action=usedrug&ID={$r['dc_id']}'>[Use]</a> </td></tr>";
}
print "<tr><td colspan=5><hr /></td></tr>";

$q3=mysql_query("SELECT dc.*,d.* FROM drug_collection dc LEFT JOIN drugs d ON dc.dc_drug=d.drug_id WHERE dc.dc_user='$userid' AND dc.dc_holding='0'",$c);
if(mysql_num_rows($q3) == 0) { print "<tr><td colspan=5>You don't have any drugs stashed.</td></tr>"; }
while($r=mysql_fetch_array($q3))
{
if($r['dc_age'] > 15) { $status="<font color=darkred>Outdated</font>"; } elseif($r['dc_age'] > 6) { $status="<font color=orange>Edible</font>"; } else { $status="<font color=darkgreen>Fresh</font>"; }
if($r['drug_holding'] == 1) { $hold="<font color=darkgreen>Yes</font>"; } else { $hold="<font color=darkred>No</font>"; }
print "<tr><td>".$r['drug_name']."</td><td>".$r['drug_type']."</td><td>$status</td><td>$hold</td><td><a href='drugfarm.php?action=throw&ID={$r['dc_id']}'>[Throw Away]</a> 
<a href='drugfarm.php?action=hold&ID={$r['dc_id']}'>[Hold]</a> <a href='drugfarm.php?action=marketadd&ID={$r['dc_id']}'>[Add to Market]</a></td></tr>";
}

print "</table>";
}
} elseif($_GET['action'] == "unhold" and $_GET['ID'])
{
mysql_query("UPDATE `drug_collection` SET `dc_holding` = '0' WHERE `dc_user` = '$userid' AND `dc_id` = '$_GET[ID]'",$c);
print "You have unholded the drug!<br /><a href='javascript:history.back();'>Back</a><br />";
} elseif($_GET['action'] == "hold" and $_GET['ID'])
{
mysql_query("UPDATE `drug_collection` SET `dc_holding` = '1' WHERE `dc_user` = '$userid' AND `dc_id` = '$_GET[ID]'",$c);
print "You have holded the drug!<br /><a href='javascript:history.back();'>Back</a><br />";
} elseif($_GET['action'] == "throw" and $_GET['ID'])
{
mysql_query("DELETE FROM `drug_collection` WHERE `dc_user` = '$userid' AND `dc_id` = '$_GET[ID]'",$c);
print "You have thrown away the drug!<br /><a href='javascript:history.back();'>Back</a><br />";
} elseif($_GET['action'] == "usedrug" and $_GET['ID'])
{
$q=mysql_query("SELECT dc.*,d.*,u.* FROM drug_collection dc LEFT JOIN drugs d ON dc.dc_drug=d.drug_id LEFT JOIN users u ON dc.dc_user=u.userid WHERE u.userid='{$userid}' AND dc.dc_holding='1' AND dc.dc_id='$_GET[ID]'",$c);
if(mysql_num_rows($q) == 0)
{
print "Invalid Drug";
} else {
$r=mysql_fetch_array($q);
$time=rand(1,$r['drug_rand']);
$hosptime=$r['drug_hospital']+$time/2;
if(eregi('A', $r['drug_type']))
{
$randa[4]=rand(3,30);
if($randa[4] > 25)
{
$hospital=+300;
}
} elseif(eregi('B', $r['drug_type']))
{
$randa[5]=rand(3,30);
if($randa[5] > 25)
{
$hospital=+150;
}
} else {
$randa[6]=rand(3,30);
if($randa[6] > 25)
{
$hospital=+70;
}
}
if($r['dc_age'] > 30)
{
$hosptime=+rand(40,80);
$sx="Poisoned";
}
if($time > $r['drug_rand']/2)
{
$sx="overdosed";
$hosptime=0;
}
$hosptime=str_replace("-", "", $hosptime);
$row=$r['drug_affect'];
$do=$r['drug_act'];
$result=$r['drug_amount'];
if($hosptime > 0)
{
event_add($ir['userid'],"Your drug $sx you so you are in hospital for $hosptime minutes.",$c);
mysql_query("UPDATE `users` SET `hospital` = `hospital` + '$hosptime', `hospreason` = '$sx by the $r[drug_name] drug' WHERE `userid` = '$userid'",$c);
}
mysql_query("UPDATE `users` SET `$row` = `$row` $do '$result' WHERE `userid` = '$userid'",$c);
print "You have taken the <b>$r[drug_name]</b> drug, You don't know what happens now.<br />
<a href='index.php'>Back</a><br />";
}
} elseif($_GET['action'] == "marketadd" and $_GET['ID'])
{
$q=mysql_query("SELECT dc.*,d.*,u.* FROM drug_collection dc LEFT JOIN drugs d ON dc.dc_drug=d.drug_id LEFT JOIN users u ON dc.dc_user=u.userid WHERE u.userid='{$userid}' AND dc.dc_id='$_GET[ID]'",$c);
if(mysql_num_rows($q) == 0)
{
print "Invalid Drug";
} else {
$r=mysql_fetch_array($q);
if((int) $_POST['price'] > 0)
{
if($_POST['price'] > 50000000)
{
print "The maximum you can post it as is \$50,000,000<br /><a href='javascript:history.back();'>Back</a><br />";
} else {
$time=time();
$drug=$r['drug_id'];
$price=$_POST['price'];
if($r['dc_age'] > 15) { $status="<font color=darkred>Outdated</font>"; } elseif($r['dc_age'] > 6) { $status="<font color=orange>Edible</font>"; } else { $status="<font color=green>Fresh</font>"; }
mysql_query("INSERT INTO `drugsmarket` (`dm_id`, `dm_from`, `dm_time`, `dm_drug`, `dm_price`,`dm_type`, `dm_daysleft`) VALUES ('NULL', '$userid', '$time', '$drug', '$price', '$status', '5');",$c);
mysql_query("DELETE FROM `drug_collection` WHERE `dc_id` = '$_GET[ID]'",$c);
print "Your drug has been added!<br />
<a href='drugmarket.php'>Back</a><br />
";
}
} else {
print "<b>Add your drug to the market</b><br />
<font color=maroon>WARNING: Once you stick your item onto the market, You can<b>not</b> remove it, After 5 days it will be deleted</font><br />
<form action='drugfarm.php?action=marketadd&ID={$_GET['ID']}' method='post'>
Price: \$<input type='text' name='price' value=''><br />
<input type='submit' value='Add to Market'>
</form>";
}
}
}
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
?>