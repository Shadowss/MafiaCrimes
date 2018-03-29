<?php
/*-----------------------------------------------------
-- Advanced Drugs Mod v2
-- Coded by Oxidati0n
-- Copyright 2007 NickMedia
-- Nicholas - oxidati0n.info Productions
DRUGMANAGER.php
-----------------------------------------------------*/
include "globals.php";
print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
	<div class='generalinfo_simple'>");

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

if($ir['user_level'] != 2)
{
die("You are not admin, Get lost.");
} else {
if(!$_GET['action'])
{
print "<h3>Drug Manager</h3><br />
This provides you with links to manage and modify your drugs<br />
<a href='drugmanager.php?action=newdrug'>Create New Drug</a><br />
<a href='drugmanager.php?action=deldrug'>Remove Drug</a><br />";
} elseif($_GET['action'] == "newdrug")
{
if($_POST['drug_name'] and $_POST['drug_description'] and $_POST['drug_type'] and $_POST['drug_affect'] and 
$_POST['drug_act'] and $_POST['drug_amount'] and $_POST['drug_timetake'] and $_POST['drug_rand'] and
$_POST['drug_growdays'] and $_POST['drug_premadeprice'] and $_POST['drug_hospital'])
{
if($_POST['drug_available']) { $drug_available=1; } else { $drug_available=0; }
mysql_query("INSERT INTO `drugs` (`drug_id`, `drug_type`, `drug_name`, `drug_description`, `drug_affect`, `drug_act`, `drug_amount`, `drug_timetake`, 
`drug_rand`, `drug_growdays`, `drug_premadeprice`, `drug_available`, `drug_hospital`) VALUES ('NULL', '$_POST[drug_type]', '
$_POST[drug_name]', '$_POST[drug_description]', '$_POST[drug_affect]', '$_POST[drug_act]', '$_POST[drug_amount]', '$_POST[drug_timetake]',
 '$_POST[drug_rand]', '$_POST[drug_growdays]', '$_POST[drug_premadeprice]', '$drug_available', '$_POST[drug_hospital]');",$c);
print "You have made the <b>$_POST[drug_name]</b> drug!<br />
<a href='drugmanager.php'>Back</a><br />";
} else {
print "<b>Create new drug..</b><br />
<form action='drugmanager.php?action=newdrug' method='post'>
<table width=90% border=1><tr><th colspan=2>
<font size=+1>Main Details</font></th></tr>
<tr><th>Drug Name: </th><td><input type='text' name='drug_name'></td></tr>
<tr><th>Drug Description: </th><td><textarea name='drug_description' cols='30' rows='9'></textarea></td></tr>
<tr><th>Drug Class: </th><td><select name='drug_type'><option value='Class C'>Class C</option><option value='Class B'>
Class B</option><option value='Class A'>Class A</option></select></td></tr>
<tr><td colspan=2><hr width=40% /></td></tr>
<tr><th colspan=2><font size=+1>Affects</font></th></tr>

<tr><th>Drug affect: </th><td><select name='drug_affect'><option value='brave'>Brave</option><option value='will'>Will</option><option value='life'>Life</option>
<option readonly>STATS</option>
<option value='strength'>Strength</option><option value='agility'>Agility</option><option value='guard'>Guard</option><option value='labour'>Labour</option>
<option value='iq'>IQ</option></select></td></tr>
<tr><th>Drug Act: </th><td><select name='drug_act'><option value='+'>+ / Up</option><option value='-'>- / Down</option></select></td></tr>
<tr><th>Drug Amount: </th><td><input type='text' name='drug_amount'></td></tr>
<tr><th>Drug Process (how long they are in a Comer for): </th><td><input type='text' name='drug_timetake'></td></tr>
<tr><th>Drug Percent (affectness) (must be over 10): </th><td><input type='text' name='drug_rand' value='10' maxlength='8'></td></tr>
<tr><th>How long it takes to grow: </th><td><input type='text' name='drug_growdays'></td></tr>
<tr><th>Drug Premade Price: </th><td><input type='text' name='drug_premadeprice'></td></tr>
<tr><th>Drug Available: </th><td><input type='checkbox' name='drug_available' value='1'></td></tr>
<tr><th>Drug Hospital Time: </th><td><input type='text' name='drug_hospital'></td></tr>
<tr><td colspan=2><input type=submit value='Create Drug'></td></tr>
</form></table>
";
}
} elseif($_GET['action'] == "deldrug")
{
if($_POST['drug'])
{
mysql_query("DELETE FROM `drugs` WHERE `drug_id` = '$_POST[drug]'",$c);
print "Drug Removed!<br />
<a href='drugmanager.php'>Back</a><br />";
} else {
print "<b>Remove a drug</b><br />
<form action='drugmanager.php?action=deldrug' method='post'>
Drug: ".drug_dropdown($c)."<br />
<input type=submit value='Delete Drug'></form>";
}
} else {
print "You have a invalid command!<br />
Ask this feature to be made by Oxidati0n or Silver.. The creators :P";
}
}
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
?>