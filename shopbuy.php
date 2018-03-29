<?php
/*-----------------------------------------------------
-- User Shops Mod
-- Created by Arson
-- Please do not redistribute
-----------------------------------------------------*/
include"globals.php";

if($ir[hospital]>0)
die("You are in the hospital for {$ir[hospital]} minutes.");
if($ir[jail]>0)
die("You are in jail for {$ir[jail]} minutes.");


$itemnum=mysql_real_escape_string($_GET['itemnum']);

$getitem=$db->query("select * from usershopitems where id=$itemnum");
if(mysql_num_rows($getitem)==0)
{
die("<center>Item was not found.<br><a href=index.php>go home</a></center>");
}
$im=mysql_fetch_array($getitem);
$getiteminfo=$db->query("select * from items where itmid={$im['itemid']}");
$item=mysql_fetch_array($getiteminfo);
$getshop=$db->query("select * from usershops where id={$im['shopid']}");
$shop=mysql_fetch_array($getshop);
if($ir['money']<$im['price'])
{
die("<center>Sorry, but you can't afford this item!<br>It costs \${$im['price']}.<br><a href=index.php>go home</a></center>");
}
else
{
if($_GET['yes']==1)
{
$_GET['quantity']=mysql_real_escape_string($_GET['quantity']);
$_GET['quantity']=abs($_GET['quantity']);
$getitemname=$db->query("select * from items where itmid={$im['itemid']}");
$itm=mysql_fetch_array($getitemname);
$itemname=$itm['itmname'];
$time=time();

if($_GET['quantity']>$im['quantity'])
{
die("There aren't {$_GET['quantity']} of this item available.
<a href=\"javascript: history.go(-1)\">click here to go back</a>");
}

if($_GET['quantity']==0)
{
$_GET['quantity']=1;
}

$price=($_GET['quantity'])*($im['price']);
$getuser=$db->query("select * from usershops where id={$im['shopid']}");
$u=mysql_fetch_array($getuser);
item_add($userid, $im['itemid'], $_GET['quantity']);
$db->query("update users set money=money-$price where userid=$userid");
$db->query("insert into usershoplogs values('','$userid','{$u['userid']}','$itemname','$price','{$_GET['quantity']}','$time')");
event_add($shop['userid'],"{$ir['username']} has purchased {$_GET['quantity']} of your {$item['itmname']}'s from your shop!",$c,'general');
print"<center>You have successfully purchased <b>{$_GET['quantity']}</b> <b>{$item['itmname']}(s)</b> for $$price.!</center>";
$db->query("update usershops set totalsold=totalsold+{$_GET['quantity']}, money=money+$price where id={$im['shopid']}");
$db->query("update usershopitems set quantity=quantity-{$_GET['quantity']} where id={$im['id']}");
$db->query("delete from usershopitems where quantity=0");


}
else
{

if($im['quantity']>1)
{
print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Buy Items ...</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<center>How many <b>{$item['itmname']}'s</b> would you like to buy for \${$im['price']} each?
<br>
There are {$im['quantity']} Available
<br>
<table class=table>
<tr>
<td>
<form action=shopbuy.php method=get>
<input type=hidden name=itemnum value='{$_GET['itemnum']}'>
<input type=hidden name=yes value='1'>
Amount: <input type=text name=quantity value='1'>
<input type=submit value=Purchase>
</form>
</td>
<td>
<form action=\"javascript:history.go(-1)\"><input type=submit value=Nevermind></form>
</td>
</tr>
</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
</center>";
}
else if($im['quantity']==1)
{
print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Buy Items ...</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


<center>Are you sure you wish to buy the <b>{$item['itmname']}</b> for \${$im['price']}?
<br>
<table>
<tr>
<td>
<form action=shopbuy.php method=get>
<input type=hidden name=itemnum value='{$_GET['itemnum']}'>
<input type=hidden name=yes value='1'>
<input type=hidden name=quantity value=1>
<input type=submit value=Yes>
</form>
</td>
<td>
<form action=\"javascript:history.go(-1)\"><input type=submit value=No></form>
</td>
</tr>
</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
</center>";
}
}
}


$h->endpage();
?>