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

include(DIRNAME(__FILE__).'/globals.php'); 
print pageHelp(_HELP_BANK_HEADER, _HELP_BANK);

echo "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Banking</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>";

if($ir['bankmoney']>-1) 
{
switch($_GET['action'])
{
case 'Withdraw': withdraw(); break;
case 'Deposit': deposit(); break;
default: index(); break;
}
}

else
{
if(isset($_GET['buy'])) 
{
$cost=20000;
if($ir['money']>$cost) 

{

$costy=number_format($cost);
echo "Congratulation you have Bought a Bank Account for \$$costy<br>><a href='bank.php'>Go to Bank</a>";
$sql = sprintf("UPDATE users SET bankmoney=0, money=money-$cost WHERE userid=$userid");
$db->query($sql);
}
else
{
echo "You do not have enough money to open an account <a href='index.php'>Back to town....</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>"; 
$h->endpage(); exit; 
}
}

else
{
print "Open a bank account today, just \$20,000 <br /> <br /> 
<a href='bank.php?buy'>Yes, sign me up!</a> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}
}




function index()
{
global $ir,$c,$userid;

$interest= $ir['bankmoney']/100*2 ;
$interests=money_formatter($interest);
$balance=money_formatter($ir['bankmoney']);  

echo "

<b>You currently have $balance in the bank.</b><br />
At the end of each day, your bank balance will go up by 2%.<br/>Interest each day for the current deposit is $interests<br />
<table width=100% class = table border=1> <tr><th>Deposit</th><th>Withdraw</th></tr><tr>
<td>
When adding to your account 2% is taken from you<br>
<form action='?action=Deposit' method='post'>
Amount: <input type='text' STYLE='color: black;  background-color: white;' name='dt' value='{$ir['money']}' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Deposit' /></form></td>

<td>
Withdrawl cash. No money is taken for withdrawl.
<form action='?action=Withdraw' method='post'>
Amount: <input type='text' STYLE='color: black;  background-color: white;' name='wd' value='{$ir['bankmoney']}' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Withdraw' /></form></td></tr>";
echo "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function withdraw()
{
global $ir,$c,$userid,$h,$db;
$_POST['wd'] = abs(intval($_POST['wd']));
$with=number_format($_POST['wd']);
$bkmon=number_format($ir['bankmoney']);
if($ir['bankmoney']<$_POST['wd']) { echo "You Tried Withdrawing <b>\$$with</b> but you only have <b>\$$bkmon</b></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div></a>"; $h->endpage(); exit; }
$total=number_format($ir['bankmoney']-$_POST['wd']);
echo "You Successfully Withdrew <b>\$$with</b><br>You now have <b>\$$total</b> in your Bank.<br><a href='bank.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";

$sql = sprintf("UPDATE users SET bankmoney=bankmoney-{$_POST['wd']}, money=money+{$_POST['wd']} WHERE userid=$userid");
$db->query($sql);
}
function deposit()
{
global $ir,$c,$userid,$h,$db;
$_POST['dt'] = abs(intval($_POST['dt']));
$dep=number_format($_POST['dt']);
$mon=number_format($ir['money']);
if($ir['money']<$_POST['dt']) { echo "You tried depositing <b>\$$dep</b> but you only have <b>\$$mon</b><br> <a href='bank.php'>Back</a></div><div> <img src='images/generalinfo_btm.jpg' alt='' /> </div><br></div></div></div></div></div>"; $h->endpage(); exit; }
$blah=$_POST['dt']/50;
if($blah>10000) { $blah=10000; }
$taken=number_format($blah);
$bank=$_POST['dt']-$blah;
$banky=number_format($bank);
$total=number_format($ir['bankmoney']+$bank);
echo "You successfully deposited <b>\$$banky</b> out of <b>\$$dep</b> into your bank account<br>The banker toke his <b>\$$taken</b> cut<br>You now have <b>\$$total</b> in your bank.<br><a href='bank.php'>Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";

$sql = sprintf("UPDATE users SET bankmoney=bankmoney+$bank, money=money-{$_POST['dt']} WHERE userid=$userid");
$db->query($sql);
}
$h->endpage();
?>