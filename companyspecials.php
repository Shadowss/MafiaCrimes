<?php
include_once (DIRNAME(__FILE__) . '/globals.php');


print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Company Specials</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<b>Specials unlocked:</b><b/><br/>You have {$ir['comppoints']} company points, What would you like to spend them on?<br/><br/>
<form action='compspecials.php' method='post'> 
<table width=75% cellspacing=1 class='table'><tr style='background:gray'><th>Reward</th><th>Cost</th><th>Take</th</tr>";
global $ir,$db;   
$com = $db->query("SELECT bmembBusiness FROM businesses_members WHERE bmembMember='{$ir['userid']}'");
$cc=$db->fetch_row($com);
$clas = $db->query("SELECT * FROM businesses WHERE busId='{$cc['bmembBusiness']}'");
$cs=$db->fetch_row($clas);
$clas = $db->query("SELECT * FROM businesses WHERE busDirector='{$ir['userid']}'");
$cs=$db->fetch_row($clas);

$js=$db->query("SELECT * FROM compspecials WHERE csJOB='{$cs['busClass']}'");
if($db->num_rows($js) == 0)
{
print "<tr class='row$current_row'><td colspan=3>This Company has no Specials</td></tr>";
$current_row = 1 - $current_row;
}
while($sp=$db->fetch_row($js))
{
print "<tr class='row$current_row'><td><font color=white>{$sp['csNAME']}</td><td> <font color=#FF0000> <b>{$sp['csCOST']} </b>  <b>Company Points</b> </font> </td><td><center><input type='radio' name='ID' value='{$sp['csID']}' /></td></tr>";
$current_row = 1 - $current_row;
}
print "<tr>
<td colspan=3><div align=center><input type='submit' value='Purchase'></div></td>
</tr></table></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> <br/>";
$h->endpage();
?>