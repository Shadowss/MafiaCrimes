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
$q=$db->query("SELECT * FROM polls WHERE active='0' ORDER BY id desc");
if ( ! $db->num_rows($q) )
{
die("<b>There are no finished polls right now</b>");
}
 print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> POLLS VIEW</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br> ";


while ($r=$db->fetch_row($q))
{
print "
<table border='2' width='100%'><tr bgcolor='gray'> <th>Choice</th> <th>Votes</th> <th width='100'>Bar</th> <th>Percentage</th> </tr> <tr> <th colspan='4'>{$r['question']}</th> </tr>";
for ( $i=1; $i <= 10; $i++)
{
if ( $r['choice'.$i])
{
$k='choice'.$i;
$ke='voted'.$i;
if ( $r['votes'] != 0) {
$perc=$r[$ke]/$r['votes']*100;
} else { $perc=0; }
print "<tr> <td>{$r[$k]}</td> <td>{$r[$ke]}</td> <td><img src='bargreen.gif' alt='Bar' width='$perc' height='10' /></td> <td>$perc%</td></tr>";
}
}
print "<tr><th colspan='4'>Total Votes: {$r['votes']}</th></tr>
<tr><th colspan='4'>Winner: ".$r['choice'.$r['winner']]."</th></tr>
</table><br />";
}

PRINT "</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";


$h->endpage();
?>

