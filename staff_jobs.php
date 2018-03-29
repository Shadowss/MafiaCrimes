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
case 'newjob': newjob(); break;
case 'jobedit': jobedit(); break;
case 'newjobrank': newjobrank(); break;
case 'jobrankedit': jobrankedit(); break;
case 'jobdele': jobdele(); break;
case 'jobrankdele': jobrankdele(); break;
default: print "Error: This script requires an action."; break;
}
function newjob()
{
global $db,$ir,$userid;
if ( $_POST['jNAME']) {
$db->query("INSERT INTO jobs VALUES('','{$_POST['jNAME']}', 0, '{$_POST['jDESC']}', '{$_POST['jOWNER']}')");
$i=$db->insert_id();
$db->query("INSERT INTO jobranks VALUES('', '{$_POST['jrNAME']}', $i, {$_POST['jrPAY']}, {$_POST['jrIQG']}, {$_POST['jrLABOURG']}, {$_POST['jrSTRG']}, {$_POST['jrIQN']}, {$_POST['jrLABOURN']}, {$_POST['jrSTRN']})");
$j=$db->insert_id();
$db->query("UPDATE jobs SET jFIRST=$j WHERE jID=$i");
print "Job created!<br>
";
}
else {
print <<<EOF

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Add New Job</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
<form action='staff_jobs.php?action=newjob' method='post'>
<b>Job Name:</b> <input type='text' STYLE='color: black;  background-color: white;' name='jNAME' /><br>
<b>Job Description:</b> <input type='text' STYLE='color: black;  background-color: white;' name='jDESC' /><br>
<b>Job Owner:</b> <input type='text' STYLE='color: black;  background-color: white;' name='jOWNER' /><br>
<hr><b>First Job Rank:</b><br>
<b>Rank Name:</b> <input type='text' STYLE='color: black;  background-color: white;' name='jrNAME' /><br>
<b>Pays:</b> <input type='text' STYLE='color: black;  background-color: white;' name='jrPAY' /><br>
<b>Gains:</b> Str: <input type='text' STYLE='color: black;  background-color: white;' name='jrSTRG' size=3 maxlength=3> Lab: <input type='text' STYLE='color: black;  background-color: white;' name='jrLABOURG' size=3 maxlength=3> IQ: <input type='text' STYLE='color: black;  background-color: white;' name='jrIQG' size=3 maxlength=3><br>
<b>Reqs:</b> Str: <input type='text' STYLE='color: black;  background-color: white;' name='jrSTRN' size=5 maxlength=5> Lab: <input type='text' STYLE='color: black;  background-color: white;' name='jrLABOURN' size=5 maxlength=5> IQ: <input type='text' STYLE='color: black;  background-color: white;' name='jrIQN' size=5 maxlength=5><br>
<input type='submit' STYLE='color: black;  background-color: white;' value='Create Job' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
}
}
function jobedit()
{
global $db,$ir,$userid;
if ( $_POST['stage2']) {
$db->query("UPDATE jobs SET jNAME='{$_POST['jNAME']}', jDESC='{$_POST['jDESC']}', jOWNER='{$_POST['jOWNER']}', jFIRST={$_POST['jFIRST']} WHERE jID={$_POST['jID']}");
print "Job updated!<br>
";
}
else if ( $_POST['stage1']) {
$q=$db->query("SELECT * FROM jobs WHERE jID={$_POST['jID']}");
$r=$db->fetch_row($q);
print <<<EOF

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Users Online</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
<form action='staff_jobs.php?action=jobedit' method='post'>
<input type='hidden' name='stage2' value='1'>
<input type='hidden' name='jID' value='{$_POST['jID']}'>
<b>Job Name:</b> <input type='text' STYLE='color: black;  background-color: white;' name='jNAME' value='{$r['jNAME']}'><br>
<b>Job Description:</b> <input type='text' STYLE='color: black;  background-color: white;' name='jDESC' value='{$r['jDESC']}'><br>
<b>Job Owner:</b> <input type='text' STYLE='color: black;  background-color: white;' name='jOWNER' value='{$r['jOWNER']}'><br>
<b>First Job Rank:</b> 
EOF;
print jobrank_dropdown($c,'jFIRST',$r['jFIRST']);
print <<<EOF
<br>
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit' />
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
}
else
{
print <<<EOF

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Select a job to edit</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
<form action='staff_jobs.php?action=jobedit' method='post'>
<input type='hidden' name='stage1' value='1'>
Select a job to edit.<br>
EOF;
print job_dropdown($c, 'jID', -1);
print <<<EOF
<br>
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit Job' />
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
}
}
function newjobrank()
{
global $db,$ir,$userid;
if ( $_POST['jrNAME']) {
$db->query("INSERT INTO jobranks VALUES('', '{$_POST['jrNAME']}', {$_POST['jrJOB']}, {$_POST['jrPAY']}, {$_POST['jrIQG']}, {$_POST['jrLABOURG']}, {$_POST['jrSTRG']}, {$_POST['jrIQN']}, {$_POST['jrLABOURN']}, {$_POST['jrSTRN']})");
print "Job rank created!<br>
";
}
else {
print <<<EOF

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> New Job Rank</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
<form action='staff_jobs.php?action=newjobrank' method='post'>
<b>Rank Name:</b> <input type='text' STYLE='color: black;  background-color: white;' name='jrNAME' /><br>
<b>Pays:</b> <input type='text' STYLE='color: black;  background-color: white;' name='jrPAY' /><br>
<b>Job:</b> 
EOF;
print job_dropdown($c,"jrJOB", -1);
print <<<EOF
<br>
<b>Gains:</b> Str: <input type='text' STYLE='color: black;  background-color: white;' name='jrSTRG' size=3 maxlength=3> Lab: <input type='text' STYLE='color: black;  background-color: white;' name='jrLABOURG' size=3 maxlength=3> IQ: <input type='text' STYLE='color: black;  background-color: white;' name='jrIQG' size=3 maxlength=3><br>
<b>Reqs:</b> Str: <input type='text' STYLE='color: black;  background-color: white;' name='jrSTRN' size=5 maxlength=5> Lab: <input type='text' STYLE='color: black;  background-color: white;' name='jrLABOURN' size=5 maxlength=5> IQ: <input type='text' STYLE='color: black;  background-color: white;' name='jrIQN' size=5 maxlength=5><br>
<input type='submit' STYLE='color: black;  background-color: white;' value='Create Job Rank' /></form> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
}
}
function jobrankedit()
{
global $db,$ir,$userid;
if ( $_POST['stage2']) {
$db->query("UPDATE jobranks SET jrNAME='{$_POST['jrNAME']}', jrJOB = {$_POST['jrJOB']}, jrPAY= {$_POST['jrPAY']}, jrIQG={$_POST['jrIQG']}, jrLABOURG={$_POST['jrLABOURG']}, jrSTRG={$_POST['jrSTRG']}, jrIQN={$_POST['jrIQN']}, jrLABOURN={$_POST['jrLABOURN']}, jrSTRN={$_POST['jrSTRN']}WHERE jrID={$_POST['jrID']}");
print "Job rank updated!<br>
";
}
else if ( $_POST['stage1']) {
$q=$db->query("SELECT * FROM jobranks WHERE jrID={$_POST['jrID']}");
$r=$db->fetch_row($q);
print <<<EOF

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Edit Job Rank</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
<form action='staff_jobs.php?action=jobrankedit' method='post'>
<input type='hidden' name='stage2' value='1'>
<input type='hidden' name='jrID' value='{$_POST['jrID']}'>
<b>Job Rank Name:</b> <input type='text' STYLE='color: black;  background-color: white;' name='jrNAME' value='{$r['jrNAME']}'><br>
<b>Job:</b> 
EOF;
print job_dropdown($c,'jrJOB',$r['jrJOB']);
print <<<EOF
<br>
<b>Pays:</b> <input type='text' STYLE='color: black;  background-color: white;' name='jrPAY' value='{$r['jrPAY']}' /><br>
<b>Gains:</b> Str: <input type='text' STYLE='color: black;  background-color: white;' name='jrSTRG' size=3 maxlength=3 value='{$r['jrSTRG']}'> Lab: <input type='text' STYLE='color: black;  background-color: white;' name='jrLABOURG' size=3 maxlength=3 value='{$r['jrLABOURG']}'> IQ: <input type='text' STYLE='color: black;  background-color: white;' name='jrIQG' size=3 maxlength=3 value='{$r['jrIQG']}'><br>
<b>Reqs:</b> Str: <input type='text' STYLE='color: black;  background-color: white;' name='jrSTRN' size=5 maxlength=5 value='{$r['jrSTRN']}'> Lab: <input type='text' STYLE='color: black;  background-color: white;' name='jrLABOURN' size=5 maxlength=5 value='{$r['jrLABOURN']}'> IQ: <input type='text' STYLE='color: black;  background-color: white;' name='jrIQN' size=5 maxlength=5 value='{$r['jrIQN']}'><br>
<b>Job:</b>
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit' />
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
}
else
{
print <<<EOF
<form action='staff_jobs.php?action=jobrankedit' method='post'>
<input type='hidden' name='stage1' value='1'>

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Select a Job Rank to edit</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


EOF;
print jobrank_dropdown($c, 'jrID', -1);
print <<<EOF
<br>
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit Job Rank' />
</form> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
}
}
function jobrankdele()
{
global $db,$ir,$userid;
 if ( $_POST['stage1']) {
$q=$db->query("SELECT * FROM jobranks WHERE jrID={$_POST['jrID']}");
$jr=$db->fetch_row($q);
$_POST['jID']=$jr['jrJOB'];
$db->query("DELETE FROM jobranks WHERE jrID={$_POST['jrID']}");
print "Job rank successfully deleted!<br>";
$db->query("UPDATE users u LEFT JOIN jobs j ON u.job=j.jID SET u.jobrank=j.jFIRST WHERE u.job={$_POST['jID']} and u.jobrank={$_POST['jrID']}");
$q=$db->query("SELECT * FROM jobs WHERE jFIRST={$_POST['jrID']}");
if($db->num_rows($q))
{
$r=$db->fetch_row($q);
print "<b>Warning!</b> The Job {$r['jNAME']} now has no first rank! Please go edit it and include a first rank.<br>";

}
}
else
{
print <<<EOF
<form action='staff_jobs.php?action=jobrankdele' method='post'>
<input type='hidden' name='stage1' value='1'>

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Select a job rank to delete</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

EOF;
print jobrank_dropdown($c, 'jrID', -1);
print <<<EOF
<br>
<input type='submit' STYLE='color: black;  background-color: white;' value='Delete Job Rank' />
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
}
}
function jobdele()
{
global $db,$ir,$userid;
 if ( $_POST['stage1']) {
$db->query("DELETE FROM jobs WHERE jID={$_POST['jID']}");
print "Job rank successfully deleted!<br>";
$db->query("DELETE FROM jobranks WHERE jrJOB={$_POST['jID']}");
print mysql_affected_rows()." job ranks deleted.<br>";
$db->query("UPDATE users SET job=0,jobrank=0 WHERE job={$_POST['jID']}");
}
else
{
print <<<EOF
<form action='staff_jobs.php?action=jobdele' method='post'>
<input type='hidden' name='stage1' value='1'>
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Select a job to delete</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
EOF;
print job_dropdown($c, 'jID', -1);
print <<<EOF
<br>
<input type='submit' STYLE='color: black;  background-color: white;' value='Delete Job' />
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
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
