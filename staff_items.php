<?php
include "sglobals.php";
//This contains item stuffs
switch($_GET['action'])
{
case 'newitem': new_item_form(); break;
case 'newitemsub': new_item_submit(); break;
case 'giveitem': give_item_form(); break;
case 'giveitemsub': give_item_submit(); break;
case 'killitem': kill_item_form(); break;
case 'killitemsub': kill_item_submit(); break;
case 'killitemtype': kill_itemtype_form(); break;
case 'killitemtypesub': kill_itemtype_submit(); break;
case 'edititem': edit_item_begin(); break;
case 'edititemform': edit_item_form(); break;
case 'edititemsub': edit_item_sub(); break;
case 'newitemtype': newitemtype(); break;
default: print "Error: This script requires an action."; break;
}
function new_item_form()
{
global $db,$ir,$c;
if($ir['user_level'] > 2)
{
die("403");
}
print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Add an Item to the Game</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br> 
<form action='staff_items.php?action=newitemsub' method='post'  enctype='multipart/form-data'>
Item Name: <input type='text' STYLE='color: black;  background-color: white;' name='itmname' value='' /><br />
Item Desc.: <input type='text' STYLE='color: black;  background-color: white;' name='itmdesc' value='' /><br />
Item Type: ".itemtype_dropdown($c,'itmtype')."<br />
Item Buyable: <input type='checkbox' name='itmbuyable' checked='checked' /><br />
Item Price: <input type='text' STYLE='color: black;  background-color: white;' name='itmbuyprice' /><br />
Item Sell Value: <input type='text' STYLE='color: black;  background-color: white;' name='itmsellprice' /><br /><br />
<hr />
<b>Usage Form</b><hr />
<b><u>Effect 1</u></b><br />
On? <input type='radio' name='effect1on' value='1' /> Yes <input type='radio' name='effect1on' value='0' checked='checked' /> No<br />
Stat: <select name='effect1stat' type='dropdown'>
<option value='energy'>Energy</option>
<option value='will'>Will</option>
<option value='brave'>Brave</option>
<option value='hp'>Health</option>
<option value='strength'>Strength</option>
<option value='agility'>Agility</option>
<option value='guard'>Guard</option>
<option value='labour'>Labour</option>
<option value='IQ'>IQ</option>
<option value='hospital'>Hospital Time</option>
<option value='jail'>Jail Time</option>
<option value='money'>Money</option>
<option value='crystals'>Crystals</option>
<option value='cdays'>Education Days Left</option>
<option value='bankmoney'>Bank money</option>
<option value='cybermoney'>Cyber money</option>
<option value='crimexp'>Crime XP</option>
</select> Direction: <select name='effect1dir' type='dropdown'>
<option value='pos'>Increase</option>
<option value='neg'>Decrease</option>
</select><br />
Amount: <input type='text' STYLE='color: black;  background-color: white;' name='effect1amount' value='0' /> <select name='effect1type' type='dropdown'>
<option value='figure'>Value</option>
<option value='percent'>Percent</option>
</select><hr />
<b><u>Effect 2</u></b><br />
On? <input type='radio' name='effect2on' value='1' /> Yes <input type='radio' name='effect2on' value='0' checked='checked' /> No<br />
Stat: <select name='effect2stat' type='dropdown'>
<option value='energy'>Energy</option>
<option value='will'>Will</option>
<option value='brave'>Brave</option>
<option value='hp'>Health</option>
<option value='strength'>Strength</option>
<option value='agility'>Agility</option>
<option value='guard'>Guard</option>
<option value='labour'>Labour</option>
<option value='IQ'>IQ</option>
<option value='hospital'>Hospital Time</option>
<option value='jail'>Jail Time</option>
<option value='money'>Money</option>
<option value='crystals'>Crystals</option>
<option value='cdays'>Education Days Left</option>
<option value='bankmoney'>Bank money</option>
<option value='cybermoney'>Cyber money</option>
<option value='crimexp'>Crime XP</option>
</select> Direction: <select name='effect2dir' type='dropdown'>
<option value='pos'>Increase</option>
<option value='neg'>Decrease</option>
</select><br />
Amount: <input type='text' STYLE='color: black;  background-color: white;' name='effect2amount' value='0' /> <select name='effect2type' type='dropdown'>
<option value='figure'>Value</option>
<option value='percent'>Percent</option>
</select><hr />
<b><u>Effect 3</u></b><br />
On? <input type='radio' name='effect3on' value='1' /> Yes <input type='radio' name='effect3on' value='0' checked='checked' /> No<br />
Stat: <select name='effect3stat' type='dropdown'>
<option value='energy'>Energy</option>
<option value='will'>Will</option>
<option value='brave'>Brave</option>
<option value='hp'>Health</option>
<option value='strength'>Strength</option>
<option value='agility'>Agility</option>
<option value='guard'>Guard</option>
<option value='labour'>Labour</option>
<option value='IQ'>IQ</option>
<option value='hospital'>Hospital Time</option>
<option value='jail'>Jail Time</option>
<option value='money'>Money</option>
<option value='crystals'>Crystals</option>
<option value='cdays'>Education Days Left</option>
<option value='bankmoney'>Bank money</option>
<option value='cybermoney'>Cyber money</option>
<option value='crimexp'>Crime XP</option>
</select> Direction: <select name='effect3dir' type='dropdown'>
<option value='pos'>Increase</option>
<option value='neg'>Decrease</option>
</select><br />
Amount: <input type='text' STYLE='color: black;  background-color: white;' name='effect3amount' value='0' /> <select name='effect3type' type='dropdown'>
<option value='figure'>Value</option>
<option value='percent'>Percent</option>
</select><hr />
<b>Combat Usage</b><br />
Weapon Power: <input type='text' STYLE='color: black;  background-color: white;' name='weapon' value='0' /><br />
Armor Defense: <input type='text' STYLE='color: black;  background-color: white;' name='armor' value='0' /><hr />
<b>Picture</b>
<center><img src='images/weapons/nopreview.jpg'></center>
<input type='checkbox' name='changePICTURE' value='change' />(Upload?)<input name='itmpic' type='file' size='40'>
<hr />
<input type='submit' STYLE='color: black;  background-color: white;' value='Add Item To Game' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function new_item_submit()
{
global $db,$ir,$c,$h;
if($ir['user_level'] > 2)
{
die("403");
}
if(!isset($_POST['itmname']) || !isset($_POST['itmdesc']) || !isset($_POST['itmtype'])  || !isset($_POST['itmbuyprice']) || !isset($_POST['itmsellprice']))
{
print "You missed one or more of the fields. Please go back and try again.<br />
<a href='staff_items.php?action=newitem'>&gt; Back</a>";
$h->endpage();
exit;
}
$itmname=$db->escape($_POST['itmname']);
$itmdesc=$db->escape($_POST['itmdesc']);
$weapon=abs((int) $_POST['weapon']);
$armor=abs((int) $_POST['armor']);
$itmpic = "nopreview.jpg";
if($_POST['changePICTURE'] == "change"){
      include('class/imageUpload.class.php');
      $image = new SimpleImage();
      $image->load($_FILES['itmpic']['tmp_name']);
      $image->resize(70,70);
      $name = time().'.jpg';
      $image->save('./images/weapons/'.$name);
      $itmpic = $name;
}

if($_POST['itmbuyable'] == 'on') { $itmbuy=1; } else { $itmbuy=0; }
$efx1=$db->escape(serialize(array("stat" => $_POST['effect1stat'], "dir" => $_POST['effect1dir'], "inc_type" => $_POST['effect1type'], "inc_amount" => abs((int) $_POST['effect1amount']))));
$efx2=$db->escape(serialize(array("stat" => $_POST['effect2stat'], "dir" => $_POST['effect2dir'], "inc_type" => $_POST['effect2type'], "inc_amount" => abs((int) $_POST['effect2amount']))));
$efx3=$db->escape(serialize(array("stat" => $_POST['effect3stat'], "dir" => $_POST['effect3dir'], "inc_type" => $_POST['effect3type'], "inc_amount" => abs((int) $_POST['effect3amount']))));
$m=$db->query("INSERT INTO items VALUES('',{$_POST['itmtype']},'$itmname','$itmdesc','$itmpic',{$_POST['itmbuyprice']},{$_POST['itmsellprice']},$itmbuy, '{$_POST['effect1on']}', '$efx1', '{$_POST['effect2on']}', '$efx2', '{$_POST['effect3on']}', '$efx3', $weapon, $armor)");
print "The {$_POST['itmname']} Item was added to the game.";
stafflog_add("Created item {$_POST['itmname']}");

}
function give_item_form()
{
global $db,$ir,$c;
if($ir['user_level'] > 3)
{
die("403");
}
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Giving Item To User</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_items.php?action=giveitemsub' method='post'>
User: ".user_dropdown($c,'user')."<br />
Item: ".item_dropdown($c,'item')."<br />
Quantity: <input type='text' STYLE='color: black;  background-color: white;' name='qty' value='1' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Give Item' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function give_item_submit()
{
global $db,$ir,$c;
if($ir['user_level'] > 3)
{
die("403");
}
$db->query("INSERT INTO inventory VALUES('',{$_POST['item']},{$_POST['user']},{$_POST['qty']})",$c) or die(mysql_error());
print "You gave {$_POST['qty']} of item ID {$_POST['item']} to user ID {$_POST['user']}";
stafflog_add("Gave {$_POST['qty']} of item ID {$_POST['item']} to user ID {$_POST['user']}");
}
function kill_item_form()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 2)
{
die("403");
}


print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Deleting Item</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

The item will be permanently removed from the game.<br />
<form action='staff_items.php?action=killitemsub' method='post'>
Item: ".item_dropdown($c,'item')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Kill Item' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function kill_item_submit()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 2)
{
die("403");
}

$d=$db->query("SELECT * FROM items WHERE itmid={$_POST['item']}");
$itemi=$db->fetch_row($d);
$db->query("DELETE FROM items WHERE itmid={$_POST['item']}");
$db->query("DELETE FROM shopitems WHERE sitemITEMID={$_POST['item']}");
$db->query("DELETE FROM inventory WHERE inv_itemid={$_POST['item']}");
$db->query("DELETE FROM itemmarket WHERE imITEM={$_POST['item']}");

print "The {$itemi['itmname']} Item was removed from the game.";
stafflog_add("Deleted item {$itemi['itmname']}");
}






