<?php
/*
+------------------------------+
|  MCCodes 2.0.0               |
|  © 2010 Pudda                |
|  http://mccodes.com/         |
+------------------------------+
*/
include_once(DIRNAME(__FILE__) . '/globals.php');
$hositalusers = $db->num_rows($db->query("SELECT userid FROM users WHERE (hospital > 0)"));
echo '
<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;">Local hospital<br />
There is currently '.number_format($hositalusers).' players in hospital</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br><br>
<table class="tablee"><tr><td><center><img src="/images/hospital.jpg" /></td></tr></table><br>

<table border = "1" width = "80%" class = "table" cellspacing = "0" cellpadding = "2">
<tr style = "text-align:center;">
    <td>User and ID</th>
    <td>Time</th>
    <td>Reason</th>
    <td>Action</th>
</tr>';
$HOSPITAL=$db->query("SELECT `username`,`userid`,`hospital`,`hospreason` FROM `users` WHERE hospital > 0 ORDER BY hospital DESC");
 if (!$db->num_rows($HOSPITAL)) {
  echo '<tr><td colspan="4" style="text-align: center;">No players are in hospital</td></tr></table>';
 } else {
while($Row=$db->fetch_row($HOSPITAL))
{
if($ir['hospital'] > 0) { 
$action = "No action available"; 
} 
else 
{ 
$action = "<a href='hospitalheal.php?ID={$Row['userid']}'>Heal</a>"; 
}
echo '
<tr><td><a href = "viewuser.php?u='.$Row['userid'].'">'.htmlentities($Row['username']).'</a> ['.number_format($Row['userid']).']</td>
<td>'.number_format($Row['hospital']).' minutes</td>
<td>'.stripslashes($Row['hospreason']).'</td>
<td>'.$action.'</td></tr>';
}
echo '</table>';
}
print('</div><div><img src="images/generalinfo_btm.jpg" alt="" /></div>');
$h->endpage();