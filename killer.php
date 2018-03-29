<?php
include(DIRNAME(__FILE__) . '/globals.php');
$_GET['x'] = isset($_GET['x']) && is_string($_GET['x']) ? strtolower(trim($_GET['x'])) : false;
switch($_GET['x'])
{
case 'step1': step1(); break;
case 'step2': step2(); break;
default: index(); break;
}
function index()
{

echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg"alt=""/></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Hiring A Killer</h2></div>
<div><img src="images/info_right.jpg"alt=""/></div> </div>
<div class="generalinfo_simple"><br> <br><br>


Assassinating a user is a good way to gain the upper hand against a higher level player.<br />
Using this feature will send the user to hospital after you pay a small fee.<br />
The cost of this feature is $10,000 * the users Level.<br />

<form method="post" action="killer.php?x=step1">
<input value="Next" STYLE="color: black;  background-color: white;" type="submit">
</form>

</div><div><img src="images/generalinfo_btm.jpg"alt=""/></div><br></div></div></div></div></div>';
}
function step1()
{
echo '


 <div class="generalinfo_txt">
<div><img src="images/info_left.jpg"alt=""/></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Hiring A Killer</h2></div>
<div><img src="images/info_right.jpg"alt=""/></div> </div>
<div class="generalinfo_simple"><br> <br><br>



Remember hiring a killer costs $10,000 * The targets level. If you choose to keep your name hidden this will cost $50,000 extra<br /><br />
<form action="killer.php?x=step2" method="post">
User: '.user_dropdown($c,'user').'<br /><br />
Keep Your name hidden? <br /><input name="hidden" value="0" checked="checked" type="radio"> No <input name="hidden" value="1" type="radio"> Yes
<br /><input value="Next" STYLE="color: white;  background-color: red;" type="submit">
</form>
</div><div><img src="images/generalinfo_btm.jpg"alt=""/></div><br></div></div></div></div></div>';
}
function step2()
{
global $db, $ir, $h;
$a=$db->query("SELECT `username`, `level`, `userid`, `hospital`, `jail` `bguard` FROM `users` WHERE `userid`= {$_POST['user']}");
$bodyguard=$db->query("SELECT `bguard` FROM `users` WHERE `userid`= {$_POST['user']}");
$protection=$db->fetch_row($bodyguard);


if(!$db->num_rows($a))
{
echo 'This user does not exist!';
$h->endpage();
exit;
}
while($assas=$db->fetch_row($a))
{
$cost=$assas['level']*10000;
$cost2=$assas['level']*10000+50000;
$hosp=mt_rand(70,160);
if($_POST['hidden'] ==1)
{
if($ir['userid'] == $assas['userid'])
{
echo 'You cannot assassinate your self!';
$h->endpage();
exit;
}
if($ir['money'] <$cost2)
{
echo 'You do not have enough to assassinate '.$assas['username'].'';
$h->endpage();
exit;
}

if($protection['bguard'] >0)
{
echo ' <h2> <font color=red>Assasination FAILED ! </font> </h2>  <br><br> <h4>  Your hired assasin is severely beaten by '.$assas['username'].'\'s bodyguard. </h4> ';
$h->endpage();
exit;
}



if($assas['hospital'] || $assas['jail'])
{
echo 'This user is in hospital or jail so they cannot be assassinated.';
$h->endpage();
exit;
}
$db->query("UPDATE `users` SET `hospital`= {$hosp}, `hospreason`= 'Assassinated By Someone' WHERE `userid`={$assas['userid']}");
$db->query("UPDATE `users` SET `money`=`money`-{$cost2} WHERE `userid`={$ir['userid']}");
event_add($assas['userid'],"You was assassinated by someone");
echo 'You have paid $'.$cost2.' to assassinate '.$assas['username'].' for '.$hosp.' Minutes';
}
else
{
if($ir['userid'] == $assas['userid'])
{
echo 'You cannot assassinate your self!';
$h->endpage();
exit;
}
if($ir['money'] <$cost)
{
echo 'You do not have enough to assassinate '.$assas['username'].'';
$h->endpage();
exit;
}

if($protection['bguard'] >0)
{
echo ' <h2> <font color=red>Assasination FAILED ! </font> </h2>  <br><br> <h4>  Your hired assasin is severely beaten by '.$assas['username'].'\'s bodyguard. </h4> ';
$h->endpage();
exit;
}

if($assas['hospital'] || $assas['jail'])
{
echo 'This user is in hospital or jail so they cannot be assassinated.';
$h->endpage();
exit;
}
$db->query("UPDATE `users` SET `hospital`= {$hosp}, `hospreason`= 'Assassinated By {$ir['username']}' WHERE `userid`={$assas['userid']}");
$db->query("UPDATE `users` SET `money`=`money`-{$cost} WHERE `userid`={$ir['userid']}");
event_add($assas['userid'],"You was assassinated by <a href='viewuser.php?u={$ir['userid']}' />{$ir['username']}</a>");
echo 'You have paid $'.$cost.' to assassinate '.$assas['username'].' for '.$hosp.' Minutes';
}
}
}
?> 