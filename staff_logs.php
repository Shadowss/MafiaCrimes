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

include "sglobals.php";
//This contains item stuffs
switch($_GET['action'])
{
case 'atklogs': view_attack_logs(); break;
case 'itmlogs': view_itm_logs(); break;
case 'cashlogs': view_cash_logs(); break;
case 'cryslogs': view_crys_logs(); break;
case 'banklogs': view_bank_logs(); break;
case 'maillogs': view_mail_logs(); break;
case 'stafflogs': view_staff_logs(); break;
case 'resignlog': resigned_log(); break;
default: print "Error: This script requires an action."; break;
}
function resigned_log()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 2)
{
echo("403");
$h->endpage();
exit;
}
$_GET['st']=abs(intval($_GET['st']));
$rpp=100;
print '<h3 style="text-align: left; text-decoration: underline;">Resign Logs</h3>
<table border="1" width="100%" class="table" cellspacing="0" cellpadding="2">
<tr style="text-align:center;">
<th>User</th>
<th>Reason</th>
<th>Time</th>
<th>IP</th>';
$logs=mysql_query("SELECT s.*, u.* FROM resign_log AS s LEFT JOIN users AS u ON s.user=u.userid ORDER BY s.time DESC LIMIT {$_GET['st']},$rpp");
while($r=$db->fetch_row($logs))
{
print "<tr><td><a href='/viewuser.php?u=".$r['userid'].">".$r['username']." [".number_format($r['userid'])."]</a></td> <td>".htmlentities(stripslashes($r['reason']))."</td> <td>".date('F j Y g:i:s a', $r['time'])."</td> <td>".$r['ip']."</td></tr>";
}
print "</table><br />
";
$mypage=floor($_GET['st']/$rpp)+1;
$q2=mysql_query("SELECT id FROM resign_log");
$rs=$db->num_rows($q2);
$pages=ceil($rs/$rpp);
print "Pages: ";
for($i=1;$i<=$pages;$i++)
{
$st=($i-1)*$rpp;
print "<a href='staff_logs.php?action=resignlog&st=$st'>$i</a>&nbsp;";
if($i % 7 == 0) { print "<br />\n"; }
}
}
function view_attack_logs()
{
global $db,$ir,$c,$h,$userid;
print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Attack Logs</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>";
if(!$_GET['st']) { $_GET['st']=0; }
$st=abs((int) $_GET['st']);
$app=100;
$q=$db->query("SELECT attacker FROM attacklogs");
$attacks=$db->num_rows($q);
$pages=ceil($attacks/$app);
print "Pages:&nbsp;";
for($i=1;$i<=$pages;$i++)
{
$s=($i-1)*$app;
if($s==$st) { print "<b>$i</b>&nbsp;"; } else { print "<a href='staff_logs.php?action=atklogs&st=$s'>$i</a>&nbsp;"; }
if($i % 25 == 0) { print "<br />"; }
}
print "<br />
<table width=100% cellspacing=1 class='table'><tr style='background:gray'><th>Time</th><th>Who Attacked</th><th>Who Was Attacked</th><th>Who Won</th><th>What Happened</th></tr>";
$q=$db->query("SELECT a.*,u1.username as un_attacker, u2.username as un_attacked FROM attacklogs a LEFT JOIN users u1 ON a.attacker=u1.userid LEFT JOIN users u2 ON a.attacked=u2.userid ORDER BY a.time DESC LIMIT $st, $app");
while($r=$db->fetch_row($q))
{
print "<tr><td>".date('F j, Y, g:i:s a',$r['time'])."</td><td>{$r['un_attacker']} [{$r['attacker']}]</td> <td>{$r['un_attacked']} [{$r['attacked']}]</td>";
if($r['result'] == "won") { print "<td>{$r['un_attacker']}</td><td>";
if($r['stole'] == -1) { print "{$r['un_attacker']} hospitalized {$r['un_attacked']}"; } else if ($r['stole'] == -2) { print "{$r['un_attacker']} attacked {$r['un_attacked']} and left them"; } else { print "{$r['un_attacker']} mugged \${$r['stole']} from {$r['un_attacked']}"; } print "</td>"; }  else { print "<td>{$r['un_attacked']}</td><td>Nothing</td>"; }
print "</tr>";
}
print "</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div><br />";
print "Pages:&nbsp;";
for($i=1;$i<=$pages;$i++)
{
$s=($i-1)*$app;
if($s==$st) { print "<b>$i</b>&nbsp;"; } else { print "<a href='staff_logs.php?action=atklogs&st=$s'>$i</a>&nbsp;"; }
if($i % 25 == 0) { print "<br />"; }
}
stafflog_add("Looked at the attack logs");
}
function view_itm_logs()
{
global $db,$ir,$c,$h,$userid;
print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Item Xfer Logs</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>";
if(!$_GET['st']) { $_GET['st']=0; }
$st=abs((int) $_GET['st']);
$app=100;
$q=$db->query("SELECT ixFROM FROM itemxferlogs");
$attacks=$db->num_rows($q);
$pages=ceil($attacks/$app);
print "Pages:&nbsp;";
for($i=1;$i<=$pages;$i++)
{
$s=($i-1)*$app;
if($s==$st) { print "<b>$i</b>&nbsp;"; } else { print "<a href='staff_logs.php?action=itmlogs&st=$s'>$i</a>&nbsp;"; }
if($i % 25 == 0) { print "<br />"; }
}
print "<br />
<table width='90%' cellspacing=1 class='table'><tr style='background:gray'><th>Time</th><th>Who Sent</th> <th>Who Received</th> <th>Sender's IP</th> <th>Receiver's IP</th> <th>Same IP?</th> <th>Item</th> </tr>";
$q=$db->query("SELECT ix.*,u1.username as sender, u2.username as sent,i.itmname as item FROM itemxferlogs ix LEFT JOIN users u1 ON ix.ixFROM=u1.userid LEFT JOIN users u2 ON ix.ixTO=u2.userid LEFT JOIN items i ON i.itmid=ix.ixITEM ORDER BY ix.ixTIME DESC LIMIT $st, $app");
while($r=$db->fetch_row($q))
{
if($r['ixFROMIP'] == $r['ixTOIP']) { $same="<font color='red'>YES</font>"; } else { $same="<font color='green'>NO</font>"; }
print "<tr><td>".date('F j Y, g:i:s a', $r['ixTIME'])."</td> <td>{$r['sender']} [{$r['ixFROM']}]</td> <td>{$r['sent']} [{$r['ixTO']}]</td> <td>{$r['ixFROMIP']}</td> <td>{$r['ixTOIP']}</td> <td>$same</td> <td>{$r['item']} x{$r['ixQTY']}</td></tr>";
}
print "</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div><br />";
print "Pages:&nbsp;";
for($i=1;$i<=$pages;$i++)
{
$s=($i-1)*$app;
if($s==$st) { print "<b>$i</b>&nbsp;"; } else { print "<a href='staff_logs.php?action=itmlogs&st=$s'>$i</a>&nbsp;"; }
if($i % 25 == 0) { print "<br />"; }
}
stafflog_add("Looked at the Item Xfer Logs");
}