function kill_itemtype_submit()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 2)
{
die("403");
}

$d=$db->query("SELECT * FROM itemtypes WHERE itmtypeid={$_POST['itmtype']}");
$itemi=$db->fetch_row($d);
$db->query("DELETE FROM itemtypes WHERE itmtypeid={$_POST['itmtype']}");


print "The {$itemi['itmtypename']} Item Type was removed from the game.";
stafflog_add("Deleted item type {$itemi['itmtypename']}");
}



function kill_itemtype_form()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 2)
{
die("403");
}

print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Deleting Item Type</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

The item type will be permanently removed from the game.<br />
<form action='staff_items.php?action=killitemtypesub' method='post'>
Item Type: ".itemtype_dropdown($c,'itmtype')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Kill Item' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}



function edit_item_begin()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 2)
{
die("403");
}


print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Editing Item</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


You can edit any aspect of this item.<br />
<form action='staff_items.php?action=edititemform' method='post'>
Item: ".item_dropdown($c,'item')."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit Item' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function edit_item_form()
{
global $db,$ir,$c,$h;
if($ir['user_level'] > 2)
{
die("403");
}
$d=$db->query("SELECT * FROM items WHERE itmid={$_POST['item']}");
$itemi=$db->fetch_row($d);
print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Editing Item</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_items.php?action=edititemsub' method='post' enctype='multipart/form-data'>
<input type='hidden' name='itmid' value='{$_POST['item']}' />
Item Name: <input type='text' STYLE='color: black;  background-color: white;' name='itmname' value='{$itemi['itmname']}' /><br />
Item Desc.: <input type='text' STYLE='color: black;  background-color: white;' name='itmdesc' value='{$itemi['itmdesc']}' /><br />
Item Type: ".itemtype_dropdown($c,'itmtype',$itemi['itmtype'])."<br />
Item Buyable: <input type='checkbox' name='itmbuyable'";
if ($itemi['itmbuyable']) { print " checked='checked'"; }
print " /><br />Item Price: <input type='text' STYLE='color: black;  background-color: white;' name='itmbuyprice' value='{$itemi['itmbuyprice']}' /><br />
Item Sell Value: <input type='text' STYLE='color: black;  background-color: white;' name='itmsellprice' value='{$itemi['itmsellprice']}' /><hr /><b>Usage Form</b><hr />";
$stats=array(
"energy" => "Energy",
"will" => "Will",
"brave" => "Brave",
"hp" => "Health",
"strength" => "Strength",
"agility" => "Agility",
"guard" => "Guard",
"labour" => "Labour",
"IQ" => "IQ",
"hospital" => "Hospital Time",
"jail" => "Jail Time",
"money" => "Money",
"crystals" => "Crystals",
"cdays" => "Education Days Left",
"bankmoney" => "Bank money",
"cybermoney" => "Cyber money",
"crimexp" => "Crime XP");
for($i=1;$i<=3;$i++)
{
  if($itemi["effect".$i])
  {
    $efx=unserialize($itemi["effect".$i]);
  }
  else
  {
    $efx=array("inc_amount" => 0);
  }
  $switch1=($itemi['effect'.$i.'_on'] > 0) ? " checked='checked'" : "";
  $switch2=($itemi['effect'.$i.'_on'] > 0) ? "" : " checked='checked'";
  print "<b><u>Effect {$i}</u></b><br />
On? <input type='radio' name='effect{$i}on' value='1'$switch1 /> Yes <input type='radio' name='effect{$i}on' value='0'$switch2 /> No<br />
Stat: <select name='effect{$i}stat' type='dropdown'>";
  foreach($stats as $k => $v)
  {
    if($k==$efx['stat'])
    {
      print "<option value='{$k}' selected='selected'>{$v}</option>\n";
    }
    else
    {
      print "<option value='$k'>{$v}</option>\n";
    }
  }
  if($efx['dir']=="neg")
  {
    $str="<option value='pos'>Increase</option><option value='neg' selected='selected'>Decrease</option>";
  }
  else
  {
    $str="<option value='pos' selected='selected'>Increase</option><option value='neg'>Decrease</option>";
  }
  if($efx['inc_type']=="percent")
  {
    $str2="<option value='figure'>Value</option><option value='percent' selected='selected'>Percent</option>";
  }
  else
  {
    $str2="<option value='figure' selected='selected'>Value</option><option value='percent'>Percent</option>";
  }
  print "</select> Direction: <select name='effect{$i}dir' type='dropdown'>{$str}
  </select><br />
  Amount: <input type='text' STYLE='color: black;  background-color: white;' name='effect{$i}amount' value='{$efx['inc_amount']}' /> <select name='effect{$i}type' type='dropdown'>{$str2}</select><hr />";
}

print "<b>Combat Usage</b><br />
Weapon Power: <input type='text' STYLE='color: black;  background-color: white;' name='weapon' value='{$itemi['weapon']}' /><br />
Armor Defense: <input type='text' STYLE='color: black;  background-color: white;' name='armor' value='{$itemi['armor']}' /><hr />
<b>Picture</b>
<center><img src='images/weapons/{$itemi['itmpic']}'></center>
<input type='checkbox' name='changePICTURE' value='change' />(Change?)<input name='itmpic' type='file' size='40'>
<hr />
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit Item' /></form> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}
function edit_item_sub()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 2)
{
die("403");
}

