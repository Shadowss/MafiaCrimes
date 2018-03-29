<?php

include"globals.php";
if($ir[hospital]>0)
{
die("You are in the hospital for {$ir[hospital]} minutes.");
}
if($ir[jail]>0)
{
die("You are in jail for {$ir[jail]} minutes.");
}
$getshops=$db->query("select * from usershops where userid=$userid");
if(mysql_num_rows($getshops)!=0)
{
echo ("Sorry, but you already own a shop!");
exit($h->endpage());
}


if($_POST['submit'])
{

//shop cost based on how many shops are already made (default)
$f=$db->query("SELECT id FROM usershops");
$shops=mysql_num_rows($f);
$shopcost=(($shops*1000)+1000);

//fixed shop cost (not default - uncomment the line below, and delete/comment the 3 lines above to use fixed)
//$shopcost=10000;


if($ir['money'] < $shopcost)
{
echo("<center>You don't have enough money to open a shop!
You need at least $$shopcost.</center>");
exit($h->endpage());
}
$name=mysql_real_escape_string($_POST['name']);
$description=mysql_real_escape_string($_POST['description']);
$image=mysql_real_escape_string($_POST['image']);

$db->query("INSERT INTO usershops VALUES('','$userid','$name','$description','$image','5','0','0')") or die(mysql_error());
$i=mysql_insert_id($c);
$db->query("update users set money=money-$shopcost where userid=$userid");
print "You have successfully created your own shop!<br><a href='myshop.php'>Click here to manage your shop</a>";
}
else
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Create Shop</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table align=center class=table><tr><th colspan=2>Creating your Own Shop</th></tr>
<tr><td width=60%>Shop Name:</td><td><form action=createshop.php method=post><input type=hidden  name=submit value=1><input type=text STYLE='color: black;  background-color: white;' name=name></td></tr>
<tr><td width=60%>Shop Description:</td><td><textarea STYLE='color: black;  background-color: white;' name=description rows=5 cols=20></textarea></td></tr>
<tr><td width=60%>Shop Sign:<br><font size=1>direct url to image</font></td><td><input type=text STYLE='color: black;  background-color: white;' name=image></td>
<tr><td colspan=2><input type=submit STYLE='color: black;  background-color: white;' value='Create your Shop!'></form></td></tr>
</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>

";
}
$h->endpage();
?>