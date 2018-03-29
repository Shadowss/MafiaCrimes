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

include "globals.php";
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Cyber Bank</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

";
if($ir['cybermoney']>-1)
{
switch($_GET['action'])
{
case "deposit":
deposit();
break;

case "withdraw":
withdraw();
break;

default:
index();
break;
}

}
else
{
if(isset($_GET['buy']))
{
if($ir['money']>9999999)
{
print "Congratulations, you bought a bank account for \$10,000,000!<br />
<a href='cyberbank.php'>Start using my account</a>";
$db->query("UPDATE users SET money=money-10000000,cybermoney=0 WHERE userid=$userid");
}
else
{
print "You do not have enough money to open an account.
<a href='explore.php'>Back to town...</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}
}
else
{
print "Open a bank account today, just \$10,000,000!<br />
<a href='cyberbank.php?buy'>&gt; Yes, sign me up!</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}
}
function index()
{
global $db,$ir,$c,$userid,$h;
$interest= $ir['cybermoney']/100*7 ;
$interests=money_formatter($interest);
$balance=money_formatter($ir['cybermoney']);
print " \n<b>You currently have $balance in the bank.</b><br/>
At the end of each day, your bank balance will go up by 7%.<br/>Interest each day for the current deposit is $interests<br />
<table width=100% class = table border=1> <tr><th>Deposit</th><th>Withdraw</th></tr><tr>
<td>
It will cost you 15% of the money you deposit, rounded up. The maximum fee is \$1,500,000.<form action='cyberbank.php?action=deposit' method='post'>
Amount: <input type='text' STYLE='color: black;  background-color: white;' name='deposit' value='{$ir['money']}' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Deposit' /></form></td> <td>
<b>Withdraw</b><br />
It will cost you nothing for the withdrawl of money. You can withdraw as many times as you want.<form action='cyberbank.php?action=withdraw' method='post'>
Amount: <input type='text' STYLE='color: black;  background-color: white;' name='withdraw' value='{$ir['cybermoney']}' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Withdraw' /></form></td> </tr> </table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}
function deposit()
{
global $db,$ir,$c,$userid,$h;
$_POST['deposit']=abs((int) $_POST['deposit']);
if($_POST['deposit'] > $ir['money'])
{
print "You do not have enough money to deposit this amount.</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div></a>";
}
else
{
$fee=ceil($_POST['deposit']*15/100);
$fees= money_formatter($fee); 
if($fee > 1500000) { $fee=1500000; }
$gain=$_POST['deposit']-$fee;
$gains= money_formatter($gain);
$balance= $ir['cybermoney'] + $gain;
$balances= money_formatter($balance);    
$db->query("UPDATE users SET cybermoney=cybermoney+$gain, money=money-{$_POST['deposit']} where userid=$userid");
print "You hand over \${$_POST['deposit']} to be deposited, <br />
after the fee is taken ($fees), $gains is added to your account. <br />
<b>You now have $balances in the Cyber Bank.</b><br />
<a href='cyberbank.php'> Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
function withdraw()
{
global 
$db,$ir,$c,$userid,$h;
$_POST['withdraw']=abs((int) $_POST['withdraw']);
if($_POST['withdraw'] > $ir['cybermoney'])

{
print "You do not have enough banked money to withdraw this amount.</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div></a>";
}

else {
    

$withdraw=$_POST['withdraw'];
$withdraws=money_formatter($withdraw); 

$balance= $ir['cybermoney'] - $_POST['withdraw'];
$balances= money_formatter($balance);

$db->query("UPDATE users SET cybermoney=cybermoney-$withdraw, money=money+$withdraw where userid=$userid");
print "You ask to withdraw $withdraws, <br />
The teller hands $withdraws to you. <br />
<b>You now have $balances in the Cyber Bank.</b><br />
<a href='cyberbank.php'> Back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div></a>";

}
}
$h->endpage();
?>
