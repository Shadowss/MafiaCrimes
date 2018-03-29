<?php

include"globals.php";

$getusershop=$db->query("select * from usershops where userid=$userid");
if(mysql_num_rows($getusershop)==0)
{
echo("You dont have a shop.");
exit($h->endpage());  
}
$us=mysql_fetch_array($getusershop);


switch($_GET['do'])
{
case 'manage': manage(); break;
case 'upgrade': upgrade(); break;
case 'changename': changename(); break;
case 'changedesc': changedesc(); break;
case 'changesign': changesign(); break;
case 'close': closeshop(); break;
case 'removeitem': removeitem(); break;
case 'withdraw': withdraw(); break;
case 'logs': buylogs(); break;
case 'add': addShopItem(); break;
default: myshop_index(); break;
}

function addShopItem(){
	global $ir,$c,$userid,$db, $us;
	$inv=$db->query("SELECT iv.*,i.*,it.* FROM inventory iv LEFT JOIN items i ON iv.inv_itemid=i.itmid LEFT JOIN itemtypes it ON i.itmtype=it.itmtypeid WHERE iv.inv_userid={$userid} ORDER BY i.itmtype ASC, i.itmname ASC");
	print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
		<div class='generalinfo_simple'>");
	if ($db->num_rows($inv) == 0){
		print "<b>You have no items!</b>";
	}else{
	print "<b>Your items are listed below.</b><br />
		<table width=100% class=\"table\" border=\"0\" cellspacing=\"1\">
		<tr>
		<th >Item</th>
		<th >Sell Value</th>
		<th >Total Sell Value</th>
		<th >Links</th>
	</tr>";
	$lt="";
	while($i=$db->fetch_row($inv)){
		if($lt!=$i['itmtypename']){
			$lt=$i['itmtypename'];
			print "\n<tr><th colspan=4><b>{$lt}</b></th></tr>";
		}
		if($i['weapon']){
			  $i['itmname']="<font color='red'>*</font>".$i['itmname'];
		}
		if($i['armor']){
			  $i['itmname']="<font color='green'>*</font>".$i['itmname'];
		}
		print "<tr><td>{$i['itmname']}";
		if ($i['inv_qty'] > 1){
			print "&nbsp;x{$i['inv_qty']}";
		}
		print "</td><td>\${$i['itmsellprice']}</td><td>";
		print "$".($i['itmsellprice']*$i['inv_qty']);
		$addtoshop="[<a href='addtoshop.php?ID={$i['inv_id']}'>Put in Shop</a>]";
		print "</td><td>[<a href='iteminfo.php?ID={$i['itmid']}'>Info</a>] $addtoshop</td></tr> ";
	}
	print "<tr><th colspan=4></th></tr></table>";
	print "<small><b>NB:</b> Items with a small red </small><font color='red'>*</font><small> next to their name can be used as weapons in combat.<br />
	Items with a small green </small><font color='green'>*</font><small> next to their name can be used as armor in combat.</small>
	</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div>";
}
}
function myshop_index()
{
global $ir,$c,$userid,$db, $us;
$getitems=$db->query("select * from usershopitems where shopid={$us['id']}");
$total=0;
while($totalitems=mysql_fetch_array($getitems))
{
$total=$total+$totalitems['quantity'];
}


print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Your Shop - {$us['name']}</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table align=center class=table width=60%>
<tr><th colspan=2>Manage Your Shop</th></tr>
<tr>
<td>
<a href=myshop.php?do=manage>Manage Items($total/{$us['size']})</a><br>
<a href=myshop.php?do=add>Add Items</a><br>
<a href=myshop.php?do=upgrade>Upgrade Size</a><br>
<a href=myshop.php?do=changename>Change Name</a><br>
<a href=myshop.php?do=changesign>Change Sign</a><br>
<a href=myshop.php?do=changedesc>Change Description</a><br>
</td>
<td valign=top>
Items Sold: {$us['totalsold']} <a href=myshop.php?do=logs>[Logs]</a><br><br>
Money: \${$us['money']} <a href=myshop.php?do=withdraw>[Withdraw]</a><br>
<hr>  <br>
<div align=right><a href=myshop.php?do=close><b>Close Shop</b></a></div>
</td>
</tr>
</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div>
";
}

