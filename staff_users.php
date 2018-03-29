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
//This contains user stuffs
switch($_GET['action'])
{
case 'newuser': new_user_form(); break;
case 'newusersub': new_user_submit(); break;
case 'edituser': edit_user_begin(); break;
case 'edituserform': edit_user_form(); break;
case 'editusersub': edit_user_sub(); break;
case 'invbeg': inv_user_begin(); break;
case 'invuser': inv_user_view(); break;
case 'deleinv': inv_delete(); break;
case 'creditform': credit_user_form(); break;
case 'creditsub': credit_user_submit(); break;
case 'masscredit': mcredit_user_form(); break;
case 'masscreditsub': mcredit_user_submit(); break;
case 'reportsview': reports_view(); break;
case 'repclear': report_clear(); break;
case 'deluser': deluser(); break;
case 'forcelogout': forcelogout(); break;
default: print "Error: This script requires an action."; break;
}
function htmlspcl($in)
{
return str_replace("'", "&#39;", htmlspecialchars($in));
}
function new_user_form()
{
global $db,$ir, $c;
if($ir['user_level'] != 2)
{
die("403");
}
print "    

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Adding a new user</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_users.php?action=newusersub' method='post'>
Username: <input type='text' STYLE='color: black;  background-color: white;' name='username' /><br />
Login Name: <input type='text' STYLE='color: black;  background-color: white;' name='login_name' /><br />
Email: <input type='text' STYLE='color: black;  background-color: white;' name='email' /><br />
Password: <input type='text' STYLE='color: black;  background-color: white;' name='userpass' /><br />
Type: <input type='radio' name='user_level' value='0' />NPC <input type='radio' name='user_level' value='1' checked='checked' />Regular Member<br />
Level: <input type='text' STYLE='color: black;  background-color: white;' name='level' value='1' /><br />
Money: <input type='text' STYLE='color: black;  background-color: white;' name='money' value='100' /><br />
Crystals: <input type='text' STYLE='color: black;  background-color: white;' name='crystals' value='0' /><br />
Donator Days: <input type='text' STYLE='color: black;  background-color: white;' name='donatordays' value='0' /><br />
Gender: <select name='gender' type='dropdown'><option>Male</option><option>Female</option></select><br />
<br />
<b>Stats</b><br />
Strength: <input type='text' STYLE='color: black;  background-color: white;' name='strength' value='10' /><br />
Agility: <input type='text' STYLE='color: black;  background-color: white;' name='agility' value='10' /><br />
Guard: <input type='text' STYLE='color: black;  background-color: white;' name='guard' value='10' /><br />
Labour: <input type='text' STYLE='color: black;  background-color: white;' name='labour' value='10' /><br />
IQ: <input type='text' STYLE='color: black;  background-color: white;' name='iq' value='10' /><br />
Rob Skill: <input type='text' STYLE='color: black;  background-color: white;' name='robskill' value='5' /><br /> 
<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Create User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";}
function new_user_submit()
{
global $db,$ir,$c,$userid;
if($ir['user_level'] != 2)
{
die("403");
}
if(!isset($_POST['username']) || !isset($_POST['login_name']) || !isset($_POST['userpass']))
{
print "You missed one or more of the required fields. Please go back and try again.<br />
<a href='admin.php?action=newuser'>&gt; Back</a>";
$h->endpage();
exit;
}
$level=abs((int) $_POST['level']);
$money=abs((int) $_POST['money']);
$crystals=abs((int) $_POST['crystals']);
$donator=abs((int) $_POST['donatordays']);
$ulevel=abs((int) $_POST['user_level']);
$strength=abs((int) $_POST['strength']);
$agility=abs((int) $_POST['agility']);
$guard=abs((int) $_POST['guard']);
$labour=abs((int) $_POST['labour']);
$robskill=abs((int) $_POST['robskill']); 

$iq=abs((int) $_POST['iq']);
$energy=10+$level*2;
$brave=3+$level*2;
$hp=50+$level*50;
$db->query("INSERT INTO users (username, login_name, userpass, level, money, crystals, donatordays, user_level, energy, maxenergy, will, maxwill, brave, maxbrave, hp, maxhp, location, gender, signedup, email, bankmoney) VALUES( '{$_POST['username']}', '{$_POST['login_name']}', md5('{$_POST['userpass']}'), $level, $money, $crystals, $donator, $ulevel, $energy, $energy, 100, 100, $brave, $brave, $hp, $hp, 1, '{$_POST['gender']}', unix_timestamp(), '{$_POST['email']}', -1)");
$i=mysql_insert_id($c);
$db->query("INSERT INTO userstats (userid,strength,agility,guard,labour,IQ,robskill) VALUES($i, $strength, $agility, $guard, $labour, $iq, $robskill)");
print "User created!";
stafflog_add("Created user {$_POST['username']} [$i]");
} 
function edit_user_begin()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] != 2)
{
die("403");
}
print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Editing User</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

