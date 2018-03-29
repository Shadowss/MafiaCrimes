<?php
include_once (DIRNAME(__FILE__). '/globals.php');  

switch ($_GET['page'])
{
case 'class': view_class(); break;
case 'profile': view_profile(); break;
case 'sendapp': send_application(); break;
case 'rob': rob_business(); break;
default: business_index(); break;
}
function business_index()
{
global $ir,$db;


print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Company Listings  </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


<table width=600 class=table>";
$fetch_classes = $db->query("SELECT * FROM `businesses_classes` ORDER BY `classId` ASC");
while($r = $db->fetch_row($fetch_classes))
{   
echo '  
<tr>
<td width="275" align="right">'.stripslashes($r['className']).' </td>
<td width="25"></td>
<td width="275" align="left"> <a href="business_view.php?page=class&id='.$r['classId'].'">View '.stripslashes($r['className']).' companies</a></td>
</tr>';
}
echo '</table> <br> <a href="business_create.php"><b>Create a Company</b></a> <br>  </div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div> 
</p>';
}
function view_class()
{
global $ir,$db;
$_GET ['id'] = abs(@intval($_GET['id']));

if($_GET['id'])
{
$fetch_class = $db->query(sprintf("SELECT * FROM `businesses_classes` WHERE (`classId` = '%u')", $_GET['id']));
if(!$db->num_rows($fetch_class))
{
echo 'You cannot view a company class that doesn\'t exist.';
}
else
{
$r = $db->fetch_row($fetch_class);
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> <b>'.stripslashes($r['className']).'</h2></b> <br />
<i>'.stripslashes($r['classDesc']).'</i>
</div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br><br><br>

<p align="center">
<br />
The '.stripslashes($r['className']).' company is small and starts with a maximum of <b>'.number_format($r['classMembers']).'</b> members until it has been upgraded.<br />
The total start up cost of a '.stripslashes($r['className']).' company is $'.number_format($r['classCost']).'.</p>

<table width="600" class="table">
<tr>
<th colspan="4">'.stripslashes($r['className']).' Ranks</th>
</tr>';
$fetch_ranks = $db->query(sprintf("SELECT * FROM `businesses_ranks` WHERE `rankClass` = '%u'", $_GET['id']));
while($rn = $db->fetch_row($fetch_ranks))
{
echo '
<tr>
<td width="25%"><b>Rank:</b> '.stripslashes($rn['rankName']).'</td>
<td width="20%"><b>Primary stat:</b> '.stripslashes($rn['rankPrim']).'</td>
<td width="20%"><b>Secondary stat:</b> '.stripslashes($rn['rankSec']).'</td>
<td width="45%"><b>Stat gain:</b> '.$rn['rankPGain'].' '.stripslashes($rn['rankPrim']).' and '.$rn['rankSGain'].' '.stripslashes($rn['rankSec']).'</td>
</tr>';
}
echo '</table>

<table width="600" class="table">
<tr>
<th colspan="3">'.stripslashes($r['className']).' Companies</th>
</tr>


<tr>
<th >Company Name</th>
<th >Director</th>
<th >Company Rank</th> 
</tr>

';
$bus_rating = $db->query("SELECT `busCash` FROM `businesses`");
$ttl_profit = 0;
while($fetch_cash = $db->fetch_row($bus_rating))
{
$ttl_profit += ($fetch_cash['busCash'] + 1);
}
$fetch_businesses = $db->query(sprintf("SELECT * FROM `businesses` LEFT JOIN `users` ON (`userid` = `busDirector`) WHERE `busClass` = '%u'", $_GET['id']));
while($fb = $db->fetch_row($fetch_businesses))
{
if($fb['brank'] < 1000) { $stars='<img src="star.png" width=25 height=25/>';
}
if($fb['brank'] > 1000) { $stars='<img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/>'; 
}
if($fb['brank'] > 5000) { $stars='<img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/>'; 
}
if($fb['brank'] >= 35000) { $stars='<img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/>'; 
}
if($fb['brank'] >= 100000) { $stars='<img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/>';              
}
$rate = (int) ((($fb['busCash'] + 1) / $ttl_profit * 100) / 20);
echo '


<tr>
<td> <a href="business_view.php?page=profile&id='.$fb['busId'].'"><b>'.stripslashes($fb['busName']).'</b></a> </td>
<td> <a href="viewuser.php?u='.$fb['userid'].'"><i>'.stripslashes($fb['username']).'</i></a></td>
<td> '.$stars.' </td>
</tr>';
}
echo '</table> <br><br><br> <a href="business_create.php"><b>Create a Company</b></a> <br></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div> ';
}
}
else
{
echo 'You did not select a company class to view.';
}
}
function view_profile()
{
global $ir,$db;
$_GET['id'] = abs(@intval($_GET['id']));

if($_GET['id'])
{
$fetch_business = $db->query(sprintf("SELECT * FROM `businesses` LEFT JOIN `businesses_classes` ON (`classId` = `busClass`) LEFT JOIN `users` ON (`userid` = `busDirector`) WHERE (`busId` = '%u')", $_GET['id']));
if(!$db->num_rows($fetch_business))
{
echo 'You cannot view a company that doesn\'t exist.';
}
else
{
$r = $db->fetch_row($fetch_business);
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Details of '.stripslashes($r['busName']).' - '.stripslashes($r['className']).'</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>



<table width="75%" class="table">
<tr>
<th colspan="3">Details of '.stripslashes($r['busName']).' - '.stripslashes($r['className']).'</th>
</tr>
<tr height="100">
<td colspan="3" valign="middle" align="center">';
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
<th colspan="3"> <b>Company Description </b> </th>
</tr>
<tr>
<td colspan="3"><center>'.($r['busDesc']).'</center></td>
</tr>  

<tr>
<th colspan="3"> <b>Company Rank</b>  </th>
</tr>';


if($r['brank'] < 1000)
{
$stars='<img src="star.png" width=25 height=25/>'; 
}
if($r['brank'] > 1000) 
{
$stars='<img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/>'; 
}
if($r['brank'] >= 5000)
{
$stars='<img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/>'; 
}
if($r['brank'] > 35000)
{
$stars='<img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/>'; 
}
if($r['brank'] > 100000) { $stars='<img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/> <img src="star.png" width=25 height=25/>'; 
}
echo '</td></tr>
<tr>
<td colspan="3"><center> '.$stars.'</center></td>
</tr>
<tr>
<th colspan="3">Further information</th>
</tr>
<tr height="150">
<td colspan="3" valign="middle" align="center">
<table width="200">
<tr>
<td>
<b>Class:</b> '.stripslashes($r['className']).'<br />
<b>Director:</b> <a href="viewuser.php?u='.$r['userid'].'">'.stripslashes($r['username']).'</a><br /><br />
<b>Todays profit:</b> $'.number_format($r['busProfit']).'<br />
<b>Yesterdays profit:</b> $'.number_format($r['busYProfit']).'<br />
<b>Todays customers:</b> '.number_format($r['busCust']).'<br />
<b>Yesterdays customers:</b> '.number_format($r['busYCust']).'<br />
</td>
</tr>
</table>
</td>
</tr>
<tr>
<th colspan="3">Company Owner : <b> <a href="viewuser.php?u='.$r['userid'].'">'.stripslashes($r['username']).' </a> </b> </th>
</tr>
<tr>
<th colspan="3"> '.stripslashes($r['busName']).' Members    </th>
</tr>

<tr>
<th width="50%">Member name</th>
<th width="50%">Job rank</th>
<th width="50%">Salary</th> 
</tr>

';
$fetch_members = $db->query(sprintf("SELECT * FROM `businesses_members` LEFT JOIN `users` ON (`userid` = `bmembMember`) LEFT JOIN `businesses_ranks` ON (`rankId` = `bmembRank`) WHERE `bmembBusiness` = '%u'", $_GET['id']));
while($fm = $db->fetch_row($fetch_members))
{
echo '


<tr>
<td><a href="viewuser.php?u='.$fm['userid'].'">'.stripslashes($fm['username']).'</a> ['.$fm['userid'].']</td>
<td>'.stripslashes($fm['rankName']).'</td>
<td> $'.number_format($fm['bmembCash']).'</td>
</tr>';
}
echo '</table>
<br/><a href="business_view.php?page=sendapp&id='.$_GET['id'].'"><b>Send Job Application</b> </a> |

<a href="business_view.php?page=rob&id='.$_GET['id'].'"><b>Attempt Robbery</a></b><br />


 </a> </div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>
';
}
}
else
{
echo 'You did not select a company to view.';
}
}
function send_application()
{
global $ir,$db;
$_GET['id'] = abs(@intval($_GET['id']));
if($ir['job'])
{
echo 'You Have A Job';
exit;
}

$check_bus = $db->query(sprintf("SELECT * FROM `businesses` WHERE (`busId` = '%u')", $_GET['id']));
$check_app = $db->query(sprintf("SELECT * FROM `businesses_apps` WHERE (`appMember` = '%u') AND (`appBusiness` = '%d')", $ir['userid'], $_GET['id']));
$check = $db->query(sprintf("SELECT * FROM `businesses` WHERE (`busDirector` = '%u')", $ir['userid']));
$check_member = $db->query(sprintf("SELECT * FROM `businesses_members` WHERE (`bmembMember` = '%u')", $ir['userid']));
if(!$db->num_rows($check_bus))
{
echo 'You cannot send an application to a non-existant company.';
}
else if($db->num_rows($check) || $db->num_rows($check_member))
{
echo '<font color=red><blink>You are part of a company right now, leave before sending an application to a new one.</blink></font>';
}
else if($db->num_rows($check_app))
{
echo 'You have a sent application to this company right now, wait for a responce.';
}
else if(!$_GET['id'])
{
echo 'You did not choose a company to send an application to.';
}
else if($_POST['application'])
{
$app = str_replace(array("\n"), array("<br />"), strip_tags($_POST['application']));
$string_app = mysql_real_escape_string($app);
$db->query(sprintf("INSERT INTO `businesses_apps` (`appId`, `appMember`, `appBusiness`, `appText`, `appTime`) VALUES ('NULL','%d', '%u', '%s', '%d')", $ir['userid'], $_GET['id'], $string_app, time()));
echo 'Your application was sent to the selected company, a responce will be given from the director soon.';
}
else
{
$r = $db->fetch_row($check_bus);
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Business Application</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

<form action="business_view.php?page=sendapp&id='.$_GET['id'].'" method="post">
<p align="center">
<b>Enter an application below to send a request to the director of '.stripslashes($r['busName']).'.</b><br />
You can send one application at a time, wait for the result of that application before sending another.
If the company director is not active, it might take a while for the application to be managed,
So it could be worth speaking with the director before submitting a new application to the company.
Entering a detailed application will increase the chance of having it accepted, but this is no guarantee.
Your working stats will also be sent to the director of the company with the application to help them decide.<br /><br />

Your application:<br />
<textarea type="text" name="application" s="40" rows="10" cols="70" maxlength="255"></textarea><br />
<input type="submit" value="Submit application" /></p>
</form> </div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div> ';
}
}

