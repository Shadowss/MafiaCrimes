<?php
function replace_meta_chars($string)
{   
return @eregi_replace("([<])|([>])|([*])|([|])|([;])|([`])|([-])|([\])|([{])|([}])|([+])|([UNION])|([SELECT])|([DROP])|([WHERE])|([EMPTY])|([FLUSH])|([INSERT])","",$string);
}
while(list($keyx,$valuex) = each($_REQUEST))
{
if(eregi("([<])|([>])|([*])|([|])|([;])|([`])|([-])|([\])|([{])|([}])|([+])",$valuex))
{
print "<table width=100% border=0 cellpadding=0 cellspacing=0>
<tr>
     <td width=100% align=center>Attack Attempt</td>
</tr>
<tr>
<td width=100% align=center>
<br/><font color=maroon size='3'><b>!!! WARNING !!!</b></font><br />
<em><b>Malicious Code Detected! The staff has been notified.<br />
Currently, we only allow the characters of ' / ' and ' ? '.</b></em>
</td>
</tr>
</table>
<br/>&lt;&lt; <a href='explore.php'>Explore</a>";
event_add(1,"<a href='viewuser.php?u=$userid'><u>{$ir['username']}</u></a> has been flagged for malicious code.<br/><br/><b><u>Char Details</u></b>
<br/>
<b>Chars Used:</b> $valuex",$c);
$h->endpage();
exit();
} 
}
reset ($_REQUEST);   while(list($keyx,$valuex) = each($_REQUEST))
{
${$keyx} = replace_meta_chars($valuex); 
} 
?>