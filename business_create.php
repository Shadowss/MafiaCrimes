<?php
include_once (DIRNAME(__FILE__). '/globals.php');
global $db,$ir;

$check = $db->query(sprintf("SELECT * FROM `businesses` WHERE (`busDirector` = '%u')", $ir['userid']));
$check_member = $db->query(sprintf("SELECT * FROM `businesses_members` WHERE (`bmembMember` = '%u')", $ir['userid']));

if($ir['level'] < 5) 
{
die ('You must be at least Level 5 to begin a Company.'); 
}
if($db->num_rows($check) || $db->num_rows($check_member)) 
{
die ('You are part of a job/company at this time, leave to start a new one.'); 
}
echo '<p class="heading">Create Company</p>';
$_POST['name'] = mysql_real_escape_string($_POST['name']);
$_POST['class'] = abs(@intval($_POST['class']));   
if($_POST['name'] AND $_POST['class'])
{
$fetch_class = $db->query(sprintf("SELECT * FROM `businesses_classes` WHERE (`classId` = '%u')", $_POST['class']));
$check = $db->query(sprintf("SELECT * FROM `businesses` WHERE (`busDirector` = '%u')", abs(@intval($ir['userid']))));
$check_member = $db->query(sprintf("SELECT * FROM `businesses_members` WHERE (`bmembMember` = '%u')", abs(@intval($ir['userid']))));

if(!$db->num_rows($fetch_class))
{
echo 'You cannot start a business in a class that doesn\'t exist.';
}
else
{
$r = $db->fetch_row($fetch_class);

if($ir['level'] < 5)
{
echo 'You must be at least Level 5 to begin a Company.';
}
else if($ir['money'] < $r['classCost'])
{
echo 'You cannot afford to start a business of this class right now.';
}
else if($db->num_rows($check) || $db->num_rows($check_member))
{
echo 'You are part of a business at this time, leave to start a new one.';
}
else
{
$db->query(sprintf("INSERT INTO `businesses` (`busId`, `busName`, `busClass`, `busDirector`, `busEmployees`) VALUES ('NULL','%s', '%d', '%u', '%u')", stripslashes($_POST['name']), $_POST['class'], abs(@intval($ir['userid'])), $r['classMembers']));
$db->query(sprintf("UPDATE `users` SET `money` = `money` - '%d' WHERE `userid` = '%u'", $r['classCost'], abs(@intval($ir['userid']))));
$check = $db->query(sprintf("SELECT * FROM `businesses` WHERE (`busDirector` = '%u')", abs(@intval($ir['userid']))));
$direct = $db->fetch_row($check);
$db->query(sprintf("UPDATE `users` SET `business` = '%u' WHERE `userid` = '%u'", $direct['busId'], abs(@intval($ir['userid']))));
echo 'The '.$_POST['name'].' business was created.';
}
}
}
else
{
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Create a new business:</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

<form action="business_create.php" method="post">

Please enter a name for the new business below, then select a class.<br /><br />
Business name: <input type="text" name="name" /><br />
Business class: <select name="class">
<option value="0">None</option>';
$select_classes = $db->query("SELECT * FROM `businesses_classes` ORDER BY `classCost` ASC");
while($c = $db->fetch_row($select_classes))
{
echo '<option value="'.$c['classId'].'">'.stripslashes($c['className']).' (\$'.number_format($c['classCost']).')</option>';
}
echo '</select><br /><br />
<input type="submit" value="Create business" /></p>
</form></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div> ';
}
$h->endpage();
?>