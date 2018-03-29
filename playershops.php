<?php
include"globals.php";

if($ir[hospital]>0)
die("You are in the hospital for {$ir[hospital]} minutes.");
if($ir[jail]>0)
die("You are in jail for {$ir[jail]} minutes.");

if($_GET['id'])
{
$shopid=mysql_real_escape_string($_GET['id']);
$getshop=$db->query("select * from usershops where id=$shopid");
if(mysql_num_rows($getshop)==0)
{
die("Sorry, this shop does not seem to exist.");
}
$shop=mysql_fetch_array($getshop);
$getowner=$db->query("select * from users where userid={$shop['id']}");
$own=mysql_fetch_array($getowner);
if($shop['image']=="nosign.jpg")
{
$image="";
}
else
{
$image="<img src='{$shop['image']}' width=400 height=100>";
}
print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'>Shop Name - {$shop['name']} </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> 



<br>$image<br><table align=center class=table width=600><tr><td colspan=3>{$shop['description']}</td></tr>
<tr><th colspan=3>Items For Sale</th><tr>
<tr><th>Item</th><th>Price Each</th><th>Option</th></tr>";
$getitems=$db->query("select * from usershopitems where shopid={$shop['id']}");
while($it=mysql_fetch_array($getitems))
{
$getiteminfo=$db->query("select * from items where itmid={$it['itemid']}");
$item=mysql_fetch_array($getiteminfo);
if($it['quantity']>1)
{
$quantity="x{$it['quantity']}";
}
else
{
$quantity="";
}
print"<tr><td>{$item['itmname']} $quantity</td><td align=center>\${$it['price']}</td><td align=center><a href=shopbuy.php?itemnum={$it['id']}>[Buy]</a></td></tr>";
}

print"</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";

}
else
{
//shop cost based on how many shops are already made (default)
$f=$db->query("SELECT id FROM usershops");
$shops=mysql_num_rows($f);
$shopcost=(($shops*1000)+1000);

//fixed shop cost (not default - uncomment the line below, and delete/comment the 3 lines above to use fixed)
//$shopcost=10000;
print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Player Shops</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


<center>Want your own shop?
<br><a href='createshop.php'>Create one now for $$shopcost!</a>
</center>";
$getshops=$db->query("select * from usershops");
print"<table align=center class=table width=550><tr><th>Shop Name</th><th>Sign</th></tr>";
while($r=mysql_fetch_array($getshops))
{
if($r['image']=="")
{
$r['image']="nosign.jpg";
}
print"<tr><td><a href=playershops.php?id={$r['id']}>{$r['name']}</a></td><td><img src='{$r['image']}' height=100 width=400></td></tr>";
}
print"<a href='itemsearch.php'>Search Shop Items</a></table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}



$h->endpage();
?>