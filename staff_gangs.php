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
//This contains gang stuffs
switch($_GET['action'])
{
case 'grecord': admin_gang_record(); break;
case 'gcredit': admin_gang_credit(); break;
case 'gwar': admin_gang_wars(); break;
case 'gwardelete': admin_gang_wardelete(); break;
case 'gedit': admin_gang_edit_begin(); break;
case 'gedit_name': admin_gang_edit_name(); break;
case 'gedit_prefix': admin_gang_edit_prefix(); break;
case 'gedit_finances': admin_gang_edit_finances(); break;
case 'gedit_staff': admin_gang_edit_staff(); break;
case 'gedit_capacity': admin_gang_edit_capacity(); break;
case 'gedit_crime': admin_gang_edit_crime(); break;
case 'gedit_ament': admin_gang_edit_ament(); break;
case 'gedit_delete': admin_gang_edit_delete(); break;
case 'gedel': admin_gang_delete_begin(); break;
default: print "Error: This script requires an action."; break;
}
function absint($in, $neg=1)
{
if($neg)
{
return abs((int) $in);
}
else
{
return (int) $in;
}
}
function admin_gang_record()
{
global $db,$ir, $userid,  $c;
if($ir['user_level'] > 3)
{
die("403");
}
$gang = absint( $_GET['gang'] );
if ( $gang )
{
$q=$db->query("SELECT g.* FROM gangs g WHERE g.gangID=$gang");
if(!$db->num_rows($q))
{
$_GET['gang']=0;
admin_gang_record();
}
else if (!$_GET['reason'])
{
$_GET['gang']=0;
admin_gang_record();
}
else
{
$r=$db->fetch_row($q);
print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Gang Info - {$r['gangNAME']} </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table width='80%' border='1'>
<tr>
<td>
Gang Name: {$r['gangNAME']}<br />
Gang Description: {$r['gangDESC']}<br />
Prefix: {$r['gangPREF']}<br />
Money: {$r['gangMONEY']}<br />
Crystals: {$r['gangCRYSTALS']}<br />
Respect: {$r['gangRESPECT']}<br />
President: {$r['gangPRESIDENT']}<br />
Vice-President: {$r['gangVICEPRES']}<br />
Capacity: {$r['gangCAPACITY']}<br />
Crime: {$r['gangCRIME']}<br />
Hours Left: {$r['gangCHOURS']}<br />
Annnouncement: {$r['gangAMENT']}
</td>
</tr>
</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>"; 
stafflog_add("{$ir['username']} looked at gang id {$r['gangID']} ({$r['gangNAME']})'s record. with the reason {$_GET['reason']}");
}
}
else
{
print "
<form action='staff_gangs.php' method='get'>
<input type='hidden' name='action' value='grecord' />

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Gang Record</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>  

Select Gang: <select name='gang' type='dropdown'>";
$q=$db->query("SELECT * FROM gangs");
while($r=$db->fetch_row($q))
{
print "<option value='{$r['gangID']}'>{$r['gangNAME']}</option>\n";
}
print "</select><br />
Reason for viewing: <input type='text' name='reason' value='' /><br />
<input type='submit' value='Go' />
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
";
}
}
function admin_gang_credit()
{
global $db,$ir, $userid,  $c;
if($ir['user_level'] > 3)
{
die("403");
}
$gang = absint( $_POST['gang'] );
$submit = absint( $_POST['submit'] );
$money = absint( $_POST['money'] , 0);
$crystals = absint( $_POST['crystals'] , 0);
$reason = $_POST['reason'];  
if ( $submit && $gang && ($money != 0 || $crystals != 0) && $reason)
{
$db->query("UPDATE gangs SET gangMONEY=gangMONEY+$money, gangCRYSTALS=gangCRYSTALS+$crystals WHERE gangID = $gang");
print "The gang was successfully credited.";
stafflog_add("{$ir['username']} credited gang ID {$gang} with {$money} money and/or {$crystals} crystals with the reason {$reason}");

}  
else if( $gang && ($money != 0 || $crystals != 0))
{ 
$q=$db->query("SELECT gangNAME FROM gangs WHERE gangID = $gang"); 
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> You are crediting Gang ID: $gang with \$$money and $crystals crystals</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
<form action='staff_gangs.php?action=gcredit' method='post'>
<input type='hidden' name='gang' value='$gang' />
<input type='hidden' name='money' value='$money' />
<input type='hidden' name='crystals' value='$crystals' />
<input type='hidden' name='submit' value='1' />
Reason: <input type='text' STYLE='color: black;  background-color: white;' name='reason' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Credit' />
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";}
else
{
print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Credit Gang</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_gangs.php?action=gcredit' method='post'>

<br /><br />
Select Gang: <select name='gang' type='dropdown'>";
$q=$db->query("SELECT * FROM gangs");
while($r=$db->fetch_row($q))
{
print "<option value='{$r['gangID']}'>{$r['gangNAME']}</option>\n";
}
print "</select><br /> <br />

<table border='1' class = table width='50%'>
 <tr>
<td align='right'>Money:</td> <td align='left'><input type='text' STYLE='color: black;  background-color: white;' name='money' 

value='1000' /></td>
</tr> <tr>
<td align='right'>Crystals:</td> <td align='left'><input type='text' STYLE='color: black;  background-color: white;' name='crystals' 

value='10' /></td>
</tr> <tr>
<td align='center' colspan='2'> <input type='submit' STYLE='color: black;  background-color: white;' value='Credit' /> </td>
</tr> </table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
function admin_gang_wars()
{
global $db,$ir, $userid,  $c;
if($ir['user_level'] > 3)
{
die("403");
}
print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Manage Gang Wars</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table width=75% border='2'>";
$q=$db->query("SELECT w.*,g1.gangNAME as declarer, g1.gangRESPECT as drespect, g2.gangNAME as defender, g2.gangRESPECT as frespect FROM gangwars w LEFT JOIN gangs g1 ON w.warDECLARER=g1.gangID LEFT JOIN gangs g2 ON w.warDECLARED=g2.gangID");
while($r=$db->fetch_row($q))
{
print "<tr> <td width=40%><a href='gangs.php?action=view&ID={$r['warDECLARER']}'>{$r['declarer']}</a> [{$r['drespect']} respect]</a></td> <td width=10%>vs.</td> <td width=40%><a href='gangs.php?action=view&ID={$r['warDECLARED']}'>{$r['defender']}</a> [{$r['frespect']} respect]</a></td> <td>[<a href='staff_gangs.php?action=gwardelete&war={$r['warID']}'>Delete</a>]</td></tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function admin_gang_wardelete()
{
global $db,$ir, $userid,  $c;
if($ir['user_level'] > 3)
{
die("403");
}
$q=$db->query("SELECT w.*,g1.gangNAME as declarer, g1.gangRESPECT as drespect, g2.gangNAME as defender, g2.gangRESPECT as frespect FROM gangwars w LEFT JOIN gangs g1 ON w.warDECLARER=g1.gangID LEFT JOIN gangs g2 ON w.warDECLARED=g2.gangID WHERE w.warID={$_GET['war']}");
$r=$db->fetch_row($q);
$db->query("DELETE FROM gangwars WHERE warID={$_GET['war']}");
print "War cleared.";
stafflog_add("{$ir['username']} deleted war ID {$_GET['war']} (<a href='gangs.php?action=view&ID={$r['warDECLARER']}'>{$r['declarer']}</a> [{$r['drespect']} respect]</a> vs. <a href='gangs.php?action=view&ID={$r['warDECLARED']}'>{$r['defender']}</a> [{$r['frespect']} respect]</a>)");
}
function admin_gang_edit_begin()
{
global $db,$ir, $userid,  $c;
if($ir['user_level'] > 3)
{
die("403");
}
$gang = absint( $_POST['gang'] );

if ( $gang )
{
$q=$db->query("SELECT gangNAME FROM gangs WHERE gangID = $gang");
$theirname=$db->fetch_single($q);
$edits = array (
1 => array (
'Name And Description', 'gedit_name', '4'
),
2 => array (
'Prefix', 'gedit_prefix', '4'
),
3 => array (
'Finances + Respect', 'gedit_finances', '4'
),
4 => array (
'Staff', 'gedit_staff', '4'
),
5 => array (
'Capacity', 'gedit_capacity', '4'
),
6 => array (
'Organised Crime', 'gedit_crime', '4'
),
7 => array (
'Announcement', 'gedit_ament', '4'
)
);
print "
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Manage Gang</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

You are managing the gang: $gang<br />
Choose an edit to perform.<br />
<table width='80%' class='table' cellspacing='1'><tr style='background: gray'><th>Edit Type</th>

<th>Available For Use</th> <th>Use</th> </tr>\n";
foreach ( $edits as $k => $v)
{
if ($v[2] >= $ir['user_level']) { $a="green'>Yes";$l="<a href='staff_gangs.php?action=$v[1]&gang=$gang'>Go</a>"; } else { $a="red'>No";$l="N/A"; }
print "<tr> <td>$v[0]</td> <td><b><font color='$a</font></b></td> <td>$l</td></tr>\n";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
else
{
print "

<form action='staff_gangs.php?action=gedit' method='post'>

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Gang Management</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


Select Gang to Manage : <select name='gang' type='dropdown'>";
$q=$db->query("SELECT * FROM gangs");
while($r=$db->fetch_row($q))
{
print "<option value='{$r['gangID']}'>{$r['gangNAME']}</option>\n";
}
print "</select><br />

<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Go' />
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
";

}
}
function admin_gang_edit_name()
{
global $db,$ir, $userid,  $c;
if($ir['user_level'] > 3)
{
die("403");
}
$gang = absint( $_GET['gang'] );
$submit = absint( $_POST['submit'] );
$q=$db->query("SELECT * FROM gangs WHERE gangID = $gang", $c);
$r=$db->fetch_row($q);
if ( $submit )
{
$db->query("UPDATE gangs SET gangNAME='{$_POST['gangNAME']}', gangDESC='{$_POST['gangDESC']}' WHERE gangID=$gang");
print "Gang has been successfully modified.";
stafflog_add($userid, "{$ir['username']} edited gang ID $gang's name and/or description", $c);
}
else
{
print <<<EOF

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Gang Management: Name/Description</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

Editing the gang: {$r['gangNAME']}<br />
<form action='staff_gangs.php?action=gedit_name&gang=$gang' method='post'>
<table width='50%' cellspacing='1' class='table'>
<tr>
<td align=right>Name:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='gangNAME' value='{$r['gangNAME']}' /></td>
</tr>
<tr>
<td align=right>Description:</td>
<td align=left><textarea rows='7' cols='40' name='gangDESC'>{$r['gangDESC']}</textarea></td>
</tr>
<tr>
<td align=center colspan=2><input type='hidden' name='submit' value='1' /><input type='submit' STYLE='color: black;  background-color: white;' value='Edit' /></td>
</tr>
</table>
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
}
}
function admin_gang_edit_prefix()
{
global $db,$ir, $userid,  $c;
if($ir['user_level'] > 3)
{
die("403");
}
$gang = absint( $_GET['gang'] );
$submit = absint( $_POST['submit'] );
$q=$db->query("SELECT * FROM gangs WHERE gangID = $gang");
$r=$db->fetch_row($q);
if ( $submit )
{
$db->query("UPDATE gangs SET gangPREF='{$_POST['gangPREF']}' WHERE gangID=$gang");
print "Gang has been successfully modified.";
stafflog_add("{$ir['username']} edited gang ID $gang's prefix");
}
else
{
print <<<EOF

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Gang Management: Prefix</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

Editing the gang: {$r['gangNAME']}<br />
<form action='staff_gangs.php?action=gedit_prefix&gang=$gang' method='post'>
<table width='50%' cellspacing='1' class='table'>
<tr>
<td align=right>Prefix:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='gangPREF' value='{$r['gangPREF']}' /></td>
</tr>
<tr>
<td align=center colspan=2><input type='hidden' name='submit' value='1' /><input type='submit' STYLE='color: black;  background-color: white;' value='Edit' /></td>
</tr>
</table>
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
}
}
function admin_gang_edit_finances()
{
global $db,$ir, $userid,  $c;
if($ir['user_level'] > 3)
{
die("403");
}
$gang = absint( $_GET['gang'] );
$money = absint( $_POST['money'], 0 );
$crystals = absint( $_POST['crystals'], 0 );
$respect = absint( $_POST['respect'], 0 );
$submit = absint( $_POST['submit'] );
$reason = $_POST['reason'];
$q=$db->query("SELECT * FROM gangs WHERE gangID = $gang");
$r=$db->fetch_row($q);
if ( $submit && $reason )
{
$db->query("UPDATE gangs SET gangMONEY=$money, gangCRYSTALS=$crystals, gangRESPECT=$respect WHERE gangID=$gang");
print "Gang has been successfully modified.";
stafflog_add("{$ir['username']} edited gang ID $gang's finances with the reason $reason");
}
else
{
print <<<EOF

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Gang Management: Financial Details</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

Editing the gang: {$r['gangNAME']}<br />
<form action='staff_gangs.php?action=gedit_finances&gang=$gang' method='post'>
<table width='50%' cellspacing='1' class='table'>
<tr>
<td align=right>Money:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='money' value='{$r['gangMONEY']}' /></td>
</tr>
<tr>
<td align=right>Crystals:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='crystals' value='{$r['gangCRYSTALS']}' /></td>
</tr>
<tr>
<td align=right>Respect:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='respect' value='{$r['gangRESPECT']}' /></td>
</tr>
<tr>
<td align=right>Reason for editing:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='reason' value='' /></td>
</tr>
<tr>
<td align=center colspan=2><input type='hidden' name='submit' value='1' /><input type='submit' STYLE='color: black;  background-color: white;' value='Edit' /></td>
</tr>
</table>
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
}
}
function admin_gang_edit_staff()
{
global $db,$ir, $userid,  $c;
if($ir['user_level'] > 3)
{
die("403");
}
$gang = absint( $_GET['gang'] );
$president = absint( $_POST['president'], 0 );
$vicepres = absint( $_POST['vicepres'], 0 );
$submit = absint( $_POST['submit'] );
$reason = $_POST['reason'];
$q=$db->query("SELECT * FROM gangs WHERE gangID = $gang");
$r=$db->fetch_row($q);
if ( $submit && $reason )
{
$db->query("UPDATE gangs SET gangPRESIDENT=$president, gangVICEPRES=$vicepres WHERE gangID=$gang");
print "Gang has been successfully modified.";
stafflog_add("{$ir['username']} edited gang ID $gang's staff with the reason $reason");
}
else
{
print <<<EOF

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Gang Management: Staff</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

Editing the gang: {$r['gangNAME']}<br />
<form action='staff_gangs.php?action=gedit_staff&gang=$gang' method='post'>
<table width='50%' cellspacing='1' class='table'>
<tr>
<td align=right>President:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='president' value='{$r['gangPRESIDENT']}' /></td>
</tr>
<tr>
<td align=right>Vice-President:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='vicepres' value='{$r['gangVICEPRES']}' /></td>
</tr>
<tr>
<td align=right>Reason for editing:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='reason' value='' /></td>
</tr>
<tr>
<td align=center colspan=2><input type='hidden' name='submit' value='1' /><input type='submit' STYLE='color: black;  background-color: white;' value='Edit' /></td>
</tr>
</table>
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
}
}

function admin_gang_edit_capacity()
{
global $db,$ir, $userid,  $c;
if($ir['user_level'] > 3)
{
die("403");
}
$gang = absint( $_GET['gang'] );
$capacity = absint( $_POST['capacity'], 0 );
$submit = absint( $_POST['submit'] );
$reason = $_POST['reason'];
$q=$db->query("SELECT * FROM gangs WHERE gangID = $gang");
$r=$db->fetch_row($q);
if ( $submit && $reason )
{
$db->query("UPDATE gangs SET gangCAPACITY=$capacity WHERE gangID=$gang");
print "Gang has been successfully modified.";
stafflog_add("{$ir['username']} edited gang ID $gang's capacity with the reason $reason");
}
else
{
print <<<EOF

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Gang Management: Capacity</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

Editing the gang: {$r['gangNAME']}<br />
<form action='staff_gangs.php?action=gedit_capacity&gang=$gang' method='post'>
<table width='50%' cellspacing='1' class='table'>
<tr>
<td align=right>Capacity:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='capacity' value='{$r['gangCAPACITY']}' /></td>
</tr>
<tr>
<td align=right>Reason for editing:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='reason' value='' /></td>
</tr>
<tr>
<td align=center colspan=2><input type='hidden' name='submit' value='1' /><input type='submit' STYLE='color: black;  background-color: white;' value='Edit' /></td>
</tr>
</table>
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
}
}
function admin_gang_edit_crime()
{
global $db,$ir, $userid,  $c;
if($ir['user_level'] > 3)
{
die("403");
}
$gang = absint( $_GET['gang'] );
$crime = absint( $_POST['crime'], 0 );
$chours = absint( $_POST['chours'], 0 );
$submit = absint( $_POST['submit'] );
$reason = $_POST['reason'];
$q=$db->query("SELECT * FROM gangs WHERE gangID = $gang");
$r=$db->fetch_row($q);
if ( $submit && $reason )
{
$db->query("UPDATE gangs SET gangCRIME=$crime, gangCHOURS=$chours WHERE gangID=$gang");
print "Gang has been successfully modified.";
stafflog_add("{$ir['username']} edited gang ID $gang's organised crime with the reason $reason");
}
else
{
print <<<EOF

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Gang Management: Organised Crimes</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<h3>Gang Management: Organised Crimes</h3>
Editing the gang: {$r['gangNAME']}<br />
<form action='staff_gangs.php?action=gedit_crime&gang=$gang' method='post'>
<table width='50%' cellspacing='1' class='table'>
<tr>
<td align=right>Crime ID:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='crime' value='{$r['gangCRIME']}' /></td>
</tr>
<tr>
<td align=right>Crime Hours Left:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='chours' value='{$r['gangCHOURS']}' /></td>
</tr>
<tr>
<td align=right>Reason for editing:</td>
<td align=left><input type='text' STYLE='color: black;  background-color: white;' name='reason' value='' /></td>
</tr>
<tr>
<td align=center colspan=2><input type='hidden' name='submit' value='1' /><input type='submit' STYLE='color: black;  background-color: white;' value='Edit' /></td>
</tr>
</table>
</form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;
}
}
function admin_gang_edit_ament()
{
global $db,$ir, $userid,  $c;
if($ir['user_level'] > 3)
{
die("403");
}
$gang = absint( $_GET['gang'] );
$submit = absint( $_POST['submit'] );
$q=$db->query("SELECT * FROM gangs WHERE gangID = $gang");
$r=$db->fetch_row($q);
if ( $submit )
{
$db->query("UPDATE gangs SET gangAMENT='{$_POST['gangAMENT']}' WHERE gangID=$gang");
print "Gang has been successfully modified.";
stafflog_add("{$ir['username']} edited gang ID $gang's announcement");
}
else
{
print <<<EOF

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Gang Management: Announcement</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<h3>Gang Management: Announcement</h3>
Editing the gang: {$r['gangNAME']}<br />
<form action='staff_gangs.php?action=gedit_ament&gang=$gang' method='post'>
<table width='50%' cellspacing='1' class='table'>
<tr>
<td align=right>Announcement:</td>
<td align=left><textarea rows='7' cols='40' name='gangAMENT'>{$r['gangAMENT']}</textarea></td>
</tr>
<tr>
<td align=center colspan=2><input type='hidden' name='submit' value='1' /><input type='submit' STYLE='color: black;  background-color: white;' value='Edit' /></td>
</tr>
</table>
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


function admin_gang_delete_begin()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] !=2)
{
die("403");
}
print "<form action='staff_gangs.php?action=gedit_delete' method='post'>

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Gang Deletion</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

Select Gang: <select name='gang' type='dropdown'>";
$q=$db->query("SELECT * FROM gangs");
while($r=$db->fetch_row($q))
{
print "<option value='{$r['gangID']}'>{$r['gangNAME']}</option>\n";
}
print "</select><br />

<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Go' />
</form> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";}
function admin_gang_edit_delete()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] !=2)
{
die("403");
}
$db->query("UPDATE users SET gang=0 WHERE gang={$_POST['gang']}");
$db->query("DELETE FROM gangs WHERE gangID={$_POST['gang']}");
stafflog_add("Deleted Gang {$_POST['gang']}");
print "
           <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'>Gang Deletion </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

            Gang Succesfully Deleted
</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>

";
}

$h->endpage();
?>