You can edit any aspect of this user. <br />
<form action='staff_users.php?action=edituserform' method='post'>
User: ".user_dropdown($c,'user')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit User' /></form>
OR enter a user ID to edit:
<form action='staff_users.php?action=edituserform' method='post'>
User: <input type='text' STYLE='color: black;  background-color: white;' name='user' value='0' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";}
function edit_user_form()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] != 2)
{
die("403");
}
$d=$db->query("SELECT u.*,us.* FROM users u LEFT JOIN userstats us on u.userid=us.userid WHERE u.userid={$_POST['user']}");
$itemi=$db->fetch_row($d);
$itemi['hospreason']=htmlspcl($itemi['hospreason']);
$itemi['jail_reason']=htmlspcl($itemi['jail_reason']);
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Editing User</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_users.php?action=editusersub' method='post'>
<input type='hidden' name='userid' value='{$_POST['user']}' />
Username: <input type='text' STYLE='color: black;  background-color: white;' name='username' value='{$itemi['username']}' /><br />
Login Name: <input type='text' STYLE='color: black;  background-color: white;' name='login_name' value='{$itemi['login_name']}' /><br />
Duties: <input type='text' STYLE='color: black;  background-color: white;' name='duties' value='{$itemi['duties']}' /><br />
Staff Notes: <input type='text' STYLE='color: black;  background-color: white;' name='staffnotes' value='{$itemi['staffnotes']}' /><br />
Level: <input type='text' STYLE='color: black;  background-color: white;' name='level' value='{$itemi['level']}' /><br />
Money: \$<input type='text' STYLE='color: black;  background-color: white;' name='money' value='{$itemi['money']}' /><br />
Bank: \$<input type='text' STYLE='color: black;  background-color: white;' name='bankmoney' value='{$itemi['bankmoney']}' /><br />
Cyber Bank: \$<input type='text' STYLE='color: black;  background-color: white;' name='cybermoney' value='{$itemi['cybermoney']}' /><br />
Crystals: <input type='text' STYLE='color: black;  background-color: white;' name='crystals' value='{$itemi['crystals']}' /><br />
Mail Ban: <input type='text' STYLE='color: black;  background-color: white;' name='mailban' value='{$itemi['mailban']}' /><br />
Mail Ban Reason: <input type='text' STYLE='color: black;  background-color: white;' name='mb_reason' value='{$itemi['mb_reason']}' /><br />
Forum Ban: <input type='text' STYLE='color: black;  background-color: white;' name='forumban' value='{$itemi['forumban']}' /><br />
Forum Ban Reason: <input type='text' STYLE='color: black;  background-color: white;' name='fb_reason' value='{$itemi['fb_reason']}' /><br />
Hospital time: <input type='text' STYLE='color: black;  background-color: white;' name='hospital' value='{$itemi['hospital']}' /><br />
Hospital reason: <input type='text' STYLE='color: black;  background-color: white;' name='hospreason' value='{$itemi['hospreason']}' /><br />
Jail time: <input type='text' STYLE='color: black;  background-color: white;' name='jail' value='{$itemi['jail']}' /><br />
Jail reason: <input type='text' STYLE='color: black;  background-color: white;' name='jail_reason' value='{$itemi['jail_reason']}' /><br />
House: ".house2_dropdown($c, "maxwill", $itemi['maxwill'])."<br />
<h4>Stats</h4>
Strength: <input type='text' STYLE='color: black;  background-color: white;' name='strength' value='{$itemi['strength']}' /><br />
Agility: <input type='text' STYLE='color: black;  background-color: white;' name='agility' value='{$itemi['agility']}' /><br />
Guard: <input type='text' STYLE='color: black;  background-color: white;' name='guard' value='{$itemi['guard']}' /><br />
Labour: <input type='text' STYLE='color: black;  background-color: white;' name='labour' value='{$itemi['labour']}' /><br />
IQ: <input type='text' STYLE='color: black;  background-color: white;' name='IQ' value='{$itemi['IQ']}' /><br />
Rob Skill: <input type='text' STYLE='color: black;  background-color: white;' name='robskill' value='{$itemi['robskill']}' /><br />   
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";}
function edit_user_sub()
{

global $db,$ir,$c,$h,$userid;
if($ir['user_level'] != 2)
{
die("403");
}
$go=0;
if(!isset($_POST['level'])) { $go=1; }
if(!isset($_POST['money'])) { $go=1; }
if(!isset($_POST['bankmoney'])) { $go=1; }
if(!isset($_POST['crystals'])) { $go=1; }
if(!isset($_POST['strength'])) { $go=1; }
if(!isset($_POST['agility'])) { $go=1; }
if(!isset($_POST['guard'])) { $go=1; }
if(!isset($_POST['labour'])) { $go=1; }
if(!isset($_POST['IQ'])) { $go=1; }
if(!isset($_POST['robskill'])) { $go=1; }  
if(!isset($_POST['username'])) { $go=1; }
if(!isset($_POST['login_name'])) { $go=1; }
if($go)
{
print "You did not fully fill out the form.";
$_POST['user']=$_POST['userid'];
edit_user_form();
}
else
{
$_POST['level']=(int) $_POST['level'];
$_POST['strength']=abs((int) $_POST['strength']);
$_POST['agility']=abs((int) $_POST['agility']);
$_POST['guard']=abs((int) $_POST['guard']);
$_POST['labour']=abs((int) $_POST['labour']);
$_POST['IQ']=abs((int) $_POST['IQ']);
$_POST['robskill']=abs((int) $_POST['robskill']); 
$_POST['money']=(int) $_POST['money'];
$_POST['bankmoney']=(int) $_POST['bankmoney'];
$_POST['cybermoney']=(int) $_POST['cybermoney'];
$_POST['crystals']=(int) $_POST['crystals'];
$_POST['mailban']=(int) $_POST['mailban'];
$_POST['forumban']=(int) $_POST['forumban'];
$maxwill=abs((int) $_POST['maxwill']);

//check for username usage
$u=$db->query("SELECT * FROM users WHERE username='{$_POST['username']}' and userid != {$_POST['userid']}");
if($db->num_rows($u) != 0)
{
print "That username is in use, choose another.";
print "<br /><a href='admin.php?action=edituser'>&gt; Back</a>";
$h->endpage();
exit;
}
$oq=$db->query("SELECT * FROM users WHERE userid={$_POST['userid']}");
$rm=$db->fetch_row($oq);
$will=($rm['will'] > $maxwill) ? $maxwill: $rm['will'];
$energy=10+$_POST['level']*2;
$nerve=3+$_POST['level']*2;
$hp=50+$_POST['level']*50;
$db->query("UPDATE users SET username='{$_POST['username']}', level={$_POST['level']}, money={$_POST['money']}, crystals={$_POST['crystals']}, energy=$energy, brave=$nerve, maxbrave=$nerve, maxenergy=$energy, hp=$hp, maxhp=$hp, hospital={$_POST['hospital']}, jail={$_POST['jail']}, duties='{$_POST['duties']}', staffnotes='{$_POST['staffnotes']}', mailban={$_POST['mailban']}, mb_reason='{$_POST['mb_reason']}', forumban={$_POST['forumban']}, fb_reason='{$_POST['fb_reason']}', hospreason='{$_POST['hospreason']}', jail_reason='{$_POST['jail_reason']}', login_name='{$_POST['login_name']}', will=$will, maxwill=$maxwill WHERE userid={$_POST['userid']}");
$db->query("UPDATE userstats SET strength={$_POST['strength']}, agility={$_POST['agility']}, guard={$_POST['guard']}, labour={$_POST['labour']}, IQ={$_POST['IQ']}, robskill={$_POST['robskill']} WHERE userid={$_POST['userid']}");
stafflog_add("Edited user {$_POST['username']} [{$_POST['userid']}]");
print "User edited....<a href='?action=edituser'>>Continue editing<</a>";

} }
function deluser()
{
global $ir,$c,$h,$userid,$db;
if($ir['user_level'] != 2)
{
die("403");
}
$undeletable = array('1','2'); // add more IDs here, such as NPCs
switch ($_GET['step'])
{
   default:
      echo "
      
      <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Deleteing User</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

      Here you can delete a user. <br />
      <form action='staff_users.php?action=deluser&step=2' method='post'>
      User: ".user_dropdown($c,'user')."<br />
      <input type='submit' STYLE='color: black;  background-color: white;' value='Delete User' /></form>
      OR enter a user ID to Delete:
      <form action='staff_users.php?action=deluser&step=2' method='post'>
      User: <input type='text' STYLE='color: black;  background-color: white;' name='user' value='0' /><br />
      <input type='submit' STYLE='color: black;  background-color: white;' value='Delete User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";break;
   case 2:
      $target = $_POST['user'];
      if (!is_numeric($target)) exit;
      if (in_array($target,$undeletable)) {
         die('You cannot delete this person.');
      }
      $d=$db->query("SELECT username FROM users WHERE userid='$target'");
      $itemi=$db->fetch_row($d);
      print "
      
      <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Confirm</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
      
      Delete user ".$itemi["username"]."?
      <form action='staff_users.php?action=deluser&step=3' method='post'>
      <input type='hidden' name='userid' value='$target' />
      <input type='submit' STYLE='color: black;  background-color: white;' name='yesorno' value='Yes' />
      <input type='submit' STYLE='color: black;  background-color: white;' name='yesorno' value='No' onclick=\"window.location='staff_users.php?action=deluser';\" /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";break;
   case 3:
      $target = $_POST['userid'];
      if (!is_numeric($target)) exit;
      if (in_array($target,$undeletable)) {
         die('You cannot delete this person.');
      }
      if($_POST['yesorno']=='No')
      {
         die("User not deleted.<br><a href='staff_users.php?action=deluser'>&gt;Back to main Delete Users page.</a>");
      }
      if ($_POST['yesorno'] != ("No" || "Yes")) die('Eh');
     $d=$db->query("SELECT username FROM users WHERE userid='$target'");
      $itemi=$db->fetch_row($d);
      $db->query("DELETE FROM users WHERE userid='$target'");
      $db->query("DELETE FROM userstats WHERE userid='$target'");
      $db->query("DELETE FROM inventory WHERE inv_userid='$target'");
      $db->query("DELETE FROM fedjail WHERE fed_userid='$target'");
      echo "User {$itemi['username']} Deleted.<br><a href='staff_users.php?action=deluser'>&gt;Back to main Delete Users page.</a>";
stafflog_add("Deleted User {$itemi['username']} [{$_POST['userid']}]");     
   break;
}
} 
function inv_user_begin()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 3)
{
die("403");
}
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'>Viewing User Inventory</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

