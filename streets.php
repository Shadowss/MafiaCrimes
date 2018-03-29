<?php

$noturns = "Sorry you dont seem to have any walks left today. Come back tomorrow";
include(DIRNAME(__FILE__) . '/globals.php');

if($ir['turns'] <= 0) {
print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
	<div class='generalinfo_simple'>");
echo $noturns;
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
exit;
}

if($ir['jail'] or $ir['hospital']) {
print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
	<div class='generalinfo_simple'>");
 print "This page cannot be accessed while in jail or hospital.";
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');

$h->endpage(); 
exit; 
}
print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
	<div class='generalinfo_simple'>");
$_GET['act'] = isset($_GET['act']) && is_string($_GET['act']) ? trim($_GET['act']) : "";
switch($_GET['act']) {
case 'search': search_streets(); break;
default: index(); break;
}
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');

function index() {
global $db, $ir, $userid, $h, $db;
$cityname = $db->fetch_single($db->query("SELECT cityname FROM cities WHERE cityid = ".$ir['location']));
$Type = mt_rand(1, 8);

echo "<h2 style='text-align:center;'>".$cityname." Streets</h2><br>";
echo " 

<style type='text/css'>
.style1 {
    text-align: center;
}
</style>


<div class='style1'>
     Welcome to the streets {$ir['username']}. You currently have <b>{$ir['turns']} turns</b> left today!<br><br>
     Click on the image to start searching ! <br><br>
</div>


";
echo "  <center> <img src='images/streets.jpg' border='0' usemap='#Map'></center>
<map name='Map'>
  <area shape='rect' coords='2,2,66,66' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='69,2,134,66' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='138,2,202,66' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='205,2,270,66' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='274,2,338,66' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='340,2,407,66' href='?act=search&search=".$Type."'>

  <area shape='rect' coords='2,70,66,133' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='69,70,136,133' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='137,70,202,133' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='205,70,270,133' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='274,70,338,133' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='340,70,407,133' href='?act=search&search=".$Type."'>

  <area shape='rect' coords='2,138,405,202' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='69,138,406,202' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='137,138,338,202' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='205,138,271,202' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='274,138,338,202'href='?act=search&search=".$Type."'>
  <area shape='rect' coords='340,138,407,202' href='?act=search&search=".$Type."'>

  <area shape='rect' coords='2,206,66,270' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='69,206,136,270' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='137,206,202,270' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='205,206,270,270' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='274,206,338,270' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='340,206,407,270' href='?act=search&search=".$Type."'>

  <area shape='rect' coords='2,273,66,337' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='69,273,136,337' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='137,273,202,337' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='205,273,270,337' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='274,273,338,337' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='340,273,407,337' href='?act=search&search=".$Type."'>

  <area shape='rect' coords='2,341,66,405' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='69,341,136,405' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='137,341,202,405' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='205,341,270,405' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='274,341,338,405' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='340,341,407,405' href='?act=search&search=".$Type."'>

  <area shape='rect' coords='2,410,66,473' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='69,410,136,473' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='137,410,202,473' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='205,410,270,473' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='274,410,338,473' href='?act=search&search=".$Type."'>
  <area shape='rect' coords='340,410,407,473' href='?act=search&search=".$Type."'>
</map>
";
}