function view_cash_logs()
{
global $db,$ir,$c,$h,$userid;
print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Cash Xfer Logs</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table width=100% cellspacing='1' class='table'> <tr style='background:gray'> <th>ID</th> <th>Time</th> <th>User From</th> <th>User To</th> <th>Multi?</th> <th>Amount</th> <th>&nbsp;</th> </tr>";
$q=$db->query("SELECT cx.*,u1.username as sender, u2.username as sent FROM cashxferlogs cx LEFT JOIN users u1 ON cx.cxFROM=u1.userid LEFT JOIN users u2 ON cx.cxTO=u2.userid ORDER BY cx.cxTIME DESC");
while($r=$db->fetch_row($q))
{
if($r['cxFROMIP'] == $r['cxTOIP']) { $m="<span style='color:red;font-weight:800'>MULTI</span>"; } else { $m=""; }
print "<tr><td>{$r['cxID']}</td> <td>" . date("F j, Y, g:i:s a",$r['cxTIME']) . "</td><td><a href='viewuser.php?u={$r['cxFROM']}'>{$r['sender']}</a> [{$r['cxFROM']}] (IP: {$r['cxFROMIP']}) </td><td><a href='viewuser.php?u={$r['cxTO']}'>{$r['sent']}</a> [{$r['cxTO']}] (IP: {$r['cxTOIP']}) </td> <td>$m</td> <td> \${$r['cxAMOUNT']}</td> <td> [<a href='staff_punit.php?action=fedform&XID={$r['cxFROM']}'>Jail Sender</a>] [<a href='staff_punit.php?action=fedform&XID={$r['cxTO']}'>Jail Receiver</a>]</td> </tr>";   
}
print "</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
stafflog_add("Viewed the Cash Xfer Logs");
}
function view_bank_logs()
{
global $db,$ir,$c,$h,$userid;
print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Bank Xfer Logs</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


<table width=100% cellspacing='1' class='table'> <tr style='background:gray'> <th>ID</th> <th>Time</th> <th>User From</th> <th>User To</th> <th>Multi?</th> <th>Amount</th> <th>Bank Type</th> <th>&nbsp;</th> </tr>";
$q=$db->query("SELECT cx.*,u1.username as sender, u2.username as sent FROM bankxferlogs cx LEFT JOIN users u1 ON cx.cxFROM=u1.userid LEFT JOIN users u2 ON cx.cxTO=u2.userid ORDER BY cx.cxTIME DESC");
$banks=array(
'bank' => 'City Bank',
'cyber' => 'Cyber Bank');
while($r=$db->fetch_row($q))
{
$mb=$banks[$r['cxBANK']];
if($r['cxFROMIP'] == $r['cxTOIP']) { $m="<span style='color:red;font-weight:800'>MULTI</span>"; } else { $m=""; }
print "<tr><td>{$r['cxID']}</td> <td>" . date("F j, Y, g:i:s a",$r['cxTIME']) . "</td><td><a href='viewuser.php?u={$r['cxFROM']}'>{$r['sender']}</a> [{$r['cxFROM']}] (IP: {$r['cxFROMIP']}) </td><td><a href='viewuser.php?u={$r['cxTO']}'>{$r['sent']}</a> [{$r['cxTO']}] (IP: {$r['cxTOIP']}) </td> <td>$m</td> <td> \${$r['cxAMOUNT']}</td> <td>$mb</td> <td> [<a href='staff_punit.php?action=fedform&XID={$r['cxFROM']}'>Jail Sender</a>] [<a href='staff_punit.php?action=fedform&XID={$r['cxTO']}'>Jail Receiver</a>]</td> </tr>";
}
print "</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
stafflog_add("Viewed the Bank Xfer Logs");
}
function view_crys_logs()
{
global $db,$ir,$c,$h,$userid;
print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Crystal Xfer Logs</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table width=100% cellspacing='1' class='table'> <tr style='background:gray'> <th>ID</th> <th>Time</th> <th>User From</th> <th>User To</th> <th>Multi?</th> <th>Amount</th> <th>&nbsp;</th> </tr>";
$q=$db->query("SELECT cx.*,u1.username as sender, u2.username as sent FROM crystalxferlogs cx LEFT JOIN users u1 ON cx.cxFROM=u1.userid LEFT JOIN users u2 ON cx.cxTO=u2.userid ORDER BY cx.cxTIME DESC");
while($r=$db->fetch_row($q))
{
if($r['cxFROMIP'] == $r['cxTOIP']) { $m="<span style='color:red;font-weight:800'>MULTI</span>"; } else { $m=""; }
print "<tr><td>{$r['cxID']}</td> <td>" . date("F j, Y, g:i:s a",$r['cxTIME']) . "</td><td><a href='viewuser.php?u={$r['cxFROM']}'>{$r['sender']}</a> [{$r['cxFROM']}] (IP: {$r['cxFROMIP']}) </td><td><a href='viewuser.php?u={$r['cxTO']}'>{$r['sent']}</a> [{$r['cxTO']}] (IP: {$r['cxTOIP']}) </td> <td>$m</td> <td> {$r['cxAMOUNT']} crystals</td> <td> [<a href='staff_punit.php?action=fedform&XID={$r['cxFROM']}'>Jail Sender</a>] [<a href='staff_punit.php?action=fedform&XID={$r['cxTO']}'>Jail Receiver</a>]</td> </tr>";
}
print "</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
stafflog_add("Viewed the Crystal Xfer Logs");
}
function view_mail_logs()
{
global $db,$ir,$c,$h,$userid;
$_GET['st']=abs((int) $_GET['st']);
$rpp=100;

print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Mail Logs</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table width=75% cellspacing='1' class='table'> \n<tr style='background:gray'> <th>ID</th> <th>Time</th> <th>User From</th> <th>User To</th> <th width>Subj</th> <th width=30%>Msg</th> <th>&nbsp;</th> </tr>";
$q=$db->query("SELECT m.*,u1.username as sender, u2.username as sent FROM mail m LEFT JOIN users u1 ON m.mail_from=u1.userid LEFT JOIN users u2 ON m.mail_to=u2.userid WHERE m.mail_from != 0 ORDER BY m.mail_time DESC LIMIT {$_GET['st']},$rpp");
while($r=$db->fetch_row($q))
{
print "\n<tr><td>{$r['mail_id']}</td> <td>" . date("F j, Y, g:i:s a",$r['mail_time']) . "</td><td>{$r['sender']} [{$r['mail_from']}] </td> <td>{$r['sent']} [{$r['mail_to']}] </td> \n<td> {$r['mail_subject']}</td> \n<td>{$r['mail_text']}</td> <td> [<a href='staff_punit.php?action=mailform&XID={$r['mail_from']}'>MailBan Sender</a>] [<a href='staff_punit.php?action=mailform&XID={$r['mail_to']}'>MailBan Receiver</a>]</td> </tr>";
}
print "</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div><br />
";
$mypage=floor($_GET['st']/$rpp)+1;
$q2=$db->query("SELECT mail_id FROM mail WHERE mail_from != 0");
$rs=$db->num_rows($q2);
$pages=ceil($rs/$rpp);
print "Pages: ";
for($i=1;$i<=$pages;$i++)
{
$st=($i-1)*$rpp;
print "<a href='staff_logs.php?action=maillogs&st=$st'>$i</a>&nbsp;";
if($i % 7 == 0) { print "<br />\n"; }
}
stafflog_add("Viewed the Mail Logs (Page $mypage)");
}
function view_staff_logs()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 2)
{
die("403");
}
$_GET['st']=abs((int) $_GET['st']);
$rpp=100;