You may browse this user's inventory.<br />
<form action='staff_users.php?action=invuser' method='post'>
User: ".user_dropdown($c,'user')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='View Inventory' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";}
function inv_user_view()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 3)
{
die("403");
}
$d=$db->query("SELECT username FROM users WHERE userid='{$_POST['user']}'");
      $un=$db->fetch_single($d);
$inv=$db->query("SELECT iv.*,i.*,it.* FROM inventory iv LEFT JOIN items i ON iv.inv_itemid=i.itmid LEFT JOIN itemtypes it ON i.itmtype=it.itmtypeid WHERE iv.inv_userid={$_POST['user']}");
if ($db->num_rows($inv) == 0)
{
print "<b>This person has no items!</b>";
}
else
{
print "<b>Their items are listed below.</b><br />
<table width=100%><tr style='background-color:gray;'><th>Item</th><th>Sell Value</th><th>Total Sell Value</th><th>Links</th></tr>";
while($i=$db->fetch_row($inv))
{
print "<tr><td>{$i['itmname']}";
if ($i['inv_qty'] > 1)
{
print "&nbsp;x{$i['inv_qty']}";
}
print "</td><td>\${$i['itmsellprice']}</td><td>";
print "$".($i['itmsellprice']*$i['inv_qty']);
print "</td><td>[<a href='staff_users.php?action=deleinv&ID={$i['inv_id']}'>Delete</a>]";
print "</td></tr>";
}
print "</table>";
}
stafflog_add("Viewed user {$un} [{$_POST['user']}] inventory");
}
function inv_delete()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 3)
{
die("403");
}

