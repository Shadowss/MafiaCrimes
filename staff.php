<?php        


include "sglobals.php"; 
//This contains general thingies 
switch($_GET['action']) 
{ 
case 'basicset': basicsettings(); break; 
case 'announce': announcements(); break; 
case 'cmanual': cronmanual(); break;  
default: index(); break; 
} 
function basicsettings() 
{ 
global $db,$ir,$c,$h,$userid,$set; 
if($ir['user_level'] != 2) 
{ 
die("403"); 
} 
if($_POST['submit']) 
{ 
unset($_POST['submit']); 
foreach($_POST as $k => $v) 
{ 
$db->query("UPDATE `settings` SET conf_value='$v' WHERE conf_name='$k'"); 
} 
print "Settings updated!<br /> 
<a href='staff.php?action=basicset'>Back</a>"; 
stafflog_add("Updated the basic game settings"); 
} 
else 
{ 
print " 

<div class='generalinfo_txt'> 
<div><img src='images/info_left.jpg' alt='' /></div> 
<div class='info_mid'><h2 style='padding-top:10px;'> Basic Settings</h2></div> 
<div><img src='images/info_right.jpg' alt='' /></div> </div> 
<div class='generalinfo_simple'><br> <br><br> 


<br> 
<form action='staff.php?action=basicset' method='post'> 
<input type='hidden' name='submit' value='1' /> 
Game Name: <input type='text' STYLE='color: black;  background-color: white;' name='game_name' value='{$set['game_name']}' /><br /> 
Game Owner: <input type='text' STYLE='color: black;  background-color: white;' name='game_owner' value='{$set['game_owner']}' /><br /> 
Game Description:<br /> 
<textarea rows='15' cols='55' name='game_description'>{$set['game_description']}</textarea><br /> 
Paypal Address: <input type='text' STYLE='color: black;  background-color: white;' name='paypal' value='{$set['paypal']}' /><br /> 
Gym/Crimes Validation: <select name='validate_on' type='dropdown'>"; 
$opt=array( 
"1" => "On", 
"0" => "Off" 
); 
foreach($opt as $k => $v) 
{ 
if($k == $set['validate_on']) 
{ 
print "<option value='{$k}' selected='selected'>{$v}</option>"; 
} 
else 
{ 
print "<option value='{$k}'>{$v}</option>"; 
} 
} 
print "</select><br /> 

Validation Period: <select name='validate_period' type='dropdown'>"; 
$opt=array( 
"5" => "Every 5 Minutes", 
"15" => "Every 15 Minutes", 
"60" => "Every Hour", 
"login" => "Every Login" 
); 
foreach($opt as $k => $v) 
{ 
if($k == $set['validate_period']) 
{ 
print "<option value='{$k}' selected='selected'>{$v}</option>"; 
} 
else 
{ 
print "<option value='{$k}'>{$v}</option>"; 
} 
} 
print "</select><br /> 
Registration CAPTCHA: <select name='regcap_on' type='dropdown'>"; 
$opt=array( 
"1" => "On", 
"0" => "Off" 
); 
foreach($opt as $k => $v) 
{ 
if($k == $set['regcap_on']) 
{ 
print "<option value='{$k}' selected='selected'>{$v}</option>"; 
} 
else 
{ 
print "<option value='{$k}'>{$v}</option>"; 
} 
} 
print "</select><br /> 
Send Crystals: <select name='sendcrys_on' type='dropdown'>"; 
$opt=array( 
"1" => "On", 
"0" => "Off" 
); 
foreach($opt as $k => $v) 
{ 
if($k == $set['sendcrys_on']) 
{ 
print "<option value='{$k}' selected='selected'>{$v}</option>"; 
} 
else 
{ 
print "<option value='{$k}'>{$v}</option>"; 
} 
} 
print "</select><br /> 

Bank Xfers: <select name='sendbank_on' type='dropdown'>"; 
$opt=array( 
"1" => "On", 
"0" => "Off" 
); 
foreach($opt as $k => $v) 
{ 
if($k == $set['sendbank_on']) 
{ 
print "<option value='{$k}' selected='selected'>{$v}</option>"; 
} 
else 
{ 
print "<option value='{$k}'>{$v}</option>"; 
} 
} 
print "</select><br /> 
Energy Refill Price (crystals): <input type='text' STYLE='color: black;  background-color: white;' name='ct_refillprice' value='{$set['ct_refillprice']}' /><br /> 
IQ per crystal: <input type='text' STYLE='color: black;  background-color: white;' name='ct_iqpercrys' value='{$set['ct_iqpercrys']}' /><br /> 
Money per crystal: <input type='text' STYLE='color: black;  background-color: white;' name='ct_moneypercrys' value='{$set['ct_moneypercrys']}' /><br /> 
Will Potion Item: ".item_dropdown($c, "willp_item", $set['willp_item'])."<br /> 
<input type='submit' STYLE='color: black;  background-color: white;' value='Update Settings' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>"; 
} 
} 
function announcements() 
{ 
global $db,$ir,$c,$h,$userid,$set; 
if($ir['user_level'] != 2) 
{ 
die("403"); 
} 
if($_POST['text']) 
{ 
$db->query("INSERT INTO announcements VALUES('{$_POST['text']}', unix_timestamp())"); 
$db->query("UPDATE users SET new_announcements=new_announcements+1"); 
print "Announcement added!<br /> 

&gt; <a href='staff.php'>Back</a>"; 
stafflog_add("Added a new announcement"); 
} 
else 
{ 
print " 

<div class='generalinfo_txt'> 
<div><img src='images/info_left.jpg' alt='' /></div> 
<div class='info_mid'><h2 style='padding-top:10px;'> Adding an announcement...</h2></div> 
<div><img src='images/info_right.jpg' alt='' /></div> </div> 
<div class='generalinfo_simple'><br> <br><br> 

Please try to make sure the announcement is concise and covers everything you want it to.<form action='staff.php?action=announce' method='post'> 
Announcement text:<br /> 

<textarea name='text' rows='10' cols='60' class='input_fix'></textarea><br /> 
<input type='submit' value='Add Announcement' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>"; 
} 
} 


