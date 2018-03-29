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
<div class='info_mid'><h2 style='padding-top:10px;'> Schooling</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table border='1' width='90%'class='table' bordercolor='#939393'><th><h2 style='padding-top:10px;'> Harvard University </h2></th><tr><td>
	<img src='images/education.jpg' alt='EDUCATION' /><br/>

		With a rich history and a dedication to the pursuit of excellence, Harvard University offers unique learning experiences across a broad spectrum of academic and social environments.</td></tr></table>
	<br />

";
if($ir['course'] > 0)
{
$cd=$db->query("SELECT * FROM courses WHERE crID={$ir['course']}");
$coud=$db->fetch_row($cd);
print "You are currently doing the {$coud['crNAME']}, you have {$ir['cdays']} days remaining.</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
else
{
if($_GET['cstart'])
{
$_GET['cstart'] = abs((int) $_GET['cstart']);
//Verify.
$cd=$db->query("SELECT * FROM courses WHERE crID={$_GET['cstart']}");
if($db->num_rows($cd) == 0)
{
print "You are trying to start a non-existant course!";
}
else
{
$coud=$db->fetch_row($cd);
$cdo=$db->query("SELECT * FROM coursesdone WHERE userid=$userid AND courseid={$_GET['cstart']}");
if($ir['money'] < $coud['crCOST'])
{
print "You don't have enough money to start this course.";
$h->endpage();
exit;
}
if($db->num_rows($cdo) > 0)
{
print "You have already done this course.";
$h->endpage();
exit;
}
$db->query("UPDATE users SET course={$_GET['cstart']},cdays={$coud['crDAYS']},money=money-{$coud['crCOST']} WHERE userid=$userid");
print "You have started the {$coud['crNAME']}, it will take {$coud['crDAYS']} days to complete.";
}
}
else
{
//list courses
print "Here is a list of available courses.";
$q=$db->query("SELECT * FROM courses ORDER BY crCOST ASC");
print "<br /> <table width=75% cellspacing=1 class='table'><tr style='background:gray;'><th>Course</th><th>Description</th><th>Cost</th><th>Take</th></tr>";
while($r=$db->fetch_row($q))
{
$cdo=$db->query("SELECT * FROM coursesdone WHERE userid=$userid AND courseid={$r['crID']}");
if($db->num_rows($cdo)) { $do="<i>Done</i>"; } else { $do="<a href='education.php?cstart={$r['crID']}'>Take</a>"; }
print "<tr><td>{$r['crNAME']}</td><td>{$r['crDESC']}</td><td>\${$r['crCOST']}</td><td>$do</td></tr>";
}
print "

</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>

";
}
}
$h->endpage();
?>