function buylogs()
{
global $ir,$c,$userid,$db,$us;
print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Sales Log</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


<table align=center class=table width=500>
<tr><th>Date</th><th>Buyer</th><th>Item</th><th>Sale Price</th>";
$getlogs=$db->query("select * from usershoplogs where seller=$userid order by date desc") or die(mysql_error());
while($log=mysql_Fetch_array($getlogs))
{
$date=date('F j, Y g:i:s a',$log['date']);
$getbuyer=$db->query("select * from users where userid={$log['buyer']}");
$buy=mysql_fetch_array($getbuyer);
print"<tr><td>$date</td><td align=center><a href=viewuser.php?u={$buy['userid']}>{$buy['username']}</a></td><td align=center>{$log['item']} x{$log['quantity']}</td><td align=center>\${$log['price']}</td></tr>";
}
print"</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div><center><br><br><a href=\"javascript: history.go(-1)\">Click here to go back</a></center>";
}

function changesign()
{
global $ir,$c,$userid,$db,$us;

if($_POST['subm']==1)
{
$sign=mysql_real_escape_string($_POST['sign']);
if($sign=="")
{
$sign="nosign.jpg";
}

 if(!preg_match('~(.?).(jpg|jpeg|gif|png)~i', $sign)) {
   print "You are trying to upload an invalid image";
   } 
else {
$sign = str_replace(array("<", ">", "'", ";", ".php", ".html", ".js"), array("", "", "", "", "", "", ""), $sign);
$db->query("update usershops set `image`='$sign' where id={$us['id']}");
print"<center>You have changed your shops sign to:<br><blockquote><img src='$sign' width=400 height=100></blockquote><br><a href=myshop.php>click here to go back</a></center>";
}
}
else
{
print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Edit your shop's sign below:</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<blockquote> <b><img src='{$us['image']}' width=400 height=100></b></blockquote>
<br><form action='myshop.php?do=changesign' method='post'>Shop Sign: <br><font size=1>Must be direct URL to image!</font><br>
<input type=text name=sign value='{$us['image']}'><input type=hidden name=subm value=1><br><input type=submit value='Change Shop Sign'></form> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
<a href=\"javascript:history.go(-1)\">Click here to go back</a></center>";
}
}


