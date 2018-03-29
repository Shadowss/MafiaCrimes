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
print pageHelp(_HELP_EXPLORE_HEADER, _HELP_EXPLORE);
$tresder=(int) rand(100,999);
global $db, $ir, $userid, $h, $db;
$cityname = $db->fetch_single($db->query("SELECT cityname FROM cities WHERE cityid = ".$ir['location']));
$citycount = $db->fetch_single($db->query("SELECT COUNT(*) FROM users WHERE location = ".$ir['location'])); 

print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'><marquee>You Are Currently Exploring $cityname !</marquee> </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div>

</div>
<div class='generalinfo_simple'>
<br>
<br>
<br />";

?>
<script>$.fn.preload = function() {this.each(function(){$('<img/>')[0].src = this;});};$(['images/hover_1.png',	'images/hover_2.png','images/hover_3.png','images/hover_4.png','images/hover_5.png','images/hover_6.png','images/hover_7.png','images/hover_8.png','images/hover_9.png','images/hover_10.png','images/hover_11.png','images/hover_12.png','images/hover_13.png','images/hover_14.png']).preload();</script>


<div style="text-align:center; width:665px; margin-left:auto; margin-right:auto; background:url('images/town.jpg');">
	<div style="text-align:center; width:665px; margin-left:auto; margin-right:auto;position:relative;" id="town_container">
		<img id="para_image" src="images/spacer.gif" usemap="#map" border="0" width="665" height="480" alt="" />
	</div>
</div>
<MAP NAME="map" id="map">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_3.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="237,212,237,230,259,245,254,321,244,326,214,332,215,349,261,337,305,388,304,394,297,397,38,464,41,478,97,477,354,409,594,289,566,280,498,313,467,304,461,302,461,315,471,318,472,323,349,379,340,378,286,325,288,249,282,241,237,212" HREF="gangarea.php">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_8.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="314,316,359,339,418,314,416,338,358,364,315,342,314,316" HREF="shoparea.php">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_6.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="317,247,316,312,357,334,416,311,417,243,398,225,380,223,321,242,317,248,317,247" HREF="homearea.php">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_4.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="50,447,38,348,32,308,71,295,161,281,187,282,211,312,213,402,156,416,144,398,118,405,120,427,50,448,50,447" HREF="education.php">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_9.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="87,187,87,227,92,239,96,252,97,265,126,262,127,239,138,238,136,201,149,198,181,197,173,186,152,187,152,182,146,178,116,180,116,187,87,187" HREF="hospital.php">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_7.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="424,56,452,55,450,42,467,42,469,19,475,5,481,21,481,44,487,46,609,36,615,60,494,70,481,66,422,61,425,55,430,56,452,55,431,55,426,55,424,56" HREF="jail.php">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_13.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="531,85,521,117,522,139,532,155,531,165,574,158,578,148,587,139,609,137,608,125,581,110,556,111,554,116,537,116,531,85" HREF="job.php">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_5.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="439,212,440,239,463,249,459,298,491,306,551,278,551,203,522,182,463,199,439,212" HREF="whorehouse.php">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_11.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="405,227,420,241,420,334,457,318,460,251,431,235,405,227" HREF="gym.php">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_14.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="270,226,288,240,310,235,310,174,298,167,283,158,269,166,270,226" HREF="infoarea.php">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_1.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="412,161,390,164,375,169,372,170,374,133,389,125,411,125,410,101,427,106,429,124,452,125,457,129,457,106,477,101,498,109,498,138,474,141,462,150,462,162,443,152,431,152,411,162,412,161" HREF="bussarea.php">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_2.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="554,205,554,264,585,269,611,257,621,254,628,250,605,194,586,199,554,194,541,187,536,187,554,200,554,206,554,208,554,213,554,205" HREF="casinoarea.php">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_12.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="92,142,96,148,99,185,114,185,113,174,118,177,152,177,156,185,181,184,179,142,148,131,117,133,91,143,93,142,94,145,92,142" HREF="banksarea.php">
<AREA SHAPE=POLY onmouseover="$('#town_container').css('background-image', 'url(images/hover_10.png)');" onmouseout="$('#town_container').css('background-image', 'url(images/spacer.gif)');"  COORDS="426,480,534,480,664,419,664,377" HREF="travel.php">
<br />
<?
print "



<div align='left' class='explorehead' style='background-color:#555; padding-left:40px;'>There are $citycount people in $cityname !</div><br />
<table class='table' width='85%'>
<tr valign='middle'>
<th width='34%'><img src='images/basket.png' alt='shop' /> Shops</th>
<th width='33%'><img src='images/building.png' alt='bis' /> Business's</th>
<th width='33%'><img src='images/coins.png' alt='casino' /> Casino</th>
</tr>

