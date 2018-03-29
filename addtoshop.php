<?php

include"globals.php";
$_GET['ID'] = abs((int) $_GET['ID']);
$_GET['price'] = abs((int) $_GET['price']);

$getusershop=
$db->query("select * from usershops where userid=$userid");
if(mysql_num_rows($getusershop)==0)
{
die("You dont have a shop.");
}
$us=mysql_fetch_array($getusershop);
$getshopitems=
$db->query("select * from usershopitems where shopid={$us['id']}");
$total=0;
while($t=mysql_fetch_array($getshopitems))
{
$total=$total+$t['quantity'];
}


if($total==$us['size'])
{
die("Sorry, but your shop is full!<br><a href=myshop.php>You will need to upgrade your shop's size.");
}


if($_GET['price'])
{
$q=
$db->query("SELECT iv.*,i.* FROM inventory iv LEFT JOIN items i ON iv.inv_itemid=i.itmid WHERE inv_id={$_GET['ID']} and inv_userid=$userid");
if(mysql_num_rows($q)==0)
{
print "Invalid Item ID";
}
$r=mysql_fetch_array($q);
if(100==500)
{
die("This item still belongs to your gang, you can't sell it.");
}
else
{
$_GET['quantity']=mysql_real_escape_string($_GET['quantity']);
if($_GET['quantity']>1)
{
$quantity=$_GET['quantity'];
}
else
{
$quantity=1;
}

if($quantity>$r['inv_qty'])
{
die("<center>You don't have this many of that item!</center>");
}

if($quantity<1)
{
die("<center>A quantity of less than one? <br>Well that doesn't make much sense now does it?</center>");
}

$newquant=$total+$quantity;
if($newquant>$us['size'])
{
die("Sorry, but you don't have enough room in your shop.<br><a href=myshop.php>click here to manage your shop</a>");
}

$checkforitem=
$db->query("select * from usershopitems where shopid={$us['id']} and itemid={$r['inv_itemid']} and price={$_GET['price']}");
if(mysql_num_rows($checkforitem)==0)
{

$db->query("INSERT INTO usershopitems VALUES ('','{$us['id']}','{$r['inv_itemid']}','{$_GET['price']}','$quantity')");
}
else
{
$theitem=mysql_fetch_array($checkforitem);

$db->query("update usershopitems set quantity=quantity+{$_GET['quantity']} where id={$theitem['id']}");
}



$db->query("UPDATE inventory SET inv_qty=inv_qty-$quantity WHERE inv_id={$_GET['ID']}");

$db->query("DELETE FROM inventory WHERE inv_qty=0", $c);
print "You have put this item in your shop.";


}
}
else
{
$q=
$db->query("SELECT * FROM inventory WHERE inv_id={$_GET['ID']} and inv_userid=$userid");
if(mysql_num_rows($q)==0)
{
print "Invalid Item ID";
}
else
{
$r=mysql_fetch_array($q);

if($r['inv_qty']>1)
{
$quantask="Quantity: <input type='text' name='quantity' value='1'><br>";
$quanttell="You have <b>{$r['inv_qty']}</b> of this item.";
}


print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Putting item in your shop</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

$quanttell
<form action='addtoshop.php' method='get'>
<input type='hidden' name='ID' value='{$_GET['ID']}' />
Price: \$<input type='text' STYLE='color: black;  background-color: white;' name='price' value='0' /><br />
$quantask
<input type='submit' STYLE='color: black;  background-color: white;' value='Put in Shop' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
$h->endpage();
?>
