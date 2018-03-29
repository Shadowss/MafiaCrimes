<?php
include "globals.php";

print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> News Paper </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
<table class='tablee'><tr><td><center><img src='images/newspaper.jpg'.png width='300' height='230' alt='Local News' /></td></tr></table>

<br>";
print "
<table width=90% cellspacing=1 class='table' border=2>
<tr>
<td class=h><center><a href='job.php'><font color='red'>YOUR JOB</font></a></td>
<td class=h><center><a href='gym.php'><font color='red'>LOCAL GYM</font></a></td>
<td class=h><center><a href='halloffame.php'><font color='red'>HALL OF FAME</font></a></td>
<td class=h><center><a href='gangs.php'><font color='red'>LOCAL GANGS</font></a></td>
<td class=h><center><a href='index.php'><font color='red'>MY HOUSE</font></a></td>
</tr>
<tr>
<td class=h><center><a href='cityusers.php'><font color='red'>LOCAL RESIDENTS</font></a></td>
<td class=h><center><a href='stats.php'><font color='red'>CITY STATS</font></a></td>
<td class=h><center><a href='usersonline.php'><font color='red'>PEOPLE AWAKE</font></a></td>
<td class=h><center><a href='gangs.php?action=gang_wars'><font color='red'>CURRENT WARS</font></a></td>
<td class=h><center><a href='estate.php'><font color='red'>HOUSES FOR SALE</font></a></td>
</tr>
<tr>
<td colspan=6>";
$q=$db->query("SELECT * FROM papercontent LIMIT 1");
$content=$db->fetch_single($q);
print "<table width=90%  cellspacing=1 class='table'><center><h3>Player Advertisements</h3><center> | <a href='newspaper.php?action=add'><b>Buy An Advertisement ($10,000)</b></a>";
if($ir['user_level'] > 1)
{
print " | <a href=newspaper.php?action=all><b>DELETE ALL</b></a>";
}
$anpdata=mysql_query("SELECT * FROM npaper");
$q=mysql_query("SELECT user_level FROM users WHERE userid=$userid");
$r=$db->fetch_row($q);
print "<marquee speed=2 direction=up onmouseover='this.stop()' onmouseout='this.start()' class='textbox'>";

while($npdata=$db->fetch_row($anpdata))
{
$us=mysql_query("SELECT username FROM users WHERE userid={$npdata['npADDER']}");
$us=$db->fetch_single($us);
$time=date('F j',$npdata['npTIME']);
print "
<hr>
<b>Ad By: <a href='viewuser.php?u={$npdata['npADDER']}'><font color=green>{$us}</font> [{$npdata['npADDER']}]</a> | Added On: {$time}</b>";
if($r['user_level'] != 1)
{
print " | <a href=newspaper.php?action=npID&npID={$npdata['npID']}><b>DELETE</b></a>";
}
print "<br />
<i><u>{$npdata['npTITLE']}</i></u><br>
<i>{$npdata['npBODY']}</i>
<br />
";
}
print "<hr /></marquee>
</table>";
$q=mysql_query("SELECT user_level FROM users WHERE userid=$userid");
$r=$db->fetch_row($q);
if($r['user_level'] != 1)
{
if($_GET['action'] == "all")
{
if($r['user_level'] != 1)
{
mysql_query("TRUNCATE TABLE npaper");
print "Newspaper Ads All Cleared!
<META HTTP-EQUIV=Refresh CONTENT='1;url=newspaper.php'>";
}
}
else if($_GET['action'] == "npID")
{
if($r['user_level'] != 1)
{
mysql_query("DELETE FROM npaper WHERE npID={$_GET['npID']}");
print "News Paper Ad ID {$_GET['npID']} deleted!
<META HTTP-EQUIV=Refresh CONTENT='1;url=newspaper.php'>";
}
}
}
if($_GET['action'] == "add")
{
print "<h3>Add Advertisement ($10,000)</h3>
<form action='newspaper.php?action=added' method='post'>
Ad Title: <br><input type='text' STYLE='color: black;  background-color: white;' name='npTITLE' class='textbox'><br />
Ad Body: <br><textarea rows=14 cols=65 name='npBODY' class='textbox'></textarea><br />
<input class='textbox' type='submit' value='Place Ad ($10,000)' />
</form>
<font color=red><b>WARNING:</b> Only plain text will work<br>Do not advertise other games<br>Follow the rules.";
}

if($_GET['action'] == "added")
{
if($ir['money']>9999)
{
print "Congratulations, you bought an ad for \$10,000!<br />";
mysql_query("UPDATE users SET money=money-10000 WHERE userid=$userid");
$title=str_replace(array("\n"),array("<br />"),strip_tags($_POST['npTITLE']));
$body=str_replace(array("\n"),array("<br />"),strip_tags($_POST['npBODY']));
$q=mysql_query("INSERT INTO `npaper` VALUES (NULL, '$userid', '$title', '$body', unix_timestamp())");
print "Advertisement was successfully added!
<META HTTP-EQUIV=Refresh CONTENT='1;url=newspaper.php'>";
}
else
{
print "You do not have enough money to place an advertisement.<br>
<a href='newspaper.php'>>Back</a>";
}
}
print"</td></tr>
<tr>
<td td colspan=6><center><h3>Game News</h3><br>$content</td>
</tr>
</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
$h->endpage();
?>