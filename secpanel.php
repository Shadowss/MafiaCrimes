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
if($ir['user_level'] != 2 && $ir['user_level'] != 3)
{
print "You sneak, get out of here!";
$h->endpage();
exit;
}
$posta=mysql_real_escape_string(print_r($_POST,1),$c);
$geta=mysql_real_escape_string(print_r($_GET,1),$c);
mysql_query("INSERT INTO seclogs VALUES('', $userid, '$posta', '$geta', unix_timestamp() )",$c);
switch($_GET['action'])
{
case 'giveitem': give_item_form(); break;
case 'giveitemsub': give_item_submit(); break;
case 'fedform': fed_user_form(); break;
case 'fedsub': fed_user_submit(); break;
case 'unfedform': unfed_user_form(); break;
case 'unfedsub': unfed_user_submit(); break;
case 'mailform': mail_user_form(); break;
case 'mailsub': mail_user_submit(); break;
case 'atklogs': view_attack_logs(); break;
case 'index': admin_index(); break;
case 'invbeg': inv_user_begin(); break;
case 'invuser': inv_user_view(); break;
case 'deleinv': inv_delete(); break;
case 'creditform': credit_user_form(); break;
case 'creditsub': credit_user_submit(); break;
case 'ipform': ip_search_form(); break;
case 'ipsub': ip_search_submit(); break;
case 'massjailip': mass_jail(); break;
case 'itmlogs': view_itm_logs(); break;
case 'cashlogs': view_cash_logs(); break;
case 'maillogs': view_mail_logs(); break;
case 'reportsview': reports_view(); break;
case 'repclear': report_clear(); break;
default: admin_index(); break;
}
function admin_index()
{
global $ir,$c;
print "Welcome to the Game Site secretary panel, {$ir['username']}!<br />
<h3><font color=red>Secretary Warning: Any sec who uses their powers without reason will be fired. No second chances.</font></h3><br />
<b>News from the Admins:</b> <br />";
include "admin.news";
print "<u>Users</u><br />
[<a href='secpanel.php?action=fedform'>Jail User</a>]<br />
[<a href='secpanel.php?action=unfedform'>Unjail User</a>]<br />
[<a href='secpanel.php?action=mailform'>Mail Ban User</a>]<br />
[<a href='secpanel.php?action=invbeg'>View User Inventory</a>]<br />
[<a href='secpanel.php?action=creditform'>Credit User Money/Crystals</a>]<br /> 
[<a href='secpanel.php?action=ipform'>Ip Search</a>]<br />
[<a href='secpanel.php?action=reportsview'>Player Reports</a>]<br />
<br />
<u>Items</u><br />
[<a href='secpanel.php?action=giveitem'>Give Item To User</a>]<br />
<br />
<u>Logs</u><br />
[<a href='secpanel.php?action=atklogs'>Attack Logs</a>]<br />
[<a href='secpanel.php?action=cashlogs'>Cash Xfer Logs</a>]<br />
[<a href='secpanel.php?action=itmlogs'>Item Xfer Logs</a>]<br />
[<a href='secpanel.php?action=maillogs'>Mail Logs</a>]";
}
function give_item_form()
{
global $ir,$c;
print "<h3>Giving Item To User</h3>
<form action='secpanel.php?action=giveitemsub' method='post'>
User: ".user_dropdown($c,'user')."<br />
Item: ".item_dropdown($c,'item')."<br />
Quantity: <input type='text' STYLE='color: black;  background-color: white;' name='qty' value='1' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Give Item' /></form>";
}
function give_item_submit()
{
global $ir,$c;
mysql_query("INSERT INTO inventory VALUES('',{$_POST['item']},{$_POST['user']},{$_POST['qty']})",$c) or die(mysql_error());
print "You gave {$_POST['qty']} of item ID {$_POST['item']} to user ID {$_POST['user']}";
}
function fed_user_form()
{
global $ir,$c,$h,$userid;
print "<h3>Jailing User</h3>
The user will be put in fed jail and will be unable to do anything in the game.<br />
<form action='secpanel.php?action=fedsub' method='post'>
User: ".user_dropdown($c,'user',$_GET['XID'])."<br />
Days: <input type='text' STYLE='color: black;  background-color: white;' name='days' /><br />
Reason: <input type='text' STYLE='color: black;  background-color: white;' name='reason' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Jail User' /></form>";
}
function fed_user_submit()
{
global $ir,$c,$h,$userid;
$q=mysql_query("SELECT * FROM users WHERE userid={$_POST['user']}", $c);
$r=mysql_fetch_array($q);
if($r['user_level'] == 2|| $r['user_level'] ==3)
{
print "You cannot jail other staff.";
}
else
{
$re=mysql_query("UPDATE users SET fedjail=1 WHERE userid={$_POST['user']}",$c);
if(mysql_affected_rows($c))
{
mysql_query("INSERT INTO fedjail VALUES('',{$_POST['user']},{$_POST['days']},$userid,'".
mysql_real_escape_string($_POST['reason'],$c)."')",$c);
}
mysql_query("INSERT INTO jaillogs VALUES('',$userid, {$_POST['user']}, {$_POST['days']}, '{$_POST['reason']}',unix_timestamp())",$c);
print "User jailed.";
}
}
function unfed_user_form()
{
global $ir,$c,$h,$userid;
print "<h3>Unjailing User</h3>
The user will be taken out of fed jail.<br />
<form action='secpanel.php?action=unfedsub' method='post'>
User: ".fed_user_dropdown($c,'user')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Unjail User' /></form>";
}
function unfed_user_submit()
{
global $ir,$c,$h,$userid;
mysql_query("UPDATE users SET fedjail=0 WHERE userid={$_POST['user']}",$c);
mysql_query("DELETE FROM fedjail WHERE fed_userid={$_POST['user']}",$c);
mysql_query("INSERT INTO unjaillogs VALUES('',$userid, {$_POST['user']}, unix_timestamp())",$c);
print "User unjailed.";
}
function mail_user_form()
{
global $ir,$c,$h,$userid;
print "<h3>Mail Banning User</h3>
The user will be banned from the mail system.<br />
<form action='secpanel.php?action=mailsub' method='post'>
User: ".user_dropdown($c,'user',$_GET['ID'])."<br />
Days: <input type='text' STYLE='color: black;  background-color: white;' name='days' /><br />
Reason: <input type='text' STYLE='color: black;  background-color: white;' name='reason' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Mailban User' /></form>";
}
function mail_user_submit()
{
global $ir,$c,$h,$userid;
$re=mysql_query("UPDATE users SET mailban={$_POST['days']},mb_reason='{$_POST['reason']}' WHERE userid={$_POST['user']}",$c);
event_add($_POST['user'],"You were banned from mail for {$_POST['days']} day(s) for the following reason: {$_POST['reason']}",$c);
print "User mail banned.";
}
function view_attack_logs()
{
global $ir,$c,$h,$userid;
print "<h3>Attack Logs</h3>
<table width=75%><tr style='background:gray'><th>Time</th><th>Detail</th></tr>";
$q=mysql_query("SELECT * FROM attacklogs ORDER BY time DESC",$c);
while($r=mysql_fetch_array($q))
{
print "<tr><td>".date('F j, Y, g:i:s a',$r['time'])."</td><td>{$r['attacker']} attacked {$r['attacked']} and {$r['result']}</td></tr>";
}
print "</table>";
}
function inv_user_begin()
{
global $ir,$c,$h,$userid;
print "<h3>Viewing User Inventory</h3>
You may browse this user's inventory.<br />
<form action='secpanel.php?action=invuser' method='post'>
User: ".user_dropdown($c,'user')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='View Inventory' /></form>";
}
function inv_user_view()
{
global $ir,$c,$h,$userid;
$inv=mysql_query("SELECT iv.*,i.*,it.* FROM inventory iv LEFT JOIN items i ON iv.inv_itemid=i.itmid LEFT JOIN itemtypes it ON i.itmtype=it.itmtypeid WHERE iv.inv_userid={$_POST['user']}",$c);
if (mysql_num_rows($inv) == 0)
{
print "<b>This person has no items!</b>";
}
else
{
print "<b>Their items are listed below.</b><br />
<table width=100%><tr style='background-color:gray;'><th>Item</th><th>Sell Value</th><th>Total Sell Value</th><th>Links</th></tr>";
while($i=mysql_fetch_array($inv))
{
print "<tr><td>{$i['itmname']}";
if ($i['inv_qty'] > 1)
{
print "&nbsp;x{$i['inv_qty']}";
}
print "</td><td>\${$i['itmsellprice']}</td><td>";
print "$".($i['itmsellprice']*$i['inv_qty']);
print "</td><td>[<a href='secpanel.php?action=deleinv&ID={$i['inv_id']}'>Delete</a>]";
print "</td></tr>";
}
print "</table>";
}
}
function inv_delete()
{
global $ir,$c,$h,$userid;
mysql_query("DELETE FROM inventory WHERE inv_id={$_GET['ID']}",$c);
print "Item deleted from inventory.";
}
function credit_user_form()
{
global $ir,$c,$h,$userid;
print "<h3>Crediting User</h3>
You can give a user money/crystals.<br />
<form action='secpanel.php?action=creditsub' method='post'>
User: ".user_dropdown($c,'user')."<br />
Money: <input type='text' STYLE='color: black;  background-color: white;' name='money' /> Crystals: <input type='text' STYLE='color: black;  background-color: white;' name='crystals' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Credit User' /></form>";
}
function credit_user_submit()
{
global $ir,$c,$h,$userid;
$_POST['money'] = (int) $_POST['money'];
$_POST['crystals'] = (int) $_POST['crystals'];
mysql_query("UPDATE users u SET money=money+{$_POST['money']}, crystals=crystals+{$_POST['crystals']} WHERE u.userid={$_POST['user']}",$c);
print "User credited.";
}
function ip_search_form()
{
global $ir,$c,$h,$userid;
print "<h3>IP Search</h3>
<form action='secpanel.php?action=ipsub' method='post'>
IP: <input type='text' STYLE='color: black;  background-color: white;' name='ip' value='...' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Search' /></form>";
}
function ip_search_submit()
{
global $ir,$c,$h,$userid;
print "Searching for users with the IP: <b>{$_POST['ip']}</b><br />
<table width=75%><tr style='background:gray'> <th>User</th> <th>Level</th> <th>Money</th> </tr>";
$q=mysql_query("SELECT * FROM users WHERE lastip='{$_POST['ip']}'",$c);
$ids=array();
while($r=mysql_fetch_array($q))
{
$ids[]=$r['userid'];
print "\n<tr> <td> <a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a></td> <td> {$r['level']}</td> <td>{$r['money']}</td> </tr>";
}
print "</table><br />
<b>Mass Jail</b><br />
<form action='secpanel.php?action=massjailip' method='post'>
<input type='hidden' name='ids' value='".implode(",",$ids)."' /> Days: <input type='text' STYLE='color: black;  background-color: white;' name='days' value='300' /> <br />
Reason: <input type='text' STYLE='color: black;  background-color: white;' name='reason' value='Same IP users, Mail admin@mysite.com with your case.' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Mass Jail' /></form>";
}
function mass_jail()
{
global $ir,$c,$h,$userid;
$ids=explode(",",$_POST['ids']);
foreach($ids as $id)
{
$q=mysql_query("SELECT * FROM users WHERE userid=$id", $c);
$r=mysql_fetch_array($q);
if($r['user_level'] == 2|| $r['user_level'] ==3)
{
print "You cannot jail other staff.";
}
else
{
$re=mysql_query("UPDATE users SET fedjail=1 WHERE userid={$id}",$c);
if(mysql_affected_rows($c))
{
mysql_query("INSERT INTO fedjail VALUES('',{$id},{$_POST['days']},$userid,'".
mysql_real_escape_string($_POST['reason'],$c)."')",$c);
}
mysql_query("INSERT INTO jaillogs VALUES('',$userid, {$id}, {$_POST['days']}, '{$_POST['reason']}',unix_timestamp())",$c);
print "User jailed : $id.";
}
}
}
function view_itm_logs()
{
global $ir,$c,$h,$userid;
print "<h3>Item Xfer Logs</h3>
<table width=75%><tr style='background:gray'><th>Time</th><th>Detail</th></tr>";
$q=mysql_query("SELECT ix.*,u1.username as sender, u2.username as sent,i.itmname as item FROM itemxferlogs ix LEFT JOIN users u1 ON ix.ixFROM=u1.userid LEFT JOIN users u2 ON ix.ixTO=u2.userid LEFT JOIN items i ON i.itmid=ix.ixITEM ORDER BY ix.ixTIME DESC",$c);
while($r=mysql_fetch_array($q))
{
print "<tr><td>" . date("F j, Y, g:i:s a",$r['ixTIME']) . "</td><td>{$r['sender']} sent {$r['ixQTY']}  {$r['item']}(s) to {$r['sent']} </td></tr>";
}
print "</table>";
}
function view_cash_logs()
{
global $ir,$c,$h,$userid;
print "<h3>Cash Xfer Logs</h3>
<table width=75% border=1> <tr style='background:gray'> <th>ID</th> <th>Time</th> <th>User From</th> <th>User To</th> <th>Multi?</th> <th>Amount</th> <th>&nbsp;</th> </tr>";
$q=mysql_query("SELECT cx.*,u1.username as sender, u2.username as sent FROM cashxferlogs cx LEFT JOIN users u1 ON cx.cxFROM=u1.userid LEFT JOIN users u2 ON cx.cxTO=u2.userid ORDER BY cx.cxTIME DESC",$c) or die(mysql_error()."<br />"."SELECT cx.*,u1.username as sender, u2.username as sent FROM cashxferlogs cx LEFT JOIN users u1 ON cx.cxFROM=u1.userid LEFT JOIN users u2 ON cx.cxTO=u2.userid ORDER BY cx.cxTIME DESC");
while($r=mysql_fetch_array($q))
{
if($r['cxFROMIP'] == $r['cxTOIP']) { $m="<span style='color:red;font-weight:800'>MULTI</span>"; } else { $m=""; }
print "<tr><td>{$r['cxID']}</td> <td>" . date("F j, Y, g:i:s a",$r['cxTIME']) . "</td><td><a href='viewuser.php?u={$r['cxFROM']}'>{$r['sender']}</a> [{$r['cxFROM']}] (IP: {$r['cxFROMIP']}) </td><td><a href='viewuser.php?u={$r['cxTO']}'>{$r['sent']}</a> [{$r['cxTO']}] (IP: {$r['cxTOIP']}) </td> <td>$m</td> <td> \${$r['cxAMOUNT']}</td> <td> [<a href='secpanel.php?action=fedform&XID={$r['cxFROM']}'>Jail Sender</a>] [<a href='secpanel.php?action=fedform&XID={$r['cxTO']}'>Jail Receiver</a>]</td> </tr>";
}
print "</table>";
}
function view_mail_logs()
{
global $ir,$c,$h,$userid;
$_GET['st']=abs((int) $_GET['st']);
$rpp=100;
print "<h3>Mail Logs</h3>
<table width=75% border=2> \n<tr style='background:gray'> <th>ID</th> <th>Time</th> <th>User From</th> <th>User To</th> <th width>Subj</th> <th width=30%>Msg</th> <th>&nbsp;</th> </tr>";
$q=mysql_query("SELECT m.*,u1.username as sender, u2.username as sent FROM mail m LEFT JOIN users u1 ON m.mail_from=u1.userid LEFT JOIN users u2 ON m.mail_to=u2.userid WHERE m.mail_from != 0 ORDER BY m.mail_time DESC LIMIT {$_GET['st']},$rpp",$c) or die(mysql_error()."<br />"."SELECT cx.*,u1.username as sender, u2.username as sent FROM cashxferlogs cx LEFT JOIN users u1 ON cx.cxFROM=u1.userid LEFT JOIN users u2 ON cx.cxTO=u2.userid ORDER BY cx.cxTIME DESC LIMIT {$_GET['st']},$rpp");
while($r=mysql_fetch_array($q))
{
print "\n<tr><td>{$r['mail_id']}</td> <td>" . date("F j, Y, g:i:s a",$r['mail_time']) . "</td><td>{$r['sender']} [{$r['mail_from']}] </td> <td>{$r['sent']} [{$r['mail_to']}] </td> \n<td> {$r['mail_subject']}</td> \n<td>{$r['mail_text']}</td> <td> [<a href='secpanel.php?action=fedform&XID={$r['mail_from']}'>Jail Sender</a>] [<a href='secpanel.php?action=fedform&XID={$r['mail_to']}'>Jail Receiver</a>]</td> </tr>";
}
print "</table><br />
";
$q2=mysql_query("SELECT mail_id FROM mail WHERE mail_from != 0",$c);
$rs=mysql_num_rows($q2);
$pages=ceil($rs/20);
print "Pages: ";
for($i=1;$i<=$pages;$i++)
{
$st=($i-1)*20;
print "<a href='secpanel.php?action=maillogs&st=$st'>$i</a>&nbsp;";
if($i % 7 == 0) { print "<br />\n"; }
}
}
function reports_view()
{
global $ir,$c,$h,$userid;
print "<h3>Player Reports</h3>
<table width=80%><tr style='background:gray'><th>Reporter</th> <th>Offender</th> <th>What they did</th> <th>&nbsp;</th> </tr>";
$q=mysql_query("SELECT pr.*,u1.username as reporter, u2.username as offender FROM preports pr LEFT JOIN users u1 ON u1.userid=pr.prREPORTER LEFT JOIN users u2 ON u2.userid=pr.prREPORTED ORDER BY pr.prID DESC",$c) or die(mysql_error());
while($r=mysql_fetch_array($q))
{
print "\n<tr> <td><a href='viewuser.php?u={$r['prREPORTER']}'>{$r['reporter']}</a> [{$r['prREPORTER']}]</td> <td><a href='viewuser.php?u={$r['prREPORTED']}'>{$r['offender']}</a> [{$r['prREPORTED']}]</td> <td>{$r['prTEXT']}</td> <td><a href='secpanel.php?action=repclear&ID={$r['prID']}'>Clear</a></td> </tr>";
}
print "</table>";
}
function report_clear()
{
global $ir,$c,$h,$userid;
$_GET['ID'] = abs((int) $_GET['ID']);
mysql_query("DELETE FROM preports WHERE prID={$_GET['ID']}",$c);
print "Report cleared and deleted!<br />
<a href='secpanel.php?action=reportsview'>&gt; Back</a>";
}
$h->endpage();
?>