function search_streets() {
global $db, $ir, $userid, $h;
/*-----------------------------------------------------
   # Start  Config #
-----------------------------------------------------*/
$cityname = $db->fetch_single($db->query("SELECT cityname FROM cities WHERE cityid = ".$ir['location']));
$nonrecorded = "What you doing here?<br /><a href='index.php'>Go back</a>";
$rand = mt_rand(0,2);
$randhard = mt_rand(0,3);
$randmoney = mt_rand(1,100);
$randcrystals = mt_rand(1,8);
$itemidsearch2 = 5; //Item id for search 2
$quantitysearch2 = 1; //Item quantity for search 2
$itemidsearch4 = 10; //Item id for search 4
$quantitysearch4 = 1; //Item quantity for search 4
$itemidsearch5 = 3; //Item id for search 5
$quantitysearch5 = 1; //Item quantity for search 5
$itemidsearch7 = 8; //Item id for search 7
$quantitysearch7 = 1; //Item quantity for search 7
$itemidsearch8 = 5; //Item id for search 8
$quantitysearch8 = 1; //Item quantity for search 8
/*-----------------------------------------------------
   # End Config #
-----------------------------------------------------*/
$_GET['search'] = abs(@intval($_GET['search']));
if(!$_GET['search']) {
echo $nonrecorded;
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();
exit;
}
$db->query("UPDATE `users` SET `turns`=`turns`-1 WHERE `userid`=$userid");
if($_GET['search'] == 1) {
if($rand == 1) {
$db->query("UPDATE `users` SET `money`=`money`+".$randmoney." WHERE `userid`=$userid");
echo "<span style='color:green;font-weight:700;'>Success</span><br />You found ".money_formatter($randmoney)." after searching an random box";
} else {
echo "<span style='color:red;font-weight:700;'>Unlucky!</span><br />While searching ".$cityname." You didnt come across anything useful<br />";
}
} else if($_GET['search'] == 2) {
if($rand == 1) {
$db->query("INSERT INTO `inventory` VALUES('',$itemidsearch2,$userid,$quantitysearch2)");
echo "<span style='color:green;font-weight:700;'>Success</span><br />While searching ".$cityname." you found an mysterious item. Go to your inventory to find out what";
} else {
$Time = mt_rand(2,30);
echo "<span style='color:red;font-weight:700;'>Unlucky!</span><br />While searching ".$cityname." a police officer arrested you.";
$db->query(sprintf("UPDATE `users` SET `jail` = %u, `jail_reason` = 'Arrested for hanging around %s' WHERE `userid` = %u", $Time, $cityname, $userid));
}
} else if($_GET['search'] == 3) {
if($rand == 1) {
$db->query("UPDATE `users` SET `money`=`money`+".$randmoney." WHERE `userid`=$userid");
echo "<font color = 'green'><b>Sucess</b></font><br />You found ".money_formatter($randmoney)." after robbing an random old man";
} else {
$Time = mt_rand(2,300);
echo "<span style='color:red;font-weight:700;'>Unlucky!</span><br />While searching ".$cityname." you got shot.";
$db->query(sprintf("UPDATE `users` SET `hospital` = %u, `hospreason` = 'While searching %s they got shot' WHERE `userid` = %u", $Time, $cityname, $userid));
}
} else if($_GET['search'] == 4) {
if($randhard == 1) {
$db->query("INSERT INTO inventory VALUES('',$itemidsearch4,$userid,$quantitysearch4)");
echo "<span style='color:green;font-weight:700;'>Success</span><br />While searching ".$cityname." you found an mysterious item. Go to your inventory to find out what";
} else {
echo "<span style='color:red;font-weight:700;'>Unlucky!</span><br />While searching ".$cityname." you found NOTHING!";
}
} else if($_GET['search'] == 5) {
$db->query("INSERT INTO inventory VALUES('',$itemidsearch5,$userid,$quantitysearch5)");
echo "<span style='color:green;font-weight:700;'>Success</span><br />While searching ".$cityname." you found an mysterious item. Go to your inventory to find out what";
} else if($_GET['search'] == 6) {
if($rand == 1) {
$db->query("UPDATE users SET `crystals`=`crystals`+".$randcrystals." WHERE userid=$userid");
echo "<span style='color:green;font-weight:700;'>Success</span><br />While searching ".$cityname." You fell down a hole and found crystal mine , You took ".number_format($randcrystals); 
} else {
$Time = mt_rand(2,30);
echo "<span style='color:red;font-weight:700;'>Unlucky!</span><br />While searching ".$cityname." a police officer arrested you.";
$db->query(sprintf("UPDATE `users` SET `jail` = %u, `jail_reason` = 'Arrested for hanging around %s' WHERE `userid` = %u", $Time, $cityname, $userid));
}
} else if($_GET['search'] == 7) {
if($rand == 1) {
$db->query("INSERT INTO inventory VALUES('',$itemidsearch7,$userid,$quantitysearch7)");
echo "<span style='color:green;font-weight:700;'>Success</span><br />While searching ".$cityname." You found an mysterious item. Go to your inventory to find out what";
} else {
$Time = mt_rand(2,30);
echo "<span style='color:red;font-weight:700;'>Unlucky!</span><br />While searching ".$cityname." a police officer arrested you.";
$db->query(sprintf("UPDATE `users` SET `jail` = %u, `jail_reason` = 'Arrested for hanging around %s' WHERE `userid` = %u", $Time, $cityname, $userid));
}
} else if($_GET['search'] == 8) {
if($randhard == 1) {
$db->query("INSERT INTO inventory VALUES('',$itemidsearch8,$userid,$quantitysearch8)");
echo "<span style='color:green;font-weight:700;'>Success</span><br />While searching ".$cityname." You found an mysterious item. Go to your inventory to find out what";
} else {
$Time = mt_rand(2,30);
echo "<span style='color:red;font-weight:700;'>Unlucky!</span><br />While searching ".$cityname." a police officer arrested you.";
$db->query(sprintf("UPDATE `users` SET `jail` = %u, `jail_reason` = 'Arrested for hanging around %s' WHERE `userid` = %u", $Time, $cityname, $userid));
}
}
}
$h->endpage();
?>