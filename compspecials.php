<?php
include_once (DIRNAME(__FILE__) . '/globals.php');
$_POST['ID'] = abs(@intval($_POST['ID']));


if(!$_POST['ID'])
{
echo "Invalid use of file";
exit;
}

else
{
$com = $db->query("SELECT bmembBusiness FROM businesses_members WHERE bmembMember='{$ir['userid']}'");
$cc=$db->fetch_row($com);
$clas = $db->query("SELECT * FROM businesses WHERE busId='{$cc['bmembBusiness']}'");
$cs=$db->fetch_row($clas);
$clas = $db->query("SELECT * FROM businesses WHERE busDirector='{$ir['userid']}'");
$cs=$db->fetch_row($clas);
$q=$db->query("SELECT * FROM compspecials WHERE csID={$_POST['ID']}");
if($db->num_rows($q) == 0)
{
print "There is no Company Special with this ID!";
}
else
{
$r=$db->fetch_row($q);
if($ir['comppoints'] < $r['csCOST'])
{
print "You don't have enough company points to get this reward!";
$h->endpage();
exit;
}
if($r['csJOB'] != $cs['busClass'])
{
print "You are not in this type of Company!";
$h->endpage();
exit;
}
if($r['csITEM'])
{
item_add($userid, $r['csITEM'], '1');
}
$money=($r['csMONEY']);
$crys=($r['csCRYSTALS']);
$cost=($r['csCOST']);
$endu=($r['csENDU']);
$iq=($r['csIQ']);
$lab=($r['csLABOUR']);
$str=($r['csSTR']);
$db->query(sprintf("UPDATE users SET money=money+%u, crystals=crystals+%u, comppoints=comppoints-%u WHERE userid=%u",$money, $crys, $cost, $userid));
$db->query(sprintf("UPDATE userstats SET strength=strength+%u,IQ=IQ+%u,labour=labour+%u WHERE userid=%u", $str, $iq, $lab, $userid));
print "You successfully redeemed the {$r['csNAME']} Special for {$r['csCOST']} Company Points.";
}
}
$h->endpage();
?>