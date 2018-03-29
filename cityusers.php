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
global $db, $ir, $userid, $h, $db;
$cityname = $db->fetch_single($db->query("SELECT cityname FROM cities WHERE cityid = ".$ir['location']));
$location = $ir['location'];  

$q=$db->query("SELECT * FROM users WHERE location = $location ORDER BY laston DESC ");





print"
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Players in your city - $cityname</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
<table width='90%' class= 'table' border='2' >
<td height='6'>
<div align='center'><strong>
<font color=white><u><font color=white></font>Order
</u></strong></u></div></td>
<td><div align='center'><strong>
<font color=white><u><font color=white><u></font>Name
</strong></u></div></td>
<td><div align='center'><strong>
<font color=white><u>ID</font></strong></u></div></td>
<td><div align='center'><strong>
<font color=white><u>Level</font></strong></u></div></td>
<td><div align='center'><strong>
<font color=white><u>Gender
<u/></strong></u></div></td>
<td><div align='center'><strong>
<font color=white><u>Last Online
<u/></strong></u></div></td>
<td><div align='center'><strong>
<font color=white><u>Money
<u/></strong></u></div></td>
<td><div align='center'><strong>
<font color=white><u>Attack
<u/></strong></u></div></td>
</tr>";

while($r=$db->fetch_row($q))
{
$la=time()-$r['laston'];
$unit="secs";
if($la >= 60)
{
$la=(int) ($la/60);
$unit="mins";
}
if($la >= 60)
{
$la=(int) ($la/60);
$unit="hours";
if($la >= 24)
{
$la=(int) ($la/24);
$unit="days";
}
}
if($r['laston'] > 0)
{
$la=time()-$r['laston'];
$unit="seconds";
if($la >= 60)
{
$la=(int) ($la/60);
$unit="minutes";
}
if($la >= 60)
{
$la=(int) ($la/60);
$unit="hours";
if($la >= 24)
{
$la=(int) ($la/24);
$unit="days";
}
}
$str="$la $unit ago";
}
else
{
$str="--";
}
if($r['last_login'] > 0)
{
$ll=time()-$r['last_login'];
$unit2="seconds";
if($ll >= 60)
{
$ll=(int) ($ll/60);
$unit2="minutes";
}
if($ll >= 60)
{
$ll=(int) ($ll/60);
$unit2="hours";
if($ll >= 24)
{
$ll=(int) ($ll/24);
$unit2="days";
}
}
$str2="$ll $unit2 ago";
}
else
{
$str2="--";
}
$money=money_formatter($r['money']); 
$cn++;


print"

<tr>
<td><div align='center'><strong>
$cn.
</strong></div></td>
<td><div align='center'><strong>
<a href='viewuser.php?u={$r['userid']}'>{$r['username']}
</strong></div></td>
<td><div align='center'><strong>
{$r['userid']}<br/>
</strong></div></td>
<td><div align='center'><strong>
{$r['level']}<br>
</div></strong></td>
<td><div align='center'><strong>
{$r['gender']}<br />
</div></strong></td>
<td><div align='center'><strong>
$str<br />
</div></strong></td>
<td><div align='center'><strong>
$money</a><br />
</div></strong></td>
<td><div align='center'><strong>
<a href='attack.php?ID={$r['userid']}'>Attack</a><br />
</div></strong></td>
 ";
}

print "</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
$h->endpage();
?>
