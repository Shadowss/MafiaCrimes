<?php
include "globals.php";


switch($_GET['action'])
{
case 'play1': play_slots1(); break;
case 'play2': play_slots2(); break;
case 'play3': play_slots3(); break;
default: slot_index(); break;
}

function slot_index()
{
global $ir,$c,$h,$userid,$db;


$slot=$db->query("SELECT * FROM `4slot` WHERE `name`='1'");
$pot=$db->fetch_row($slot);

$pota=money_formatter($pot['pot']);
$potb=money_formatter($pot['pot2']); 
$potc=money_formatter($pot['pot3']); 

print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Magic Slots</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br> 

This is a community based game where every time you lose you add your money to the pot. Whoever wins gets all the money in the pot. To win you need to line up 111, 555, or 999.<br /><br /> 

<table width = 75% class=table>

<tr>

<th>Slot Type </th> <th>Pot </th> <th>Play </th>

</tr>

<tr><td>$100 Slots</td><td>$pota</td><td>
<form action='magicslots.php?action=play1' method='post'><input type='submit' value='Play $100 Slots' /></form></td></tr>
<tr>
<td>$1,000 Slots</td><td>$potb</td><td><form action='magicslots.php?action=play2' method='post'><input type='submit' value='Play $1,000 Slots' /></form></td></tr><tr><td>$10,000 Slots</td><td>$potc</td><td><form action='magicslots.php?action=play3' method='post'><input type='submit' value='Play $10,000 Slots' /></form></td></tr>

</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";

}



function play_slots1()
{
global $ir,$c,$h,$userid,$db;


if($ir['money'] < 100)
{
print "

<div id='mainOutput' style='text-align: center; color: white;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>
You do not have enough money to play

<br/> <br/> <br/> 

<a href='index.php'><b>Back To Home</b></a>

<a 

";
$h->endpage();    
exit;
}


$slot=$db->query("SELECT * FROM `4slot` WHERE `name`='1'");
$pot=$db->fetch_row($slot);
$db->query("UPDATE users SET money=money-100 WHERE $userid=userid");
$db->query("UPDATE 4slot SET pot=pot+100 WHERE name=1");

$slotnumber1=rand(1,9);
$slotnumber2=rand(1,9);
$slotnumber3=rand(1,9);
$crap=1;
$pota=money_formatter($pot['pot']);

print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Magic Slots | Current Pot At: $pota</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br> 

<h2><b><center>$slotnumber1$slotnumber2$slotnumber3</center></b></h2><br />";

if($slotnumber1==1 && $slotnumber2==1 && $slotnumber3==1 || $slotnumber1==5 && $slotnumber2==5 && $slotnumber3==5 || $slotnumber1==9 && $slotnumber2==9 && $slotnumber3==9)
{
print "<center><b>Congrats You Won!</b><br />You won {$pot['pot']}!!!";
$db->query("UPDATE users SET money=money+{$pot['pot']} WHERE $userid=userid");
$db->query("UPDATE 4slot SET pot=100 WHERE name=1");
}
else
{
print "<center> Sorry you did not win this time</center><br /><br />";
}
print "<center> <a href='magicslots.php?action=play1'>Play again?</a> | <a href='magicslots.php'>Back</a></center></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}

function play_slots2()
{
global $ir,$c,$h,$userid,$db;

if($ir['money'] < 1000)
{
print "

<div id='mainOutput' style='text-align: center; color: white;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>
You do not have enough money to play

<br/> <br/> <br/> 

<a href='index.php'><b>Back To Home</b></a>

<a 

";
$h->endpage();    
exit;
}

$slot=$db->query("SELECT * FROM `4slot` WHERE `name`='1'");
$pot=$db->fetch_row($slot);
$db->query("UPDATE users SET money=money-1000 WHERE $userid=userid");
$db->query("UPDATE 4slot SET pot2=pot2+1000 WHERE name=1");

$slotnumber1=rand(1,9);
$slotnumber2=rand(1,9);
$slotnumber3=rand(1,9);
$crap=1;
$potb=money_formatter($pot['pot2']);

print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Magic Slots | Current Pot At: $potb</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br> 

<h2><b><center>$slotnumber1$slotnumber2$slotnumber3</center></b></h2><br />";

if($slotnumber1==1 && $slotnumber2==1 && $slotnumber3==1 || $slotnumber1==5 && $slotnumber2==5 && $slotnumber3==5 || $slotnumber1==9 && $slotnumber2==9 && $slotnumber3==9)
{
print "<center><b>Congrats You Won!</b><br />You won {$pot['pot2']}!!!";
$db->query("UPDATE users SET money=money+{$pot['pot2']} WHERE $userid=userid");
$db->query("UPDATE 4slot SET pot2=1000 WHERE name=1");
}
else
{
print "<center> Sorry you did not win this time</center><br /><br />";
}
print "<center><a href='magicslots.php?action=play2'>Play again?</a> | <a href='magicslots.php'>Back</a></center></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}

function play_slots3()
{
global $ir,$c,$h,$userid,$db;

if($ir['money'] < 10000)
{
print "

<div id='mainOutput' style='text-align: center; color: white;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>
You do not have enough money to play

<br/> <br/> <br/> 

<a href='index.php'><b>Back To Home</b></a>

<a 

";
$h->endpage();    
exit;
}

$slot=$db->query("SELECT * FROM `4slot` WHERE `name`='1'");
$pot=$db->fetch_row($slot);
$db->query("UPDATE users SET money=money-10000 WHERE $userid=userid");
$db->query("UPDATE 4slot SET pot3=pot3+10000 WHERE name=1");

$slotnumber1=rand(1,9);
$slotnumber2=rand(1,9);
$slotnumber3=rand(1,9);
$crap=1;
$potc=money_formatter($pot['pot3']); 

print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Magic Slots | Current Pot At: $potc </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br> 

<h2><b><center>$slotnumber1$slotnumber2$slotnumber3</center></b></h2><br />";

if($slotnumber1==1 && $slotnumber2==1 && $slotnumber3==1 || $slotnumber1==5 && $slotnumber2==5 && $slotnumber3==5 || $slotnumber1==9 && $slotnumber2==9 && $slotnumber3==9)
{
print "<center><b>Congrats You Won!</b><br />You won {$pot['pot3']}!!!";
$db->query("UPDATE users SET money=money+{$pot['pot3']} WHERE $userid=userid");
$db->query("UPDATE 4slot SET pot3=10000 WHERE name=1");
}
else
{
print "<center> Sorry you did not win this time</center><br /><br />";
}
print "<center><a href='magicslots.php?action=play3'>Play again?</a> | <a href='magicslots.php'>Back</a></center></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}

$h->endpage();


?>