$db->query("DELETE FROM inventory WHERE inv_id={$_GET['ID']}");
print "Item deleted from inventory.";
stafflog_add("Deleted inventory ID {$_GET['ID']}");
}
function credit_user_form()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 3)
{
die("403");
}
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Crediting User</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


You can give a user money/crystals.<br />
<form action='staff_users.php?action=creditsub' method='post'>
User: ".user_dropdown($c,'user')."<br />
Money: <input type='text' STYLE='color: black;  background-color: white;' name='money' /> Crystals: <input type='text' STYLE='color: black;  background-color: white;' name='crystals' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Credit User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";}
function credit_user_submit()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 3)
{
die("403");
}
$_POST['money'] = (int) $_POST['money'];
$_POST['crystals'] = (int) $_POST['crystals'];
$db->query("UPDATE users u SET money=money+{$_POST['money']}, crystals=crystals+{$_POST['crystals']} WHERE u.userid={$_POST['user']}");
print "User credited.";
$d=$db->query("SELECT username FROM users WHERE userid='{$_POST['user']}'");
      $un=$db->fetch_single($d);
stafflog_add("Credited $un [{$_POST['user']}] \${$_POST['money']} and/or {$_POST['crystals']} crystals.");
}
function mcredit_user_form()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 2)
{
die("403");
}
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Mass Payment</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