function rob_business()
{    
global $ir,$db,$h,$userid;
$_GET['id'] = abs(@intval($_GET['id']));
if($_GET['id'])
{
$fetch_business = $db->query(sprintf("SELECT * FROM `businesses` LEFT JOIN `businesses_classes` ON (`classId` = `busClass`) LEFT JOIN `users` ON (`userid` = `busDirector`) WHERE (`busId` = '%u')", $_GET['id'])); 
if(!$db->num_rows($fetch_business))
{
echo 'You cannot rob a company that doesn\'t exist.';
}
else
{
$r = $db->fetch_row($fetch_business);


if($ir['rob'] == 1)
{
echo 'You cannot attempt to rob a company more than once a day!';
$h->endpage();
exit;
}

if($ir['userid'] == $r['busDirector'])
{
echo 'Why would you attempt to rob your own company?';
$h->endpage();
exit;
}

else
{

if($ir['robskill'] <= $r['bussecurity'])
{
print "


<h1><font color=red>BUSTED !! </font></h1>   <br><br> 

<div id='mainOutput' style='text-align: center; color: white;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

While attempting to break into the business, greedy with plans of large bucks.  You fail to notice the police car driving by.  Just as you crack the lock and begin to head inside you are knocked over the head.  You wake up in jail with a raging headache and the discovery YOU WERE CAUGHT";
event_add($_GET['id'],"<a href='viewuser.php?u=$userid'>{$ir['username']}</a> Attempted to Rob your Business but was caught.");
$jailtime=mt_rand(10,40);
$query = sprintf('UPDATE users SET jail = jail +%u, jail_reason = "Failed to Rob %s.", rob = 0 WHERE userid = %u', $jailtime, $r['busName'], $userid);
$db->query($query);
$db->query("UPDATE users SET rob = rob + 1 WHERE userid = $userid");  
$db->query("UPDATE businesses SET bussecurity = bussecurity + 1 WHERE busId = {$_GET['id']}");
business_alert($r['busId'], " Someone tried to rob from your company and got busted ! "); 
}

else if($ir['robskill'] > $r['bussecurity'])
{
$rando = mt_rand(10,25);
$cash = round($r['busCash']/$rando);

print "

<h1><font color=green>SUCESS !! </font></h1>   <br><br> 

<div id='mainOutput' style='text-align: center; color: white;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>


After scoping out the latest company for a few days, you decide now is your chance to do some damage.  You sneak up to the backdoor after dark and jiggle the lock.  With a bit of luck on your side, the door is unlocked.  You sneak in flashlight in hand and head for the vault.  Noticing the lack of security in this place you are hopeful someone hasn't beat you to the punch.  As you enter the dark office where the stash of cash is located it would appear luck is on your side twice!  The owner left the key to the safe on his desk!  You quickly grab the cash and bolt.  You earned yourself a nice smooth $cash cash.";
$db->query("UPDATE users SET money = money + $cash, rob = 0 WHERE userid = $userid"); 
$db->query("UPDATE users SET rob = rob + 1 WHERE userid = $userid"); 
$db->query("UPDATE businesses SET busCash = busCash - $cash, bussecurity = bussecurity - 1 WHERE busId = {$_GET['id']}");
$robbery = $money=money_formatter($cash); 
business_alert($r['busId'], " Someone successfully robbed $robbery from your company ! "); 

}
}
}
}

}
$h->endpage();
?>