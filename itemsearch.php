<?php
/*-----------------------------------------------------
-- User Shops Mod
-- Created by Arson
-- By purchasing this mod you have given your word that you won't redistribute it.
-- Only the worthless go back on their word.
-----------------------------------------------------*/
include"globals.php";

if($_GET['name'])
{

$itemfind=$db->query("SELECT * FROM items WHERE itmname LIKE ('%{$_GET['name']}%')");
if(mysql_num_rows($itemfind)!=0)
{
print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Item Search ...</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<center>You only notice the most reasonable prices</center>";
print"<table class=table align=center width=50%><tr><th>Item</th><th>Price</th><th>Action</th></tr>";
while($if=mysql_fetch_array($itemfind))
{
$getitem=$db->query("select * from usershopitems where itemid={$if['itmid']} order by price asc limit 20");
if(mysql_num_rows($itemfind)!=0)
{
while($io=mysql_fetch_array($getitem))
{
if($io['quantity']>1)
{
$quant="x{$io['quantity']}";
}
else
{
$quant="";
}
print"<tr><td>{$if['itmname']} $quant</td><td align=center width=20%>\${$io['price']}</td><td align=center width=25%><a href=playershops.php?id={$io['shopid']}>[Visit Shop]</a> <a href=shopbuy.php?itemnum={$io['id']}>[Buy]</a></td></tr>";
}
print"</table>";
}
else
{
print"No items found.";
}
}
}
else
{
print"<center>No items found.</center>";
}
}
else
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Searching Items In Shops.....</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


<b>Search for: </b><form action='itemsearch.php' method='get'>
<input type='text' name='name' /><br />
<input type='submit' value='Search' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}

$h->endpage();
?>
