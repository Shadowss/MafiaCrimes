<?php
include "globals.php";

if($ir['user_level'] <> STAFF_CLASS)
	die("ERROR! Fucking Retard!");

if ($_GET["act"] == "newsect")
{
//print("<td valign=top style=\"padding: 10px;\" colspan=2 align=center>");


print("<form method=\"post\" action=\"modrules.php?act=addsect\">");
print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
print("<tr><td>Title:</td><td><input style=\"width: 400px; color:black;\" type=\"text\" name=\"title\"/></td></tr>\n");
print("<tr><td style=\"vertical-align: top;\">Rules:</td><td><textarea cols=90 rows=20 style=\" color:black;\" name=\"text\"></textarea></td></tr>\n");

print("<tr><td colspan=\"2\" align=\"center\"><input type=\"radio\" name='public' value=\"yes\" checked>For everybody<input type=\"radio\" name='public' value=\"no\">Registered only (Class: <input type=\"text\" name='class'  style=\" color:black;\" value=\"0\" size=1>)</td></tr>\n");
print("<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\"  style='color:#000000;' value=\"Add\" style=\"width: 60px;\"></td></tr>\n");
print("</table></form>");
$h->endpage();
exit;

}
elseif ($_GET["act"]=="addsect"){
$title = sqlesc($_POST["title"]);
$text = sqlesc($_POST["text"]);
$public = sqlesc($_POST["public"]);
$class = sqlesc($_POST["class"]);
mysql_query("insert into rules (title, text, public, class) values($title, $text, $public, $class)");
header("Refresh: 0; url=modrules.php");
}
elseif ($_GET["act"] == "edit"){
$id = $_POST["id"];
$res = @mysql_fetch_array(@mysql_query("select * from rules where id='$id'"));

print("<form method=\"post\" action=\"modrules.php?act=edited\">");
print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
print("<tr><td>Title:</td><td><input style=\" color:black;\" style=\"width: 400px;\" type=\"text\" name=\"title\" value=\"$res[title]\" /></td></tr>\n");
print("<tr><td style=\"vertical-align: top;\">Rules:</td><td><textarea cols=90 rows=20 name=\"text\">$res[text]</textarea></td></tr>\n");

print("<tr><td colspan=\"2\" align=\"center\"><input type=\"radio\" name='public' value=\"yes\" ".($res["public"]=="yes"?"checked":"").">For everybody<input type=\"radio\" name='public' value=\"no\" ".($res["public"]=="no"?"checked":"").">Registered only (Class: <input  style=\" color:black;\" type=\"text\" name='class' value=\"$res[class]\" size=1>)</td></tr>\n");
print("<tr><td colspan=\"2\" align=\"center\"><input type=hidden value=$res[id] name=id><input type=\"submit\" style='color:#000000;' value=\"Save\" style=\"width: 60px;\"></td></tr>\n");
print("</table>");
$h->endpage();
exit;
}
elseif ($_GET["act"]=="edited"){
$id = $_POST["id"];
$title = sqlesc($_POST["title"]);
$text = sqlesc($_POST["text"]);
$public = sqlesc($_POST["public"]);
$class = sqlesc($_POST["class"]);
mysql_query("update rules set title=$title, text=$text, public=$public, class=$class where id=$id");
header("Refresh: 0; url=modrules.php");
}
else{
$res = mysql_query("select * from rules order by id");
print("<br><table width=100% border=1 cellspacing=0 cellpadding=10>");
print("<tr><td align=center><a href=modrules.php?act=newsect>Add Section</a></td></tr></table>\n");
while ($arr=mysql_fetch_assoc($res)){
print("<br><table width=100% border=1 cellspacing=0 cellpadding=10>");
print("<form method=post action=modrules.php?act=edit&id=><tr><td class=colhead>:: $arr[title]</td></tr><tr><td><ul>\n");
print(format_comment($arr["text"]));
print("</td></tr><tr><td><input type=hidden value=$arr[id] name=id><input type=submit style='color:#000000;' value='Edit'></td></tr></form>");
print("</table>");
}
$h->endpage();
exit;
}
?>