if(!isset($_POST['itmname']) || !isset($_POST['itmdesc']) || !isset($_POST['itmtype'])  || !isset($_POST['itmbuyprice']) || !isset($_POST['itmsellprice']))
{
print "You missed one or more of the fields. Please go back and try again.<br />
<a href='staff_items.php?action=edititem'>&gt; Back</a>";
$h->endpage();
exit;
}
$itmname=$_POST['itmname'];
$itmdesc=$_POST['itmdesc'];
$weapon=abs((int) $_POST['weapon']);
$armor=abs((int) $_POST['armor']);
if($_POST['itmbuyable'] == 'on') { $itmbuy=1; } else { $itmbuy=0; }

$d_itm=$db->query("SELECT itmpic FROM items WHERE itmid={$_POST['itmid']}");
$r_itm=$db->fetch_row($d_itm);
$itmpic = $r_itm['itmpic'];
if($_POST['changePICTURE'] == "change"){
      if($r_itm['itmpic'] != "nopreview.jpg"){
	$myFile = "./images/weapons/".$r_itm['itmpic'];
	unlink($myFile);
      }
      include('class/imageUpload.class.php');
      $image = new SimpleImage();
      $image->load($_FILES['itmpic']['tmp_name']);
      $image->resize(70,70);
      $name = time().'.jpg';
      $image->save('./images/weapons/'.$name);
      $itmpic = $name;
}

