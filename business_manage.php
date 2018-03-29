<?php
include_once (DIRNAME(__FILE__). '/globals.php');
global $db,$ir;
$fetch_business = $db->query(sprintf("SELECT * FROM `businesses` LEFT JOIN `businesses_classes` ON (`classId` = `busClass`) WHERE (`busDirector` = '%u')", $ir['userid']));
if(!$db->num_rows($fetch_business))
{
echo 'You do not own a Company right now!';
$h->endpage();
exit;
}
else
{
$inf = $db->fetch_row($fetch_business);
}
switch ($_GET['p'])
{
case 'new_name': new_business_name(); break;
case 'new_banner': new_business_banner(); break;
case 'new_rank': edit_member_rank(); break;
case 'new_salary': edit_member_salary(); break;
case 'view_vault': view_vault(); break;
case 'donate_cash': donate_cash(); break;
case 'new_Director': new_Director(); break; 
case 'withdraw_mula': withdraw_mula(); break;
case 'debt': sort_debt(); break;
case 'bankrupt': bankrupt_business(); break;
case 'credit_member': credit_member(); break;
case 'view_apps': manage_applications(); break;
case 'kick_out': kick_member(); break;
case 'upgrade': upgrade_business(); break;
case 'change_desc': change_description(); break;
case 'secupgrade': secure_business(); break;
default: business_index(); break;
}
function business_index()
{
global $ir, $inf, $db;

if($inf['busDebt'])
{
echo 'This Company is in debt of \$'.number_format($inf['busDebt']).' right now. Click <a href="business_manage.php?p=debt">here</a> to sort it out.<br />
To bankrupt and close down the Company, click <a href="business_manage.php?p=bankrupt">here</a> to complete proceedings.';
}
else
{

echo '


<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Manage Company</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


<table width="300" class=table bgcolor="black" border="2">
<tr>
<td colspan="100%"><center>
<b>Manage Your Company:</b></center></td></tr>
<tr><td><a href="business_manage.php?p=new_name">Edit Company name</a></td>
<td><a href="business_manage.php?p=change_desc">Edit description</a></td></tr>
<tr><td><a href="business_manage.php?p=new_banner">Change company banner</a></td>
<td><a href="business_manage.php?p=credit_member">Credit cash to employee</a></td></tr>
<td><a href="business_manage.php?p=view_apps">Manage applications</a></td>
<td><a href="business_manage.php?p=new_rank">Edit employees rank</a></td></tr>
<td><a href="business_manage.php?p=upgrade">Upgrade The Company size</a></td>
<td><a href="business_manage.php?p=new_salary">Change employee salary</a></td></tr>
<td><a href="business_manage.php?p=kick_out">Kick employee out</a><br /></td>
<td><a href="business_manage.php?p=view_vault">View company vault</a></td></tr>
<td><a href="business_manage.php?p=bankrupt">Bankrupt the Company</a></td>
<td><a href="business_manage.php?p=secupgrade">Increase Security</a> 
</td>
</tr>
</table> <br/>

<table class=table><tr>
<th><a href="business_manage.php?p=new_Director">Change Director of the business</a><br /></th></tr></table>

</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
}
function new_business_name()
{
global $ir, $inf, $db;
$_POST['name'] = $db->escape(stripslashes($_POST['name']));
if(!$_POST['name'])
{
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Edit Company Name</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


<form action="business_manage.php?p=new_name" method="post">
<p align="center">
<b>You are changing the Company name of the '.stripslashes($inf['busName']).' Company.</b><br />
Please enter a new name in the input box below and click \'Change name\' to submit the new name.<br /><br />
<input type="text" name="name" /><br /><br />
<input type="submit" value="Change name" />
</p>
</form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
else
{
$check = $db->query(sprintf("SELECT * FROM `businesses` WHERE (`busName` = '%s')", $_POST['name']));
if(!$db->num_rows($check))
{
$db->query(sprintf("UPDATE `businesses` SET `busName` = '%s' WHERE `busId` = '%u'", $_POST['name'], $inf['busId']));
echo 'The Company name was changed to '.$_POST['name'].'!';
business_alert($inf['busId'], "The Company name was changed to ".$_POST['name'].".");
}
else
{
echo 'Sorry this Company name is in use at this time.';
}
}
}
function new_business_banner()
{
global $ir, $inf, $db;

if(!$_POST['banner'])
{
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Edit Banner</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


<form action="business_manage.php?p=new_banner" method="post">
<p align="center">
<b>You are changing the banner of the '.stripslashes($inf['busName']).' Company.</b><br />
Please enter a new banner image location in the input box below and click \'Change banner\' to submit the new image.<br /><br />
<b>Current image:</b> <br /> <br /> ';

if($inf['busImage'])
{
echo '<img src="'.stripslashes($inf['busImage']).'" alt="'.stripslashes($inf['busName']).' banner" width="400" height="100" />';
}
else
{
echo '<img src="images/nobusbanner.png " width="400" height="100"/>';
}
echo '<br /><br />
New image URL: <input type="text" name="banner" size="50" /><br /><br />
<input type="submit" value="Change banner" />
</p>
</form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}

else {
   if(!preg_match('~(.?).(jpg|jpeg|gif|png)~i', $_POST['banner'])) {
   print "You are trying to upload an invalid image";
   } 
   else {
    $_POST['banner'] = str_replace(array("<", ">", "'", ";", ".php", ".html", ".js"), array("", "", "", "", "", "", ""), $_POST['banner']);
$db->query(sprintf("UPDATE `businesses` SET `busImage` = '%s' WHERE `busId` = '%u'", stripslashes($_POST['banner']), $inf['busId']));
echo 'The Company banner was updated.';
business_alert($inf['busId'], "The Company banner has been updated.");
}
}
}
function edit_member_rank()
{
global $ir, $inf, $db;

$_POST['member'] = abs(@intval($_POST['member']));   
$_POST['rank'] = abs(@intval($_POST['rank']));
if(!$_POST['member'] || !$_POST['rank'])
{
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Edit Employees Rank</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

<form action="business_manage.php?p=new_rank" method="post">
<p align="center">
<b>Set the Company rank:</b><br /><br />
Company employee: <select name="member">
<option value="0">None</option>';
$select_members = $db->query(sprintf("SELECT * FROM `businesses_members` LEFT JOIN `users` ON (`userid` = `bmembMember`) WHERE (`bmembBusiness` = '%u') ORDER BY `bmembId` ASC", $inf['busId']));
while($sm = $db->fetch_row($select_members))
{
echo '<option value="'.$sm['userid'].'">'.stripslashes($sm['username']).'</option>';
}
echo '</select><br />
Company rank: <select name="rank">
<option value="0">None</option>';
$select_ranks = $db->query(sprintf("SELECT * FROM `businesses_ranks` WHERE (`rankClass` = '%u') ORDER BY `rankId` ASC", $inf['classId']));
while($sr = $db->fetch_row($select_ranks))
{
echo '<option value="'.$sr['rankId'].'">'.stripslashes($sr['rankName']).'</option>';
}
echo '</select><br /><br />
<input type="submit" value="Change rank" /></p>
</form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
else
{
$select_member = $db->query(sprintf("SELECT * FROM `businesses_members` WHERE (`bmembMember` = '%u') AND (`bmembBusiness` = '%u')", $_POST['member'], $inf['busId']));

if(!$db->num_rows($select_member))
{
echo 'You cannot edit the rank of this employee.';
}
else
{
$select_cash = $db->query(sprintf("SELECT * FROM `businesses_ranks` WHERE (`rankId` = '%u')", $_POST['rank']));
$realname = $db->query(sprintf("SELECT * FROM `users` WHERE (`userid` = '%u')", $_POST['member']));
$sc = $db->fetch_row($select_cash);
$thename = $db->fetch_row($realname);
$realrank = $db->query(sprintf("SELECT * FROM `businesses_ranks` WHERE (`rankId` = '%u')", $_POST['rank']));
$rname = $db->fetch_row($realrank);
echo 'This member\'s rank was updated.';
$db->query(sprintf("UPDATE `businesses_members` SET `bmembRank` = '%d', `bmembCash` = '%d' WHERE (`bmembMember` = '%u')", $_POST['rank'], $sc['rankCash'], $_POST['member']));
business_alert($inf['busId'], " ".$thename['username']."\'s rank was changed to ".$rname['rankName'].".");
}
}
}
function edit_member_salary()
{
global $ir, $inf, $db;
$_POST['member'] = abs(@intval($_POST['member']));
$_POST['salary'] = abs(@intval($_POST['salary']));

if(!$_POST['member'] || !$_POST['salary'])
{
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Edit Employees Salary</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

<form action="business_manage.php?p=new_salary" method="post">
<p align="center">
<b>Set the new Company salary:</b><br /><br />
Company employee: <select name="member">
<option value="0">None</option>';
$select_members = $db->query(sprintf("SELECT * FROM `businesses_members` LEFT JOIN `users` ON (`userid` = `bmembMember`) WHERE (`bmembBusiness` = '%u') ORDER BY `bmembId` ASC", $inf['busId']));
while($sm = $db->fetch_row($select_members))
{
echo '<option value="'.$sm['userid'].'">'.stripslashes($sm['username']).'</option>';
}
echo '</select><br />
Salary amount: <input type="text" name="salary" size="8" maxlength="6" /><br /><br />
<input type="submit" value="Change salary" /></p>
</form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
else
{
$select_member = $db->query(sprintf("SELECT * FROM `businesses_members` WHERE (`bmembMember` = %u) AND (`bmembBusiness` = %u)", $_POST['member'], $inf['busId']));

if(!$db->num_rows($select_member))
{
echo 'You cannot edit the salary of this employee.';
}
else
{ 
echo 'This employee\'s salary was updated to £'.number_format($_POST['salary']).'.';
$realname = $db->query(sprintf("SELECT * FROM `users` WHERE (`userid` = '%u')", $_POST['member']));
$thename = $db->fetch_row($realname);
$db->query(sprintf("UPDATE `businesses_members` SET `bmembCash` = '%d' WHERE (`bmembMember` = '%u')", $_POST['salary'], $_POST['member']));
business_alert($inf['busId'], "".$thename['username']."\'s salary was changed to ".number_format($_POST['salary']).".");
}
}
}
function view_vault()
{
global $ir, $inf, $db;
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Company Vault</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

<form action="business_manage.php?p=donate_cash" method="post">
Your Company has '.number_format($inf['busCash']).' secured in it\'s vault.<br /><br />
<b>Donate cash:</b><br /><br />
Cash amount: <input type="text" name="cash" /><br /><br />
<input type="submit" value="Donate cash"></form>
<form action="business_manage.php?p=withdraw_mula" method="post">
<br/><b>Withdraw cash:</b><br /><br />
Cash amount: <input type="text" name="mula" /><br /><br />
<input type="submit" value="Withdraw cash"></form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
function sort_debt()
{
global $ir, $inf, $db;
$_POST['cash'] = abs(@intval($_POST['cash']));
if($_POST['cash'] > 0)
{
if($_POST['cash'] > $ir['money'])
{
echo 'You do not have enough cash to sort out that amount of debt.';
}
else if($_POST['cash'] > $inf['busDebt'])
{
echo 'The Company does not owe that much cash in debt.';
}
else
{
$db->query(sprintf("UPDATE `users` SET `money` = `money` - '%d' WHERE `userid` = '%u'", $_POST['cash'], $ir['userid']));
$db->query(sprintf("UPDATE `businesses` SET `busDebt` = `busDebt` - '%d' WHERE `busId` = '%u'", $_POST['cash'], $inf['busId']));
echo 'You have cleared up '.number_format($_POST['cash']).' of the Company debt.';
business_alert($inf['busId'], "".$ir['username']." paid ".number_format($_POST['cash'])." of the Company debt.");

  }
}
else
{
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Company Debt</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

<form action="business_manage.php?p=debt" method="post">
Your Company has £'.number_format($inf['busDebt']).' of debt.<br /><br />
<b>Enter amount:</b><br /><br />
Cash: <input type="text" name="cash" /><br /><br />
<input type="submit" value="Submit" />
</form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
}
function donate_cash()
{
global $ir, $inf, $db;
$_POST['cash'] = abs(@intval($_POST['cash']));

if($_POST['cash'] > 0)
{
if(@intval($_POST['cash'] > $ir['money']))
{
echo 'You do not have enough cash to donate this much to the Company.';
}
else
{
$db->query(sprintf("UPDATE `users` SET `money` = `money` - '%d' WHERE `userid` = '%u'", $_POST['cash'], $ir['userid']));
$db->query(sprintf("UPDATE `businesses` SET `busCash` = `busCash` + '%d' WHERE `busId` = '%u'", $_POST['cash'], $inf['busId']));
echo 'You have donated '.number_format($_POST['cash']).' to the Company.';
business_alert($inf['busId'], "".$ir['username']." donated ".number_format($_POST['cash'])." to the Company.");
}
}
else
{
echo 'You missed one or more of the required fields.';
}
}
function withdraw_mula()
{
global $ir, $inf, $userid, $db;

$_POST['mula']=abs(@intval($_POST['mula']));
if($_POST['mula'] > 0)
{
if($_POST['mula'] > $inf['busCash'])
{
echo 'You do not have enough cash to withdraw this much from the Company.';
}
else
{
$db->query(sprintf("UPDATE `users` SET `money` = `money` + '%d' WHERE `userid` = '%u'", $_POST['mula'], $ir['userid']));
$db->query(sprintf("UPDATE `businesses` SET `busCash` = `busCash` - '%d' WHERE `busId` = '%u'", $_POST['mula'], $inf['busId']));
echo 'You have withdrawn '.number_format($_POST['mula']).' from the Company.';
business_alert($inf['busId'], "".$ir['username']." withdrawn ".number_format($_POST['mula'])." from the Company.");
}
}
else
{
echo 'You missed one or more of the required fields.';
}
}

function kick_member()
{
global $ir, $inf, $db;

if(!isset($_POST['member']))
{
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Fire Employee</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

Please select a member to kick out of the Company:<br />
<form action="business_manage.php?p=kick_out" method="post">
Company employee: <select name="member">
<option value="0">None</option>';
$select_members = $db->query(sprintf("SELECT * FROM `businesses_members` LEFT JOIN `users` ON (`userid` = `bmembMember`) WHERE (`bmembBusiness` = '%u') ORDER BY `bmembId` ASC", $inf['busId']));
while($sm = $db->fetch_row($select_members))
{
echo '<option value="'.$sm['userid'].'">'.stripslashes($sm['username']).'</option>';
}
echo '</select><br /><br />
<input type="submit" value="Kick from company" />
</form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
else
{
$db->query(sprintf("DELETE FROM `businesses_members` WHERE `bmembMember` = '%u'", $_POST['member']));
$realname = $db->query(sprintf("SELECT * FROM `users` WHERE (`userid` = '%u')", $_POST['member']));
$thename = $db->fetch_row($realname);
$db->query(sprintf("UPDATE `users` SET `business` = '0' WHERE `userid` = '%u'", $_POST['member']));
echo 'This member has been kicked out of the Company.';
business_alert($inf['busId'], " ".$thename['username']." was kicked out of the Company.");
}
}
function bankrupt_business()
{
global $ir, $inf, $db;

if(!$_GET['confirm'])
{
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Declare Bankrupt</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


You are about to bankrupt the '.stripslashes($inf['busName']).' Company. Please confirm this action.<br />
Once this has been confirmed there is no chance to go back.<br /><br />
<a href="business_manage.php?p=bankrupt&confirm=1">Bankrupt the Company</a> </div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div> ';
}
else
{
$send_event = $db->query(sprintf("SELECT `bmembMember` FROM businesses_members WHERE `bmembBusiness` = '%u' ORDER BY `bmembId` DESC", $bs['busId']));
while($se = $db->fetch_row($send_event))
{
$text = "The director has chosen to bankrupt the {$inf['busName']} Company\, all members have been made redundent.";
insert_event($se['bmembMember'], $text);
}
$db->query(sprintf("DELETE FROM `businesses_members` WHERE (`bmembBusiness` = '%u')", $inf['busId']));
$db->query(sprintf("DELETE FROM `businesses` WHERE (`busId` = '%u')", $inf['busId']));
$db->query(sprintf("UPDATE `users` SET `business` = '0' WHERE `business` = '%u'", $inf['busId']));
echo 'You have decided to bankrupt the Company, all members have been made redundent.';
}
}
function credit_member()
{
global $ir, $inf;
if($_POST['cash'] AND $_POST['member'])
{
if($_POST['cash'] > $inf['busCash'])
{
echo 'You cannot credit more than the business has in it\'s vault.';
}
else
{
mysql_query(sprintf("UPDATE `users` SET `money` = `money` + '%d' WHERE `userid` = '%u'", abs((int) $_POST['cash']), abs((int) $_POST['member'])));
mysql_query(sprintf("UPDATE `businesses` SET `busCash` = `busCash` - '%d' WHERE `busId` = '%u'", abs((int) $_POST['cash']), $inf['busId'])); 
echo 'You gave $'.number_format($_POST['cash']).' to this member from the vault.'; 
business_alert($inf['busId'], "Member ID ".$_POST['member']." was credited \$".number_format($_POST['cash'])." from the business.");
}
}
else
{
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Credit Member</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

<form action="business_manage.php?p=credit_member" method="post">
<p align="center">
Your business vault contains $'.number_format($inf['busCash']).' at this time, which can be credited to a member.<br />
Select a member from the box below and enter an amount of cash to give to them.<br /><br />
Cash amount: <input type="text" name="cash" /><br />
Business member: <select name="member">
<option value="0">None</option>
<option value="'.$ir['userid'].'">'.stripslashes($ir['username']).'</option>';
$select_members = mysql_query(sprintf("SELECT * FROM `businesses_members` LEFT JOIN `users` ON (`userid` = `bmembMember`) WHERE (`bmembBusiness` = '%u') ORDER BY `bmembId` ASC", $inf['busId']));
while($sm = mysql_fetch_assoc($select_members))
{
echo '<option value="'.$sm['userid'].'">'.stripslashes($sm['username']).'</option>';
}
echo '</select><br /><br />
<input type="submit" value="Credit cash" />
</p>
</form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
}
function manage_applications()
{
global $ir, $inf, $db;
$_GET['id'] = abs(@intval($_GET['id']));
$_POST['member'] = abs(@intval($_POST['member'])); 
if(!isset($_GET['a']))
{
$fetch_apps = $db->query(sprintf("SELECT * FROM `businesses_apps` LEFT JOIN `users` ON `userid` = `appMember` WHERE `appBusiness` = '%u'", $inf['busId']));
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Job Applications</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


<table width="600" class="table">
<tr>
<th width="15%">Member</th>
<th width="50%">Application</th>
<th width="15%">Time</th>
<th width="20%">Manage</th>
</tr>';
while($r = $db->fetch_row($fetch_apps))
{
echo '
<tr>
<td><a href="viewuser.php?u='.$r['userid'].'">'.stripslashes($r['username']).'</a></td>
<td>'.stripslashes(htmlentities($r['appText'])).'</td>
<td>'.date('d-m-Y, g:i:s A', $r['appTime']).'</td>
<td><a href="business_manage.php?p=view_apps&a=accept&id='.$r['appId'].'"><small>Accept</small></a><small>-</small>  <a href="business_manage.php?p=view_apps&a=decline&id='.$r['appId'].'"><small>Decline</small></a></td>
</tr>';
}
echo '</table></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
else if($_GET['a'] == 'accept' AND $_GET['id'])
{
$fetch_app = $db->query(sprintf("SELECT * FROM `businesses_apps` LEFT JOIN `users` ON `userid` = `appMember` WHERE `appId` = '%u'", $_GET['id']));

if($db->num_rows($fetch_app))
{
$it = $db->fetch_row($fetch_app);
$check = $db->query(sprintf("SELECT * FROM `businesses_members` WHERE (`bmembMember` = '%u')", $it['appMember']));

if(!$db->num_rows($check))
{
$rows = $db->query(sprintf("SELECT * FROM `businesses_members` WHERE (`bmembBusiness` = '%u')", $inf['busId']));

if($db->num_rows($rows) < $inf['busEmployees'])
{
$fetch_rank = $db->query(sprintf("SELECT * FROM `businesses_ranks` WHERE (`rankClass` = '%u') ORDER BY `rankCash` ASC LIMIT 1", $inf['classId']));
$fr = $db->fetch_row($fetch_rank);
$realname = $db->query(sprintf("SELECT * FROM `users` WHERE (`userid` = '%u')", $_POST['member']));
$thename = $db->fetch_row($realname);
business_alert($inf['busId'], " A new employee has been accepted into the Company.");
$db->query(sprintf("INSERT INTO `businesses_members` (`bmembId`, `bmembMember`, `bmembBusiness`, `bmembCash`, `bmembRank`) VALUES ('NULL', '%u', '%d', '%d', '%d')", $it['appMember'], $inf['busId'], $fr['rankCash'], $fr['rankId']));
$db->query(sprintf("UPDATE `users` SET business='{$inf['busId']}' WHERE `userid` = '%u'", $it['appMember']));
$db->query(sprintf("DELETE FROM `businesses_apps` WHERE `appId` = '%u'", $_GET['id']));
echo 'The selected application has been accepted.';
}
else
{
echo 'Your Company cannot hold more members at this time.';
}
}
else
{
echo 'This member is part of a Company at this time, the application could not be accepted.';
$db->query(sprintf("DELETE FROM `businesses_apps` WHERE `appId` = '%u'", $_GET['id']));
}
}
else
{
echo 'The selected application no longer exists.';
}
}
else if($_GET['a'] == 'decline' AND $_GET['id'])
{
$fetch_app = $db->query(sprintf("SELECT * FROM `businesses_apps` WHERE `appId` = '%u'", $_GET['id']));

if($db->num_rows($fetch_app))
{
echo 'The selected application was declined, It has been removed from the log.';
$db->query(sprintf("DELETE FROM `businesses_apps` WHERE `appId` = '%u'", $_GET['id']));
}
else
{
echo 'The selected application no longer exists.';
}
}
else
{
echo 'You did not select an application to manage, go back and select one!';
}
}


function upgrade_business()
{
global $ir, $inf, $db;

if($inf['busEmployees'] >= 50) 
{
die('This company is already fully upgraded to 50 employees.');
}
if(!$_GET['confirm'])
{
$price_upgrade = (($inf['busEmployees'])*1500000);
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Upgrade Business</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


You currently have '.$inf['busEmployees'].' employee spots.<br/><br/>You are about to upgrade the '.stripslashes($inf['busName']).' Company at a cost of '.number_format($price_upgrade).' for an additional 5 slots. Please confirm this action.<br />
Once this has been confirmed there is no chance to go back.<br /><br />
<a href="business_manage.php?p=upgrade&confirm=1">Upgrade the Company</a></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
else
{
$price_upgrade = (($inf['busEmployees'])*1500000);

if ($inf['busCash'] < $price_upgrade) 
{
die('You do not have enough money in the vault.');
}
else if($inf['busEmployees'] >= 50)  
{
die('this company is already fully upgraded to 50 employees.');    
}
else
{
$db->query(sprintf("UPDATE `businesses` SET `busEmployees` = busEmployees+5, `busCash` = busCash - ".$price_upgrade." WHERE `busDirector` = ".$ir['userid'].""));
business_alert($inf['busId'], "The Director has upgraded the Company for 5 extra members.");

echo 'You have decided to upgrade the Company, you can now employee an additional 5 members.';
}
} 
}
function change_description()
{
global $ir, $inf, $db;

if(!mysql_real_escape_string(htmlentities($_POST['desc'])))
{
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Change Company Description</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


<form action="business_manage.php?p=change_desc" method="post">
<p align="center">
<b>You are changing the Company description of the '.stripslashes($inf['busName']).' Company.</b><br />
Please enter a description in the input box below and click \'Change description\' to submit the new description. <br/>Maximum characters is set at 50!!<br /><br />
<textarea rows="10" cols="50" name="desc">'.($inf['busDesc']).'</textarea><br/>
<input type="submit" value="Change description" />
</p>
</form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
else
{
$db->query(sprintf("UPDATE `businesses` SET `busDesc` = '%s' WHERE `busId` = '%u'", stripslashes($_POST['desc']), $inf['busId']));
echo 'The Company description was changed to:<br/> '.stripslashes($_POST['desc']).'!';
}
}

function secure_business()
{
global $ir, $inf, $db;


if(!$_GET['confirm'])
{
$price_upgrade = (($inf['busEmployees'])*200000);
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Company Security</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


Your Company Security Level is '.$inf['bussecurity'].' <br/><br/>You are about to security upgrade the '.stripslashes($inf['busName']).' Company at a cost of '.number_format($price_upgrade).' for 10 additional security. Please confirm this action.<br />
Once this has been confirmed there is no chance to go back.<br /><br />
<a href="business_manage.php?p=secupgrade&confirm=1">Purchase Security</a></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
else
{
$price_upgrade = (($inf['busEmployees'])*200000);

if ($inf['busCash'] < $price_upgrade) 
{
die('You do not have enough money in the vault.');
}

else
{
$db->query(sprintf("UPDATE `businesses` SET `bussecurity` = bussecurity+10, `busCash` = busCash - ".$price_upgrade." WHERE `busDirector` = ".$ir['userid'].""));


echo 'You have decided to upgrade the Company, you now have 10 extra security level.';
business_alert($inf['busId'], "The Director has upgraded the Company and added +10 Extra Security.");
}
} 
} 

function new_Director() 
{ 
global $ir, $inf; 
if(!$_GET['confirm']) 
{ 
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Change Director</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

<form action="business_manage.php?p=new_Director&confirm=1" method="post"> 
<p align="center"> 
Select a member from the box below to whom you wish to make the new Director 
<br><br> 
Business member: <select name="member">'; 
$select_members = mysql_query(sprintf("SELECT * FROM businesses_members LEFT JOIN users ON (userid = bmembMember) WHERE (bmembBusiness = '%u') ORDER BY bmembId ASC", $inf['busId'])); 

while($sm = mysql_fetch_assoc($select_members)) 
{ 
echo '<option value="'.$sm['userid'].'">'.stripslashes($sm['username']).'</option>'; 
} 
echo '</select><br /><br /> 
<input type="submit" value="Change Director" /> 
</p> 
</form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>'; 
} 
else 
{ 
if ($ir['userid'] != $inf['busDirector']) { 
die('You need to be the Director to perform this action.'); 
}else{ 

$select_members2 = mysql_query(sprintf("SELECT * FROM businesses_members WHERE (bmembMember = '%u')", $_POST['member'])); 

$sm2 = mysql_fetch_assoc($select_members2); 

mysql_query(sprintf("INSERT INTO businesses_members (bmembId, bmembMember, bmembBusiness, bmembMoney, bmembRank, bmembDays) VALUES ('NULL', '%u', '%d', 'NULL', 'NULL', '%d')", $inf['busDirector'], $inf['busId'], $inf['busDays'])); 

mysql_query(sprintf("UPDATE businesses SET busDirector = ".$_POST['member'].", busDays=".$sm2['bmembDays']." WHERE busId = ".$inf['busId']."")); 
mysql_query(sprintf("DELETE FROM `businesses_members` WHERE `businesses_members`.`bmembMember` = ".$_POST['member']." LIMIT 1")); 
business_alert($inf['busId'], "The business has a new Director"); 
echo 'Director Has Been Changed !'; 
} 
} 
} 
 
$h->endpage();
?>