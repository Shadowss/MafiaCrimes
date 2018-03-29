<?php
include "globals.php";


print ("
<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Game Site Rules and Regulations</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
");

 $res = mysql_query("select * from rules order by id");
while ($arr=mysql_fetch_assoc($res)){
if ($arr["public"]=="yes"){
print("<table width=100% border=0 cellspacing=0 cellpadding=10>");
print("<h2>$arr[title]</h2><tr><td>\n");
print(format_comment($arr["text"]));
print("</td></tr>");
print("</table>"); }
elseif($arr["public"]=="no" && $arr["class"]<=$CURUSER["class"]){
print("<br><table width=100% border=1 cellspacing=0 cellpadding=10>");
print("<h2>$arr[title]</h2><tr><td style='text-align:left;'>\n");
print(format_comment($arr["text"]));
print("</td></tr>");
print("</table>");
}
}

print("</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
");

$h->endpage();
?>