print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Staff Logs</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


<table width=100% cellspacing='1' class='table'> \n<tr style='background:gray'> <th>Staff</th> <th>Action</th> <th>Time</th> <th>IP</th> </tr>";
$q=$db->query("SELECT s.*, u.* FROM stafflog AS s LEFT JOIN users AS u ON s.user=u.userid ORDER BY s.time DESC LIMIT {$_GET['st']},$rpp");
while($r=$db->fetch_row($q))
{
print "<tr><td>{$r['username']} [{$r['user']}]</td> <td>{$r['action']}</td> <td>".date('F j Y g:i:s a', $r['time'])."</td> <td>{$r['ip']}</td></tr>";
}
print "</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div><br />
";
$mypage=floor($_GET['st']/$rpp)+1;
$q2=$db->query("SELECT id FROM stafflog");
$rs=$db->num_rows($q2);
$pages=ceil($rs/$rpp);
print "Pages: ";
for($i=1;$i<=$pages;$i++)
{
$st=($i-1)*$rpp;
print "<a href='staff_logs.php?action=stafflogs&st=$st'>$i</a>&nbsp;";
if($i % 7 == 0) { print "<br />\n"; }
}
}
function report_clear()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 3)
{
die("403");
}
$_GET['ID'] = abs((int) $_GET['ID']);
stafflog_add("Cleared player report ID {$_GET['ID']}");
$db->query("DELETE FROM preports WHERE prID={$_GET['ID']}");
print "Report cleared and deleted!<br />
<a href='staff_users.php?action=reportsview'>&gt; Back</a>";
}
$h->endpage();
?>
