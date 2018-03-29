<?php
include "globals.php";
if($ir['jail'] or $ir['hospital']) { die("This page cannot be accessed while in jail or hospital."); }
if(!$_GET['spend'])
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Five Star Protection Agency</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><center><br> <br><br>

<img src='images/swat.png' alt='BODYGUARD' /><br/>

Welcome, here you can hire a bodyguard to protect you for a limited ammount of time.<br/>
Prices and payment options are listed below, different currencies have different prices.<br/>

<br />

<table align='center' class='table'>
	<tr><th colspan='2'>Pay With Money</th></tr>
	<tr>
		<td>
			<img src='images/money.png' alt='Pay With Money' />
		</td>
		<td>
			<a href='bodyguard.php?spend=5minsM'>Hire For 5 Minutes - \$5,000,000</a><br />
			<a href='bodyguard.php?spend=10minsM'>Hire For 10 Minutes - \$10,000,000</a><br />
			<a href='bodyguard.php?spend=30minsM'>Hire For 30 Minutes - \$30,000,000</a><br />
			<a href='bodyguard.php?spend=1hourM'>Hire For 1 Hour - \$60,000,000</a><br /><br />
		</td>
	</tr>
</table>
<br/>



<table align='center' class='table'>
	<tr><th colspan='2'>Pay With Crystals</th></tr>
	<tr>
		<td>
			<img src='images/crystal.png' alt='Pay With Crystals' />
		</td>
		<td>
			<a href='bodyguard.php?spend=5minsC'>Hire for 5 Minutes - 50 Crystals</a><br />
			<a href='bodyguard.php?spend=10minsC'>Hire for 10 Minutes - 100 Crystals</a><br />
			<a href='bodyguard.php?spend=30minsC'>Hire for 30 Minutes - 300 Crystals</a><br />
			<a href='bodyguard.php?spend=1hourC'>Hire for 1 Hour - 600 Crystals</a><br /><br/><br/><br/><br/>
		</td>
	</tr>
</table>
</center>
</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>

";
}
else
{
if($_GET['spend'] == '5minsM')
{
if($ir['money'] <5000000)
{
print "You don't have enough money to hire a bodyguard!";
}
else
{
$db->query("UPDATE users SET bguard=bguard+5,money=money-5000000 WHERE userid=$userid");
print "Congratulations, You payed a bodyguard \$5,000,000 to protect you for 5 minutes.";
}
}
else if($_GET['spend'] == '10minsM')
{
if($ir['money'] <10000000)
{
print "You don't have enough money to hire a bodyguard!";
}
else
{
$db->query("UPDATE users SET bguard=bguard+10,money=money-10000000 WHERE userid=$userid");
print "Congratulations, You payed a bodyguard \$10,000,000 to protect you for 10 minutes.";
}
}
else if($_GET['spend'] == '30minsM')
{
if($ir['money'] <30000000)
{
print "You don't have enough money to hire a bodyguard!";
}
else
{
$db->query("UPDATE users SET bguard=bguard+30,money=money-30000000 WHERE userid=$userid");
print "Congratulations, You payed a bodyguard \$30,000,000 to protect you for 30 minutes.";
}
}
else if($_GET['spend'] == '1hourM')
{
if($ir['money'] <60000000)
{
print "You don't have enough money to hire a bodyguard!";
}
else
{
$db->query("UPDATE users SET bguard=bguard+60,money=money-60000000 WHERE userid=$userid");
print "Congratulations, You payed a bodyguard \$60,000,000 to protect you for 1 hour.";
}
}
else if($_GET['spend'] == '5minsC')
{
if($ir['crystals'] <50)
{
print "You don't have enough silver to hire a bodyguard!";
}
else
{
$db->query("UPDATE users SET bguard=bguard+5,crystals=crystals-50 WHERE userid=$userid");
print "Congratulations, You payed a bodyguard 50 Crystals to protect you for 5 minutes.";
}
}
else if($_GET['spend'] == '10minsC')
{
if($ir['crystals'] <100)
{
print "You don't have enough crystals to hire a bodyguard!";
}
else
{
$db->query("UPDATE users SET bguard=bguard+10,crystals=crystals-100 WHERE userid=$userid");
print "Congratulations, You payed a bodyguard 100 Crystals to protect you for 10 minutes.";
}
}
else if($_GET['spend'] == '30minsC')
{
if($ir['crystals'] <300)
{
print "You don't have enough crystals to hire a bodyguard!";
}
else
{
$db->query("UPDATE users SET bguard=bguard+30,crystals=crystals-300 WHERE userid=$userid");
print "Congratulations, You payed a bodyguard 300 Crystals to protect you for 30 minutes.";
}
}
else if($_GET['spend'] == '1hourC')
{
if($ir['crystals'] <600)
{
print "You don't have enough crystals to hire a bodyguard!";
}
else
{
$db->query("UPDATE users SET bguard=bguard+60,crystals=crystals-600 WHERE userid=$userid");
print "Congratulations, You payed a bodyguard 600 Crystals to protect you for 1 hour.";
}
}
}
$h->endpage();
?>