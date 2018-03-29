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

global $db,$c,$ir, $set;
$hc=$set['hospital_count'];
$jc=$set['jail_count'];
$ec=$ir['new_events'];
$mc=$ir['new_mail'];
if($ir['hospital'])
{
print "

<div class='navipart'>
<div class='navitop'><p>
<img src='images/navi_txt.gif' alt='' />
</p></div>

<div class='navi_mid'><ul>



<li> <a class='link1' href='index.php'>"._HOME."</a></li>
<li> <a class='link1' href='shops.php'>Medical Shop</a></li>
<li> <a class='link1' href='hospital.php'>"._HOSPITAL." ($hc)</a></li> 
<li> <a class='link1' href='inventory.php'>"._INVENTORY."</a></li>";
}
elseif($ir['jail'])
{

print "

<div class='navipart'>
<div class='navitop'><p>
<img src='images/navi_txt.gif' alt='' />
</p></div>

<div class='navi_mid'><ul>


<li><a class='link1' href='jail.php'>"._JAIL." ($jc)</a></li>";
}
else
{
print "


<div class='navipart'>
<div class='navitop'><p>
<img src='images/navi_txt.gif' alt='' />
</p></div>

<div class='navi_mid'><ul>


<li><a class='link1' href='index.php'>"._HOME."</a></li><li>
<a class='link1' href='inventory.php'>"._INVENTORY."</a></li>";
}
if($ec > 0) { print "<li> <b><a style='color:red;' class='link1' href='events.php'>"._EVENTS." ($ec)</a></b></li>"; }
else { print "<li> <a class='link1' href='events.php'>"._EVENTS." (0)</a></li>"; }
if($mc > 0) { print "<li> <b><a style='color:red;' class='link1' href='mailbox.php'>"._MAILBOX." ($mc)</a></b></li>"; }
else { print "<li> <a class='link1' href='mailbox.php'>"._MAILBOX." (0)</a></li>"; }
if($ir['new_announcements'])
{
print "<li> <b><a style='color:red;' class='link1' href='announcements.php' style='font-weight: 800;'>"._ANNOUNCEMENTS." ({$ir['new_announcements']})</a></b></li>";
}
else
{
print "<li> <a class='link1' href='announcements.php'>"._ANNOUNCEMENTS." (0)</a></li>";
}


if($ir['jail'] and !$ir['hospital'])
{
print "<li> <a class='link1' href='gym.php'>"._JAIL." "._GYM."</a></li>
<li> <a class='link1' href='hospital.php'>"._HOSPITAL." ($hc)</a></li>";
}
else if (!$ir['hospital'])
{
print "<li> <a class='link1' href='explore.php'>"._EXPLORE."</a></li>
<li> <a class='link1' href='gym.php'>"._GYM."</a></li>
<li> <a class='link1' href='tasks.php'>"._CRIMES."</a></li>
<li> <a class='link1' href='job.php'>"._YOUR_JOB."</a></li>
<li> <a class='link1' href='shoutarea.php'><b>"._CHAT."</b></a></li> 
<li> <a class='link1' href='stocks.php'>"._STOCK_MARKET."</a></li>
<li> <a class='link1' href='drugfarm.php?action=mydrugs'>"._YOUR_DRUGS."</a></li>
<li> <a class='link1' href='business_home.php'>"._YOUR_BUSINESS."</a></li>  
<li> <a class='link1' href='education.php'>"._EDUCATION."</a></li>
<li> <a class='link1' href='hospital.php'>"._HOSPITAL." ($hc)</a></li>
<li> <a class='link1' href='jail.php'>"._JAIL." ($jc)</a></li>";
}
else
{
print "<li> <a class='link1' href='jail.php'>"._JAIL." ($jc)</a></li>";
}
print "<li> <a class='link1' href='forums.php'>"._FORUMS."</a></li>";

print "
<li> <a class='link1' href='newspaper.php'>"._NEWSPAPER."</a></li>
<li> <a class='link1' href='search.php'>"._SEARCH."</a></li>";


if($ir['jail'] )
{
print "

</div>
<div><img src='images/navi_btm.gif' alt='' /></div>
</div>  

";
}


if(!$ir['jail'] )
{
print "<li> <a class='link1' href='yourgang.php'>"._YOUR_GANG."</a></li>


</div>

<div><img src='images/navi_btm.gif' alt='' /></div>
</div>  


";
}


if($ir['user_level'] > 1)
{
print "


<div class='navipart'>
<div class='navitop'><p>
<img src='images/staff_links.gif' alt='' /> 
</p></div>

<div class='navi_mid'><ul>
<li> <a class='link1' href='staff.php'>"._STAFF_PANEL."</a></li>
</div>
<div><img src='images/navi_btm.gif' alt='' /></div>
</div>    


";

}


print "

<div class='navipart'>
<div class='navitop'><p>
<img src='images/staff_online.gif' alt='' />
</p></div>
<div class='navi_mid'><ul> 
";
$q=$db->query("SELECT * FROM users WHERE laston>(unix_timestamp()-15*60) AND user_level>1 ORDER BY userid ASC");
while($r=$db->fetch_row($q))
{
$la=time()-$r['laston'];
$unit="secs";
if($la >= 60)
{
$la=(int) ($la/60);
$unit="mins";
}
if($la >= 60)
{
$la=(int) ($la/60);
$unit="hours";
if($la >= 24)
{
$la=(int) ($la/24);
$unit="days";
}
}
print "<li><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> ($la $unit)</li>";
}

print"</ul></div>

<div><img src='images/navi_btm.gif' alt='' /></div>
</div>  ";

if($ir['donatordays'])
{
print "


<div class='navipart'>
<div class='navitop'><p>
<img src='images/donators_only.gif' alt='' />
</p></div>
<div class='navi_mid'><ul> 

<li> <a class='link1' href='friendslist.php'>"._FRIENDS_LIST."</a></li>
<li> <a class='link1' href='blacklist.php'>"._BLACK_LIST."</a></li>

</div>

<div><img src='images/navi_btm.gif' alt='' /></div>
</div>  


";
}
print "


<div class='navipart'>
<div class='navitop'><p>
<img src='images/other_links.gif' alt='' />
</p></div>
<div class='navi_mid'><ul> 


<li> <a class='link1' href='preferences.php'>"._PREFERENCES."</a></li>
<li> <a class='link1' href='preport.php'>"._PLAYER_REPORT."</a></li>
<li> <a class='link1' href='helptutorial.php'>"._TUTORIAL."</a></li>
<li> <a class='link1' href='rules.php'>"._RULES."</a></li>
<li> <a class='link1' href='viewuser.php?u={$ir['userid']}'>"._MY_PROFILE."</a></li>
<li> <a class='link1' href='logout.php'>"._LOGOUT."</a></li>

</div>

<div><img src='images/navi_btm.gif' alt='' /></div>
</div>  


" ; 



?>
