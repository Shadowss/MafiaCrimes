<?php
/*
+------------------------------+
|  MCCodes 2.0.0               |
|  © 2010 Pudda                |
|  http://mccodes.com/         |
+------------------------------+
*/
include_once (DIRNAME(__FILE__). '/sglobals.php');
$_GET['resign'] = isset($_GET['resign']) && ctype_alpha($_GET['resign']) ? trim($_GET['resign']) : 'Index';
switch($_GET['resign']) {
 case 'Yes': Remove(); break;
 case 'No': take_home(); break;
 default: Index(); break;
 }
 if (!in_array($_GET['resign'], array('Index', 'Yes', 'No'))) {
 echo('Invalid Command!');
 exit($h->endpage());
 }
 function Index() {
 echo '<h3 style="text-decoration: underline;">Staff Resign</h3>';
 print ' You are currently choosing if you wish to leave staff and go back to a member, Please be sure as there is no way to undo this action, When you click leave staff you leave ALL your powers behind, Please remember this<br />';
 echo '<a href="?resign=Yes">Resign Now</a><br />
 <a href="?resign=No">No, take me home</a><br />';
}
function Remove()
{
global $userid,$h,$db,$IP;
if(isset($_POST['Resign_Reason'])) {
if($_POST['Resign_Reason'] == "")
{
print "You did not supply a reason, We need you supply one so we can make the game better<br />";
exit($h->endpage());
}
if (preg_match('~(www\.|http\://|\.com|\.co\.uk|\.net|\.org)~', $_POST['Resign_Reason']))
{
echo 'Links cannot be used in your reason';
exit($h->endpage());
} else {
$_POST['Resign_Reason'] = str_replace(array("<", ">", "\\\'"), array("&lt;", "&gt;", "'"), $_POST['Resign_Reason']);
$db->query("UPDATE users SET user_level=1 WHERE userid=$userid");
$db->query("INSERT INTO resign_log VALUES(NULL, $userid, unix_timestamp(), '".mysql_real_escape_string($_POST['Resign_Reason'])."', '$IP')");
print "Your now a member, Thank you for your help and support";
}
} else {
print "<h3>Resign Form</h3><br /> Please supply a reason why you have resigned from staff, It could help us, And may help you.
<form action='?resign=Yes' method='post'>
Reason: <input type='text' name='Resign_Reason' value='' /><br />
<input type='submit' value='Resign' /></form>";
}
}
function Take_home() {
global $userid;
print 'We are taking you home now, Thank you for staying on';
print '<meta http-equiv="refresh" content="4;url=/index.php" />';
event_add($userid,"We noticed you went to resign, Please mail ID 1 if you have any issues",$c);
}
$h->endpage();
?>