$db->query("DELETE FROM items WHERE itmid={$_POST['itmid']}",$c);
$efx1=$db->escape(serialize(array("stat" => $_POST['effect1stat'], "dir" => $_POST['effect1dir'], "inc_type" => $_POST['effect1type'], "inc_amount" => abs((int) $_POST['effect1amount']))));
$efx2=$db->escape(serialize(array("stat" => $_POST['effect2stat'], "dir" => $_POST['effect2dir'], "inc_type" => $_POST['effect2type'], "inc_amount" => abs((int) $_POST['effect2amount']))));
$efx3=$db->escape(serialize(array("stat" => $_POST['effect3stat'], "dir" => $_POST['effect3dir'], "inc_type" => $_POST['effect3type'], "inc_amount" => abs((int) $_POST['effect3amount']))));
$m=$db->query("INSERT INTO items VALUES('{$_POST['itmid']}',{$_POST['itmtype']},'$itmname','$itmdesc','$itmpic',{$_POST['itmbuyprice']},{$_POST['itmsellprice']},$itmbuy, '{$_POST['effect1on']}', '$efx1', '{$_POST['effect2on']}', '$efx2', '{$_POST['effect3on']}', '$efx3', $weapon, $armor)");
print "The {$_POST['itmname']} Item was edited successfully. <a href='?action=edititem'>Continue editing</a>";
stafflog_add("Edited item {$_POST['itmname']}");
}

function newitemtype()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 2)
{
die("403");
}
if($_POST['name'])
{
$db->query("INSERT INTO itemtypes VALUES(NULL, '{$_POST['name']}')");
print "Item Type {$_POST['name']} added.";
stafflog_add("Added item type {$_POST['name']}");
}
else
{
print "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Add Item Type</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


<form action='staff_items.php?action=newitemtype' method='post'>
Name: <input type='text' STYLE='color: black;  background-color: white;' name='name' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Add Item Type' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
$h->endpage();
?>
