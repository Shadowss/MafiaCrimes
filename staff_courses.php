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
//This contains course stuffs
switch($_GET['action'])
{
case "addcourse": addcourse(); break;
case "editcourse": editcourse(); break;
case "delcourse": delcourse(); break;
default: print "Error: This script requires an action."; break;
}
function addcourse()
{
global $db, $ir, $c, $h, $userid;
$cost=abs((int) $_POST['cost']);
$energy=abs((int) $_POST['energy']);
$days=abs((int) $_POST['days']);
$str=abs((int) $_POST['str']);
$agil=abs((int) $_POST['agil']);
$gua=abs((int) $_POST['gua']);
$lab=abs((int) $_POST['lab']);
$iq=abs((int) $_POST['iq']);
if($_POST['name'] && $_POST['desc'] && $cost && $days)
{
$db->query("INSERT INTO courses VALUES(NULL, '{$_POST['name']}', '{$_POST['desc']}', '$cost', '$energy', '$days', '$str', '$gua',  '$lab', '$agil', '$iq')");
print "Course {$_POST['name']} added.";
stafflog_add("Added course {$_POST['name']}");
}
else
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Add Course</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
<form action='staff_courses.php?action=addcourse' method='post'>
Name: <input type='text' STYLE='color: black;  background-color: white;' name='name' /><br />
Description: <input type='text' STYLE='color: black;  background-color: white;' name='desc' /><br />
Cost (Money): <input type='text' STYLE='color: black;  background-color: white;' name='cost' /><br />
Cost (Energy): <input type='text' STYLE='color: black;  background-color: white;' name='energy' /><br />
Length (Days): <input type='text' STYLE='color: black;  background-color: white;' name='days' /><br />
Strength Gain: <input type='text' STYLE='color: black;  background-color: white;' name='str' /><br />
Agility Gain: <input type='text' STYLE='color: black;  background-color: white;' name='agil' /><br />
Guard Gain: <input type='text' STYLE='color: black;  background-color: white;' name='gua' /><br />
Labour Gain: <input type='text' STYLE='color: black;  background-color: white;' name='lab' /><br />
IQ Gain: <input type='text' STYLE='color: black;  background-color: white;' name='iq' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Add Course' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
function editcourse()
{
global $db, $ir, $c, $h, $userid;
switch($_POST['step'])
{
case "2":
$cost=abs((int) $_POST['cost']);
$energy=abs((int) $_POST['energy']);
$days=abs((int) $_POST['days']);
$str=abs((int) $_POST['str']);
$agil=abs((int) $_POST['agil']);
$gua=abs((int) $_POST['gua']);
$lab=abs((int) $_POST['lab']);
$iq=abs((int) $_POST['iq']);
$name=$_POST['name'];
$db->query("UPDATE courses SET crNAME='$name', crDESC='{$_POST['desc']}', crCOST=$cost, crENERGY=$energy, crDAYS=$days, crSTR=$str, crGUARD=$gua, crLABOUR=$lab, crAGIL=$agil, crIQ=$iq WHERE crID={$_POST['id']}");
print "Course $name was edited successfully.";
stafflog_add("Edited course $name");
break;
case "1":
$q=$db->query("SELECT * FROM courses WHERE crID={$_POST['course']}");
$old=$db->fetch_row($q);
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Editing a Course</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
<form action='staff_courses.php?action=editcourse' method='post'>
<input type='hidden' name='step' value='2' />
<input type='hidden' name='id' value='{$_POST['course']}' />
Name: <input type='text' STYLE='color: black;  background-color: white;' name='name' value='{$old['crNAME']}' /><br />
Description: <input type='text' STYLE='color: black;  background-color: white;' name='desc' value='{$old['crDESC']}' /><br />
Cost (Money): <input type='text' STYLE='color: black;  background-color: white;' name='cost' value='{$old['crCOST']}' /><br />
Cost (Energy): <input type='text' STYLE='color: black;  background-color: white;' name='energy' value='{$old['crENERGY']}' /><br />
Length (Days): <input type='text' STYLE='color: black;  background-color: white;' name='days' value='{$old['crDAYS']}' /><br />
Strength Gain: <input type='text' STYLE='color: black;  background-color: white;' name='str' value='{$old['crSTR']}' /><br />
Agility Gain: <input type='text' STYLE='color: black;  background-color: white;' name='agil' value='{$old['crAGIL']}' /><br />
Guard Gain: <input type='text' STYLE='color: black;  background-color: white;' name='gua' value='{$old['crGUARD']}' /><br />
Labour Gain: <input type='text' STYLE='color: black;  background-color: white;' name='lab' value='{$old['crLABOUR']}' /><br />
IQ Gain: <input type='text' STYLE='color: black;  background-color: white;' name='iq' value='{$old['crIQ']}' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit Course' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
break;
default:
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Editing a Course</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_courses.php?action=editcourse' method='post'>
<input type='hidden' name='step' value='1' />
Course: ".course_dropdown($c, "course")."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit Course' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
break;
}
}
function delcourse()
{
global $db,$ir,$c,$h,$userid;
if($_POST['course'])
{
$q=$db->query("SELECT * FROM courses WHERE crID={$_POST['course']}");
$old=$db->fetch_row($q);
$db->query("UPDATE users SET course=0, cdays=0 WHERE course={$_POST['course']}");
$db->query("DELETE FROM courses WHERE crID={$_POST['course']}");
print "Course {$old['crNAME']} deleted.";
stafflog_add("Deleted course {$old['crNAME']}");
}
else
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Deleting a Course</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_courses.php?action=delcourse' method='post'>
Course: ".course_dropdown($c, "course")."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Delete Course' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
function report_clear()
{
global $db,$ir,$c,$h,$userid;
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