<tr style='height: 100%;'>
<td valign='top'>
<a href='shops.php'>City Shops</a><br />
<a href='playershops.php'>Player Shops</a><br /> 
<a href='itemmarket.php'>Item Market</a><br />
<a href='cmarket.php'>Crystal Market</a><br />
<a href='estate.php'>Real Estate</a><br />
<a href='drugfarm.php'>Drug Farm</a><br />
<a href='drugsmarket.php'>Drugs Market</a><br />
<a href='crystaltemple.php'>Crystal Temple</a><br />
<a href='stocks.php'>Stock Market</a><br />
</td>
<td valign='top'>
<a href='business_view.php'>Business Listings</a><br /> 
<a href='business_home.php'>Your Business</a><br />  
<a href='bank.php'>City Bank</a>";
if($ir['level'] >= 5)
{
print "<br />
<a href='cyberbank.php'>Cyber Bank</a><br />";
}
print "</td>
<td valign='top'>  
<a href='slotsmachine.php?tresde=$tresder'>Slots Machine</a><br />
<a href='magicslots.php'>Magic Slots</a><br />
<a href='roulette.php?tresde=$tresder'>Roulette</a><br />
<a href='lucky.php'>Lucky Boxes</a>  <br />
<a href='poker_home.php'>Multiplayer Poker</a>  
<tr>
<th width='33%'><img src='images/door.png' alt='life' /> Your Life</th>
<th><img src='images/sport_soccer.png' alt='act' /> Mysterious</th>
<th><img src='images/building_link.png' alt='head' /> Headquarters</th>
</tr>

<tr style='height: 100%;'>
<td valign='top'>
<a href='viewuser.php?u={$ir['userid']}'>Your Profile</a><br />
<a href='inventory.php'>Inventory</a><br />
<a href='drugfarm.php?action=mydrugs'>Your Drugs</a><br />
<a href='gamestation.php'>Game Station</a><br />
<a href='streets.php'>Search Streets</a><br />
<a href='attacklist.php'>Player Attack List</a><br />

";
$checkforshop=$db->query("select * from usershops where userid=$userid");
if(mysql_num_rows($checkforshop)!=0)
{
print"<a href='myshop.php'>Your Shop</a> <br/>";
}

print "
</td>
<td valign='top'>
<a href='hospital.php'>Hospital</a><br /> 
<a href='education.php'>Local School</a><br />
<a href='whorehouse.php'>Brothel</a><br />    
<a href='travel.php'>Travel</a><br />
<a href='gym.php'>Gym</a><br />
<a href='bodyguard.php'>Protection</a><br />
<a href='jail.php'>Jail</a><br />
<a href='battle_ladder.php'>Battle Ladder</a><br />
<a href='job.php'>Find a job</a><br />
</td>
<td valign='top'>
<a href='stats.php'>Game Stats</a><br />
<a href='stafflist.php'>{$set['game_name']} Staff</a><br /
<a href='halloffame.php'>Hall of Fame</a><br />
<a href='usersonline.php'>Users Online</a><br />
<a href='userlist.php'>User List</a><br />
<a href='preport.php'>Player Report</a><br />
<a href='fedjail.php'>Federal Jail</a><br />
<a href='cityusers.php'>Players in your City</a><br />
</tr>

<tr>
<th><img src='images/information.png' alt='info' /> Information</th>
<th><img src='images/carbullet.png' alt='Race' /> Racing Area</th>
<th><img src='images/user_suit.png' alt='Platoon' /> Gang</th>
</tr>

<tr style='height: 100%;'>
<td valign='top'>
<a href='helptutorial.php'>Tutorial</a><br />
<a href='rules.php'>Rules</a><br />
<a href='polling.php'>Polls</a><br />
<a href='forums.php'>Forums</a><br />
</td>
<td valign='top'>&nbsp;
<a href='garage.php'>Garage</a><br />
<a href='caryard.php'>Car Yard</a><br />
<a href='sellcar.php'>Sell Car</a><br />
<a href='carmarket.php'>Car Market</a><br />
</td>
<td valign='top'>
<a href='gangs.php'>Gang List</a><br />
<a href='gangs.php?action=gang_wars'>Gang Wars</a><br />
<a href='yourgang.php'>Your Gang</a><br />


";






print "  


</td></tr></table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>


This is your referal link: http://{$domain}/signup.php?REF=$userid <br><br />
Every signup from this link earns you two valuable crystals!";
$h->endpage();
?>