You can give all users money/crystals.<br />
<form action='staff_users.php?action=masscreditsub' method='post'>
Money: <input type='text' STYLE='color: black;  background-color: white;' name='money' /> Crystals: <input type='text' STYLE='color: black;  background-color: white;' name='crystals' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Credit User' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";}
function mcredit_user_submit()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 2)
{
die("403");
}
$_POST['money'] = (int) $_POST['money'];
$_POST['crystals'] = (int) $_POST['crystals'];
$db->query("UPDATE users u SET money=money+{$_POST['money']}, crystals=crystals+{$_POST['crystals']}");
print "All Users credited. Click <a href='staff.php?action=announce'>here to add an announcement</a> or <a href='staff_special.php?action=massmailer'>here to send a mass mail</a> explaining why.";
stafflog_add("Credited all users \${$_POST['money']} and/or {$_POST['crystals']} crystals.");
}
function reports_view()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 3)
{
die("403");
}
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Player Reports</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table width=80%><tr style='background:gray'><th>Reporter</th> <th>Offender</th> <th>What they did</th> <th>&nbsp;</th> </tr>";
$q=$db->query("SELECT pr.*,u1.username as reporter, u2.username as offender FROM preports pr LEFT JOIN users u1 ON u1.userid=pr.prREPORTER LEFT JOIN users u2 ON u2.userid=pr.prREPORTED ORDER BY pr.prID DESC");
while($r=$db->fetch_row($q))
{
print "\n<tr> <td><a href='viewuser.php?u={$r['prREPORTER']}'>{$r['reporter']}</a> [{$r['prREPORTER']}]</td> <td><a href='viewuser.php?u={$r['prREPORTED']}'>{$r['offender']}</a> [{$r['prREPORTED']}]</td> <td>{$r['prTEXT']}</td> <td><a href='staff_users.php?action=repclear&ID={$r['prID']}'>Clear</a></td> </tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}
function forcelogout()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 2)
{
die("403");
}
$_POST['userid'] = abs((int) $_POST['userid']);
if($_POST['userid'])
{
$db->query("UPDATE users SET force_logout=1 WHERE userid={$_POST['userid']}");
print "User ID {$_POST['userid']} successfully forced to logout.";
stafflog_add("Forced User ID {$_POST['userid']} to logout");
}
else
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Force User Logout</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

The user will be automatically logged out next time he/she makes a hit to the site.<form action='staff_users.php?action=forcelogout' method='post'>
User: ".user_dropdown($c, 'userid')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Force User to Logout' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";}
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
