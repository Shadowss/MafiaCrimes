<?php
include "globals.php";
if(!in_array($_GET['type'], array("equip_primary", "equip_secondary", "equip_armor")))
{
print "This slot ID is not valid.";
$h->endpage();
exit;
}
if(!$ir[$_GET['type']])
{
print "You do not have anything equipped in this slot.
<br />
<a href='inventory.php'>Back</a>";
$h->endpage();
exit;
}
item_add($userid, $ir[$_GET['type']], 1);
$db->query("UPDATE users SET {$_GET['type']}=0 WHERE userid={$ir['userid']}");
$names=array(
"equip_primary" => "Primary Weapon",
"equip_secondary" => "Secondary Weapon",
"equip_armor" => "Armor",
);
print "The item in your {$names[$_GET['type']]} slot was successfully unequiped.
<br />
<a href='inventory.php'>Back</a>";
$h->endpage();
?>

