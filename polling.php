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
<div class='info_mid'><h2 style='padding-top:10px;'> Polling Booth</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br><br>
";
$_POST['poll']=abs((int) $_POST['poll']);
$ir['voted']=unserialize($ir['voted']);
if ( $_POST['choice'] && $_POST['poll'])
{
if ( $ir['voted'][$_POST['poll']] )
{
die("You've already voted in this poll.<br />
&gt; <a href='explore.php'>Back</a>");
}
if($db->num_rows($db->query("SELECT * FROM polls WHERE active='1' AND id='{$_POST['poll']}'"))==0)
{
  die("You are trying to vote in an invalid or finished poll.<br />
  &gt; <a href='explore.php'>Back</a>");
}
$ir['voted'][$_POST['poll']]=$_POST['choice'];
$ser=addslashes(serialize($ir['voted']));
$db->query("UPDATE users SET voted='$ser' WHERE userid=$userid");
$db->query("UPDATE polls SET voted{$_POST['choice']} = voted{$_POST['choice']} +1, votes=votes+1 WHERE active='1' AND id='{$_POST['poll']}'");
print "Your vote has been cast.<br />
&gt; <a href='polling.php'>Back To Polling Booth</a>";
}
else
{
$q=$db->query("SELECT * FROM polls WHERE active='1'");
if ( ! $db->num_rows($q) )
{
die("<b>There are no active polls at this time</b>");
}


while($r=$db->fetch_row($q))
{
if ( $ir['voted'][$r['id']])
{
print "


<br/> <b> Polls</b>

<table border='2' width='100%'><tr bgcolor='gray'> <th>Choice</th> <th>Votes</th> <th width='100'>Bar</th> <th>Percentage</th> </tr> <tr> <th colspan='4'>{$r['question']} (Already Voted)</th> </tr><br/>";
if(!$r['hidden'])
{
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
}
else
{
  print "<tr><td colspan='4' align='center'>Sorry, the results of this poll are hidden until its end.</td></tr>";
}
$myvote=$r['choice'.$ir['voted'][$r['id']]];
print "<tr><th colspan='2'>Your Vote: {$myvote}</th><th colspan='2'>Total Votes: {$r['votes']}</th></tr>
</table>";
}
else
{
print "<br /><form action='polling.php' method='post'>
<input type='hidden' name='poll' value='{$r['id']}' />
<table border='2' width='100%'><tr bgcolor='gray'> <th>Choice</th> <th>Choose</th> </tr> <tr> <th colspan='2'>{$r['question']} (Not Voted)</th> </tr>";
for ( $i=1; $i <= 10; $i++)
{
if ( $r['choice'.$i])
{
$k='choice'.$i;
if ( $i == 1) { $c="checked='checked'"; } else { $c=""; }
print "<tr> <td>{$r[$k]}</td> <td><input type='radio' name='choice' value='$i' $c /></tr>";
}
}
print "<tr><th colspan='2'><input type='submit' STYLE='color: black;  background-color: white;' value='Vote' /></th></tr>
</table></form>";
}
}
}

if ( ! $_POST['choice'] || !$_POST['poll'] )
{
print " <br/><br/><a href='polls_view.php'>View Old Polls</a><br/>";
}

print "</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";  

$h->endpage();
?>