function upgrade()
{
global $ir,$c,$userid,$db,$us;
$upgradeprice=($us['size']*100)+100;
$newsize=$us['size']+1;
if($ir['money']<$upgradeprice)
{
die("<center>You do not have enough money to upgrade your shop.<br>If you have money in your shop till, you will need to withdraw it before you can use it.</center>");
}

if($_POST['yes']==1)
{
$db->query("update users set money=money-$upgradeprice where userid=$userid");
$db->query("update usershops set size=size+1 where id={$us['id']}");

print"
<center>You have upgraded your shops capacity to <b>$newsize</b>!<br><a href=myshop.php>click here to go back</a></center>";
}
else
{
print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Upgrade Shop</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<center>You are about to upgrade your shop to a capacity of <b>$newsize</b> items.<br>This will cost $$upgradeprice.<br><br><form action='myshop.php?do=upgrade' method='post'><input type=hidden name=yes value=1><input type=submit value='Upgrade Shop'></form><br><form action=\"javascript: history.go(-1)\"><input type=submit value=Cancel></form></center></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}


}

function changedesc()
{
global $ir,$c,$userid,$db,$us;

if($_POST['desc'])
{
$desc=mysql_real_escape_string($_POST['desc']);

$db->query("update usershops set `description`='$desc' where id={$us['id']}");
print"<center>You have changed your shops description to:<br><blockquote><b>{$_POST['desc']}</b></blockquote><br><a href=myshop.php>click here to go back</a></center>";
}
else
{
print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Edit your shop description below:</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<blockquote> <b>{$us['desc']}</b></blockquote>
<br><form action='myshop.php?do=changedesc' method='post'>Shop Description: <br>
<textarea name=desc rows=5 cols=30>{$us['description']}</textarea><br><input type=submit value='Change Shop Description'></form> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
<a href=\"javascript:history.go(-1)\">Click here to go back</a></center>";
}
}


function changename()
{
global $ir,$c,$userid,$db,$us;

if($_POST['name'])
{
$name=mysql_real_escape_string($_POST['name']);

$db->query("update usershops set `name`='$name' where id={$us['id']}");
print"<center>You have changed your shops name to <b>{$_POST['name']}</b><br><a href=myshop.php>click here to go back</a></center>";
}
else
{
print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Your shop's name is currently: <b>{$us['name']}</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='myshop.php?do=changename' method='post'>Shop Name: <input type=text name=name><input type=submit value='Change Shop Name'></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
<a href=\"javascript:history.go(-1)\">Click here to go back</a></center>";
}
}


function withdraw()
{
global $ir,$c,$userid,$db,$us;
$_POST['amount']=abs($_POST['amount']);
if($_POST['amount'])
{
if($_POST['amount']>$us['money'])
{
die("Your shop doesn't have that much money.");
}
$db->query("update users set money=money+{$_POST['amount']} where userid=$userid");
$db->query("update usershops set money=money-{$_POST['amount']} where id={$us['id']}");
print"<center>You withdrew \${$_POST['amount']} from your shop </center>";
}
else
{
print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Withdraw Money</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<center>You have \${$us['money']} in your shop <br>How much would you like to withdraw?
<br>
<form action='myshop.php?do=withdraw' method='post'>
Amount: $<input type=text name=amount value={$us['money']}>
<input type=submit value=Withdraw></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div><br><a href=\"javascript:history.go(-1)\">Click here to go back</a></center>";
}
}


function closeshop()
{
global $ir,$c,$userid,$db,$us;
print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Closing your shop</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

";
if($_POST['yes']==1)
{
$checkforitems=$db->query("select * from usershopitems where shopid={$us['id']}");
if(mysql_num_rows($checkforitems)!=0)
{
die("<center>It would be foolish to leave items in your shop before closing it!<br><a href='myshop.php?do=manage'>click here to manage your items</a><a href=\"javascript: history.go(-1)\">or click here to go back</a></center>");
}
$db->query("delete from usershops where userid=$userid");
print"<center>You have closed your shop.</center>";


}
else
{
print"<center>Are you sure you wish to close your shop?<br>
You won't be able to undo this.<br><br>
<form action='myshop.php?do=close' method='post'><input type=hidden name=yes value=1><input type=submit value='I am sure'></form><form action=\"javascript:history.go(-1)\" method=get><input type=submit value=Nervermind></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div></center>";
}
}



function removeitem()
{
global $ir,$c,$userid,$db,$us;
$_GET['id']=mysql_real_escape_string($_GET['id']);
$getid=$db->query("select * from usershopitems where id='{$_GET['id']}'") or die(mysql_error());
if(mysql_num_rows($getid)==0)
{
die("This item is not in your shop.");
}

$id=mysql_fetch_array($getid);

if($id['quantity']>1)
{
item_add($userid, $id['itemid'], $id['quantity']);
}
else
{
item_add($userid, $id['itemid'], 1);
}
$db->query("delete from usershopitems where id={$id['id']}") or die(mysql_error());
print"<center>The item has been removed from your shop.<br><a href=myshop.php?do=manage>Continue Managing Items</a></center>";

}

function manage()
{
global $ir,$c,$userid,$db,$us;
if($_POST['price'] && $_POST['id'])
{
$_POST['id']=mysql_real_escape_string($_POST['id']);
$_POST['price']=mysql_real_escape_string($_POST['price']);
$getitem=$db->query("select * from usershopitems where `id`='{$_POST['id']}'");
$it=mysql_fetch_array($getitem);

if($it['shopid']!=$us['id'])
{
die("You should try editing your own shop items.");
}
$db->query("update usershopitems set `price`='{$_POST['price']}' where `id`='{$_POST['id']}'");
print"<font color=green>Item price has been changed.</font><br>";
}

print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Manage Shop</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table align=center class=table width=70%>
<tr><th colspan=3>Items currently in your shop</th></tr><tr><th width=50%>Item</th><th width=35%>Price</th><th>Option</th>";
$getshopitems=$db->query("select * from usershopitems where shopid={$us['id']}") or die(mysql_error());
while($it=mysql_fetch_array($getshopitems))
{
$getitem=$db->query("select * from items where itmid={$it['itemid']}") or die(mysql_error());
$item=mysql_fetch_array($getitem);
if($it['quantity']>1)
{
$quantity="x{$it['quantity']}";
}
else
{
$quantity="";
}
print"<tr><td valign=top>{$item['itmname']} $quantity</td><td align=center><form action='myshop.php?do=manage' method='post'>$<input type=text name=price value={$it['price']} size=10><input type=hidden name=id value={$it['id']}><input type=submit value=Change></form></td><td align=center><form action='myshop.php' method='get'><input type=hidden name=do value=removeitem><input type=hidden name=id value='{$it['id']}'><input type=submit value=Remove></form></td></tr>";
}
print"</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
print"<center><a href=myshop.php>Click here to go back</a></center>";
}


$h->endpage();
?>