function cronmanual() 
{ 
global $db,$ir,$c,$h,$userid,$set; 
if($ir['user_level'] != 2) 
{ 
die("403"); 
} 
print " 



<div class='generalinfo_txt'> 
<div><img src='images/info_left.jpg' alt='' /></div> 
<div class='info_mid'><h2 style='padding-top:10px;'> Manual Cron Jobs</h2></div> 
<div><img src='images/info_right.jpg' alt='' /></div> </div> 
<div class='generalinfo_simple'><br> <br><br> 


<style type='text/css'> 
.style1 { 
    color: #FF0000; 
} 
.style2 { 
    text-decoration: underline; 
    color: #008000; 
} 
</style> 

You can manually run cron jobs from here.<br><br> 
<span class='style1'><b>Warning</b></span>: Use only for testing. Statistics are updated  
every time you run a corresponding cron instead of time limit. 
<br><br> 
<a href='cron_srun_minute.php'>Run 1 Minute Cron Jobs</a> [ Updates Jail and  
Hospital Time ]<br><br> 
<a href='cron_srun_five.php'>Run 5 Minute Cron Jobs</a> [ Updates User  
Statistics ]<br><br> 

<a href='cron_srun_hour.php'>Run Hourly Cron Jobs</a>&nbsp; [ Updates Hourly  
Cron ]<br><br> 

<a href='cron_srun_day.php'>Run Daily Cron Jobs</a>&nbsp; [ Updates Daily Cron ]<br><br> 


<a href='battle_cron.php'>Run Battle Ladder Cron</a>&nbsp; [ Updates Battle Ladder Cron Job ] <br><br>  

Run Battle Ladder cron , every week , month or so ! <br>Running this job credit the table leader with cash and points and also reset the battle ladder for new tournament ! 

</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> 


"; 
} 



function index() 
{ 
global $db,$ir,$c,$h,$userid,$set, $_CONFIG; 
$pv=phpversion(); 
$mv=$db->fetch_single($db->query("SELECT VERSION()")); 
$dv=$_CONFIG['driver']; 
if($ir['user_level']==2) 
{ 
$versionno=2101; 
$version="2.1.01"; 
print " 


<div class='generalinfo_txt'> 
<div><img src='images/info_left.jpg' alt='' /></div> 
<div class='info_mid'><h2 style='padding-top:10px;'> Game Engine Information</h2></div> 
<div><img src='images/info_right.jpg' alt='' /></div> </div> 
<div class='generalinfo_simple'><br> <br><br> 



<table width='75%' cellspacing='1' class='table'> 
<tr> 
<th>PHP Version:</th> 
<td>$pv</td> 

</tr> 
<tr> 
<th>MySQL Version:</th> 
<td>$mv</td> 
</tr> 
<tr> 
<th>MySQL Driver:</th> 
<td>$dv</td> 
</tr> 
<tr> 
<th>Ravan's MMORPG Script  </th> 
<td>2.1.01 (Build: 2101)</td> 

</tr> 
</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> 
      
      
<div class='generalinfo_txt'> 
<div><img src='images/info_left.jpg' alt='' /></div> 
<div class='info_mid'><h2 style='padding-top:10px;'> Last 10 Staff Actions</h2></div> 
<div><img src='images/info_right.jpg' alt='' /></div> </div> 
<div class='generalinfo_simple'><br> <br><br>      
           


<table width='90%' cellspacing='1' class='table'> 
<tr> 
<th>Staff</th> 
<th>Action</th> 

<th>Time</th> 
<th>IP</th> 
</tr>"; 
$q=$db->query("SELECT s.*, u.* FROM stafflog AS s LEFT JOIN users AS u ON s.user=u.userid ORDER BY s.time DESC LIMIT 10"); 
while($r=$db->fetch_row($q)) 
{ 
print "<tr><td>{$r['username']} [{$r['user']}]</td> <td>{$r['action']}</td> <td>".date('F j Y g:i:s a', $r['time'])."</td> <td>{$r['ip']}</td></tr>"; 
} 
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>"; 
} 
print "    

<div class='generalinfo_txt'> 
<div><img src='images/info_left.jpg' alt='' /></div> 
<div class='info_mid'><h2 style='padding-top:10px;'> Staff Notepad</h2></div> 

<div><img src='images/info_right.jpg' alt='' /></div> </div> 
<div class='generalinfo_simple'><br> <br><br>"; 
if($_POST['pad']) 
{ 
$db->query("UPDATE settings SET conf_value='{$_POST['pad']}' WHERE conf_name='staff_pad'"); 
$set['staff_pad']=stripslashes($_POST['pad']); 
print "<b>Staff Notepad Updated!</b><hr />"; 
} 
print "<form action='staff.php' method='post'> 
<textarea rows='10' cols='60' name='pad' class='input_fix'>".htmlspecialchars($set['staff_pad'])."</textarea><br /> 
<input type='submit'  value='Update Notepad' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>"; 
} 
$h->endpage(); 
?>