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

$special_page = '<script type="text/javascript" src="js/shops.js"/></script>';
include "globals.php";
$_GET['shop'] = abs((int) $_GET['shop']);
if(!$_GET['shop']){
	print "
	<div class='generalinfo_txt'>
		<div><img src='images/info_left.jpg' alt='' /></div>
		<div class='info_mid'><h2 style='padding-top:10px;'> Shops </h2></div>
		<div><img src='images/info_right.jpg' alt='' /></div>
	</div>
	<div class='generalinfo_simple'>
		<br> <br><br>
		You begin looking through town and you see a few shops.<br />";
	$q=$db->query("SELECT * FROM shops WHERE shopLOCATION={$ir['location']}");
	print "	<table width=85% cellspacing=1 border=1 class='table'>
			<tr style='background: gray;'><th>Shop</th><th>Description</th></tr>";
	while($r=$db->fetch_row($q))
		print "	<tr><td><a href='shops.php?shop={$r['shopID']}'>{$r['shopNAME']}</a></td><td>{$r['shopDESCRIPTION']}</td></tr>";
	print "	</table>
	</div>
	<div><img src='images/generalinfo_btm.jpg' alt='' /></div>";
}else{
	$sd=$db->query("SELECT * FROM shops WHERE shopID={$_GET['shop']}");
	if($db->num_rows($sd)){
		$shopdata=$db->fetch_row($sd);
		if($shopdata['shopLOCATION'] == $ir['location']){
			print "
				<div class='generalinfo_txt'>
					<div><img src='images/info_left.jpg' alt='' /></div>
					<div class='info_mid'><h2 style='padding-top:10px;'> {$shopdata['shopNAME']} </h2></div>
					<div><img src='images/info_right.jpg' alt='' /></div>
				</div>
				<div class='generalinfo_simple'><br> <br><br>
					Browsing items at <b> {$shopdata['shopNAME']} ...</b><br />
					<table cellspacing=1 class='table'><tr style='background: gray;'><th>Picture</th><th>Item</th><th>Description</th><th>Price</th><th>Sell Price</th><th>Buy</th></tr>";
			$qtwo=$db->query("SELECT si.*,i.*,it.* FROM shopitems si LEFT JOIN items i ON si.sitemITEMID=i.itmid LEFT JOIN itemtypes it ON i.itmtype=it.itmtypeid WHERE si.sitemSHOP={$_GET['shop']} ORDER BY i.itmtype ASC, i.itmbuyprice ASC, i.itmname ASC");
			$lt="";
			while($r=$db->fetch_row($qtwo)){
				if($lt!=$r['itmtypename']){
					$lt=$r['itmtypename'];
					print "\n<tr style='background: gray;'><th colspan=6>{$lt}</th></tr>";
				}
				?><tr><td><img src="./images/weapons/<?=$r["itmpic"]?>" class="item_img"></td><td><?=$r["itmname"]?></td><td><?=$r["itmdesc"]?></td><td>$<?=$r["itmbuyprice"]?></td><td>$<?=$r["itmsellprice"]?></td><td><form action="itembuy.php?ID=<?=$r["itmid"]?>" method="post" onSubmit="return buyItem(<?=$r["itmid"]?>,this.qty.value);">Qty: <input type="text" STYLE="color: black;  background-color: white;" name="qty" value="1" /><input type="submit" STYLE="color: black;  background-color: white;" value="Buy" /></form></td></tr><?
			}
			print "	</table>
			</div>
			<div><img src='images/generalinfo_btm.jpg' alt='' /></div>";
		}else{
			print "You are trying to access a shop in another city!";
		}
	}else{
		print "You are trying to access an invalid shop!";
	}
}
$h->endpage();
?>
