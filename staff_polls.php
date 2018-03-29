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

include "sglobals.php";
if($ir['user_level'] > 2)
{
die("403");
}
//This contains shop stuffs
switch($_GET['action'])
{
case 'spoll': startpoll(); break;
case 'startpoll': startpollsub(); break;
case 'endpoll': endpoll(); break;
default: print "Error: This script requires an action."; break;
}
function startpoll()
{
global $ir, $c, $userid, $db;

print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Polls</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

Fill out question and choices to start a poll.<br>
<form action='staff_polls.php?action=startpoll' method='post'>
Question: <input type='text' STYLE='color: black;  background-color: white;' name='question'><br />
Choice 1: <input type='text' STYLE='color: black;  background-color: white;' name='choice1' value=''><br />
Choice 2: <input type='text' STYLE='color: black;  background-color: white;' name='choice2' value=''><br />
Choice 3: <input type='text' STYLE='color: black;  background-color: white;' name='choice3' value=''><br />
Choice 4: <input type='text' STYLE='color: black;  background-color: white;' name='choice4' value=''><br />
Choice 5: <input type='text' STYLE='color: black;  background-color: white;' name='choice5' value=''><br />
Choice 6: <input type='text' STYLE='color: black;  background-color: white;' name='choice6' value=''><br />
Choice 7: <input type='text' STYLE='color: black;  background-color: white;' name='choice7' value=''><br />
Choice 8: <input type='text' STYLE='color: black;  background-color: white;' name='choice8' value=''><br />
Choice 9: <input type='text' STYLE='color: black;  background-color: white;' name='choice9' value=''><br />
Choice 10: <input type='text' STYLE='color: black;  background-color: white;' name='choice10' value=''><br />
Results hidden till end: <input type='radio' name='hidden' value='1'> Yes <input type='radio' name='hidden' value='0' checked='checked'> No
<input type='submit' STYLE='color: black;  background-color: white;' value='Submit'></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function startpollsub()
{
global $ir, $c,$userid, $db;
print "Starting new poll...";
$question=$_POST['question'];
$choice1=$_POST['choice1'];
$choice2=$_POST['choice2'];
$choice3=$_POST['choice3'];
$choice4=$_POST['choice4'];
$choice5=$_POST['choice5'];
$choice6=$_POST['choice6'];
$choice7=$_POST['choice7'];
$choice8=$_POST['choice8'];
$choice9=$_POST['choice9'];
$choice10=$_POST['choice10'];
$poll=$db->query("INSERT into polls (active, question, choice1, choice2, choice3, choice4, choice5, choice6, choice7, choice8, choice9, choice10, hidden) VALUES('1', '$question', '$choice1', '$choice2', '$choice3', '$choice4', '$choice5', '$choice6', '$choice7', '$choice8', '$choice9' ,'$choice10', '{$_POST['hidden']}')");
print "New Poll Started";
}
function endpoll()
{
global $ir, $c,$userid, $db;
if(!$_POST['poll'])
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Polls</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

Choose a poll to close<br>
<form action='staff_polls.php?action=endpoll' method='post'>
";
$q=$db->query("SELECT * FROM polls WHERE active='1'");
while($r=$db->fetch_row($q))
{
print "<input type='radio' name='poll' value='{$r['id']}' /> Poll ID {$r['id']} - {$r['question']}<br />";
}
print "<input type='submit' STYLE='color: black;  background-color: white;' value='Close Selected Poll' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
else
{
$db->query("UPDATE polls SET active='0' WHERE id={$_POST['poll']}");
print "Poll closed";
}
}
function report_clear()
{
global $db,$db,$ir,$c,$h,$userid;
if($ir['user_level'] > 3)
{
die("403");
}
$_GET['ID'] = abs((int) $_GET['ID']);
stafflog_add("Cleared player report ID {$_GET['ID']}");
$db->query("DELETE FROM preports WHERE prID={$_GET['ID']}");
print "Report cleared and deleted!<br />
<a href='staff_users.php?action=reportsview'>&gt; Back</a>";
}
$h->endpage();
?>
