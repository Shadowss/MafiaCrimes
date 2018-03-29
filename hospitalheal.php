<?php
/*
+------------------------------+
|  MCCodes 2.0.0               |
|  © 2010 Pudda                |
|  http://mccodes.com/         |
+------------------------------+
*/
include_once(DIRNAME(__FILE__) . '/globals.php');
if($ir['hospital'])
{
  echo 'Were sorry but your still in hospital. please go <a href="index.php">Back</a>';
exit($h->endpage());
}
if($ir['jail'])
{
  echo 'Were sorry but your still in jail. please go <a href="index.php">Back</a>';
exit($h->endpage());
}
$r=$db->fetch_row($db->query("SELECT `userid`,`username`,`level`,`hospital` FROM users WHERE userid=".abs(@intval($_GET['ID'])).""));
if(!$r['userid'])
{
  echo 'Were sorry but we could not find a user with the ID given';
  exit($h->endpage());
}
if(!$r['hospital'])
{
echo 'User is not in hospital';
  exit($h->endpage());
}
$cost=$r['level']*5000;
$cf=number_format($cost);
if($ir['money'] < $cost)
{
 echo 'Were sorry but you seem to short on funds, You will need <span style = "color:#8B0000; font-family:Segoe UI">'.$cf.'$</span> to heal '.htmlentities($r['username']).'';
 exit($h->endpage());
}
echo 'Success: You have successfully healed '.htmlentities($r['username']).' We have taken the <span style = "color:#8B0000; font-family:Segoe UI">'.$cf.'</span> from your account<br /><a href="index.php">Go Back</a>';
  $db->query("UPDATE users SET money=money-{$cost} WHERE userid=$userid");
  $db->query("UPDATE users SET hospital='0',hospreason='' WHERE userid=".abs(intval($r['userid']))."");
  event_add($r['userid'],'<a href="viewuser.php?u='.abs(intval($ir['userid'])).'">'.htmlentities($ir['username']).'</a> healed from hospital.');
$h->endpage();
?>