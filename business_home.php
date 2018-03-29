<?php
include_once (DIRNAME(__FILE__). '/globals.php');
include_once (DIRNAME(__FILE__). '/bbcode_parser.php');
global $ir,$db;

$check = $db->query(sprintf("SELECT * FROM `businesses_members` WHERE (`bmembMember` = '%u')", $ir['userid']));
$check_two = $db->query(sprintf("SELECT * FROM `businesses` WHERE (`busDirector` = '%u')", $ir['userid']));
if(!$db->num_rows($check_two) AND !$db->num_rows($check))
{
echo 'You are not a member of a Company right now, come back another time.

<br><br><a href="business_view.php">View Business listings</a><br />


';
$h->endpage();
exit;
}
else
{
$r = $db->fetch_row($check);
$b = $db->fetch_row($check_two);
$fetch_business = $db->query(sprintf("SELECT * FROM `businesses` LEFT JOIN `businesses_classes` ON (`classId` = `busClass`) WHERE (`busId` = '%u') OR (`busId` = '%u')", $r['bmembBusiness'], $b['busId']));
if(!$db->num_rows($fetch_business))
{
echo 'This Company does not exist at this time, please come back later.';
$h->endpage();
exit;
}
else
{
$inf = $db->fetch_row($fetch_business);
}
}
switch ($_GET['p'])
{
case 'leave_business': leave_business(); break;
case 'view_members': view_members(); break;
case 'donate_cash': donate_cash(); break;
case 'view_vault': view_vault(); break;
default: business_index(); break;
}
function business_index()
{
global $ir, $inf, $db;
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> '.stripslashes($inf['busName']).' options:</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>';

if($inf['busDirector'] == $ir['userid'])
{
echo '<b><a href="business_manage.php">Manage Company</a> </b> | ';
}
else
{
echo '<b><a href="business_home.php?p=view_vault">Donate to the Company</a></b> | ';
echo '<b><a href="business_home.php?p=leave_business">Leave the Company</a></b> | ';
}
echo '<b><a href="business_home.php?p=view_members">View members</a></b>  <br><br>';

$fetch_business = $db->query(sprintf("SELECT * FROM `businesses` LEFT JOIN `businesses_classes` ON (`classId` = `busClass`) LEFT JOIN `users` ON (`userid` = `busDirector`) WHERE (`busId` = '%u')", abs((int) $inf['busId'])));    

if(!$db->num_rows($fetch_business))
{
echo 'You cannot view a Company that doesn\'t exist .';
}
else
{
$r = $db->fetch_row($fetch_business);
$fetch_memberinfo = $db->query(sprintf("SELECT * FROM `businesses_members` WHERE `bmembMember` = '%u'", $ir['userid']));
$mem = $db->fetch_row($fetch_memberinfo);
$realrank = $db->query(sprintf("SELECT * FROM `businesses_ranks` WHERE (`rankId` = '%u')", $mem['bmembRank']));
$rname = $db->fetch_row($realrank);

if($mem['bmembRank'] == 0) 
{
$rank='dont have an assigned rank'; 
}
else  
{
$rank='work as a '.($rname['rankName']).'';  
}

if($mem['bmembCash'] >= 0){ $mcash='$'.number_format($mem['bmembCash']).'';
}
if(!$rname['rankPGain'] AND !$rname['rankPrim'] AND !$rname['rankSGain'] AND !$rname['rankSec']) 
{
$gaininfo='You also receive 50 labour, 50 intelligence and 50 strength every day.'; 
}
else                                                    {
$gaininfo='You also receive '.($rname['rankPGain']).' '.($rname['rankPrim']).' and '.($rname['rankSGain']).' '.($rname['rankSec']).' every day.'; 
}
if($mem['bmembRank'] == 0)
{
$gaininfo='You also receive 0 labour, 0 intelligence and 0 strength every day.'; 
} 
if($ir['userid'] == $r['busDirector']) 
{
$rank='are the owner'; 
}
if($ir['userid'] == $r['busDirector']) 
{
$gaininfo='You also receive 50 labour, 50 intelligence and 50 strength every day.'; 
}
echo '  <div class="nosign_line"><img src="images/sign_line.jpg" alt="" /> </div> 
You currently '.stripslashes($rank).' at '.stripslashes($r['busName']).' which is owned by <a href="viewuser.php?u='.$r['userid'].'">'.stripslashes($r['username']).'</a>.<br/>';

if($ir['userid'] == $r['busDirector']) 
{

echo ' Total asset of your company is </b> $'.number_format($r['busCash']).'<br /> ';

}

else {

echo ' You are paid '.($mcash).' at midnight every day when you are in the company!<br /> ';

}


echo '

'.($gaininfo).'      <br/><br/>  
<div class="nosign_line"><img src="images/sign_line.jpg" alt="" /> </div> 
<table width="75%" class="table">
<tr>
<th colspan="2">Details of '.stripslashes($r['busName']).' - '.stripslashes($r['className']).'</th>
</tr>
<tr height="100">
<td colspan="2" valign="middle" align="center">';
if($r['busImage'])
{
echo '<img src="'.stripslashes($r['busImage']).'" alt="'.stripslashes($r['busName']).' banner" width="400" height="100" />';
}
else
{
echo '<img src="images/nobusbanner.png" alt="'.stripslashes($r['busName']).' banner" width="400" height="100" />';
}
      echo '</td></tr>
      
      
<tr>
<th colspan="2"> <b>Company Description </b> </th>
</tr>
<tr>
<td colspan="2"><center>'.($r['busDesc']).'</center></td>
</tr>      


<tr>
<th colspan="2"> <b>Company Rank </b> </th>
</tr>';

if($r['brank'] < 1000) 
{
$stars='<img src="star.png" width=25 height=25/>'; 
}
if($r['brank'] > 1000) 
{
$stars='<img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/>'; 
}
if($r['brank'] > 5000) 
{
$stars='<img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/>'; 
}
if($r['brank'] > 35000) 
{
$stars='<img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/>'; 
}
if($r['brank'] > 100000) 
{
$stars='<img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/>'; 
}

$fetch_members = $db->num_rows($db->query(sprintf("SELECT * FROM `businesses_members` WHERE `bmembBusiness` = '%u'", $r['busId'])));
$fetch_memberinfo = $db->query(sprintf("SELECT * FROM `businesses_members` WHERE `bmembMember` = '%u'", $ir['userid']));
$mem = $db->fetch_row($fetch_memberinfo);
$cd = $db->query(sprintf("SELECT * FROM `userstats` WHERE `userid` = '%u'", $ir['userid']));
$fstats = $db->fetch_row($cd);
$realrank = $db->query(sprintf("SELECT * FROM `businesses_ranks` WHERE (`rankId` = '%u')", $mem['bmembRank']));
$rname = $db->fetch_row($realrank);

if($mem['bmembRank'] <= 0) 
{
$rank='Director'; 
}
else 
{
$rank=''.($rname['rankName']).''; 
}

if($mem['bmembCash'] == 0) 
{
$mcash='<font color=red> --- </font>'; 
}
else if($mem['bmembCash'] > 0)
{ 
$mcash='<font color=green>+'.number_format($mem['bmembCash']).'</font>'; 
}

echo '</td></tr>
<tr>
<td colspan="2"><center> '.$stars.'</center></td>
</tr>
<tr>
<th colspan="2">Further information</th>
</tr>
<tr height="150">
<td colspan="2" valign="middle" align="center">
<table width="100%">
<tr>
<td>
<b>Type:</b> '.stripslashes($r['className']).'<br />
<b>Director:</b> <a href="viewuser.php?u='.$r['userid'].'">'.stripslashes($r['username']).'</a><br />
<b>Company Bank:</b> $'.number_format($r['busCash']).'<br />
<b>Employees:</b> '.number_format($fetch_members).'/'.($r['busEmployees']).'<br />
<b>Days old:</b> '.number_format($r['busDays']).'<br /><br/>
</td>
<td>
<b>Your details</b><br/>
<b>Rank: </b>'.stripslashes($rank).'</b><br/>
<b>Income: </b>'.($mcash).'<br/>
<b>Labour: </b>'.number_format($fstats['labour']).'<br/>
<b>Intelligence: </b>'.number_format($fstats['IQ']).'<br/>
<b>Strength:</b> '.number_format($fstats['strength']).'<br/>
<b>Company points:</b> '.number_format($ir['comppoints']).' [<a href="companyspecials.php"/>Use</a>]<br/>
<br/>
</td>
</tr>
<tr>
<td>
<b>Todays profit:</b> $'.number_format($r['busProfit']).'<br />
<b>Yesterdays profit:</b> $'.number_format($r['busYProfit']).'<br />
<b>Todays customers:</b> '.number_format($r['busCust']).'<br />
<b>Yesterdays customers:</b> '.number_format($r['busYCust']).'<br />
<center></td>
</tr>
</table>';
}

echo '
<table width="100%" class="table">
<tr>
<th>Action</th>
<th>Time</th>
</tr>';
$business_alerts = $db->query(sprintf("SELECT * FROM `businesses_alerts` WHERE `alertBusiness` = '%u' ORDER BY `alertTime` DESC LIMIT 25", $inf['busId']));
while($ba = $db->fetch_row($business_alerts))
{
echo '
<tr>
<td width="50%">'.stripslashes($ba['alertText']).'</td>
<td width="20%">'.date('d-m-Y, g:i:s A', $ba['alertTime']).'</td>
</tr>';
}
echo '</table></table></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div> ';
}

function view_vault()
{
global $ir, $inf, $db;
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Donate Cash</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


<form action="business_home.php?p=donate_cash" method="post">
Your Company has '.number_format($inf['busCash']).' secured in it\'s vault.<br /><br />
Cash amount: <input type="text" name="cash" /><br /><br />
<input type="submit" value="Donate Cash"></form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}

function donate_cash()
{
global $ir, $inf, $db;
$_POST['cash'] = abs(@intval($_POST['cash']));   
if($_POST['cash'] > 0)
{
if($_POST['cash'] > $ir['money'])
{
echo 'You do not have enough cash to donate this much to the Company.';
}
else
{
$db->query(sprintf("UPDATE `users` SET `money` = `money` - '%d' WHERE `userid` = '%u'", $_POST['cash'], $ir['userid']));
$db->query(sprintf("UPDATE `businesses` SET `busCash` = `busCash` + '%d' WHERE `busId` = '%u'", $_POST['cash'], $inf['busId']));
echo 'You have donated $'.number_format($_POST['cash']).' to the Company.';
business_alert($inf['busId'], "".$ir['username']." donated $".number_format($_POST['cash'])." to the Company.");
}
}
else
{
echo 'You missed one or more of the required fields.';
}
}

function leave_business()
{
global $ir, $inf, $db;

if($inf['busDirector'] != $ir['userid'])
{
if(!$_GET['confirm'])
{
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Leave Company</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


You are about to leave the '.$inf['busName'].' Company. Please confirm this action.<br /><br />
<a href="business_home.php?p=leave_business&confirm=1">Leave the Company</a></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
else
{
$db->query(sprintf("DELETE FROM `businesses_members` WHERE (`bmembMember` = '%u')", $ir['userid']));
$db->query(sprintf("UPDATE `users` SET `business` = '0' WHERE (`userid` = '%u')", $ir['userid']));
echo 'You have decided to leave the Company.';
}
}
else
{
echo 'You cannot leave the Company while still the director.'; 
}
}

function view_members()
{
global $ir, $inf, $db;
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Company Employees</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


<table width="60%" class="table">
<tr>
<th width="50%">Member name</th>
<th width="50%">Job rank</th>
<th width="50%">Salary</th> 
</tr>';
$fetch_members = $db->query(sprintf("SELECT * FROM `businesses_members` LEFT JOIN `users` ON (`userid` = `bmembMember`) LEFT JOIN `businesses_ranks` ON (`rankId` = `bmembRank`) WHERE `bmembBusiness` = '%u'", $inf['busId']));
while($fm = $db->fetch_row($fetch_members))
{
echo '
<tr>
<td><a href="viewuser.php?u='.$fm['userid'].'">'.stripslashes($fm['username']).'</a> ['.$fm['userid'].']</td>
<td>'.stripslashes($fm['rankName']).'</td>
<td> $'.number_format($fm['bmembCash']).'</td>
</tr>';
}
echo '</table></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
$h->endpage();
?>